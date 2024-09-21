<?php
if (isset($_POST['codeInput'])||isset($_POST['idd'])) {
  $code = intval($_POST['codeInput']);
  $num_etudient = intval($_POST['idd']);
  
  error_log("Received POST data:");
  error_log(print_r($_POST, true));

  // Create a connection to the database
  $db = mysqli_connect('localhost', 'root', '', 'bddg8');

  // Check the database connection
  if ($db === false) {
    die("Connection failed: " . mysqli_connect_error());
  }

  $query = "SELECT note FROM note WHERE num_etudient = ? AND code_module = ?";
  $stmt = $db->prepare($query);

  if (!$stmt) {
    die("Error in query preparation: " . $db->error);
  }

  $stmt->bind_param('ii', $num_etudient, $code);

  $stmt->execute();

  if ($stmt->error) {
    die("Error in query execution: " . $stmt->error);
  }

  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $note = $row['note'];
  } else {
    $note = null;
  }

  echo json_encode(['note' => $note]);
} else {
  echo json_encode(['note' => null]);
}
?>
