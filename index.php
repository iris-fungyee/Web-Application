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

if ($_SERVER["REQUEST_METHOD"] == "POST") {

  $email = $_POST["email"];
  $password = $_POST["password"];

  $sql = "SELECT * FROM student WHERE email='$email' AND password='$password'";

// Execute the SQL query
  $result = $conn->query($sql);

// Process the result set
  if ($result->num_rows > 0) {
  $_SESSION["email"] = $_POST["email"];
  header("Location:booklist.php");
  
  echo "Login Successful";
  } else {
  echo "Invalid email or password";
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