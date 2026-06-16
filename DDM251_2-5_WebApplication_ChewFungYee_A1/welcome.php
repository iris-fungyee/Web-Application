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
  <style>
    body {
      margin: 0;
      font-family: Arial, sans-serif;
      display: flex;
    }
    /* Sidebar styling */
    .sidebar {
      width: 200px;
      background-color: #8CC0EB;
      color: black;
      height: 100vh;
      padding-top: 20px;
    }
    .sidebar button {
      display: block;
      width: 100%;
      padding: 12px;
      margin: 5px 0;
      border: none;
      background: #BFDDF0;
      color: black;
      text-align: left;
      cursor: pointer;
    }
    .sidebar button:hover {
      background: #8CC0EB;
    }
  
  </style>
</head>
<body>
  <div class="sidebar">
    <h2>icfy shop</h2>
    <button>Dashboard</button>
    <button>Customer</button>
    <button>Product</button>
    <button>Order</button>
    <button>Log out</button>
  </div>

</body>
</html>
