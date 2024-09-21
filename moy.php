<?php
// Assuming you have a database connection established
$db = mysqli_connect('localhost', 'root', '', 'bddg8') or die('Erreur de connexion ' . mysqli_connect_error());

// Fetch data for histogram
$histogramQuery = "SELECT COUNT(*) AS count, CASE WHEN role = 'admin' THEN 'admin' ELSE 'user' END AS moyenne_category
                  FROM user 
                  GROUP BY moyenne_category";
$histogramResult = mysqli_query($db, $histogramQuery);

$histogramData = array('labels' => array(), 'datasets' => array(array('data' => array())));

while ($row = mysqli_fetch_assoc($histogramResult)) {
    $histogramData['labels'][] = $row['moyenne_category'];
    $histogramData['datasets'][0]['data'][] = $row['count'];
}

// Fetch data for pie chart
$pieChartQuery = "SELECT COUNT(*) AS count, CASE WHEN role = 'admin' THEN 'admin' ELSE 'user' END AS moyenne_category
                  FROM user 
                  GROUP BY moyenne_category";
$pieChartResult = mysqli_query($db, $pieChartQuery);

$pieChartData = array('labels' => array(), 'datasets' => array(array('data' => array())));

while ($row = mysqli_fetch_assoc($pieChartResult)) {
    $pieChartData['labels'][] = $row['moyenne_category'];
    $pieChartData['datasets'][0]['data'][] = $row['count'];
}

// Close the database connection
mysqli_close($db);

// Return data as JSON
header('Content-Type: application/json');
echo json_encode(array('histogramData' => $histogramData, 'pieChartData' => $pieChartData));
?>
