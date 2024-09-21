<?php
if (isset($_POST['ajouter'])) {
  
  $nomnatio =$_POST['nationalite'];
  $libnatio =$_POST['lib-nationalite'];

  if(isset($_POST['nationalite']))      $codnatio=$_POST['nationalite'];
else      $nomnatio="";

if(isset($_POST['lib-nationalite']))      $libnatio=$_POST['lib-nationalite'];
else      $libnatio="";
  

$conn = mysqli_connect('localhost', 'root', '', 'bddg8') or die('Erreur de connexion ' . mysqli_connect_error());

if (!$conn) {
      die('Could not connect to the databa  : ' . mysqli_connect_error());
  }

$sql = "INSERT INTO nationality(nom_natio,libele) VALUES('$codnatio','$libnatio')"; 
  // on insère les informations du formulaire dans la table 
mysqli_query($conn,$sql) or die('Erreur SQL !'.$sqli.'<br>'.mysqli_error($conn)); 

  // on affiche le résultat pour le visiteur 
  echo "Valeur de codnatio : " . $codnatio . "<br>";
  echo "Valeur de libnatio : " . $libnatio . "<br>";
  
echo 'Vos infos on été ajoutées Merci pour votre patience .'; 
}
?>