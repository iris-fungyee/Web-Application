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

$customerID = $_POST["customer_id"];
$name = $_POST["name"];
$password = $_POST["password"];
$confirm_password = $_POST["confirm_password"];

if (empty($name) || empty($password) || empty($confirm_password)) {
    header("Location: editCustomer.php?customerID=$customerID&error=Please fill in all fields.");
    
}

else if (strlen($password) < 6) {
    header("Location: editCustomer.php?customerID=$customerID&error=Password must be at least 6 characters long.");
  
}
else if ($password != $confirm_password) {
    header("Location: editCustomer.php?customerID=$customerID&error=Password and Confirm Password must be the same.");
    
}
else{
$sql = "UPDATE customer SET name='$name', password='$password' WHERE customerID='$customerID'";

        if (mysqli_query($conn, $sql)) {
        header("Location:customer.php");
        }
}
mysqli_close($conn);


?>
