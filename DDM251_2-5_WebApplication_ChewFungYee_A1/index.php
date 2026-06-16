<?php
$servername = "localhost";
$username = "icfyshop";
$password = "ouAnDc-5hKQH9n(l";
$dbname = "icfyshop";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = $_POST["username"] ?? "";
    $password = $_POST["password"] ?? "";

    // Check both fields
    if ($username === "" || $password === "") {
        if ($username === "") {
            echo "Please enter your username<br>";
        }
        if ($password === "") {
            echo "Please enter your password<br>";
        }
    } else {
        // Query the database
        $sql = "SELECT * FROM customer WHERE username='$username'";
        $result = $conn->query($sql);

        if ($result->num_rows == 0) {
            echo "User not found";
        } else {
            $user = $result->fetch_assoc();

            if ($user["password"] != $password) {
                echo "Your password is incorrect";
            } else {
                header("Location: welcome.php");
                exit();
            }
        }
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

    .login-box {
      background: #BFDDF0;
      width: 300px;
    }

    .login-header {
      background: #8CC0EB;
      text-align: center;
      padding: 20px;
    }

    .login-header h2 {
      font-size: 25px;
      color: #FFEBCC;
    }

    .login-header p {
      font-size: 16px;
    }

     .login-body {
      padding: 20px;
    }

    .login-body .login-btn {
      background: #8CC0EB;
    }

    .login-body .signup-btn {
      background: #FFEBCC;
    }

  </style>
</head>

<body>

<div class="login-box">
    <div class="login-header">
      <h2>Welcome to icfyshop</h2>
      <p>Sign in</p>
    </div>

    <div class="login-body">
        <div id="username">
            <form target="_self" method="POST">
            <h2>Username</h2>
            <input type="text" name="username">
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