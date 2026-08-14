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

// Get submitted data
$selectedUser = $_POST['username'] ?? '';
$products = $_POST['productName'] ?? [];
$quantity = $_POST['quantity'] ?? [];

// Store current state in session immediately
$_SESSION['order_form'] = [
    'username' => $selectedUser,
    'products' => $products,
    'quantity' => $quantity
];

// Helper function to safely save session before HTTP redirects
function redirectWithError($message) {
    session_write_close();
    header("Location: createOrder.php?error=" . urlencode($message));
    exit();
}

// ===============================
// 1. CHECK CUSTOMER
// ===============================
if (empty($selectedUser)) {
    redirectWithError("Please select a username.");
}

// ===============================
// 2. CHECK PRODUCTS AND QUANTITY
// ===============================
if (empty($products) || empty($quantity)) {
    redirectWithError("Please add at least one product.");
}

// ===============================
// 3. CHECK EACH ROW IS FILLED
// ===============================
foreach ($products as $index => $product) {
    if (empty($product)) {
        redirectWithError("Please select a product for every row.");
    }

    if (empty($quantity[$index])) {
        redirectWithError("Please select a quantity for every product.");
    }
}

// ===============================
// 4. CHECK DUPLICATE PRODUCTS
// ===============================
if (count($products) != count(array_unique($products))) {
    redirectWithError("Products cannot be duplicated.");
}

// ===============================
// 5. GET CUSTOMER INFORMATION
// ===============================
$customerQuery = "SELECT * FROM customer WHERE customerID = '$selectedUser'";
$customerResult = mysqli_query($conn, $customerQuery);

if (!$customerResult || mysqli_num_rows($customerResult) == 0) {
    redirectWithError("Customer not found.");
}

$customer = mysqli_fetch_assoc($customerResult);
$customerUsername = $customer['username'];
$customerName = $customer['name'];

// ===============================
// 6. CREATE ORDER ID
// ===============================
$orderQuery = "SELECT MAX(orderID) AS maxOrderID FROM orderlist";
$orderResult = mysqli_query($conn, $orderQuery);
$orderRow = mysqli_fetch_assoc($orderResult);

$orderID = ($orderRow['maxOrderID'] == NULL) ? 1 : $orderRow['maxOrderID'] + 1;

// ===============================
// 7. GET CURRENT DATE/TIME
// ===============================
$orderDate = date("Y-m-d H:i:s");

// ===============================
// 8. INSERT EACH PRODUCT
// ===============================
$orderdetailsID = 1;

// ===============================
// 8. INSERT EACH PRODUCT
// ===============================
foreach ($products as $index => $productID) {
    $qty = $quantity[$index];

    // Get product information
    $productQuery = "SELECT * FROM product WHERE productID = '$productID'";
    $productResult = mysqli_query($conn, $productQuery);
    $product = mysqli_fetch_assoc($productResult);

    $productName = $product['productName'];
    $price = $product['price'];
    $totalPrice = $price * $qty;

    // Notice orderdetailsID is removed from columns and values
    $sql = "INSERT INTO orderlist (orderID, username, name, orderDate, productName, productQuantity, price, totalPrice)
            VALUES ('$orderID', '$customerUsername', '$customerName', '$orderDate', '$productName', '$qty', '$price', '$totalPrice')";

    if (!mysqli_query($conn, $sql)) {
        die("Error inserting order: " . mysqli_error($conn));
    }
}

// ===============================
// 9. SUCCESS - CLEAR SESSION & REDIRECT
// ===============================
unset($_SESSION['order_form']);
session_write_close();
mysqli_close($conn);

header("Location: order.php?success=Order created successfully.");
exit();
?>