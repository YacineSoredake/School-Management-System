<?php 

if (isset($_POST['afficher']) || isset($_POST['enregistrer']) || isset($_POST['modifier']) || isset($_POST['suprimer']) || isset($_POST['ajouter']) )  {
  $code=$_POST['code'];
  $designation=$_POST['designation'];
  $coeff=$_POST['coeff'];
  $volumeH=$_POST['volumeH'];
  $type=$_POST['type'];
  $filiere=$_POST['filiere'];

//la partie enregistrer le formulaire
$photo ="";
if (isset($_POST['enregistrer'])) {

if(isset($_POST['code']))      $code=$_POST['code'];
else      $code="";

if(isset($_POST['designation']))      $designation=$_POST['designation'];
else      $designation="";

if(isset($_POST['coeff']))      $coeff=$_POST['coeff'];
else      $coeff="";

if(isset($_POST['volumeH']))      $volumeH=$_POST['volumeH'];
else      $volumeH="";

if(isset($_POST['type']))      $type=$_POST['type'];
else      $type="";

if(isset($_POST['$filiere']))      $filiere=$_POST['$filiere'];
else      $filiere="$filiere";
  


if(empty($code) OR empty($designation) OR empty($coeff) OR empty($volumeH) OR empty($filiere)) 
  { 
  echo '<font color="red"> Veuillez remplir tous les champs </font>'; 
  } 
  {
      // connexion à la base
   $db = mysqli_connect ('localhost', 'root', '', 'bddg8')  or die('Erreur de connexion '.mysqli_connect_error());

   // on écrit la requête sql 
   $sql = "INSERT INTO module(code,designation, coefficient, volume,Filiere,type) VALUES('$code','$designation','$coeff','$volumeH','$filiere','$type')"; 
   // on insère les informations du formulaire dans la table 
   mysqli_query($db,$sql) or die('Erreur SQL !'.$sqli.'<br>'.mysqli_error($db)); 

   // on affiche le résultat pour le visiteur 
   echo 'Vos infos sur le module on été ajoutées Merci pour votre patience .'; 

   mysqli_close($db);  // on ferme la connexion 
   }  
 
}

}

?> 
<?php
if (isset($_POST['modifier'])) {
  // Retrieve the input data from the form
  $id = $_POST['idd'];
  $code=$_POST['code'];
  $designation=$_POST['designation'];
  $coeff=$_POST['coeff'];
  $volumeH=$_POST['volumeH'];
  $type=$_POST['type'];
  $filiere =$_POST['filiere'];
  
  // Establish a database connection
  
  $conn = mysqli_connect('localhost', 'root', '', 'bddg8') or die('Erreur de connexion ' . mysqli_connect_error());
  
  if (!$conn) {
      die('Could not connect to the database: ' . mysqli_connect_error());
  }
  
  // Build the SQL query to update the record
  $sql = '';
  if ($code !== '') {
    $sql .= "UPDATE module SET `code` = '$code' WHERE id  = $id;";
  } 
  if ($designation !== '') {
    $sql .= "UPDATE module SET `designation` = '$designation' WHERE id = $id;";
  } 
  if ($coeff !== '') {
    $sql .= "UPDATE module SET `coefficient` = '$coeff' WHERE id = $id;";
  } 
  if ($volumeH !== '') {
    $sql .= "UPDATE module SET `volume` = '$volumeH' WHERE id = $id;";
  } 
  if ($filiere !== '') {
    $sql .= "UPDATE module SET `Filiere` = '$filiere' WHERE id = $id;";
  } 
  if ($type !== '') {
    $sql .= "UPDATE module SET `type` = '$type' WHERE id = $id;";
  } 

  
  // Execute the SQL query
  if ($sql !== '') {
    $result = mysqli_multi_query($conn, $sql);
  
    if ($result) {
        echo "les valeurs du module ont été modifiées avec succées.";
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
  }
  
  // Close the database connection
  mysqli_close($conn); 
}
?>
<?php
// make database connection
$db = mysqli_connect('localhost', 'root', '', 'bddg8') or die('Erreur de connexion ' . mysqli_connect_error());

// check if the form is submitted
if (isset($_POST['supprimer'])) {
  $id = $_POST['idd'];

  // prepare and execute SQL query to delete the row
  $requete = "DELETE FROM module WHERE id = ?";
  $stmt = $db->prepare($requete);
  $stmt->bind_param('i', $id);
  $stmt->execute();

  // check if any rows were affected by the delete operation
  if ($stmt->affected_rows > 0) {
    echo  "Le module avec le ID $id a été supprimé avec succées.";
  } else {
    echo "No rows were deleted for the ID $id.";
  }
}

?>


