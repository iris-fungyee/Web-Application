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

$orderID = $_POST['orderID'] ?? '';
$selectedUser = $_POST['username'] ?? '';
$products = $_POST['productName'] ?? [];
$quantity = $_POST['quantity'] ?? [];

function redirectWithError($orderID, $message) {
    header(
        "Location: editOrder.php?orderID="
        . urlencode($orderID)
        . "&error="
        . urlencode($message)
    );
    exit();
}

if (empty($orderID)) {
    header("Location: order.php");
    exit();
}

if (empty($selectedUser)) {
    redirectWithError(
        $orderID,
        "Please select a username."
    );
}

if (empty($products) || empty($quantity)) {

    redirectWithError(
        $orderID,
        "Please add at least one product."
    );
}

foreach ($products as $index => $product) {
    if (empty($product)) {
        redirectWithError(
            $orderID,
            "Please select a product for every row."
        );
    }

    if (empty($quantity[$index])) {
        redirectWithError(
            $orderID,
            "Please select a quantity for every product."
        );
    }
}

if (count($products) != count(array_unique($products))) {
    redirectWithError(
        $orderID,
        "Products cannot be duplicated."
    );
}

$customerQuery = "SELECT username, name FROM customer WHERE customerID = '$selectedUser'";
$customerResult = mysqli_query($conn, $customerQuery);

if (
    !$customerResult||mysqli_num_rows($customerResult) == 0) {
    redirectWithError(
        $orderID,
        "Customer not found."
    );
}

$customer = mysqli_fetch_assoc($customerResult);
$customerUsername = $customer['username'];
$customerName = $customer['name'];

$orderDate = date("Y-m-d H:i:s");

$deleteQuery = "DELETE FROM orderlist WHERE orderID = '$orderID'";

if (!mysqli_query($conn, $deleteQuery)) {
    die(
        "Error deleting old order: "
        . mysqli_error($conn)
    );
}

foreach ($products as $index => $productID) {
    $qty = $quantity[$index];

    $productQuery = "SELECT productName, price FROM product WHERE productID = '$productID'";
    $productResult = mysqli_query($conn, $productQuery);

    if (
        !$productResult||
        mysqli_num_rows($productResult) == 0
    ) {
        die("Product not found.");
    }

    $product = mysqli_fetch_assoc($productResult);

    $productName = $product['productName'];
    $price = $product['price'];

    $totalPrice = $price * $qty;

    $sql = "INSERT INTO orderlist (orderID, username, name, orderDate, productName, productQuantity, price, totalPrice)
            VALUES ('$orderID','$customerUsername','$customerName','$orderDate','$productName','$qty','$price','$totalPrice')";

    if (!mysqli_query($conn, $sql)) {
        die(
            "Error updating order: "
            . mysqli_error($conn)
        );
    }
}

mysqli_close($conn);
header(
    "Location: order.php?success="
    . urlencode("Order updated successfully.")
);
exit();
?>