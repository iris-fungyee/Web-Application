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

$email = $_SESSION['email']; //?? "" means else

$sql = "SELECT * FROM user WHERE email = '$email'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {

    $user = $result->fetch_assoc();
    $fullname = $user['fullname'];
}
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
  <div id="container">
    <div class="header">
        <h1>SecondChapter</h1>
    </div>

    <div class="home-box">
      <div class="home-header">
        <h2>Welcome In, <?php echo $fullname; ?> </h2>
        <p>Looking for your next read?</p>

        <div class="search-bar">
          <form action="search.php" method="GET">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
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
        <button class="<?php echo (isset($_GET['booklist']) && $_GET['booklist']=="Children's") ? "active" : ""; ?>" name="booklist" value="Children's">Children's</button>
        <button class="<?php echo (isset($_GET['booklist']) && $_GET['booklist']=="Other") ? "active" : ""; ?>" name="booklist" value="Other">Other</button>
      </form>
    </div>

     <div class="section-title">
      <h2>Recommended For You</h2>
    </div>

    <div class="section-title">
      <h2>Recently Donated</h2>
    </div>

    <div class="banner-title">
      <h3>Have A Book To Share?</h3>
      <button type="submit" class="index-btn">DONATE A BOOK</button>   
    </div>



  </div>
</body>
</html>