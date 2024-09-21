<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="daw3.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Acme&family=IBM+Plex+Sans&display=swap"
      rel="stylesheet"
    />
    <title>
      NOTE
    </title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        h2 {
            color: #333;
        }

        .table-container {
            margin-top: 20px;
            overflow-x: auto;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        p {
            margin-top: 10px;
        }

        span.admis {
            color: green;
        }

        span.ajourne {
            color: red;
        }
    </style>
  </head>
  <body>
  
  
  
  
  <?php
session_start();

// Vérifiez si l'utilisateur est connecté (vous devrez ajuster cela en fonction de votre mécanisme de connexion)
if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];

    $db = mysqli_connect('localhost', 'root', '', 'bddg8') or die('Erreur de connexion ' . mysqli_connect_error());

    // Récupérer l'id_p à partir de la table 'user' en fonction de l'email
    $stmt_user = $db->prepare("SELECT id_etudient FROM user WHERE email = ?");
    $stmt_user->bind_param('s', $email);
    $stmt_user->execute();
    $result_user = $stmt_user->get_result();

    if ($result_user->num_rows > 0) {
        $row_user = $result_user->fetch_assoc();
        $id_p = $row_user['id_etudient'];

        // Préparez et exécutez la requête SQL pour récupérer les notes de l'étudiant avec les informations du module
        $requete_notes = "SELECT note.num_etudient, note.note, note.code_module, note.filiere, note.coefficient, module.designation
            FROM note
            JOIN module ON note.code_module = module.code
            WHERE note.num_etudient = ?";
        $stmt_notes = $db->prepare($requete_notes);
        $stmt_notes->bind_param('i', $id_p);
        $stmt_notes->execute();
        $resultat_notes = $stmt_notes->get_result();

        // Récupérer le nom et le prénom de la table "personne"
        $requete_personne = "SELECT Nom_pre FROM personne WHERE id = ?";
        $stmt_personne = $db->prepare($requete_personne);
        $stmt_personne->bind_param('i', $id_p);
        $stmt_personne->execute();
        $resultat_personne = $stmt_personne->get_result();
        $ligne_personne = $resultat_personne->fetch_assoc();
        $nom_prenom = $ligne_personne['Nom_pre'];

        // Initialiser les variables pour le calcul
        $somme_coefficients = 0;
        $somme_coefficient_note = 0;

        // Affichez le résultat dans un tableau
        if ($resultat_notes->num_rows > 0) {
            echo "<h2>Bulletin de notes pour l'étudiant " . $nom_prenom . "</h2>";
            echo "<div class='table-container'>";
            echo "<table class='table'>";
            echo "<thead><tr>
                  <th>Numéro étudiant</th>
                  <th>Note</th>
                  <th>Code Module</th>
                  <th>Nom du Module</th>
                  <th>Filière</th>
                  <th>Coefficient</th>
                  </tr></thead>";
            echo "<tbody>";

            while ($ligne_notes = $resultat_notes->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $ligne_notes['num_etudient'] . "</td>";
                echo "<td>" . $ligne_notes['note'] . "</td>";
                echo "<td>" . $ligne_notes['code_module'] . "</td>";
                echo "<td>" . $ligne_notes['designation'] . "</td>";
                echo "<td>" . $ligne_notes['filiere'] . "</td>";
                echo "<td>" . $ligne_notes['coefficient'] . "</td>";
                echo "</tr>";

                // Calculer la somme des coefficients
                $somme_coefficients += $ligne_notes['coefficient'];

                // Calculer la somme des coefficients * notes
                $somme_coefficient_note += $ligne_notes['coefficient'] * $ligne_notes['note'];
            }

            // Calculer la moyenne
            $moyenne = ($somme_coefficients > 0) ? ($somme_coefficient_note / $somme_coefficients) : 0;

            echo "</tbody></table>";

            // Afficher la somme des coefficients
            echo "<p>Somme des coefficients: " . $somme_coefficients . "</p>";

            // Afficher la somme des coefficients * notes
            echo "<p>Somme des coefficients * notes: " . $somme_coefficient_note . "</p>";

            // Afficher la moyenne
            echo "<p>Moyenne: ";
            if ($moyenne > 10) {
                echo "<span style='color: green;'>$moyenne (admis)</span>";
            } else {
                echo "<span style='color: red;'>$moyenne (ajourné)</span>";
            }
            echo "</p>";

        } else {
            echo "<p>Aucun résultat trouvé pour l'étudiant " . $nom_prenom . "</p>";
        }
    } else {
        echo "<p>Aucun utilisateur trouvé avec l'adresse e-mail $email</p>";
    }
} 


// Affichez le formulaire pour l'adresse e-mail et le message
echo '<form method="post" action="testmail.php">';
echo '<label for="recipientEmail">Adresse e-mail du destinataire :</label>';
echo '<input type="email" id="recipientEmail" name="recipientEmail" required>';

echo '<label for="message">Message :</label>';
echo '<textarea id="message" name="message"  required></textarea>';

echo'<form method="post" action="testmail.php">';
echo'<input type="submit" value="envoyermail avec phpmailer" name="sendWithPHPMailer">';
echo '</form>';
// Bouton Imprimer
echo "<button onclick='imprimerInformations()'>Imprimer</button>";

// Script JavaScript pour imprimer
echo "<script>
function imprimerInformations() {
  window.print();
}
</script>";


?>


          
   
  </body>
  

</html>  