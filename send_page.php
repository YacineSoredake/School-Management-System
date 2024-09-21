<?php
require("PHPMailer/src/PHPMailer.php");
require("PHPMailer/src/SMTP.php");
require("PHPMailer/src/Exception.php");


// Your existing code...

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id_etudiant = $_GET['id'];

    // Fetch and display the student's bulletin using $id_etudiant
    $requete = "
    SELECT 
    note.num_etudient , 
    note.code_module, 
    module.designation, 
    note.filiere , 
    personne.Nom_pre,
    MAX(note.coefficient) AS coefficient, 
    MAX(note.note) AS note,
    SUM(note.coefficient) AS sum_coefficient,
    SUM(note.coefficient * note.note) AS sum_note_coef,
    AVG(note.note) AS moyenne
FROM 
    note
JOIN
    personne ON note.num_etudient = personne.id
JOIN 
    module ON note.code_module = module.code
WHERE 
    note.num_etudient = ?
GROUP BY 
    note.num_etudient,personne.Nom_pre, note.code_module, module.designation, note.filiere;

    ";


    if ($rowCount > 0) {
        // Display cumulative values
        echo "<p>-----  information sur L'élève  -----</p>";
            echo "<p> Nom et prenom : $nom</p>";
            echo "<p> Filiere : $filiere</p>";
            echo "<p>-</p>";
            echo "<p>La somme des Coefficients: $sumCoefficient</p>";
            echo "<p>La sommme (Coefficient * Note): $sumNoteCoef</p>";

            // Display average
            $moyenne = $sumNoteCoef / $sumCoefficient;
            $color = ($moyenne > 10) ? 'green' : 'red';
            echo "<p id='moyenne' style='color: $color;'>La Moyenne: $moyenne</p>";

        // Create a new PHPMailer instance
        $mail = new PHPMailer\PHPMailer\PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'your_smtp_host';
        $mail->SMTPAuth = true;
        $mail->Username = 'fantatchina31@gmail.com'; // Your SMTP username
        $mail->Password = 'ywddedoslqxflksf'; // Your SMTP password
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('fantatchina31@gmail.com', 'blaha'); // Your email and name
        $mail->addAddress('blahayacine9@gmail.com', 'yacine'); // Re
        $mail->isHTML(true);

        // Subject and body of the email
        $mail->Subject = 'Student Bulletin';
        $mail->Body = "<html>Your HTML content for the email goes here...</html>";

        // Send the email
        if (!$mail->send()) {
            echo 'Message could not be sent.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        } else {
            echo 'Message has been sent';
        }

        // Your existing code...
    }
}
?>
