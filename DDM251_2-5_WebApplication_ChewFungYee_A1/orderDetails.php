<?php
$servername = "localhost";
$username = "icfyshop";
$password = "ouAnDc-5hKQH9n(l";
$dbname = "icfyshop";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$orderdetailsID = $_GET['orderdetailsID'];

$orderIDQuery = "SELECT orderID FROM orderlist WHERE orderdetailsID='$orderdetailsID'";
$orderIDResult = mysqli_query($conn, $orderIDQuery);
$orderRow = mysqli_fetch_assoc($orderIDResult);
$orderID = $orderRow['orderID'];

$query = "SELECT * FROM orderlist WHERE orderID='$orderID'";
$result = mysqli_query($conn, $query) or die("Couldn't execute query");
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Details</title>
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
    <table width="1000">
        <tr>
            <th width="100">Order ID</th>
            <th width="100">Order Details ID</th>
            <th width="100">Username</th>
            <th width="100">Product Name</th>
            <th width="100">Order Date</th>
            <th width="100">Quantity</th>
            <th width="100">Product Price</th>
            <th width="100">Total Price</th>

        </tr>

        <?php 
        $grandTotal = 0;
        while ($orderlist = mysqli_fetch_assoc($result)): 
            $grandTotal += $orderlist['totalPrice'];
        ?>
       
            <tr>
                <td><?php echo $orderlist ['orderID'] ?></td>
                <td><?php echo $orderlist ['orderdetailsID'] ?></td>
                <td><?php echo $orderlist ['username'] ?></td>
                <td><?php echo $orderlist ['productName'] ?></td>
                <td><?php echo $orderlist ['orderDate'] ?></td>
                <td><?php echo $orderlist ['productQuantity'] ?></td>
                <td><?php echo $orderlist ['price'] ?></td>
                <td><?php echo $orderlist ['totalPrice'] ?></td>
                
            </tr>
            <?php endwhile; ?>
            
            <tr class="total-row">
                <td colspan="7" style="text-align: right; font-weight: bold; padding-right: 10px;">Total</td>
                <td style="font-weight: bold;"><?php echo $grandTotal; ?></td>
            </tr>

    </table>
    
        <a href="order.php" class="btn"><button type="button">Back to Order List</button></a>
        <a href="editOrder.php?orderID=<?php echo $orderID; ?>"><input type="button" value="Edit"></a>
    </div>
       


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

     