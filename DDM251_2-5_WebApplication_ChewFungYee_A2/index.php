<?php
$servername = "localhost";
$username = "secondchapter";
$password = "cB]EYDah/79Jos0O";
$dbname = "secondchapter";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - The Second Chapter</title>
</head>
<body>
    <div class="login-box">
    <div class="login-header">
      <h2>Welcome to The Second Chapter</h2>
      <p></p>
    </div>

    <div class="login-body">
        <div id="email">
            <form target="_self" method="POST">
            <h2>Email</h2>
            <input type="text" name="email">
            <br />
            <h2>Password</h2>
            <input type="password" name="password">
            <button type="submit" class="login-btn">Login</button>
            <button type="button" class="signup-btn">Sign up</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>