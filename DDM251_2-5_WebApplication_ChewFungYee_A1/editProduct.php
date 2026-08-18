<?php
$servername = "localhost";
$username = "icfyshop";
$password = "ouAnDc-5hKQH9n(l";
$dbname = "icfyshop";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

//if (isset($_GET["error"])) {
//  echo "<p style='color:red'>" . $_GET["error"] . "</p>";
//}

if (isset($_GET["error"])) {
    echo "<p class='error-message'>" . htmlspecialchars($_GET["error"]) . "</p>";
}

session_start();

$productID = $_GET['productID'];

$query = "SELECT * FROM product WHERE productID='$productID'";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
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

    .error-message {
    color: #d8000c;
    position: absolute;
    top: 20px;
    left: 50%;
    transform: translateX(-50%);
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

    <a href="product.php"><input type="submit" value="Back"></a>

     <div>
        <h3>Edit Product Information</h3>
    <table width="1000">
        <tr>
            <th width="200">Product ID</th>
            <th width="200">Product Name</th>
            <th width="200">Description</th>
            <th width="200">Price</th>
          
        </tr>
        
        <tr>
            <form action="updateProduct.php" method="POST">
                <td><input type=text name=productID value="<?php echo $row['productID']; ?>" readonly> </td>
                <td><input type=text name=productName></td>
                <td><input type=text name=description ></td>
                <td><input type=text name=price></td>
                <td><input type=submit value=Submit></td>
            </form>
        </tr>
    </table>
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