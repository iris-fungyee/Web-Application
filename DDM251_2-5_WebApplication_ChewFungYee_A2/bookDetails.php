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

$email = $_SESSION['email'];

// Get current user's ID
$userQuery = "SELECT userID FROM user WHERE email = '$email'";
$userResult = mysqli_query($conn, $userQuery);

$user = mysqli_fetch_assoc($userResult);
$userID = $user['userID'];

// Get book ID
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $bookID = $_POST['bookID'];
} else {
    $bookID = $_GET['bookID'];
}

// Submit review
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['rating'])) {

    $rating = $_POST['rating'];
    $reviewText = $_POST['reviewText'];

    if ($rating >= 1 && $rating <= 5 && $reviewText != "") {

        $insertReview = "INSERT INTO review 
                         (bookID, userID, rating, reviewText, reviewDate)
                         VALUES 
                         ('$bookID', '$userID', '$rating', '$reviewText', NOW())";

        mysqli_query($conn, $insertReview);

        header("Location: bookDetails.php?bookID=$bookID");
        exit();
    }
}

// Get book details
$bookQuery = "SELECT *, bookcategory.categoryName
              FROM booklist
              LEFT JOIN bookcategory
              ON booklist.categoryID = bookcategory.categoryID
              WHERE booklist.bookID = '$bookID'";

$bookResult = mysqli_query($conn, $bookQuery);
$book = mysqli_fetch_assoc($bookResult);

// Get reviews
$reviewQuery = "SELECT *, user.fullname
                FROM review
                JOIN user
                ON review.userID = user.userID
                WHERE review.bookID = '$bookID'
                ORDER BY review.reviewDate DESC";

$reviewResult = mysqli_query($conn, $reviewQuery);

// Check if current user has already reviewed this book
$checkReviewQuery = "SELECT reviewID
                     FROM review
                     WHERE bookID = '$bookID'
                     AND userID = '$userID'";

$checkReviewResult = mysqli_query($conn, $checkReviewQuery);

$hasReviewed = mysqli_num_rows($checkReviewResult) > 0;

// Check if current user has read this book
$readQuery = "SELECT *
              FROM readbook
              WHERE bookID = '$bookID'
              AND userID = '$userID'";

$readResult = mysqli_query($conn, $readQuery);

$hasRead = mysqli_num_rows($readResult) > 0;

// Calculate average rating
$ratingQuery = "SELECT AVG(rating) AS averageRating FROM review WHERE bookID = '$bookID'";
$ratingResult = mysqli_query($conn, $ratingQuery);
$rating = mysqli_fetch_assoc($ratingResult);
$averageRating = round($rating['averageRating'], 1);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Details - SecondChapter</title>
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
        <div class="bookdetail-box">
            <div class="bookdetail-header">
                <a href="home.php">
                    <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
                </a>
                <h2>Book Details</h2>
            </div>

            <div class="book-card-details">
                  <a href="bookdetails.php?bookID=<?php echo $book['bookID']; ?>" class="book-card">
                <?php
                $image = $book['bookImage'];
                if (strpos($image, 'images/') !== 0) {
                    $image = 'images/' . $image;
                }
                ?>
                <img src="<?php echo htmlspecialchars($image); ?>" alt="Book Cover">
                <h3><?php echo $book['title']; ?></h3>
                <p><?php echo $book['author']; ?></p>
                <p><?php echo $book['categoryName']; ?></p>
                <p><?php echo $book['description']; ?></p>
            </div>

            <div class="buttons">
                <?php
                if ($hasRead) {
                ?>
                <button type="button" class="second-btn" disabled>✓ READ</button>
                <?php
                } else {
                ?>

                <form action="readbook.php" method="POST">
                    <input type="hidden" name="bookID" value="<?php echo $book['bookID']; ?>">
                    <button type="submit" class="index-btn">MARK AS READ</button>
                </form>
                <?php
                }
                ?>
            </div>
        </div>

        <div class="section-title">
            <h2>Reviews</h2>
            <p> 
                <?php
                $roundedRating = round($averageRating);
                echo str_repeat('★', $roundedRating);
                echo str_repeat('☆', 5 - $roundedRating);
                ?>
                <?php echo $averageRating; ?>
                (<?php echo mysqli_num_rows($reviewResult); ?>)<p>
        </div>

        <div class="section-review">
            <?php
            if (mysqli_num_rows($reviewResult) > 0) {
            while ($review = mysqli_fetch_assoc($reviewResult)) {
            ?>

        <div class="review">
            <p class="rating">
                <?php
                echo str_repeat('★', $review['rating']);
                echo str_repeat('☆', 5 - $review['rating']);
                ?>
            </p>
            <p><?php echo htmlspecialchars($review['reviewText']); ?></p>
            <p><?php echo htmlspecialchars($review['fullname']); ?> · <?php echo $review['reviewDate']; ?></p>
        </div>
            <?php
            }
        } else {
            ?>
            <p>No reviews yet — be the first to share your thoughts.</p>
            <?php
        }
            ?>

            <?php
            if (!$hasReviewed) {
            ?>
            <h3>Write A Review</h3>
                <form method="POST">
                    <input type="hidden" name="bookID" value="<?php echo $book['bookID']; ?>">

                    <label for="rating">Rating</label>
                    <select name="rating" id="rating" required>
                        <option value="">Choose a rating</option>
                        <option value="5">★★★★★</option>
                        <option value="4">★★★★☆</option>
                        <option value="3">★★★☆☆</option>
                        <option value="2">★★☆☆☆</option>
                        <option value="1">★☆☆☆☆</option>
                    </select>

                    <label for="reviewText">Your Review</label>
                    <textarea name="reviewText" id="reviewText" required></textarea>

                    <button type="submit" class="index-btn"> SUBMIT REVIEW</button>
                </form>
            </br>
            <?php
            }
            ?>
        </div>
    </div>
</body>
</html>