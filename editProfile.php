<?php
$servername = "localhost";
$username = "irisfungyee";
$password = "F7*PLPCW]9bW]QF_";
$dbname = "irisfungyee";

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
    <title>Edit Profile</title>
    <style>
        table{
            border-collapse: collapse;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }
    </style>
</head>
<body>
    <button><a class="link" href="booklist.php">Back</a></button>
    <button><a class="link" href="index.php">Log Out</a></button>
    <table width="600">
        <tr>
            <th>Password</th>
            <th>Confirm Password</th>
            <th>Name</th>
            <th>Year Joined</th>
        </tr>
        
        <tr>
            <form action="updateProfile.php" method="POST">
                <td><input type=password name=password></td>
                <td><input type=password name=confirm_password></td>
                <td><input type=text name=name></td>
                <td><input type=text name=year_joined></td>
                <td><input type=submit value=Submit></td>
            </form>
        </tr>
</body>
</html>