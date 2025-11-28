<?php
session_start();
include 'db_conn.php'; 


if (!isset($_SESSION['emp_id']) || $_SESSION['role'] !== 'Receptionist') {
    header("Location: employee_login.php");
    exit();
}

$reservationMessage = "";


if (isset($_POST['check_in'])) {
    $res_id = mysqli_real_escape_string($conn, $_POST['res_id']);

    
    $query = "SELECT res_status, check_in FROM Reservations WHERE res_id = '$res_id'";
    $result = mysqli_query($conn, $query);
    $today = date('Y-m-d');
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $status = $row['res_status'];
        $check_in_date = $row['check_in'];
        if ($status === 'Confirmed') {
            if ($check_in_date === $today) {
            
                $updateQuery = "UPDATE Reservations SET res_status = 'Checked-in' WHERE res_id = '$res_id'";
                if (mysqli_query($conn, $updateQuery)) {
                    $reservationMessage = "Reservation ID $res_id has been successfully checked-in.";
                } else {
                    $reservationMessage = "Error updating reservation status. Please try again.";
                }
            }else {
                $reservationMessage = "Reservation ID $res_id is not for today. Cannot check-in.";
            }
        } else {
            $reservationMessage = "Reservation ID $res_id is not in 'Confirmed' status. Cannot check-in.";
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
    <title>Check-in</title>
</head>
<body>
    <center><h1>Check-in Reservation</h1></center>
    <a href="reseptionist_dashboard.php">Back to Dashboard</a>
    
    <form method="POST">
        <label for="res_id">Enter Reservation ID:</label>
        <input type="text" id="res_id" name="res_id" required>
        <button type="submit" name="check_in">Check-in</button>
    </form>

    <?php if ($reservationMessage): ?>
        <p><?php echo "$reservationMessage"; ?></p>
    <?php endif; ?>

</body>
</html>
<?php
$conn->close();
?>