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
    <table width="800">
        <tr>
            <th>Name</th>
            <th width="300">Email</th>
            <th width="200">Year Joined</th>
        </tr>
        <?php

        $query = "SELECT * FROM student";

        $result = mysqli_query($conn, $query) or die("Couldn't execute query");

        while ($row = mysqli_fetch_assoc($result)) {
        ?>
            <tr>
                <td><?php echo $row["name"] ?></td>
                <td><?php echo $row["email"] ?></td>
                <td><?php echo $row["yearjoin"] ?></td>
                <td><input type="button" value="Edit"></td>
            </tr>
        <?php
        }
        mysqli_close($conn);
        ?>

        <a href="booklist.php"><input type="submit" value="Back"></a>

    </table>

</body>

</html>