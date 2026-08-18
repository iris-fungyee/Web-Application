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

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') { 
    $bookID = $_POST['bookID'] ?? ''; 
    $ISBN = $_POST['ISBN'] ?? ''; 
    $title = $_POST['title'] ?? ''; 
    $author = $_POST['author'] ?? ''; 
    $categoryID = $_POST['categoryID'] ?? ''; 
    $description = $_POST['description'] ?? '';
    $donatedBy = $_SESSION['email'] ?? '';
    $donatedDate = $_POST['donatedDate'] ?? '';
    $bookImage = $_POST['bookImage'] ?? '';

    if (empty($donatedDate) || empty($ISBN) || empty($title) || empty($author) || empty($categoryID) || empty($description) || empty($bookImage)) 
    {
    $error = "Please fill in all fields.";
    } else {
     $sql = "INSERT INTO booklist (ISBN, title, author, categoryID, description, donatedBy, donatedDate, bookImage)
            VALUES ('$ISBN', '$title', '$author', '$categoryID', '$description', '$donatedBy', '$donatedDate' ,'$bookImage')";

    if (mysqli_query($conn, $sql)) {        
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
                if ($error != "") {
                echo '<p class="error-message">' . htmlspecialchars($error) . '</p>';
                }
                ?>

                <form action="donate.php" method="POST">

                    <label for="donatedDate">DONATION DATE</label>
                    <input type="date" name="donatedDate" value="<?php echo $today; ?>" min="<?php echo $today; ?>">

                    <label for="ISBN">ISBN</label>
                    <input type="text" name="ISBN" value="<?php echo htmlspecialchars($_POST['ISBN'] ?? ''); ?>" inputmode="numeric" placeholder="e.g. 9783161484100">

                    <label for="title">BOOK TITLE</label>
                    <input type="text" name="title" value="<?php echo htmlspecialchars($_POST['title'] ?? ''); ?>">

                    <label for="author">AUTHOR</label>
                    <input type="text" name="author" value="<?php echo htmlspecialchars($_POST['author'] ?? ''); ?>">

                    <label for="category">CATEGORY</label>
                        <select name="categoryID">

                        <option value="">Choose a category</option>

                        <?php
                        $selectedCategory = $_POST['categoryID'] ?? '';
                        $result = $conn->query("SELECT categoryID, categoryName FROM bookcategory");
                        while ($row = $result->fetch_assoc()) {
                            $selected = ($row['categoryID'] == $selectedCategory) ? 'selected' : '';
                            echo '<option value="' . $row['categoryID'] . '" ' . $selected . '>' . htmlspecialchars($row['categoryName']) . '</option>';
                        }
                        ?>
                        </select>

                    <label for="description">BOOK DESCRIPTION</label>
                    <textarea name="description"><?php echo htmlspecialchars($_POST['description'] ?? ''); ?></textarea>
                    
                    <label for="bookImage">COVER PHOTO</label>
                    <input type="file" name="bookImage" accept="image/*">

                    <button type="submit" class="index-btn">DONATE</button>   
                </form>
            </div>
        </div>
    </div>

    <div class="header-banner">
    </div>
</body>
</html>