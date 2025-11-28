<?php
include('db_conn.php');
session_start();
if (!isset($_SESSION['user_name'])) {
    header("Location: Home_page.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>user home page</title>
</head>
<body>
    <center><h1>Hello mr/mrs. <?php echo "{$_SESSION['firstname']} {$_SESSION['lastname']}" ?></h1></center>

    <a href="user_logout.php">Logout</a>
    <ul>
        <li><a href='book_room.php'>Book a Room</a></li>
        <li><a href='cancel_booking.php'>Cancel Booking</a></li>
        
    </ul>
</body>
</html>