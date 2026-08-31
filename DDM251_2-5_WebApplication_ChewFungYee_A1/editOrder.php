<?php
session_start();

$servername = "localhost";
$username = "icfyshop";
$password = "ouAnDc-5hKQH9n(l";
$dbname = "icfyshop";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$orderID = $_GET['orderID'] ?? '';

if (empty($orderID)) {
    header("Location: order.php");
    exit();
}

$orderQuery = "SELECT * FROM orderlist WHERE orderID = '$orderID'";
$orderResult = mysqli_query($conn, $orderQuery);

if (!$orderResult || mysqli_num_rows($orderResult) == 0) {
    die("Order not found.");
}

$selectedUser = '';
$products = [];
$quantity = [];

while ($row = mysqli_fetch_assoc($orderResult)) {

    if ($selectedUser == '') {

        $customerQuery = "SELECT customerID FROM customer WHERE username = '" . $row['username'] . "'";
        $customerResult = mysqli_query($conn, $customerQuery);
        $customer = mysqli_fetch_assoc($customerResult);

        if ($customer) {
            $selectedUser = $customer['customerID'];
        }
    }

    $productQuery = "
        SELECT productID FROM product WHERE productName = '" . $row['productName'] . "'";
    $productResult = mysqli_query($conn, $productQuery);
    $product = mysqli_fetch_assoc($productResult);

    if ($product) {
        $products[] = $product['productID'];
        $quantity[] = $row['productQuantity'];
    }
}

$productList = [];
$productResult = $conn->query("SELECT * FROM product");

if ($productResult) {
    while ($row = $productResult->fetch_assoc()) {
        $productList[] = $row;
    }
}

if (isset($_POST['action']) && $_POST['action'] === 'add') {

    $selectedUser = $_POST['username'] ?? $selectedUser;
    $products = $_POST['productName'] ?? $products;
    $quantity = $_POST['quantity'] ?? $quantity;

    $products[] = '';
    $quantity[] = '';
}

if (isset($_POST['delete_index'])) {

    $selectedUser = $_POST['username'] ?? $selectedUser;
    $products = $_POST['productName'] ?? $products;
    $quantity = $_POST['quantity'] ?? $quantity;

    $indexToDelete = (int)$_POST['delete_index'];

    if (isset($products[$indexToDelete])) {

        unset($products[$indexToDelete]);
        unset($quantity[$indexToDelete]);

        $products = array_values($products);
        $quantity = array_values($quantity);
    }

    if (empty($products)) {
        $products = [''];
        $quantity = [''];
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Order</title>
    <link rel="stylesheet" href="css/common.css">
    <style>
        .product-row {
            display: flex;
            align-items: flex-end;
            gap: 15px;
            margin-bottom: 15px;
        }

          .dropdown:hover .dropdown-container {
            display: block;
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
                Order <span class="arrow">&#9660;</span>
            </button>
            <div class="dropdown-container">
                <a href="createOrder.php" class="sub-btn">
                    Create An Order
                </a>
                <a href="order.php" class="sub-btn">
                    Order List
                </a>
            </div>
        </div>
        <button>
            <a href="logOut.php" class="btn">Log out</a>
        </button>
    </div>


    <div class="main-content">
        <h3>Edit Order #<?php echo htmlspecialchars($orderID); ?></h3>
        <?php
        if (isset($_GET['error'])) {
            echo '<p style="color:red;">'. htmlspecialchars($_GET['error']). '</p>';
        }
        ?>

        <form action="updateOrder.php" method="POST">
            <input type="hidden" name="orderID" value="<?php echo htmlspecialchars($orderID); ?>">
            <div class="form-group">
                <label for="username">Username</label>
                <select name="username">
                    <option value="">Select a username</option>
                    <?php
                    $customerResult = $conn->query("SELECT customerID, username FROM customer");
                    while ($customer = $customerResult->fetch_assoc()) {
                    ?>
                        <option value="<?php echo $customer['customerID']; ?>"
                            <?php
                            if ($customer['customerID']== $selectedUser) {
                                echo 'selected';
                            }
                            ?>>
                            <?php echo htmlspecialchars($customer['username']);?>
                        </option>
                    <?php
                    }
                    ?>
                </select>
            </div>
            <br>

            <div class="product-container">
                <?php
                for ( $index = 0; $index < count($products); $index++) {
                    $selectedProduct = $products[$index];
                ?>
                    <div class="product-row">
                        <div class="form-group inline">
                            <label>Product Name</label>
                            <select name="productName[]">
                                <option value="">Select a product</option>
                                <?php
                                for (
                                    $p = 0;
                                    $p < count($productList);
                                    $p++
                                ) {
                                    $product = $productList[$p];
                                    $pSelected =($product['productID']== $selectedProduct)? 'selected': '';
                                ?>
                                    <option value="<?php echo $product['productID'];?>"<?php echo $pSelected; ?>>
                                        <?php echo htmlspecialchars($product['productName']);
                                        ?>
                                    </option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>

                        <div class="form-group inline">
                            <label>Quantity</label>
                            <select name="quantity[]">
                                <option value="">Select Quantity</option>
                                <?php
                                for ($i = 1; $i <= 10; $i++) {
                                    $qSelected =(isset($quantity[$index]) && $quantity[$index] == $i)? 'selected': '';
                                ?>
                                    <option value="<?php echo $i; ?>"<?php echo $qSelected; ?>>
                                        <?php echo $i; ?>
                                    </option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>

                        <button type="submit" name="delete_index" value="<?php echo $index; ?>"formaction="editOrder.php?orderID=<?php echo $orderID; ?>">
                            Delete
                        </button>
                    </div>
                <?php
                }
                ?>
            </div>

            <div class="form-row">
                <button type="submit" name="action" value="add" formaction="editOrder.php?orderID=<?php echo $orderID; ?>">
                    + Add Another Product
                </button>
            </div>

            <br>

            <div class="form-row">
                <button type="submit">Save Changes</button>
                <a href="order.php">
                    <button type="button">Cancel</button>
                </a>
            </div>
        </form>
    </div>
</body>
</html>