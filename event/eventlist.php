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

$userID = $_SESSION['userID'];

$message = "";

if (isset($_POST['bookEvent'])) {

    $email = $_SESSION['email'];
    $eventID = $_POST['eventID'];
    $eventName = $_POST['eventName'];
    $eventDate = $_POST['eventDate'];
    
    // Check if already booked
    $check = mysqli_query($conn,
        "SELECT * FROM bookinglist
         WHERE userID='$userID'
         AND eventID='$eventID'");

    if (mysqli_num_rows($check) > 0) {

        $message = "You have already booked this event.";

    } else {

        $slotCheckQuery = mysqli_query($conn, "SELECT slotsBooked, totalSlots FROM eventlist WHERE eventID='$eventID'");
        $slotData = mysqli_fetch_assoc($slotCheckQuery);

            if ($slotData['slotsBooked'] >= $slotData['totalSlots']) {

                $message = "Sorry, this event is fully booked!";

            } else {

        mysqli_query($conn,
            "INSERT INTO bookinglist(userID, email, eventID, eventName, eventDate)
             VALUES('$userID', '$email', '$eventID', '$eventName', '$eventDate')");

        mysqli_query($conn,
        "UPDATE eventlist
        SET slotsBooked = slotsBooked + 1
        WHERE eventID='$eventID'");

        $message = "Event booked successfully!";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event List</title>
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
    <?php
        if ($message != "") {
        echo $message;
        }
    ?>

    <div>
        <a href="profile.php"><input type="submit" value="Profile"></a>
    </div>

    <h3>Events</h3>

        <form method="GET">
            <button class="<?php echo (isset($_GET['eventDate']) && $_GET['eventDate']=="2026-07-28") ? "active" : ""; ?>" name="eventDate" value="2026-07-28">28 July 2026</button>
            <button class="<?php echo (isset($_GET['eventDate']) && $_GET['eventDate']=="2026-07-29") ? "active" : ""; ?>" name="eventDate" value="2026-07-29">29 July 2026</button>
            <button class="<?php echo (isset($_GET['eventDate']) && $_GET['eventDate']=="2026-07-30") ? "active" : ""; ?>" name="eventDate" value="2026-07-30">30 July 2026</button>
        </form>

    </br>

     <table width="1000">
        <tr>
            <th>Event ID</th>
            <th>Event Name</th>
            <th>Event Description</th>
            <th>Slots</th>
        </tr>
    

        <?php
        if (isset($_GET['eventDate']) && $_GET['eventDate'] != "") {
        $eventDate = mysqli_real_escape_string($conn, $_GET['eventDate']);
        $query = "SELECT * FROM eventlist WHERE eventDate = '$eventDate'";
        } else {
        $query = "SELECT * FROM eventlist";
        }

        $result = mysqli_query($conn, $query) or die("Couldn't execute query");

        while ($row = mysqli_fetch_assoc($result)) {
            
        ?>


        <tr>
                <td><?php echo $row['eventID'] ?></td>
                <td><?php echo $row['eventName'] ?></td>
                <td><?php echo $row['eventDesc'] ?></td>
                <td><?php echo $row['slotsBooked'] . " / " . $row['totalSlots']; ?></td>
                <td>
                    <form method="POST" style="display:inline;">
                        <input type="hidden" name="eventID" value="<?php echo $row['eventID']; ?>">
                        <input type="hidden" name="eventName" value="<?php echo $row['eventName']; ?>">
                        <input type="hidden" name="eventDate" value="<?php echo $row['eventDate']; ?>">
                       <?php if ($row['slotsBooked'] >= $row['totalSlots']) { ?>
                            <input type="button" value="Fully Booked" disabled>
                        <?php } else { ?>
                            <input type="submit" name="bookEvent" value="Book Event">
                        <?php } ?>
                        <!-- <input type="submit" name="bookEvent" value="Book Event"> -->
                    </form>
                </td>
                
        </tr>

        <?php
        }
        ?>
    </table>
    
</body>
</html>