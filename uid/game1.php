<?php
session_start();

$servername = "localhost";
$username = "irisfungyee";
$password = "F7*PLPCW]9bW]QF_";
$dbname = "irisfungyee";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$currentUID = $_SESSION['UID'];

if (!isset($_SESSION['game1_updates'])) {
    $_SESSION['game1_updates'] = 0;
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['game1'])) {
    $game1 = $_POST["game1"];

    if ($_SESSION['game1_updates'] >= 2) {

        $message = "You can only update Game 1 a maximum of 2 times.";

    } else {
        
        $sql = "UPDATE uid SET game1 = '$game1' WHERE UID = '$currentUID'";
    
    //echo $currentUID;
    if ($conn->query($sql) === TRUE) {

        $_SESSION['game1_updates']++;

         $message = "Score saved! Updates used: " .
                       $_SESSION['game1_updates'] . "/2";
        //$message = "Saved score <strong>$game1</strong> for UID: <code>$currentUID</code>";
    } else {

            $message = "Database error: " . $conn->error;
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Button</title>
</head>
<body>
<form target="_self" method="POST">
    <button type="submit" name="game1" value="0" class="num-btn">0</button>
    <button type="submit" name="game1" value="1" class="num-btn">1</button>
    <button type="submit" name="game1" value="2" class="num-btn">2</button>
    <button type="submit" name="game1" value="3" class="num-btn">3</button>
    <button type="submit" name="game1" value="4" class="num-btn">4</button>
    <button type="submit" name="game1" value="5" class="num-btn">5</button>
</form>
</body>
</html>