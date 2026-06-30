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

$productID = $_POST['productID'];
$productName = $_POST['productName'];
$description = $_POST['description'];
$price = $_POST['price'];

$sql = "INSERT INTO product (productID, productName, description, price)
VALUES ('$productID', '$productName', '$description', '$price')";

if (mysqli_query($conn, $sql)) {
  header("Location: product.php");
}

mysqli_close($conn);
?>