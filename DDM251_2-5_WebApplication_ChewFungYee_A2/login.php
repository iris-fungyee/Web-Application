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

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = $_POST["email"] ?? "";
    $password = $_POST["password"] ?? "";

    if (empty($email) || empty($password)) {
    header("Location: login.php?error=Please enter your email and password.");
    exit();
    }

    else if ($email === "") {
    header("Location: login.php?error=Please enter your email.");
    exit();
    }

    else if ($password === "") {
    header("Location: login.php?error=Please enter your password.");
    exit();
    }

    $sql = "SELECT * FROM user WHERE email='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows == 0) {
            header("Location: login.php?error=Email is not found.");
            exit();
    } else {
            $user = $result->fetch_assoc();
            }

    if ($user["password"] != $password) {
                header("Location: login.php?error=Your password is incorrect.");
                exit();

            } else {
                header("Location: home.php");
                exit();
            }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SecondChapter</title>
    <link rel="stylesheet" href="css/common.css">
</head>
<body>
<div id="container">
    <div class="header">
        <h1>SecondChapter</h1>
    </div>
    
    <div class="login-box">
        <div class="login-header">
            <h2>Welcome In</h2>
            <p>Your personal digital library card.</p>
        </div>

        <div class="login-body">

            <?php
                if (isset($_GET['error'])) {
                    echo '<p class="error-message">' . htmlspecialchars($_GET['error']) . '</p>';
                    }   
            ?> 

            <form target="_self" method="POST">
                <h3>EMAIL ADDRESS</h3>
                <input type="text" name="email">
                <h3>PASSWORD</h3>
                <input type="password" name="password">
                <button type="submit" class="index-btn">LOGIN</button>   
            </form>

                <p>New here? <a href="register.php">Create an account</a></p>
        </div>
    </div>
</div>
</body>
</html>