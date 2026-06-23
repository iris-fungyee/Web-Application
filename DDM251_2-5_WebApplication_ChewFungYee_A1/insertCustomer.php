<?php
$servername = "localhost";
$username = "icfyshop";
$password = "ouAnDc-5hKQH9n(l";
$dbname = "icfyshop";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

$customerID = $_POST['customerID'];
$username = $_POST['username'];
$name = $_POST['name'];
$password = $_POST['password'];

$sql = "INSERT INTO customer (customerID, username, name, password)
VALUES ('$customerID', '$username', '$name', '$password')";

if (mysqli_query($conn, $sql)) {
  header("Location: customer.php");
}

mysqli_close($conn);
?>