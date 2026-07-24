<?php
$servername = "localhost";
$username = "irisfungyee";
$password = "F7*PLPCW]9bW]QF_";
$dbname = "irisfungyee";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee</title>
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

  form {
    display: inline-block;
  }
</style>

<body>


<form method="GET">
    <button class="<?php echo (!isset($_GET['department']) || $_GET['department']=="") ? "active" : ""; ?>" name="department" value="">All</button>

    <button class="<?php echo (isset($_GET['department']) && $_GET['department']=="UI/UX Design") ? "active" : ""; ?>" name="department" value="UI/UX Design">UI/UX Design</button>

    <button class="<?php echo (isset($_GET['department']) && $_GET['department']=="Graphic Design") ? "active" : ""; ?>" name="department" value="Graphic Design">Graphic Design</button>

    <button class="<?php echo (isset($_GET['department']) && $_GET['department']=="Product Design") ? "active" : ""; ?>" name="department" value="Product Design">Product Design</button>
</form>

<form action="download.php" method="GET">
    <input type="hidden" name="department"
           value="<?php echo isset($_GET['department']) ? $_GET['department'] : ''; ?>">

    <button type="submit">Download CSV</button>
</form>

<br>

<table width="800">
    <tr>
        <th>ID</th>
        <th width="300">Name</th>
        <th width="300">Department</th>
    </tr>

<?php

if (isset($_GET['department']) && $_GET['department'] != "") {
    $department = mysqli_real_escape_string($conn, $_GET['department']);
    $query = "SELECT * FROM employee WHERE department = '$department'";
} else {
    $query = "SELECT * FROM employee";
}

$result = mysqli_query($conn, $query) or die("Couldn't execute query");

$count = 1;

while ($row = mysqli_fetch_assoc($result)) {
?>
    <tr>
        <td><?php echo $count; ?></td>
        <td><?php echo $row['name']; ?></td>
        <td><?php echo $row['department']; ?></td>
    </tr>
<?php

    $count++;
}
        mysqli_close($conn);
    ?>

</table>

</body>

</html>