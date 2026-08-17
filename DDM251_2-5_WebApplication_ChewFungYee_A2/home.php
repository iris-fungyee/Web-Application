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

if (!isset($_SESSION['email'])) {
    header("Location: index.php");
    exit();
}
$email = $_SESSION['email']; //?? "" means else

$sql = "SELECT * FROM user WHERE email = '$email'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {

    $user = $result->fetch_assoc();

    $fullname = $user['fullname'];
    $categoryID = $user['categoryID'];

    } else {
    header("Location: login.php");
    exit();
}

$selectedCategory = $_GET['booklist'] ?? '';
if ($selectedCategory != "") {

    // User clicked a category
  $recommendSQL = "SELECT * FROM booklist WHERE categoryID = (SELECT categoryID FROM bookcategory WHERE categoryName = '$selectedCategory')
                  ORDER BY RAND()
                  LIMIT 4";

} else if ($categoryID == NULL) {

    // No category selected + user has no preference
  $recommendSQL = "SELECT * FROM booklist
                  ORDER BY RAND()
                  LIMIT 4";

} else {
    // No category selected + user has a favourite category
    $recommendSQL = "SELECT * FROM booklist WHERE categoryID = $categoryID ORDER BY donatedDate DESC
                     LIMIT 4";
}

$recommendResult = $conn->query($recommendSQL);

if ($selectedCategory != "") {

    // Show recent books from selected category
    $recentSQL = "SELECT * FROM booklist WHERE categoryID = (SELECT categoryID FROM bookcategory WHERE categoryName = '$selectedCategory')
                  ORDER BY donatedDate DESC
                  LIMIT 4";

} else {
    // Show all recently donated books
    $recentSQL = "SELECT * FROM booklist ORDER BY donatedDate DESC
                  LIMIT 4";
}

$recentResult = $conn->query($recentSQL);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - SecondChapter</title>
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
    <div class="home-box">
      <div class="home-header">
        <h2>Welcome In, <?php echo $fullname; ?> </h2>
        <p>Looking for your next read?</p>
      </div>

      <div class="search-border">
        <form class="search-bar" action="search.php" method="GET">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <circle cx="11" cy="11" r="8"/>
          <line x1="21" y1="21" x2="16.65" y2="16.65"/>
          </svg>
          <input type="text" name="query" placeholder="Search title or author..." required>
        </form>
      </div>
    </div>
    
    <div class="section-title">
      <h2>Categories</h2>
    </div>

    <div class="category-list">
      <form method="GET">
        <button class="<?php echo (!isset($_GET['booklist']) || $_GET['booklist']=="") ? "active" : ""; ?>" name="booklist" value="">All Books</button>
        <button class="<?php echo (isset($_GET['booklist']) && $_GET['booklist']=="Fantasy") ? "active" : ""; ?>" name="booklist" value="Fantasy">Fantasy</button>
        <button class="<?php echo (isset($_GET['booklist']) && $_GET['booklist']=="Mystery") ? "active" : ""; ?>" name="booklist" value="Mystery">Mystery</button>
        <button class="<?php echo (isset($_GET['booklist']) && $_GET['booklist']=="Romance") ? "active" : ""; ?>" name="booklist" value="Romance">Romance</button>
        <button class="<?php echo (isset($_GET['booklist']) && $_GET['booklist']=="Sci-Fi") ? "active" : ""; ?>" name="booklist" value="Sci-Fi">Sci-Fi</button>
        <button class="<?php echo (isset($_GET['booklist']) && $_GET['booklist']=="Biography") ? "active" : ""; ?>" name="booklist" value="Biography">Biography</button>
        <button class="<?php echo (isset($_GET['booklist']) && $_GET['booklist']=="Self-Help") ? "active" : ""; ?>" name="booklist" value="Self-Help">Self-Help</button>
        <button class="<?php echo (isset($_GET['booklist']) && $_GET['booklist']=="Childrens") ? "active" : ""; ?>" name="booklist" value="Childrens">Children's</button>
        <button class="<?php echo (isset($_GET['booklist']) && $_GET['booklist']=="Other") ? "active" : ""; ?>" name="booklist" value="Other">Other</button>
      </form>
    </div>

    <div class="section-title">
      <h2>Recommended For You</h2>
    </div>

    <div class="book-list">

    <?php
    if ($recommendResult->num_rows > 0) {
    while ($book = $recommendResult->fetch_assoc()) {
    ?>
      
      <a href="bookdetails.php?bookID=<?php echo $book['bookID']; ?>" class="book-card">
          <img 
              src="images/<?php echo $book['bookImage']; ?>" 
          >
          <h3><?php echo $book['title']; ?></h3>
          <p><?php echo $book['author']; ?></p>
      </a>

    <?php
    }

    } else {
    ?>
      <p class="no-books">
        No books here yet. Be the first to donate one!
      </p>
    <?php
    }
    ?>
    </div>

    <div class="section-title">
      <h2>Recently Donated</h2>
    </div>

    <div class="book-list">

    <?php
    if ($recentResult->num_rows > 0) {
    while ($book = $recentResult->fetch_assoc()) {
    ?>

      <a href="bookdetails.php?bookID=<?php echo $book['bookID']; ?>" class="book-card">
            <img src="images/<?php echo $book['bookImage']; ?>">
            <h3><?php echo $book['title']; ?></h3>
            <p><?php echo $book['author']; ?></p>
      </a>
    <?php
    }

    } else {
    ?>
      <p class="no-books">
        No books here yet. Be the first to donate one!
      </p>
    <?php
    }
    ?>
  </div>
</div>

  <div class="header-banner">
      <h3 class="banner">Have A Book To Share?</h3>
      <a class="donate" href="donate.php">
        <button type="submit" class="second-btn">DONATE A BOOK</button>
      </a>  
  </div>

</body>
</html>