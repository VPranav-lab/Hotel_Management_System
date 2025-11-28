<?php
include('db_conn.php');
session_start();
if (!isset($_SESSION['emp_id']) || $_SESSION['role'] !== 'Housekeeping') {
    header("Location: employee_login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>House Keeping</title>
</head>
<body>
    <center><h1>House Keeping Dashboard</h1></center>

    <a href="logout.php">Logout</a>
  
    <form method="POST" action="under_maintenance.php">
        <input type="submit" name="view_under_maintenance" value="View Rooms Under Maintenance">
    </form>

    <hr>

    
    <h3>Mark Room as Available:</h3>
    <form action="update_room_status.php" method="POST">
        <label for="room_num">Room Number:</label>
        <input type="number" name="room_num" required>
        <button type="submit" name="status" value="Available">Mark as Available</button>
    </form><br>
</body>
</html>
<?php
$conn->close();
?>


        


