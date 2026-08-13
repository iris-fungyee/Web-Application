<?php
$servername = "localhost";
$username = "irisfungyee";
$password = "F7*PLPCW]9bW]QF_";
$dbname = "irisfungyee";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name  = $_POST['name'];
    $email = $_POST['email'];
    $age   = $_POST['age'];

    date_default_timezone_set ('Asia/Kuala_Lumpur');
    $characters = "ABCDEFGHILJKLMNOPQRSTUVWXYZ0123456789";
    $code = '';

    for ($i = 0; $i < 6; $i++) {
    $code .= $characters[random_int(0, strlen($characters) - 1)];
    }

$uniqueCode = date('YmdHis') . "_" . $code;

$sql = "INSERT INTO uid (UID, name, email, age)
VALUES ('$uniqueCode', '$name', '$email', '$age')";

if ($conn->query($sql) === TRUE) {
        echo "Successfully generated and saved UID: " . $uniqueCode;
        $_SESSION['UID'] = $uniqueCode;
        header("Location: button.php");
        exit();
    } else {

        echo "Error: " . $conn->error;
        
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generate UID</title>
</head>
<body>
    <form target="_self" method="POST">
      <h2>Name</h2>
      <input type="text" name="name">
      <br />
      <h2>Email</h2>
      <input type="text" name="email">
      <br />
      <h2>Age</h2>
      <input type="text" name="age">
      <button type="submit">Generate UID</button> 
    </form>

    
</body>
</html>