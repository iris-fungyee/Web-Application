<?php
$servername = "localhost";
$username = "event";
$password = "FM)f9)o.3eihzH/6";
$dbname = "event";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

  $email = $_POST["email"];
  $password = $_POST["password"];

  $sql = "SELECT * FROM user WHERE email='$email' AND password='$password'";

// Execute the SQL query
  $result = $conn->query($sql);

// Process the result set
    if ($result->num_rows > 0) {

    $row = $result->fetch_assoc();

    $_SESSION["userID"] = $row["userID"];
    $_SESSION["email"] = $row["email"];

    header("Location: eventlist.php");
    exit();
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
    * {
      font-size: 20px;
    }

    body {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }
  </style>
</head>
<body>
     <div id="email">
    <form target="_self" method="POST">
      <h2>Enter your Email:</h2>
      <input type="text" name="email">
      <br />
      <h2>Password:</h2>
      <input type="password" name="password">
      <input type="submit">
    </form>
  </div>
    
</body>
</html>