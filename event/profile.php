<?php
$servername = "localhost";
$username = "event";
$password = "FM)f9)o.3eihzH/6";
$dbname = "event";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

session_start();
if (!isset($_SESSION['userID'])) {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
</head>
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

<body>
  <h3>My Booked Events</h3>
    <table width="800">
        <tr>
            <th>Event ID</th>
            <th>Event Name</th>
            <th>Event Date</th>
        </tr>
        <?php

         $query = "SELECT * FROM bookinglist WHERE email='" . $_SESSION["email"] . "'";

        $result = mysqli_query($conn, $query) or die("Couldn't execute query");

        while ($row = mysqli_fetch_assoc($result)) {
        ?>
                <td><?php echo $row["eventID"] ?></td>
                <td><?php echo $row["eventName"] ?></td>
                <td><?php echo $row["eventDate"] ?></td>

            </tr>
        <?php
        }
        mysqli_close($conn);
        ?>

    </table>
</body>
</html>