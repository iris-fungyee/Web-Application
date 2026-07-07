<?php
$servername = "localhost";
$username = "irisfungyee";
$password = "F7*PLPCW]9bW]QF_";
$dbname = "irisfungyee";
 session_start();
// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

//if (empty($_POST["name"]) || empty($_POST["password"]) || empty($_POST["confirm_password"]) || empty($_POST["year_joined"])) {
// $empty = "No empty allow";
// header("Location: editProfile.php?error=$empty");
// }else if ($_POST["year_joined"] > date("Y")) {
// $year = "Year joined must within this year ");
// header("Location: editProfile.php?error=$year");
// }else if ($_POST["password"] != $_POST["confirm_password"]) {
// $password_error = "Password and Confirm Password must be the same.";
// header("Location: editProfile.php?error=$password_error");
// }

$name = $_POST["name"];
$password = $_POST["password"];
$confirm_password = $_POST["confirm_password"];
$year_joined = $_POST["year_joined"];

if ($password != $confirm_password) {
    header("Location: editProfile.php?error=Password and Confirm Password must be the same.");
    exit();
}

if ($year_joined > date("Y")) {
    header("Location: editProfile.php?error=Year Joined cannot be more than " . date("Y") . ".");
    exit();
}
else{
$sql = "UPDATE student
        SET name='$name',
            password='$password',
            yearjoin='$year_joined'
        WHERE email='" . $_SESSION["email"] . "'";

if (mysqli_query($conn, $sql)) {
    header("Location: profile.php");
} else {
    echo "Error updating record: " . mysqli_error($conn);
}

mysqli_close($conn);
}


?>
