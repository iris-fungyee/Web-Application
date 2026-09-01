<?php
session_start();

$servername = "localhost";
$username = "secondchapter";
$password = "cB]EYDah/79Jos0O";
$dbname = "secondchapter";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$error = "";
$success = "";

$email = $_SESSION['email'];

$userQuery = "SELECT *, bookcategory.categoryName
              FROM user
              LEFT JOIN bookcategory
              ON user.categoryID = bookcategory.categoryID
              WHERE user.email = '$email'";

$userResult = mysqli_query($conn, $userQuery);
$user = mysqli_fetch_assoc($userResult);
$userID = $user['userID'];

//Count Books Read
$readQuery = "SELECT COUNT(*) AS totalRead
              FROM readbook
              WHERE userID = '$userID'";

$readResult = mysqli_query($conn, $readQuery);
$read = mysqli_fetch_assoc($readResult);

//Count Reviews
$reviewQuery = "SELECT COUNT(*) AS totalReviews
                FROM review
                WHERE userID = '$userID'";

$reviewResult = mysqli_query($conn, $reviewQuery);
$reviews = mysqli_fetch_assoc($reviewResult);

//Update Profile
if (isset($_POST['updateProfile'])) {

    $fullname = $_POST['fullname'];
    $phonenum = $_POST['phonenum'];
    $categoryID = $_POST['categoryID'];

    if ($categoryID == "") {
        $updateQuery = "UPDATE user
                        SET fullname = '$fullname',
                            phonenum = '$phonenum',
                            categoryID = NULL
                        WHERE userID = '$userID'";
    } else {
        $updateQuery = "UPDATE user
                        SET fullname = '$fullname',
                            phonenum = '$phonenum',
                            categoryID = '$categoryID'
                        WHERE userID = '$userID'";
    }

    mysqli_query($conn, $updateQuery);
    header("Location: profile.php");
    exit();
}
//Change Password
if (isset($_POST['changePassword'])) {

    $currentPassword = $_POST['currentPassword'];
    $newPassword = $_POST['newPassword'];
    $confirmPassword = $_POST['confirmPassword'];

    if ($currentPassword != $user['password']) {

        $error = "Current password is incorrect.";

    } else if ($newPassword != $confirmPassword) {

        $error = "New passwords do not match.";
    
    } else if (strlen($newPassword) < 6) {

    $error = "Password must be at least 6 characters long."; 

    } else {

        $updatePassword = "UPDATE user
                           SET password = '$newPassword'
                           WHERE userID = '$userID'";

        if (mysqli_query($conn, $updatePassword)) {
            $success = "Password changed successfully.";
        } else {
            $error = "Unable to change password.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - SecondChapter</title>
    <link rel="stylesheet" href="css/common.css">
</head>
<body>

<div class="header-banner">
    <div class="header">
      <a class="logo" href="home.php"><h1>Second<span class="logo">Chapter</span></h1></a>
      <a href="profile.php" class="profile-icon">
        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" 
             stroke="currentColor" stroke-width="2" 
             stroke-linecap="round" stroke-linejoin="round">
            <circle cx="12" cy="8" r="4"/>
            <path d="M4 21c0-4 3.6-7 8-7s8 3 8 7"/>
        </svg>
      </a>
    </div>  
</div>
    
<div id="container">
    <div class="profile-box">
        <h2>My Profile</h2>

        <div class="profile-info">
            <form method="POST">
            <label for="fullname">FULL NAME</label>
            <input type="text" name="fullname" id="fullname" value="<?php echo htmlspecialchars($user['fullname']); ?>" required>

            <label for="email">EMAIL</label>
            <input type="email" id="email" value="<?php echo htmlspecialchars($user['email']); ?>" disabled>

            <label for="phonenum">PHONE NUMBER</label>
            <input type="tel" name="phonenum" id="phonenum" value="<?php echo htmlspecialchars($user['phonenum']); ?>" maxlength="11"inputmode="numeric"required>

            <label for="categoryID">FAVOURITE GENRE</label>
            <select name="categoryID" id="categoryID">
                <option value="">No preference</option>
                <option value="1"<?php if ($user['categoryID'] == 1) echo "selected"; ?>>Fantasy</option>
                <option value="2"<?php if ($user['categoryID'] == 2) echo "selected"; ?>>Mystery</option>
                <option value="3"<?php if ($user['categoryID'] == 3) echo "selected"; ?>>Romance</option>
                <option value="4"<?php if ($user['categoryID'] == 4) echo "selected"; ?>>Sci-Fi</option>
                <option value="5"<?php if ($user['categoryID'] == 5) echo "selected"; ?>>Biography</option>
                <option value="6"<?php if ($user['categoryID'] == 6) echo "selected"; ?>>Self-Help</option>
                <option value="7"<?php if ($user['categoryID'] == 7) echo "selected"; ?>>Children's</option>
                <option value="8"<?php if ($user['categoryID'] == 8) echo "selected"; ?>>Other</option>
            </select>

            <button type="submit" name="updateProfile" class="index-btn">SAVE CHANGES</button>
            </form>
        
            <h3>YOUR ACTIVITY</h3>
        <div class="profile-stats">
            
            <div class="stat">
                <h3><?php echo $read['totalRead']; ?></h3>
                <p>BOOKS READ</p>
            </div>

            <div class="stat">
                <h3><?php echo $reviews['totalReviews']; ?></h3>
                <p>REVIEWS</p>
            </div>
        
            
        </div>

        <details class="change-password" <?php if ($error != "" || $success != "") echo "open"; ?>>
            <summary>CHANGE PASSWORD</summary>

            <?php
            if ($error != "") {
                echo '<p class="error-message">' . htmlspecialchars($error) . '</p>';
            }

            if ($success != "") {
                echo '<p class="success-message">' . htmlspecialchars($success) . '</p>';
            }
            ?>

            <form method="POST">
                <label for="currentPassword">CURRENT PASSWORD</label>
                <input type="password" name="currentPassword" id="currentPassword">

                <label for="newPassword">NEW PASSWORD</label>
                <input type="password" name="newPassword" id="newPassword">

                <label for="confirmPassword">CONFIRM NEW PASSWORD</label>
                <input type="password" name="confirmPassword" id="confirmPassword">

        <button type="submit" name="changePassword" class="index-btn">CHANGE PASSWORD</button>
            </form>
    </details>
        
    <div class ="logout-section">
        <form action="logOut.php" method="POST">
            <button type="submit" class="second-btn">LOG OUT</button>
        </form>
</div>

</div>
</body>
</html>