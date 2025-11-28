<?php
include('db_conn.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Room Details and Availability</title>
</head>
<body>
    <center><h1>View Room Details and Availability</h1></center>

    
    <form method="POST" action="room_type.php">
        <input type="submit" name="view_room_types" value="View Room Types, Descriptions, and Prices">
    </form>

    <hr>

    
    <form method="POST" action="">
        <label for="room_type">Select Room Type:</label>
        <select name="room_type" id="room_type" required>
            <?php
            
            $query = "SELECT type_name FROM Room_Type";
            $result = mysqli_query($conn, $query);
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<option value='" . $row['type_name'] . "'>" . $row['type_name'] . "</option>";
            }
            ?>
        </select><br><br>
        <input type="submit" name="check_availability" value="Check Availability">
    </form><br>
</body>
</html>

<?php


    if (isset($_POST['check_availability'])) {
        
        $selected_room_type = $_POST['room_type'];

        $query = "SELECT COUNT(*) AS available_rooms FROM Rooms 
                  WHERE room_type_id = (SELECT room_type_id FROM Room_Type WHERE type_name = '$selected_room_type') 
                  AND status = 'Available'";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($result);

        echo "<h3>Availability for $selected_room_type</h3>";
        echo "<p>Available Rooms: " . $row['available_rooms'] . "</p>";
    }
?>
<a href="home_page.php">Go Back to Home</a>
<?php
$conn->close();
?>
