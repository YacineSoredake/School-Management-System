<?php
// Assuming you have a database connection established
$db = mysqli_connect('localhost', 'root', 'seojun2003', 'bddg8') or die('Erreur de connexion ' . mysqli_connect_error());

// Fetch gender data from the database
$query = "SELECT Civilité, COUNT(*) AS count FROM personne GROUP BY Civilité";
$result = mysqli_query($db, $query);

$genderData = array('labels' => array(), 'datasets' => array(array('data' => array())));

while ($row = mysqli_fetch_assoc($result)) {
    $genderData['labels'][] = ($row['Civilité'] == 'monsieur') ? 'Male' : 'Female';
    $genderData['datasets'][0]['data'][] = $row['count'];
}

header('Content-Type: application/json');
echo json_encode($genderData);
?>
