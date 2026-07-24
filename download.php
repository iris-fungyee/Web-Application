<?php
$servername = "localhost";
$username = "irisfungyee";
$password = "F7*PLPCW]9bW]QF_";
$dbname = "irisfungyee";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Build the query
if (isset($_GET['department']) && $_GET['department'] != "") {

    $department = mysqli_real_escape_string($conn, $_GET['department']);
    $query = "SELECT * FROM employee WHERE department='$department'";

} else {

    $query = "SELECT * FROM employee";

}

$result = mysqli_query($conn, $query);

// Tell the browser to download a CSV
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="employees.csv"');

$output = fopen('php://output', 'w');

// CSV headings
fputcsv($output, array('ID', 'Name', 'Department'));

$count = 1;

while ($row = mysqli_fetch_assoc($result)) {

    fputcsv($output, array(
        $count,
        $row['name'],
        $row['department']
    ));

    $count++;
}

fclose($output);
mysqli_close($conn);

exit;
?>