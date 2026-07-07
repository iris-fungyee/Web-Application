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

$customerID = $_GET['customerID'];

$query = "SELECT * FROM customer WHERE customerID='$customerID'";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Customer</title>
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
        <button>Dashboard</button>
         <button>
           <a href="customer.php" class="btn">Customer</a>
        </button>
        <button>Product</button>
        <button>Order</button>
        <button>Log out</button>
    </div>

    <a href="customer.php"><input type="submit" value="Back"></a>

     <div>
        <h3>Edit Customer Information</h3>
    <table width="1000">
        <tr>
            <th width="200">Customer ID</th>
            <th width="200">Username</th>
            <th width="200">Password</th>
            <th width="200">Confirm Password</th>
            <th width="200">Name</th>
        </tr>
        
        <tr>
            <form action="updateCustomer.php" method="POST">
                <td><input type=text name=customer_id value="<?php echo $row['customerID']; ?>" readonly> </td>
                <td><input type=text name=username value="<?php echo $row['username']; ?>" readonly></td>
                <td><input type=password name=password></td>
                <td><input type=password name=confirm_password></td>
                <td><input type=text name=name></td>
                <td><input type=submit value=Submit></td>
            </form>
        </tr>
    </table>
    </div>
</body>
</html>