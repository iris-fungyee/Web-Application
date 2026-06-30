<?php
$servername = "localhost";
$username = "irisfungyee";
$password = "F7*PLPCW]9bW]QF_";
$dbname = "irisfungyee";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

// SQL to update a record
$sql = "UPDATE booklist SET title='" . $_POST["title"] . "' , author='" . $_POST["author"] . "' , description='" . $_POST["description"] . "' , price='" . $_POST["price"] . "' WHERE ISBN= '" . $_SESSION["ISBN"] . "'";

if (mysqli_query($conn, $sql)) {
  
  header ("Location: booklist.php");
} else {
  echo "Error updating record: " . mysqli_error($conn);
}

mysqli_close($conn);
?>
,/