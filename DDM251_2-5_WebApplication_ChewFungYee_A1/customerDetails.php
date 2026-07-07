<?php
$servername = "localhost";
$username = "icfyshop";
$password = "ouAnDc-5hKQH9n(l";
$dbname = "icfyshop";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$customerID = $_GET['customerID'];

$query = "SELECT * FROM customer WHERE customerID='$customerID'";
$result = mysqli_query($conn, $query) or die("Couldn't execute query");
$customer = mysqli_fetch_assoc($result);
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Details</title>
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
    <table width="800">
        <tr>
            <th width="200">Customer ID</th>
            <th width="200">Username</th>
            <th width="200">Name</th>
            <th width="200">Password</th>
        </tr>
       
            <tr>
                <td><?php echo $customer['customerID'] ?></td>
                <td><?php echo $customer['username'] ?></td>
                <td><?php echo $customer['name'] ?></td>
                <td><?php echo $customer['password'] ?></td>
            </tr>


        </div>

        <a href="customer.php"><input type="submit" value="Back"></a>
        <a href="editCustomer.php?customerID=<?php echo $customer['customerID'] ?>"><input type="button" value="Edit"></a>


    </body>
</html>

     