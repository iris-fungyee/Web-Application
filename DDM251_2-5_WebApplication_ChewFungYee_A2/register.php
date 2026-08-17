<?php
session_start();

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

$fullname = '';
$email = '';
$phonenum = '';
$categoryID = '';
$password = '';
$confirm_password = '';
$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') { 
    $fullname = $_POST['fullname'] ?? ''; 
    $email = $_POST['email'] ?? ''; 
    $phonenum = $_POST['phonenum'] ?? ''; 
    $categoryID = $_POST['categoryID'] ?? ''; 
    $password = $_POST['password'] ?? ''; 
    $confirm_password = $_POST['confirm_password'] ?? '';

if (empty($fullname) || empty($email) || empty($phonenum) || empty($password) || empty($confirm_password)) 
{
    $error = "Please fill in all fields.";

} else if (strlen($password) < 6) {

    $error = "Password must be at least 6 characters long.";

} else if ($password != $confirm_password) {

    $error = "Password and Confirm Password must be the same.";
}

if ($error == "") {

    if ($categoryID === '') {
        $categoryID = NULL;
    }

    $sql = "INSERT INTO user (fullname, email, phonenum, categoryID, password)
            VALUES ('$fullname', '$email', '$phonenum', " . ($categoryID === NULL ? "NULL" : "'$categoryID'") . ",'$password')";

    if (mysqli_query($conn, $sql)) {
        $_SESSION['email'] = $email;
        
        header("Location: home.php");
        exit();
    }
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
    <div class="header-banner">
        <div class="header">
            <h1>Second<span class="logo">Chapter</span></h1>
        </div>  
    </div>

    <div id="container">
        <div class="access-box">
            <div class="access-header">
                <h2>Join SecondChapter</h2>
                <p>Begin and create your personal library card.</p>
            </div>

            <div class="access-body">
              <?php
                if ($error != "") {
                echo '<p class="error-message">' . htmlspecialchars($error) . '</p>';
                }
                ?>

                <form action="register.php" method="POST">

                    <label for="fullname">FULL NAME</label>
                    <input type="text" name="fullname" value="<?php echo htmlspecialchars($fullname); ?>">

                    <label for="email">EMAIL ADDRESS</label>
                    <input type="text" name="email" value="<?php echo htmlspecialchars($email); ?>">

                    <label for="phonenum">PHONE NUMBER</label>
                    <input type="tel" name="phonenum"  value="<?php echo htmlspecialchars($phonenum); ?>">

                    <label for="category">FAVOURITE GENRE</label>
                        <select name="categoryID">

                        <option value="">No preference yet</option>
                        <?php
                        $result = $conn->query("SELECT categoryID, categoryName FROM bookcategory");
                        while ($row = $result->fetch_assoc()) {
                        ?>
                        <option 
                            value="<?php echo $row['categoryID']; ?>"
                            <?php if ($categoryID == $row['categoryID']) echo "selected"; ?>
                        >
                        <?php echo $row['categoryName']; ?>
                        </option>
                        <?php
                        }
                        ?>
                        </select>

                    <label for="password">PASSWORD</label>
                    <input type="password" name="password">

                    <label for="confirm_password">CONFIRM PASSWORD</label>
                    <input type="password" name="confirm_password">
                    <button type="submit" class="index-btn">REGISTER</button>   
                </form>

                <p>Already have an account? <a href="index.php">Log in</a></p>
            </div>
        </div>
    </div>

    <div class="header-banner">
    </div>
</body>
</html>