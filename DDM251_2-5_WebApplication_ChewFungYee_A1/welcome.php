<?php
$servername = "localhost";
$username = "icfyshop";
$password = "ouAnDc-5hKQH9n(l";
$dbname = "icfyshop";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Welcome</title>
  <link rel="stylesheet" href="css/common.css">
</head>
<body>
  
  <div class="sidebar">
    <h2>iCFY shop</h2>
    <button>Dashboard</button>
    <button>
      <a href="customer.php" class="btn">Customer</a>
    </button>
    <button>Product</button>
    <button>Order</button>
    <button>Log out</button>
  </div>

</body>
</html>
