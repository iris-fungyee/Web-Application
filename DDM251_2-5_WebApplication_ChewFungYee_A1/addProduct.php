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
    <title>Add Product</title>
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
        <button>Dashboard</button>
         <button>
           <a href="customer.php" class="btn">Customer</a>
        </button>
        <button>
            <a href="product.php" class="btn">Product</a>
        </button>
        <button>Order</button>
        <button>Log out</button>
    </div>

    <div>
        <h3> Create / Add New Product </h3>
    <table width="1000">
        <tr>
            <th  width="200">Product ID</th>
            <th  width="200">Product Name</th>
            <th  width="200">Description</th>
            <th  width="200">Price (RM)</th>
        </tr>
        <tr>
            <form action="insertProduct.php" method="POST">
                <td><input type=text name=productID></td>
                <td><input type=text name=productName></td>
                <td><input type=text name=description></td>
                <td><input type=text name=price></td>
                <td><input type="submit" value="Add"></td>
                <a href="product.php"><input type="submit" value="Back to Products"></a>
             
            </form>
        </tr>
    </div>
</body>
</html>
