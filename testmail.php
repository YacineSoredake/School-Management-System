<?php

require("PHPMailer/src/PHPMailer.php");
require("PHPMailer/src/SMTP.php");
require("PHPMailer/src/Exception.php");

if (isset($_POST['sendWithPHPMailer'])) {
    session_start(); // Assurez-vous que la session est démarrée

        // Récupérer l'adresse e-mail du destinataire et le message
        $recipientEmail = $_POST['recipientEmail'];
        $message = $_POST['message'];

    $mysqli = new mysqli('localhost', 'root', '', 'bddg8');
    if ($mysqli->connect_errno) {
        echo 'Failed to connect to MySQL: ' . $mysqli->connect_error;
        exit();
    }

    // Récupérer l'identifiant de l'étudiant connecté depuis la session
    if (isset($_SESSION['email'])) {
        $email = $_SESSION['email'];

        // Récupérer l'id_p à partir de la table 'user' en fonction de l'email
        $stmt_user = $mysqli->prepare("SELECT id_etudient FROM user WHERE email = ?");
        $stmt_user->bind_param('s', $email);
        $stmt_user->execute();
        $result_user = $stmt_user->get_result();

        if ($result_user->num_rows > 0) {
            $row_user = $result_user->fetch_assoc();
            $id_p = $row_user['id_etudient'];

            // Récupérer les notes de l'étudiant avec les informations du module
            $requete_notes = "SELECT personne.Nom_pre, note.num_etudient, note.note, note.code_module, note.filiere, note.coefficient, module.designation
                FROM note
                JOIN module ON note.code_module = module.code
                JOIN personne ON note.num_etudient = personne.id
                WHERE note.num_etudient = ?
                ORDER BY note.num_etudient, module.designation";
            $stmt_notes = $mysqli->prepare($requete_notes);
            $stmt_notes->bind_param('i', $id_p);
            $stmt_notes->execute();
            $result_notes = $stmt_notes->get_result();

            // Votre configuration d'e-mail
            $mail = new PHPMailer\PHPMailer\PHPMailer();

            try {
                // Paramètres du serveur
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com'; // Votre hôte SMTP
                $mail->SMTPAuth = true;
                $mail->Username = ''; // Votre nom d'utilisateur SMTP
                $mail->Password = ''; // Votre mot de passe SMTP
                $mail->SMTPSecure = 'tls';
                $mail->Port = 587;

                // Destinataires
                $mail->setFrom('', ''); // Votre e-mail et votre nom
                $mail->addAddress($recipientEmail, 'Destinataire'); // E-mail et nom du destinataire

                // Contenu
                $mail->isHTML(true);

                // Préparer le contenu de l'e-mail avec le tableau des notes
                $emailContent = ""; // Initialiser la variable
$emailContent .= "<div class='table-container'>";
$emailContent .= "<table class='table'>";
$emailContent .= "<thead><tr>
        <th>Nom du Module</th>
        <th>Code Module</th>
        <th>Filiere</th>
        <th>Coefficient</th>
        <th>Note</th>
        </tr></thead>";
$emailContent .= "<tbody>";

$nom_etudiant = ""; // Initialiser la variable
$somme_coefficients = 0; // Initialiser la somme des coefficients
$somme_coefficient_note = 0; // Initialiser la somme des coefficients * notes

while ($row = $result_notes->fetch_assoc()) {
    $emailContent .= "<tr>";
    $emailContent .= "<td>" . $row['designation'] . "</td>";
    $emailContent .= "<td>" . $row['code_module'] . "</td>";
    $emailContent .= "<td>" . $row['filiere'] . "</td>";
    $emailContent .= "<td>" . $row['coefficient'] . "</td>";
    $emailContent .= "<td>" . $row['note'] . "</td>";
    $emailContent .= "</tr>";

        // Calculer la somme des coefficients
        $somme_coefficients += $row['coefficient'];

        // Calculer la somme des coefficients * notes
        $somme_coefficient_note += $row['coefficient'] * $row['note'];
    
        // Extraire le nom de l'étudiant
        $nom_etudiant = $row['Nom_pre'];
}

$emailContent .= "</tbody></table>";
$emailContent .= "</div>";

// Calculer la moyenne
$moyenne = ($somme_coefficients > 0) ? ($somme_coefficient_note / $somme_coefficients) : 0;

// Ajouter le contenu au corps de l'e-mail
$mail->Subject = 'Bulletin of Etudiant';
$mail->Body = "<h2>Bulletin de notes pour " . $nom_etudiant . "</h2>" . $emailContent;

// Ajouter la moyenne à l'e-mail
$mail->Body .= "<p>Moyenne: ";
if ($moyenne > 10) {
    $mail->Body .= "<span style='color: green;'>$moyenne (admis)</span>";
} else {
    $mail->Body .= "<span style='color: red;'>$moyenne (ajourné)</span>";
}
$mail->Body .= "</p>";
// Ajouter le message personnalisé
$mail->Body .= "<p>Message: $message</p>";


                // Envoyer l'e-mail
                $mail->send();
                echo 'Email has been sent';

            } catch (Exception $e) {
                echo "Email could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
        } else {
            echo "<p>Aucun utilisateur trouvé avec l'adresse e-mail $email</p>";
        }
    } else {
        echo "<p>L'utilisateur n'est pas connecté.</p>";
    }

    mysqli_close($mysqli);
}
?>
