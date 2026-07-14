<?php
$servername = "localhost";
$username = "icfyshop";
$password = "ouAnDc-5hKQH9n(l";
$dbname = "icfyshop";
 session_start();
// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

$productID = $_POST["productID"];
$productName = $_POST["productName"];
$description = $_POST["description"];
$price = $_POST["price"];


if (empty($productName) || empty($price) || empty($description)) {
    header("Location: editProduct.php?productID=$productID&error=Please fill in all fields.");
    
}

else if (!is_numeric($price)) {
    header("Location: editProduct.php?productID=$productID&error=Invalid price. Please use numbers only.");
}
else{
$sql = "UPDATE product SET productName='$productName', description='$description', price='$price' WHERE productID='$productID'";

        if (mysqli_query($conn, $sql)) {
        header("Location: product.php");
        }
}
mysqli_close($conn);


?>
