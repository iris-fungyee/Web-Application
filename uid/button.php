<?php
$servername = "localhost";
$username = "irisfungyee";
$password = "F7*PLPCW]9bW]QF_";
$dbname = "irisfungyee";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

session_start();
echo $_SESSION["UID"];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Button</title>
    <style>
        a {
            text-decoration: none;
        }
    </style>
</head>
<body>
    <button><a href="game1.php">Game 1</a></button>
    <button><a href="game2.php">Game 2</a></button>
    <button><a href="game3.php">Game 3</a></button>
</body>
</html>