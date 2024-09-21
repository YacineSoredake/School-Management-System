<?php
if (isset($_POST['filiere'])) {
    $filiere = $_POST['filiere'];

    // Establish a database connection (replace with your database credentials)
    $conn = mysqli_connect('localhost', 'root', '', 'bddg8');
    if (!$conn) {
        die('Could not connect to the database: ' . mysqli_connect_error());
    }

    // Define and execute your SQL query
    $sql = "SELECT designation FROM module WHERE Filiere = '$filiere'";
    $result = mysqli_query($conn, $sql);

    // Check for errors in the query
    if (!$result) {
        die('Error in the SQL query: ' . mysqli_error($conn));
    }

    // Fetch the options and return them as a JSON array
    $options = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $options[] = $row['designation'];
    }

    echo json_encode($options);

    // Close the database connection
    mysqli_close($conn);
}
?>
