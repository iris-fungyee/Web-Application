<?php
session_start();

$servername = "localhost";
$username = "icfyshop";
$password = "ouAnDc-5hKQH9n(l";
$dbname = "icfyshop";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// If user clicks "Create An Order" fresh from the sidebar menu, reset the form
if (isset($_GET['new'])) {
    unset($_SESSION['order_form']);
}

// Fetch dropdown data ONCE
$customers = [];
$customerResult = $conn->query("SELECT * FROM customer");
if ($customerResult) {
    while ($row = $customerResult->fetch_assoc()) {
        $customers[] = $row;
    }
}

$productList = [];
$productResult = $conn->query("SELECT * FROM product");
if ($productResult) {
    while ($row = $productResult->fetch_assoc()) {
        $productList[] = $row;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $selectedUser = $_POST['username'] ?? '';
    $products = $_POST['productName'] ?? [''];
    $quantity = $_POST['quantity'] ?? [''];
} elseif (isset($_GET['error']) && isset($_SESSION['order_form'])) {
    $selectedUser = $_SESSION['order_form']['username'] ?? '';
    $products = $_SESSION['order_form']['products'] ?? [''];
    $quantity = $_SESSION['order_form']['quantity'] ?? [''];
} else {
    // Fresh visit: Clear session and set empty defaults
    unset($_SESSION['order_form']);
    $selectedUser = '';
    $products = [''];
    $quantity = [''];
}

// 2. Handle "Add Another Product"
if (isset($_POST['action']) && $_POST['action'] === 'add') {
    $products[] = ''; 
    $quantity[] = '';
}

// 3. Handle "Delete" for a specific index
if (isset($_POST['delete_index'])) {
    $indexToDelete = (int)$_POST['delete_index'];
    
    if (isset($products[$indexToDelete])) {
        unset($products[$indexToDelete]);
        unset($quantity[$indexToDelete]);

        // Re-index both arrays cleanly
        $products = array_values($products);
        $quantity = array_values($quantity);
    }

    // Ensure at least one row remains
    if (empty($products)) {
        $products = [''];
        $quantity = [''];
    }
}

// ALWAYS update session state so page refreshes never wipe user selections
$_SESSION['order_form'] = [
    'username' => $selectedUser,
    'products' => $products,
    'quantity' => $quantity
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create An Order</title>
    <link rel="stylesheet" href="css/common.css">
    <style>
        input[type=text] {
            padding: 5px;
            box-sizing: border-box;
        }

        h3 {
            margin-left: 20px;
        }

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
        <button><a href="customer.php" class="btn">Customer</a></button>
        <button><a href="product.php" class="btn">Product</a></button>
        <div class="dropdown">
            <button class="dropdown-btn">
                Order <span class="arrow">&#9660;</span>
            </button>
            <div class="dropdown-container">
                <!-- Appended ?new=1 so clicking sidebar starts a brand new order -->
                <a href="createOrder.php?new=1" class="sub-btn">Create An Order</a>
                <a href="order.php" class="sub-btn">Order List</a>
            </div>
        </div>
        <button>
            <a href="logOut.php" class="btn">Log out</a>
        </button>
    </div>

<div class="main-content">
    <h3>Create A New Order</h3>

    <?php
    if (isset($_GET['error'])) {
        echo '<p class="error-message" style="color: red;">' . htmlspecialchars($_GET['error']) . '</p>';
    }   
    ?>
  
    <form action="" method="POST">
        <!-- Customer Selection -->
        <div class="form-group">
            <label for="username">Username</label>
            <select name="username">
                <option value="">Select a username</option>
                <?php foreach ($customers as $customer): ?>
                    <?php $uSelected = ($customer['customerID'] == $selectedUser) ? 'selected' : ''; ?>
                    <option value="<?php echo $customer['customerID']; ?>" <?php echo $uSelected; ?>>
                        <?php echo htmlspecialchars($customer['username']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <br>

        <!-- Dynamic Product Rows -->
        <div class="product-container" id="productContainer">
            <?php foreach ($products as $index => $selectedProduct): ?>
                <div class="product-row">
                    <!-- Product Dropdown -->
                    <div class="form-group inline">
                        <label>Product Name</label>
                        <select name="productName[]">
                            <option value="">Select a product</option>
                            <?php foreach ($productList as $product): ?>
                                <?php $pSelected = ($product['productID'] == $selectedProduct) ? 'selected' : ''; ?>
                                <option value="<?php echo $product['productID']; ?>" <?php echo $pSelected; ?>>
                                    <?php echo htmlspecialchars($product['productName']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
            
                    <!-- Quantity Dropdown -->
                    <div class="form-group inline">
                        <label>Quantity</label>
                        <select name="quantity[]">
                            <option value="">Select Quantity</option>
                            <?php for ($i = 1; $i <= 10; $i++): ?>
                                <?php $qSelected = (isset($quantity[$index]) && $quantity[$index] == $i) ? 'selected' : ''; ?>
                                <option value="<?php echo $i; ?>" <?php echo $qSelected; ?>><?php echo $i; ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>

                    <!-- Delete Row Button -->
                    <button type="submit" name="delete_index" value="<?php echo $index; ?>">Delete</button>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Add Product Row Button -->
        <div class="form-row">
            <button type="submit" name="action" value="add">+ Add Another Product</button>
        </div>

        <br>
        <!-- Submit / Navigation Buttons -->
        <div class="form-row">
            <button type="submit" formaction="insertOrder.php">Submit Order</button>
            <a href="order.php" class="btn"><button type="button">Back to Order List</button></a>
        </div>
    </form>
</div>

</body>
</html>