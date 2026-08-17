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

     $sql = "INSERT INTO user (fullname, email, phonenum, categoryID, password)
            VALUES ('$fullname', '$email', '$phonenum', " . ($categoryID === NULL ? "NULL" : "'$categoryID'") . ",'$password')";

    if (mysqli_query($conn, $sql)) {        
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
    <title>Donate - SecondChapter</title>
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
        <div class="donate-box">
            <div class="donate-header">
                <h2>Donate A Book</h2>
                <p>Fill in the details below and give a book a second chapter. </p>
            </div>

            <div class="donate-body">

                <?php
                    if (isset($_GET['error'])) {
                    echo '<p class="error-message">' . htmlspecialchars($_GET['error']) . '</p>';
                    }   
                ?>

                <form action="donate.php" method="POST">

                    <label for="date">DONATION DATE</label>
                    <input type="date" name="donationDate" value="<?php echo $today; ?>" min="<?php echo $today; ?>" required>

                    <label for="ISBN">ISBN</label>
                    <input type="text" name="ISBN" inputmode="numeric" placeholder="e.g. 9783161484100" required>

                    <h3>BOOK TITLE</h3>
                    <input type="text" name="title" required>

                    <h3>AUTHOR</h3>
                    <input type="text" name="author" required>

                    <h3>CATEGORY</h3>
                        <select name="categoryID" required>

                        <option value="">Choose a category</option>

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

                    <h3>COVER PHOTO</h3>
                    <input type="file" name="coverPhoto" accept="image/*" required>

                    <button type="submit" class="index-btn">DONATE</button>   
                </form>
            </div>
        </div>
    </div>

    <div class="header-banner">
    </div>
</body>
</html>