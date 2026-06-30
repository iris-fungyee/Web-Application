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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product List</title>
    <link rel="stylesheet" href="css/common.css">
    <style>       

    input[type=submit] {
        padding: 12px;
        margin: 20px;
        cursor: pointer;
        background-color: #8CC0EB;
        color: white;
        border: none;
        border-radius: 3px;
        font-size: 15px;
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
    <table width="1000">
        <tr>
            <th  width="200">Product ID</th>
            <th  width="200">Product Name</th>
            <th  width="200">Description</th>
            <th  width="200">Price (RM)</th>

        </tr>
        <?php

        $query = "SELECT * FROM product";

        $result = mysqli_query($conn, $query) or die("Couldn't execute query");

        while ($row = mysqli_fetch_assoc($result)) {
        ?>
            <tr>
                <td><?php echo $row['productID'] ?></td>
                <td><?php echo $row['productName'] ?></td>
                <td><?php echo $row['description'] ?></td>
                <td><?php echo $row['price'] ?></td>
                <td> 
                    <a href=""><input type="button" value="Details"></a>
                </td>
                <td><input type="button" value="Edit"></td>
                <td><input type="button" value="Delete"></td>
            </tr>
        <?php
        }
        mysqli_close($conn);
        ?>
        </div>

        <a href="addProduct.php"><input type="submit" value="Add Product"></a>
        
    </table>
</body>
</html>