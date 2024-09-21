<?php

if (isset($_POST['enregistrer'])) {
    $email = $_POST['email'];
    $mdp = $_POST['mdp'];
    $role = $_POST['role'];
    $id_etudient = isset($_POST['id_etudient'])? $id_etudient : NULL;

    // Validation
    if ( empty($email) || empty($mdp) || empty($role)) {
        echo '<font color="red">Veuillez remplir tous les champs</font>';
    } else {
        // Database connection
        $db = mysqli_connect('localhost', 'root', '', 'bddg8') or die('Erreur de connexion ' . mysqli_connect_error());

        // Prepared statement
        $sql = "INSERT INTO user (email, mdp, role,id_etudient) VALUES (?, ?, ?,?)";
        $stmt = mysqli_prepare($db, $sql);

        // Bind parameters
        mysqli_stmt_bind_param($stmt, "sssi",$email, $mdp, $role,$id_etudient);

        // Execute the statement
        if (mysqli_stmt_execute($stmt)) {
            echo "L'email a été ajoutée, merci !";
        } else {
            echo 'Erreur lors de l\'insertion : ' . mysqli_error($db);
        }

        // Close the database connection
        mysqli_close($db);
    }
}
if (isset($_POST['modifier'])) {
    $id = $_POST['id'];
    $email = $_POST['email'];
    $mdp = $_POST['mdp'];
    $role = $_POST['role'];
    $id_etudient = $_POST['id_etudient'];

  $conn = mysqli_connect('localhost', 'root', '', 'bddg8') or die('Erreur de connexion ' . mysqli_connect_error());
  
  if (!$conn) {
      die('Could not connect to the database: ' . mysqli_connect_error());
  }
  
  // Build the SQL query to update the record
  $sql = '';
  if ($email !== '') {
    $sql .= "UPDATE user SET `email` = '$email' WHERE id  = $id; ";
  } 
  if ($mdp !== '') {
    $sql .= "UPDATE user SET `mdp` = '$mdp' WHERE id  = $id; ";
  } 
  if ($role !== '') {
    $sql .= "UPDATE user SET `role` = '$role' WHERE id  = $id; ";
  } 
  if ($id_etudient !== '') {
    $sql .= "UPDATE user SET `id_etudient` = '$id_etudient' WHERE id  = $id; ";
  } 

  if ($sql !== '') {
    $result = mysqli_multi_query($conn, $sql);
  
    if ($result) {
        echo "l'eamil a été modifiée avec succées.";
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
  }
  
  // Close the database connection
  mysqli_close($conn); 

}
 
if (isset($_POST['supprimer'])) {
    $id = $_POST['id'];

  $conn = mysqli_connect('localhost', 'root', '', 'bddg8') or die('Erreur de connexion ' . mysqli_connect_error());

  // Build the SQL query to delete the row
  $sql = "DELETE FROM user WHERE id = $id";

  if (mysqli_query($conn, $sql)) {
    if (mysqli_affected_rows($conn) > 0) {
      echo "L'émail $id a été supprimée avec succès.";
    } else {
      echo "Aucune ligne n'a été supprimée";
    }
  } else {
    echo "Error deleting record: " . mysqli_error($conn);
  }

  // Close the database connection
  mysqli_close($conn);
}

?>

