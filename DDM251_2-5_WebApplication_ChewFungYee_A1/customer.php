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
    <title>Customer List</title>
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
        <button>Product</button>
        <button>Order</button>
        <button>Log out</button>
    </div>

    <div>
    <table width="800">
        <tr>
            <th width="200">Customer ID</th>
            <th width="200">Username</th>
            <th width="200">Name</th>
        </tr>
        <?php

        $query = "SELECT * FROM customer";

        $result = mysqli_query($conn, $query) or die("Couldn't execute query");

        while ($row = mysqli_fetch_assoc($result)) {
        ?>
            <tr>
                <td><?php echo $row['customerID'] ?></td>
                <td><?php echo $row['username'] ?></td>
                <td><?php echo $row['name'] ?></td>
                <td> 
                    <a href="customerDetails.php"><input type="button" value="Details"></a>
                </td>
                <td><input type="button" value="Edit"></td>
                <td><input type="button" value="Delete"></td>
            </tr>
        <?php
        }
        mysqli_close($conn);
        ?>
        </div>

        <a href="addCustomer.php"><input type="submit" value="Add Customer"></a>
        
    </table>
</body>
</html>