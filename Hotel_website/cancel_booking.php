<?php
include 'db_conn.php'; 
session_start();
if (!isset($_SESSION['user_name'])) {
    header("Location: Home_page.php");
    exit();
}?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cancel Booking</title>
</head>
<body>
    <center><h2>Cancel Booking</h2></center>
    <a href="user_logout.php">logout</a>
    <form action = "cancel_booking.php" method="POST">
        <label>Enter Reservation ID:</label>
        <input type="number" name="res_id" required>
        <button type="submit">Cancel Booking</button>
    </form>
    <br>
    <a href="user_home.php">Go Back to Home</a>
</body>
</html>

<?php
include 'db_conn.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $res_id = $_POST['res_id'];
    $user_name = $_SESSION['user_name'];
    $querry1 = mysqli_query($conn, "SELECT guest_id FROM guests WHERE username = '$user_name'") ;
    $row1 = mysqli_fetch_assoc($querry1);
    $guest_id = $row1['guest_id'];

    $querry2 = mysqli_query($conn, "SELECT res_id FROM reservations WHERE guest_id = '$guest_id'");
    $row2 = mysqli_fetch_assoc($querry2);
    $res_id2 = $row2['res_id'];

    $query = "SELECT room_num FROM Reservations WHERE guest_id = ? AND res_status = 'Confirmed'";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $guest_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $reservation = mysqli_fetch_assoc($result);

    if ($reservation && $res_id == $res_id2) {
        $room_num = $reservation['room_num'];

        
        $updateRes = "UPDATE Reservations SET res_status = 'Cancelled' WHERE res_id = ?";
        $stmt1 = mysqli_prepare($conn, $updateRes);
        mysqli_stmt_bind_param($stmt1, "i", $res_id2);
        mysqli_stmt_execute($stmt1);

       
        $updateRoom = "UPDATE Rooms SET status = 'Available' WHERE room_num = ?";
        $stmt2 = mysqli_prepare($conn, $updateRoom);
        mysqli_stmt_bind_param($stmt2, "i", $room_num);
        mysqli_stmt_execute($stmt2);

        echo "<p style='color: green; font-weight: bold;'>Booking cancelled successfully. Room $room_num is now available for booking.</p>";
    } else {
        echo "<p style='color: red; font-weight: bold;'>Invalid Reservation ID or Booking already cancelled.</p>";
    }
}
$conn->close(); 
?>


