<?php
$servername = "localhost";
$username = "irisfungyee";
$password = "F7*PLPCW]9bW]QF_";
$dbname = "irisfungyee";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

$ISBN = $_POST['ISBN'];
$title = $_POST['title'];
$author = $_POST['author'];
$description = $_POST['description'];
$price = $_POST['price'];

$sql = "INSERT INTO booklist (ISBN, title, author, description, price)
VALUES ('$ISBN', '$title', '$author', '$description', $price)";

// Check if any field is empty
if (empty($ISBN) || empty($title) || empty($author) || empty($description) || empty($price)) {
    header("Location: addBook.php?error=Please fill in all fields.");
}
else if (!preg_match('/^\d{13}$/', $ISBN)) { //is_numeric, else if rather than if
    header("Location: addBook.php?error=ISBN must contain exactly 13 digits.");
}
else if (!preg_match('/^\d+(\.\d{1,2})?$/', $price)) {
    header("Location: addBook.php?error=Price can only contain numbers.");
}
else if (mysqli_query($conn, $sql)) {
    header("Location: booklist.php");
    exit();
} 

mysqli_close($conn);
?>