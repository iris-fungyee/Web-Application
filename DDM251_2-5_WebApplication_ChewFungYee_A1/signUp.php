<?php
$servername = "localhost";
$username = "icfyshop";
$password = "ouAnDc-5hKQH9n(l";
$dbname = "icfyshop";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $name = $_POST['name'] ?? '';
    $password = $_POST['password'] ?? '';

    if (empty($username) || empty($name) || empty($password)) {
        $error = "Please fill in all fields.";
    } else {
        $checkQuery = "SELECT * FROM customer WHERE username = '$username'";
        $checkResult = mysqli_query($conn, $checkQuery);

        if (mysqli_num_rows($checkResult) > 0) {
            $error = "Username already exists.";
        } else {
            $sql = "INSERT INTO customer (username, name, password)
                    VALUES ('$username', '$name', '$password')";

            if (mysqli_query($conn, $sql)) {
                header("Location: index.php?success=Account created successfully.");
                exit();
            } else {
                $error = "Error creating account.";
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
    <title>Sign Up</title>
    <link rel="stylesheet" href="css/common.css">
</head>
<body>
       <div class="main-content">
        <h3>Create An Account</h3>
            <?php
                if ($error != "") {
                echo '<p class="error-message">' . htmlspecialchars($error) . '</p>';
                }
                ?>

        <form method="POST">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" value="<?php echo htmlspecialchars($username ?? ''); ?>">
            </div>

            <div class="form-group">
                <label>Name</label>
                <input type="text" name="name" value="<?php echo htmlspecialchars($name ?? ''); ?>">
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password">
            </div>

            <br>
            <button type="submit">Sign Up</button>
        </form>

        <p>Already have an account? <a href="index.php">Log In</a></p>
       </div>
</body>
</html>