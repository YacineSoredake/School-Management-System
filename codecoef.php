<?php
// Connect to the database
$db = mysqli_connect('localhost', 'root', '', 'bddg8') or die('Erreur de connexion ' . mysqli_connect_error());

// Get the selected module from the POST request
$selectedModule = $_POST['module'];

// Prepare and execute an SQL query to fetch 'code module' and 'coefficient' based on the selected module
$requete = "SELECT code, coefficient FROM module WHERE designation = ?";
$stmt = $db->prepare($requete);
$stmt->bind_param('s', $selectedModule);
$stmt->execute();
$resultat = $stmt->get_result();

// Fetch the result as an associative array
if ($resultat->num_rows > 0) {
  $row = $resultat->fetch_assoc();

  // Return the data as JSON
  echo json_encode($row);
} else {
  // Handle the case where no data was found
  echo json_encode(array('code' => '', 'coefficient' => ''));
}
?>
