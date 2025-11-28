<?php
session_start();
include 'db_conn.php'; 


if (!isset($_SESSION['emp_id']) || $_SESSION['role'] !== 'Receptionist') {
    header("Location: employee_login.php");
    exit();
}

$reservationMessage = "";


if (isset($_POST['check_out'])) {
    $res_id = mysqli_real_escape_string($conn, $_POST['res_id']);
    $today = date('Y-m-d'); 
    $query = "SELECT res_status, check_in, check_out, room_num FROM Reservations WHERE res_id = '$res_id'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $status = $row['res_status'];
        $check_out_date = $row['check_out'];
        $room_num = $row['room_num'];

        if ($status === 'Checked-in') {
            
            if ($check_out_date === $today) {
                
                $updateQuery = "UPDATE Reservations SET res_status = 'Checked-Out' WHERE res_id = '$res_id'";
                
                if (mysqli_query($conn, $updateQuery)) {
                    
                    $updateRoomQuery = "UPDATE Rooms SET status = 'Under Maintenance' WHERE room_num = '$room_num'";

                    if (mysqli_query($conn, $updateRoomQuery)) {
                        $reservationMessage = "Reservation ID $res_id has been successfully checked-out, and room $room_num is now available.";
                    } else {
                        $reservationMessage = "Error updating room availability. Please try again.";
                    }
                } else {
                    $reservationMessage = "Error updating reservation status. Please try again.";
                }
            } else {
                $reservationMessage = "Reservation ID $res_id is not eligible for check-out today.";
            }
        } else {
            $reservationMessage = "Reservation ID $res_id is not in 'Checked-in' status. Cannot check-out.";
        }
    } else {
        $reservationMessage = "No reservation found with ID $res_id.";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Check-out</title>
</head>
<body>
    <center><h1>Check-out Reservation</h1></center>
    <a href="reseptionist_dashboard.php">Back to Dashboard</a>
    
    <form method="POST">
        <label for="res_id">Enter Reservation ID:</label>
        <input type="text" id="res_id" name="res_id" required>
        <button type="submit" name="check_out">Check-out</button>
    </form>

    <?php if ($reservationMessage): ?>
        <p><?php echo "$reservationMessage"; ?></p>
    <?php endif; ?>

</body>
</html>
<?php
$conn->close();
?>