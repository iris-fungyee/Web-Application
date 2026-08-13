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
    <title>Donate - SecondChapter</title>
    <link rel="stylesheet" href="css/common.css">
</head>
<body>
 <div id="container">
        <div class="header">
            <h1>SecondChapter</h1>
        </div>
        
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
                    <h3>DONATION DATE</h3>
                    <input type="date" name="donationDate" value="<?php echo $today; ?>" min="<?php echo $today; ?>" required>

                    <h3>ISBN</h3>
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
</body>
</html>