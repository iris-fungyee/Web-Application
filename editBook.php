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

session_start();

$ISBN = $_GET['ISBN'];

$query = "SELECT * FROM booklist WHERE ISBN='$ISBN'";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Book</title>
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
    <table width="600">
        <tr>
            <th>ISBN</th>
            <th width="300">Title</th>
            <th width="200">Author</th>
            <th> Description</th>
            <th>Price(RM)</th>
        </tr>

        <tr>
         <form action="updateBook.php" method="POST">
            <td> 
                <input type="text" name="ISBN"
                value="<?php echo $row['ISBN']; ?>"readonly>
            </td>
            <td> 
                <input type="text" name="title"
                value="<?php echo $row['title']; ?>">
            </td>
            <td>
                <input type="text" name="author"
                value="<?php echo $row['author']; ?>">
            </td>
            <td>
                <textarea name="description" cols="50"><?php echo $row['description']; ?></textarea>
            </td>
            <td>
                <input type="text" name="price"
                value="<?php echo $row['price']; ?>">
            </td>
                <td><input type="submit" value="Submit"></td>
            </form>
        </tr>
</body>
</html>