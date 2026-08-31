<?php
session_start();

$servername = "localhost";
$username = "secondchapter";
$password = "cB]EYDah/79Jos0O";
$dbname = "secondchapter";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$email = $_SESSION['email'];

// Get current user's ID
$userQuery = "SELECT userID FROM user WHERE email = '$email'";
$userResult = mysqli_query($conn, $userQuery);

$user = mysqli_fetch_assoc($userResult);
$userID = $user['userID'];

// Get book ID
$bookID = $_POST['bookID'];

// Check if already marked as read
$checkQuery = "SELECT * FROM readbook
               WHERE bookID = '$bookID'
               AND userID = '$userID'";

$checkResult = mysqli_query($conn, $checkQuery);

if (mysqli_num_rows($checkResult) == 0) {

    $insertQuery = "INSERT INTO readbook (bookID, userID)
                    VALUES ('$bookID', '$userID')";

    mysqli_query($conn, $insertQuery);
}

// Go back to book details
header("Location: bookDetails.php?bookID=$bookID");
exit();
?>