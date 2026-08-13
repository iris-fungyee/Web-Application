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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $fullname = $_POST['fullname'] ?? '';
    $email = $_POST['email'] ?? '';
    $phonenum = $_POST['phonenum'] ?? '';
    $categoryID = $_POST['categoryID'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    if (
        empty($fullname) || empty($email) || empty($phonenum) || empty($password) || empty($confirm_password)) {
        header("Location: register.php?error=Please fill in all fields.");
        exit();
    }

    else if (strlen($password) < 6) {
        header("Location: register.php?error=Password must be at least 6 characters long.");
        exit();
    }

    else if ($password != $confirm_password) {
        header("Location: register.php?error=Password and Confirm Password must be the same.");
        exit();
    }

    else if ($categoryID === '') {
        $categoryID = NULL;
    }

    $sql = "INSERT INTO user 
            (fullname, email, phonenum, categoryID, password)
            VALUES ('$fullname', '$email', '$phonenum', '$categoryID', '$password')";

    if (mysqli_query($conn, $sql)) {

        header("Location: home.php");
    } 
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - SecondChapter</title>
    <link rel="stylesheet" href="css/common.css">
</head>
<body>
    <div id="container">
        <div class="header">
            <h1>SecondChapter</h1>
        </div>
        
        <div class="register-box">
            <div class="register-header">
                <h2>Join SecondChapter</h2>
                <p>Begin and create your personal library card.</p>
            </div>

            <div class="register-body">

                <?php
                    if (isset($_GET['error'])) {
                    echo '<p class="error-message">' . htmlspecialchars($_GET['error']) . '</p>';
                    }   
                ?>

                <form action="register.php" method="POST">
                    <h3>FULL NAME</h3>
                    <input type="text" name="fullname" required>

                    <h3>EMAIL ADDRESS</h3>
                    <input type="text" name="email" required>

                    <h3>PHONE NUMBER</h3>
                    <input type="text" name="phonenum" required>

                    <h3>FAVOURITE GENRE</h3>
                        <select name="categoryID" required>

                        <option value="">No preference yet</option>

                        <?php
                        $result = $conn->query("SELECT categoryID, categoryName FROM bookcategory");
                        while ($row = $result->fetch_assoc()) {
                        ?>
                        <option value="<?php echo $row['categoryID']; ?>">
                            <?php echo $row['categoryName']; ?>
                        </option>
                        <?php
                        }
                        ?>
                        </select>

                    <h3>PASSWORD</h3>
                    <input type="password" name="password" required>

                    <h3>CONFIRM PASSWORD</h3>
                    <input type="password" name="confirm_password" required>
                    <button type="submit" class="index-btn">REGISTER</button>   
                </form>

                <p>Already have an account? <a href="login.php">Log in</a></p>
            </div>
        </div>
    </div>
</body>
</html>