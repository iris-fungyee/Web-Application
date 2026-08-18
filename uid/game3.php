<?php
session_start();

$servername = "localhost";
$username = "irisfungyee";
$password = "F7*PLPCW]9bW]QF_";
$dbname = "irisfungyee";

$conn = new mysqli($servername, $username, $password, $dbname);

$uid = $_SESSION['UID'] ?? $_SESSION['uid'] ?? '';

if (empty($uid)) {
    header("Location: generateuid.php");
    exit();
}

$safe_uid = mysqli_real_escape_string($conn, $uid);
$message = "";

// 1. Fetch current click count directly from Database
$checkSql = "SELECT game3clicks FROM uid WHERE UID = '$safe_uid'";
$result   = mysqli_query($conn, $checkSql);
$row      = mysqli_fetch_assoc($result);

$currentClicks = $row['game3clicks'] ?? 0;

// 2. Process form submission
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['game3'])) {

    if ($currentClicks >= 2) {
        $message = "You can only select a score 2 times!";
    } else {
        $game3 = mysqli_real_escape_string($conn, $_POST['game3']);

        // Update score AND increment click counter in database
        $updateSql = "UPDATE uid 
                      SET game3 = '$game3', game3clicks = game3clicks + 1 
                      WHERE UID = '$safe_uid'";

        if (mysqli_query($conn, $updateSql)) {
            $currentClicks++; // Update local variable for immediate UI response
            $message = "Score $game3 saved! Attempts used: $currentClicks/2";
        } else {
            $message = "Database error: " . mysqli_error($conn);
        }
    }
}

    // Disable buttons automatically after 2 clicks
$disabled = ($currentClicks >= 2) ? 'disabled' : '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Button</title>
</head>
<body>
    <!-- Debug view to verify session persistence -->
    <p>UID:<?php echo htmlspecialchars($uid); ?></p>
    <p>Attempts Used: <strong><?php echo $currentClicks; ?> / 2</strong></p>

    <strong><?php if (!empty($message))
        {
            echo htmlspecialchars($message);
        }
    ?></strong>

<form target="_self" method="POST">
    <button type="submit" name="game3" value="0" class="num-btn">0</button>
    <button type="submit" name="game3" value="1" class="num-btn">1</button>
    <button type="submit" name="game3" value="2" class="num-btn">2</button>
    <button type="submit" name="game3" value="3" class="num-btn">3</button>
    <button type="submit" name="game3" value="4" class="num-btn">4</button>
    <button type="submit" name="game3" value="5" class="num-btn">5</button>
</form>

<br>
    <a href="button.php">Back to Game Selection</a>
</body>
</html>