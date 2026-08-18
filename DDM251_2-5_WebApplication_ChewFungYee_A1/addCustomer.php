<?php
$servername = "localhost";
$username = "icfyshop";
$password = "ouAnDc-5hKQH9n(l";
$dbname = "icfyshop";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Customer</title>
    <link rel="stylesheet" href="css/common.css">
    <style>
        input[type=text] {
            padding: 5px;
            box-sizing: border-box;
        }

        h3 {
            margin-left: 20px;
        }

    </style>
</head>

<body>
<div class="sidebar">
        <h2>iCFY Shop</h2>
        <button>
            <a href="welcome.php" class="btn">Dashboard</a>
        </button>
         <button>
           <a href="customer.php" class="btn">Customer</a>
        </button>
        <button>
            <a href="product.php" class="btn">Product</a>
        </button>
        <div class="dropdown">
        <button class="dropdown-btn">
            Order
            <span class="arrow">&#9660;</span>
        </button>
            <div class="dropdown-container">
                <a href="createOrder.php" class="sub-btn">Create An Order</a>
                <a href="order.php" class="sub-btn">Order List</a>
         </div>
        </div>
        <button>
            <a href="logOut.php" class="btn">Log out</a>
        </button>
    </div>

    <div>
        <h3> Create / Add New Customer </h3>
    <table width="600">
        <tr>
            <th>Customer ID</th>
            <th>Username</th>
            <th>Name</th>
            <th>Password</th>
        </tr>
        <tr>
            <form action="insertCustomer.php" method="POST">
                <td><input type=text name=customerID></td>
                <td><input type=text name=username></td>
                <td><input type=text name=name></td>
                <td><input type=text name=password></td>
                <td><input type=submit value=Add></td>
            </form>
        </tr>
    </div>
</body>
</html>
