<?php
$servername = "localhost";
$username = "icfyshop";
$password = "ouAnDc-5hKQH9n(l";
$dbname = "icfyshop";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// SQL to delete a record
$sql = "DELETE FROM orderlist WHERE orderID = '" . $_GET["orderID"] . "'";

if ($conn->query($sql) === TRUE) {

  echo "Record deleted successfully";
} else {
  echo "Error deleting record: " . $conn->error;
}

$conn->close();
?>