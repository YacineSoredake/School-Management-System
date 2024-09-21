<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/styles/table.css">
    <title>table</title>
    <style>
        button {
            padding: 10px;
            background-color: lightcoral;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }

        p {
            font-weight: bold;
            font-family: Arial, Helvetica, sans-serif;
            color: black;
        }
        select{
            border: 1px solid black;
            border-radius: 4px;
            color: black;
            background-color: lightgray;
            height: 36px;
        }
    </style>
</head>
<body>
<form class="header" method="get" action="page_selection.php">
    <div class="buttons">
      <button class="menu-btn"type="submit" name="page" value="enseignant">Retour vers le Formulaire </button>
    </div>
  </form>
    <h1> PV des étudiants :</h1>
    <h2>
        <form method="post" >
            <select name="filiereInput">
                <option value="3isil">3isil</option>
                <option value="3si">3si</option>
                <option value="1ing">1ing</option>
                <option value="2ing">2ing</option>
                <option value="m1">m1</option>
                <option value="m2isi">m2isi</option>
                <option value="tc">tc</option>
                <option value="2sc">2sc</option>
                <option value="m2wic">m2wic</option>
                <option value="m2rssi">m2rssi</option>
            </select>       
            <button type="submit">Filter</button>
        </form>
    </h2>

    <?php  
    session_start();
    $db = mysqli_connect('localhost', 'root', '', 'bddg8') or die('Erreur de connexion ' . mysqli_connect_error());

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['filiereInput'])) {
        $filiere = $_POST['filiereInput'];
        $_SESSION['filiere'] = $filiere;
        $requete = "SELECT 
                        personne.filiere,
                        personne.Nom_pre, 
                        moyenne.id_etudient, 
                        moyenne.moyenne
                    FROM personne
                    JOIN moyenne ON personne.id = moyenne.id_etudient
                    WHERE filiere = '$filiere'";
        
        $resultat = mysqli_query($db, $requete);

        $sumMoyenne = 0;
        $countEtudiants = 0;
        $maxMoyenne = PHP_INT_MIN; // Initialize to smallest possible value
        $minMoyenne = PHP_INT_MAX; // Initialize to largest possible value

        if ($resultat) {
            ?>
            <table class="table">
                <thead>
                    <tr>           
                        <th>N°étudiant</th>
                        <th>Nom et Prénom</th>
                        <th>Moyenne générale</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    while ($ligne = mysqli_fetch_array($resultat)) {
                        $sumMoyenne += $ligne['moyenne'];
                        $countEtudiants++;
                        $maxMoyenne = max($maxMoyenne, $ligne['moyenne']);
                        $minMoyenne = min($minMoyenne, $ligne['moyenne']);
                        ?>
                        <tr>
                            <td><?php echo $ligne['id_etudient']; ?></td>
                            <td><?php echo $ligne['Nom_pre']; ?></td>             
                            <td><?php echo $ligne['moyenne']; ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            
            <!-- Display AVG, MIN, and MAX Moyenne below the table -->
            <?php
            if ($countEtudiants > 0) {
                $avgMoyenne = $sumMoyenne / $countEtudiants;
                echo "<p>AVG Moyenne: " . number_format($avgMoyenne, 2) . "</p>";
                echo "<p>MIN Moyenne: $minMoyenne</p>";
                echo "<p>MAX Moyenne: $maxMoyenne</p>";
            } else {
                echo "<p>No students found</p>";
            }
        } else {
            echo "Erreur au niveau de la requête " . mysqli_error($db);
        }
    } ?>

    <button type="button" onclick="printPage()">Imprimer</button>

    <form method="post" action="">
    <input type="submit" value="envoyermail avec phpmailer" name="sendToprof">
    </form>


    <script>
        function printPage() {
            window.print();
        }
    </script>
</body>
</html>

<?php
require("PHPMailer/src/PHPMailer.php");
require("PHPMailer/src/SMTP.php");
require("PHPMailer/src/Exception.php");

if (isset($_POST['sendToprof'])) {
    if (isset($_SESSION['filiere'])) {
        $filiere = $_SESSION['filiere'];
            $mysqli = new mysqli('localhost', 'root', '', 'bddg8');
            if ($mysqli->connect_errno) {
                echo 'Failed to connect to MySQL: ' . $mysqli->connect_error;
                exit();
            }

    // Retrieve data from the table
    
    if (!empty($filiere)) {
        $requete = "SELECT 
                        personne.filiere,
                        personne.Nom_pre, 
                        moyenne.id_etudient, 
                        moyenne.moyenne
                    FROM personne
                    JOIN moyenne ON personne.id = moyenne.id_etudient
                    WHERE filiere = '$filiere'";
        
        $result = mysqli_query($mysqli, $requete);

        // Your email configuration
        $mail = new PHPMailer\PHPMailer\PHPMailer();

        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; // Votre hôte SMTP
            $mail->SMTPAuth = true;
            $mail->Username = 'blahayacine9@gmail.com'; // Votre nom d'utilisateur SMTP
            $mail->Password = 'mkyfnsxyiceskhum'; // Votre mot de passe SMTP
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            // Destinataires
            $mail->setFrom('blahayacine9@gmail.com', 'blaha');
            $mail->addAddress('fantatchina31@gmail.com', 'yacine'); // Recipient email and 
            // Content
            $mail->isHTML(true);
            $mail->Subject = 'Bulletin of Etudiant';

            // Prepare the content of the email with the bulletin table
            $emailContent = "Le PV des étudient de la filière $filiere";
            $emailContent .= "<table border=1><tr><th>ID etudient </th><th>Nom / Prénom</th><th>moyenne</th></tr>";

            while ($row = mysqli_fetch_assoc($result)) {
                $emailContent .= "<tr>";
                $emailContent .= "<td>" . $row['id_etudient'] . "</td>";
                $emailContent .= "<td>" . $row['Nom_pre'] . "</td>";
                $emailContent .= "<td>" . number_format($row['moyenne'], 2) . "</td>";
                $emailContent .= "</tr>";
            }
            $emailContent .= "</table>";

            // Add the content to the email body
            $mail->Body = $emailContent;

            // Send email
            $mail->send();
            echo 'Email has been sent';

        } catch (Exception $e) {
            echo "Email could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        echo "Filiere not provided.";
    }

    mysqli_close($mysqli);
}}
?>
