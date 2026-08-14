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
    <title>Order List</title>
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
        <button>Log out</button>
    </div>

    <div>
    <table width="1000">
        <h3 class="title"> Order List </h3>
        <tr>
            <th  width="200">Order ID</th>
            <th  width="200">Username</th>
            <th  width="200">Name</th>
            <th  width="200">Order Date and Time</th>

        </tr>
        <?php

        $query = "SELECT * FROM orderlist GROUP BY orderID, username, name, orderDate";
        
        $result = mysqli_query($conn, $query) or die("Couldn't execute query");

        while ($row = mysqli_fetch_assoc($result)) {
        ?>
            <tr>
                <td><?php echo $row['orderID'] ?></td>
                <td><?php echo $row['username'] ?></td>
                <td><?php echo $row['name'] ?></td>
                <td><?php echo $row['orderDate'] ?></td>
                <td> 
                    <a href="orderDetails.php?orderdetailsID=<?php echo $row['orderdetailsID']; ?>">
                    <input type="button" value="Details">
                    </a>
                 <td> 
                <td>    
                    <input type="button" value="Edit">
                </td>
                <td> 
                    <input type="button" value="Delete">
                </td>
            </tr>
        <?php
        }
        mysqli_close($conn);
        ?>
        </div>

        <a href="createOrder.php"><input type="submit" value="Create New Order"></a>
        
    </table>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const dropdownBtn = document.querySelector(".dropdown-btn");
        
        dropdownBtn.addEventListener("click", function () {
            const parent = this.parentElement;
            parent.classList.toggle("active");
        });
    });
</script>
</body>
</html>