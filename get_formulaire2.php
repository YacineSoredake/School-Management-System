<?php 

if (isset($_POST['afficher']) || isset($_POST['enregistrer']) || isset($_POST['modifier']) || isset($_POST['suprimer']) || isset($_POST['ajouter']) )  {
  $civ=$_POST['civ'];
  $civ = $_POST['civ'];
  $numero = $_POST['numero'];
  $nom = $_POST['nom'];
  $adresse = $_POST['adresse'];
  $pays = $_POST['pays'];
  $naissance = $_POST['naissance'];
  $lieunaissance = $_POST['lieunaissance'];
  $grade = $_POST['grade'];
  $specialite = $_POST['specialite'];
  $nationa=$_POST['nationality'];

//la partie enregistrer le formulaire
$photo ="";
if (isset($_POST['enregistrer'])) {

if(isset($_POST['civ']))      $civ=$_POST['civ'];
else      $civ="";

if(isset($_POST['nom']))      $Nom=$_POST['nom'];
else      $nom="";

if(isset($_POST['adresse']))      $adresse=$_POST['adresse'];
else      $adresse="";

if(isset($_POST['pays']))      $pays=$_POST['pays'];
else      $pays="";

if(isset($_POST['nationality']))      $nationa=$_POST['nationality'];
else      $nationa="";

if(isset($_POST['naissance']))      $naissance=$_POST['naissance'];
else      $naissance="";

if(isset($_POST['lieunaissance']))      $lieunaissance=$_POST['lieunaissance']; 
else      $lieunaissance="";

if(isset($_POST['grade']))      $grade=$_POST['grade']; 
else      $grade="";

if(isset($_POST['specialite']))      $specialite=$_POST['specialite']; 
else      $specialite="";





if(empty($numero)) 
  { 
  echo '<font color="red"> Veuillez remplir tous les champs </font>'; 
  } 
  {
      // connexion à la base
   $db = mysqli_connect ('localhost', 'root', '', 'bddg8')  or die('Erreur de connexion '.mysqli_connect_error());

   // on écrit la requête sql 
   $sql = "INSERT INTO enseignant(numero,civilite, nom_pre, Adresse,dnaissance,Lnaissance, grade ,pays,specialite,na_tiona_lite) VALUES('$numero','$civ','$nom','$adresse','$naissance','$lieunaissance','$grade','$pays','$specialite','$nationa')"; 
   // on insère les informations du formulaire dans la table 
   mysqli_query($db,$sql) or die('Erreur SQL !'.$sqli.'<br>'.mysqli_error($db)); 

   // on affiche le résultat pour le visiteur 
   echo 'Vos infos sur l enseignant on été ajoutées Merci pour votre patience .'; 

   mysqli_close($db);  // on ferme la connexion 
   }  
 
}

}

?> 
<?php
if (isset($_POST['modifier'])) {
  // Retrieve the input data from the form
  $id = $_POST['idd'];
  $civ = $_POST['civ'];
  $numero = $_POST['numero'];
  $nom = $_POST['nom'];
  $adresse = $_POST['adresse'];
  $pays = $_POST['pays'];
  $naissance = $_POST['naissance'];
  $lieunaissance = $_POST['lieunaissance'];
  $grade = $_POST['grade'];
  $specialite = $_POST['specialite'];
  $nationa= $_POST['nationality'];

  // Establish a database connection
  $conn = mysqli_connect('localhost', 'root', '', 'bddg8') or die('Erreur de connexion ' . mysqli_connect_error());

  if (!$conn) {
    die('Could not connect to the database: ' . mysqli_connect_error());
  }

  // Build the SQL query to update the record
  $sql = '';

  // Check if each field is not empty and update the query accordingly (example for 'civ' field):
  if ($civ !== '') {
    $sql .= "UPDATE enseignant SET `civilite` = '$civ' WHERE id = $id;";
  }
  if ($nom !== '') {
    $sql .= "UPDATE enseignant SET `nom_pre` = '$nom' WHERE id = $id;";
  }
  if ($adresse !== '') {
    $sql .= "UPDATE enseignant SET `Adresse` = '$adresse' WHERE id = $id;";
  } 
  if ($lieunaissance !== '') {
    $sql .= "UPDATE enseignant SET `Lnaissance` = '$lieunaissance' WHERE id = $id;";
  } 
  if ($grade !== '') {
    $sql .= "UPDATE enseignant SET `grade` = '$grade' WHERE id = $id;";
  } 
  if ($specialite !== '') {
    $sql .= "UPDATE enseignant SET `specialite` = '$specialite' WHERE id = $id;";
  }
  if ($numero !== '') {
    $sql .= "UPDATE enseignant SET `numero` = '$numero' WHERE id = $id;";
  } 
  if ($pays !== '') {
    $sql .= "UPDATE enseignant SET `pays` = '$pays' WHERE id = $id;";
  }
  if ($naissance !== '') {
    $sql .= "UPDATE enseignant SET `dnaissance` = '$naissance' WHERE id = $id;";
  }
  if ($nationa !== '') {
    $sql .= "UPDATE enseignant SET `na_tiona_lite` = '$nationa' WHERE id = $id;";
  }



  // Execute the SQL query
  if ($sql !== '') {
    $result = mysqli_multi_query($conn, $sql);

    if ($result) {
      echo "Les valeurs sur l'enseignant ont été modifiées avec succès.";
    } else {
      echo "Error updating record: " . mysqli_error($conn);
    }
  }
}
?>

<?php
// make database connection
$db = mysqli_connect('localhost', 'root', '', 'bddg8') or die('Erreur de connexion ' . mysqli_connect_error());

// check if the form is submitted
if (isset($_POST['supprimer'])) {
  $id = $_POST['idd'];

  // prepare and execute SQL query to delete the row
  $requete = "DELETE FROM enseignant WHERE id = ?";
  $stmt = $db->prepare($requete);
  $stmt->bind_param('i', $id);
  $stmt->execute();

  // check if any rows were affected by the delete operation
  if ($stmt->affected_rows > 0) {
    echo  "L'enseignant avec le ID $id a été supprimé avec succées.";
  } else {
    echo "No rows were deleted for the ID $id.";
  }
}

?>


