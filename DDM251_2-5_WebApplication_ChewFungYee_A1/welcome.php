<?php
$servername = "localhost";
$username = "icfyshop";
$password = "ouAnDc-5hKQH9n(l";
$dbname = "icfyshop";

session_start();
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$username = $_SESSION['username']; //?? "" means else

$sql = "SELECT * FROM customer WHERE username = '$username'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    $name = $user['name'];
    } else {
    header("Location: index.php");
    exit();
}

/* TOTAL ORDER */
$sql = "SELECT COUNT(DISTINCT orderID) AS totalOrder
        FROM orderlist";

$result = $conn->query($sql);
$row = $result->fetch_assoc();
$totalOrder = $row['totalOrder'];

/* PRODUCTS HAVEN'T SOLD */
$sql = "SELECT COUNT(*) AS unsold
        FROM product p
        LEFT JOIN orderlist o
        ON p.productName = o.productName
        WHERE o.productName IS NULL";

$result = $conn->query($sql);
$row = $result->fetch_assoc();
$unsold = $row['unsold'];

/* CUSTOMERS HAVEN'T PURCHASED */
$sql = "SELECT COUNT(*) AS noPurchase
        FROM customer c
        LEFT JOIN orderlist o
        ON c.username = o.username
        WHERE o.username IS NULL";

$result = $conn->query($sql);
$row = $result->fetch_assoc();

$noPurchase = $row['noPurchase'];


/* TOP 3 PRODUCTS */
$sql = "SELECT productName, SUM(productQuantity) AS totalSold
        FROM orderlist
        GROUP BY productName
        ORDER BY totalSold DESC
        LIMIT 3";

$topProducts = $conn->query($sql);
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

<div class="main-content">
    <div class="welcome-header">
        <h1>Welcome, <?php echo $name; ?> </h1>
    </div>

    <div class="card-container">
        <div class="card">
            <p>Total Order</p>
            <h2><?php echo $totalOrder; ?></h2>
        </div>

        <div class="card">
            <p>Product Haven't Sell</p>
            <h2><?php echo $unsold; ?></h2>
        </div>

        <div class="card">
            <p>Customers Haven't Purchase</p>
            <h2><?php echo $noPurchase; ?></h2>
        </div>
    </div>

    <div class="top-products">
        <h3>Top 3</h3>

        <table>
        <?php while ($row = $topProducts->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $row['productName']; ?></td>
            <td><?php echo $row['totalSold']; ?></td>
        </tr>
        <?php } ?>
    </table>
    </div>
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
