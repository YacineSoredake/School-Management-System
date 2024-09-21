
<?php

if (isset($_POST['afficher']) || isset($_POST['enregistrer']) || isset($_POST['modifier']) || isset($_POST['suprimer']) || isset($_POST['ajouter']) )  {
  $civ=$_POST['civ'];
  $nom=$_POST['nom'];
  $adresse=$_POST['adresse'];
  $postal=$_POST['postal'];
  $Localité=$_POST['Localité'];
  $pays=$_POST['pays'];
  $sport = $_POST['sport'];

//la partie enregistrer le formulaire
$photo ="";
if (isset($_POST['enregistrer'])) {

if(isset($_POST['civ']))      $civ=$_POST['civ'];
else      $civ="";

if(isset($_POST['nom']))      $Nom=$_POST['nom'];
else      $nom="";

if(isset($_POST['adresse']))      $adresse=$_POST['adresse'];
else      $adresse="";

if(isset($_POST['postal']))      $postal=$_POST['postal'];
else      $postal="";

if(isset($_POST['Localité']))      $Localité=$_POST['Localité'];
else      $Localité="";

if(isset($_POST['pays']))      $pays=$_POST['pays'];
else      $pays="";

foreach ($_POST['platformes'] as $platforme) {

if(isset($_POST['$platforme']))      $platforme=$_POST['$platforme'];
else      $platforme="$platforme";
}

foreach ($_POST['applications'] as $application) {

if(isset($_POST['$application']))      $application=$_POST['$application'];
else      $application="$application";
}

foreach ($_POST['filieres'] as $filiere) {

  if(isset($_POST['$filiere']))      $filiere=$_POST['$filiere'];
  else      $filiere="$filiere";
  }

foreach ($_POST['nationalites'] as $nationalite) {

 if(isset($_POST['$nationalite']))      $nationalite=$_POST['$nationalite'];
 else      $nationalite="$nationalite";
}

$photo =$_FILES['fileInput']['name'];
$upload = "images/".$photo;
move_uploaded_file ($_FILES['fileInput']['tmp_name'],$upload);

if(empty($civ) OR empty($nom) OR empty($adresse) OR empty($postal) OR empty($Localité)) 
  { 
  echo '<font color="red"> Veuillez remplir tous les champs </font>'; 
  } 
  {
      // connexion à la base
   $db = mysqli_connect ('localhost', 'root', '', 'bddg8')  or die('Erreur de connexion '.mysqli_connect_error());

   // on écrit la requête sql 
   $sql = "INSERT INTO personne(Civilité, Nom_pre, Adresse, cod_post, localité, plat_form, filiere,application,natio_nalite, pays ,sport,image) VALUES('$civ','$nom','$adresse','$postal','$Localité','$platforme','$filiere','$application' ,'$nationalite','$pays' ,'$sport','$photo')"; 
   // on insère les informations du formulaire dans la table 
   mysqli_query($db,$sql) or die('Erreur SQL !'.$sqli.'<br>'.mysqli_error($db)); 

   // on affiche le résultat pour le visiteur 
   echo 'Vos infos on été ajoutées Merci pour votre patience .'; 

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
  $nom = $_POST['nom'];
  $adresse = $_POST['adresse'];
  $postal = $_POST['postal'];
  $localite = $_POST['Localité'];
  $pays = $_POST['pays'];
  $sport = $_POST['sport'];
  $filiere = isset($_POST['filieres']) ? implode(',', $_POST['filieres']) : '';
  $platforme = isset($_POST['platformes']) ? implode(',', $_POST['platformes']) : ''; 
  $application = isset($_POST['applications']) ? implode(',', $_POST['applications']) : '';
  $nationalite = isset($_POST['nationalites']) ? implode(',', $_POST['nationalites']) : '';
  $photo =$_FILES['fileInput']['name'];
  // Establish a database connection
  
  $conn = mysqli_connect('localhost', 'root', '', 'bddg8') or die('Erreur de connexion ' . mysqli_connect_error());
  
  if (!$conn) {
      die('Could not connect to the database: ' . mysqli_connect_error());
  }
  
  // Build the SQL query to update the record
  $sql = '';
  if ($civ !== '') {
    $sql .= "UPDATE personne SET `Civilité` = '$civ' WHERE id = $id;";
  } 
  if ($nom !== '') {
    $sql .= "UPDATE personne SET `Nom_pre` = '$nom' WHERE id = $id;";
  } 
  if ($adresse !== '') {
    $sql .= "UPDATE personne SET `Adresse` = '$adresse' WHERE id = $id;";
  } 
  if ($postal !== '') {
    $sql .= "UPDATE personne SET `cod_post` = '$postal' WHERE id = $id;";
  } 
  if ($localite !== '') {
    $sql .= "UPDATE personne SET `localité` = '$localite' WHERE id = $id;";
  } 
  if ($platforme !== '') {
    $sql .= "UPDATE personne SET `plat_form` = '$platforme' WHERE id = $id;";
  } 
  if ($application !== '') {
    $sql .= "UPDATE personne SET `application` = '$application' WHERE id = $id;";
  } 
  if ($filiere !== '') {
    $sql .= "UPDATE personne SET `filiere` = '$filiere' WHERE id = $id;";
  }
  if ($nationalite !== '') {
    $sql .= "UPDATE personne SET `natio_nalite` = '$nationalite' WHERE id = $id;";
  } 
  if ($sport !== '') {
    $sql .= "UPDATE personne SET `sport` = '$sport' WHERE id = $id;";
  } 
  if ($pays!== '') {
    $sql .= "UPDATE personne SET `pays` = '$pays' WHERE id = $id;";
  }
  if ($photo!== '') {
    $sql .= "UPDATE personne SET `image` = '$photo' WHERE id = $id;";
  }
  
  
  
  // Execute the SQL query
  if ($sql !== '') {
    $result = mysqli_multi_query($conn, $sql);
  
    if ($result) {
        echo "les valeurs ont été modifiées avec succées.";
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
  $requete = "DELETE FROM personne WHERE id = ?";
  $stmt = $db->prepare($requete);
  $stmt->bind_param('i', $id);
  $stmt->execute();

  // check if any rows were affected by the delete operation
  if ($stmt->affected_rows > 0) {
    echo  "La personne avec le ID $id a été supprimé avec succées.";
  } else {
    echo "No rows were deleted for the ID $id.";
  }
}

?>


