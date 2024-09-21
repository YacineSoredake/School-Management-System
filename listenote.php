<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Note Table</title>
    <style>
        /* Add your CSS styles here */
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
        tr:hover{
            background-color: #faebd7;
        }
    </style>
</head>
<body>

<?php
// Place your PHP code here
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    $db = mysqli_connect('localhost', 'root', '', 'bddg8') or die('Erreur de connexion ' . mysqli_connect_error());

    $requete = "SELECT 
    note.num_etudient, 
    note.code_module, 
    module.designation, 
    note.filiere, 
    MAX(note.coefficient) AS coefficient, 
    MAX(note.note) AS note,
    SUM(note.coefficient) AS sum_coefficient,
    SUM(note.coefficient * note.note) AS sum_note_coef,
    AVG(note.note) AS moyenne
FROM 
    note
JOIN 
    module ON note.code_module = module.code
WHERE 
    note.num_etudient = ?
GROUP BY 
    note.num_etudient, note.code_module, module.designation, note.filiere;
";
    
    $stmt = $db->prepare($requete);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $resultat = $stmt->get_result();

    if ($resultat->num_rows > 0) {
        echo "<h1>Note Table for Student ID: $id</h1>";
        echo "<table>";
        echo "<tr><th>num_etudient</th><th>filiere</th><th>code_module</th><th>designation</th><th>coefficient</th><th>note</th></tr>";
    
        $sumCoefficient = 0;
        $sumNoteCoef = 0;
        $rowCount = 0;
    
        // Fetch data from the result set
        while ($ligne = $resultat->fetch_assoc()) {
            $rowCount++;
            echo "<tr><td>{$ligne['num_etudient']}</td><td>{$ligne['filiere']}</td><td>{$ligne['code_module']}</td><td>{$ligne['designation']}</td><td>{$ligne['coefficient']}</td><td>{$ligne['note']}</td></tr>";
    
            // Update cumulative values
            $sumCoefficient += $ligne['coefficient'];
            $sumNoteCoef += $ligne['coefficient'] * $ligne['note'];
        }
    
        echo "</table>";
    
        if ($rowCount > 0) {
            // Display cumulative values
            echo "<p>La somme des Coefficients: $sumCoefficient</p>";
            echo "<p>La sommme (Coefficient * Note): $sumNoteCoef</p>";
    
            // Display average
            $moyenne = $sumNoteCoef / $sumCoefficient;
            $color = ($moyenne > 10) ? 'green' : 'red';
            echo "<p id='moyenne' style='color: $color;'>La Moyenne: $moyenne</p>";
        }
        $moyenneQuery = "INSERT INTO moyenne (id_etudient, moyenne) VALUES (?, ?) ON DUPLICATE KEY UPDATE moyenne = ?";
        $stmtMoyenne = $db->prepare($moyenneQuery);
        $stmtMoyenne->bind_param('idd', $id, $moyenne, $moyenne);
        $stmtMoyenne->execute();
    
        
        exit();}
        
        else {
            echo "L'étudient avec l'id : $id n'a pas encore enregistrer des notes";
        }
    } else {
        echo "L'étudient avec l'id : $id n'a pas encore enregistrer des notes";
    }
    
    

    mysqli_close($db);

?>
<!-- Add this button where you want on the original page -->


</body>

</html>
