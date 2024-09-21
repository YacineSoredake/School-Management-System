<?php

// Check if the "afficher_table" button is clicked
if (isset($_POST['afficher_table'])) {
  // Retrieve the student ID from the form
  $id = $_POST['idd'];

  // Redirect to a new page with the student ID as a parameter
  header("Location: listenote.php?id=$id");
  exit();
}

if (isset($_POST['enregistrer'])) {
    $idd = $_POST['idd'];
    $filiere = $_POST['filiere'];
    $code = $_POST['codeInput'];
    $coefficient = $_POST['coefficient'];
    $note = $_POST['note'];

    // Validation
    if (empty($idd) || empty($filiere) || empty($code) || empty($coefficient) || empty($note)) {
        echo '<font color="red">Veuillez remplir tous les champs</font>';
    } else {
        // Database connection
        $db = mysqli_connect('localhost', 'root', '', 'bddg8') or die('Erreur de connexion ' . mysqli_connect_error());

        // Prepared statement
        $sql = "INSERT INTO note (num_etudient, filiere, code_module, coefficient, note) VALUES (?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($db, $sql);

        // Bind parameters
        mysqli_stmt_bind_param($stmt, "isiii", $idd, $filiere, $code, $coefficient, $note);

        // Execute the statement
        if (mysqli_stmt_execute($stmt)) {
            echo 'La note a été ajoutée, merci !';
        } else {
            echo 'Erreur lors de l\'insertion : ' . mysqli_error($db);
        }

        // Close the database connection
        mysqli_close($db);
    }
}
if (isset($_POST['modifier'])) {
  $note = $_POST['note'];
  $id = $_POST['idd'];
  $code=$_POST['codeInput'];

  $conn = mysqli_connect('localhost', 'root', '', 'bddg8') or die('Erreur de connexion ' . mysqli_connect_error());
  
  if (!$conn) {
      die('Could not connect to the database: ' . mysqli_connect_error());
  }
  
  // Build the SQL query to update the record
  $sql = '';
  if ($note !== '') {
    $sql .= "UPDATE note SET `note` = '$note' WHERE num_etudient  = $id and code_module = $code;";
  } 

  if ($sql !== '') {
    $result = mysqli_multi_query($conn, $sql);
  
    if ($result) {
        echo "la note a été modifiée avec succées.";
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
  }
  
  // Close the database connection
  mysqli_close($conn); 

}
 
if (isset($_POST['supprimer'])) {
  $id = $_POST['idd'];
  $code = $_POST['codeInput'];

  $conn = mysqli_connect('localhost', 'root', '', 'bddg8') or die('Erreur de connexion ' . mysqli_connect_error());

  // Build the SQL query to delete the row
  $sql = "DELETE FROM note WHERE num_etudient = $id AND code_module = '$code'";

  if (mysqli_query($conn, $sql)) {
    if (mysqli_affected_rows($conn) > 0) {
      echo "La note de l'étudiant $id sur le module $code a été supprimée avec succès.";
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

