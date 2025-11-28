<?php
include('db_conn.php'); 
session_start();
if (!isset($_SESSION['emp_id']) || $_SESSION['role'] !== 'Housekeeping') {
    header("Location: employee_login.php");
    exit();
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $room_num = $_POST['room_num'];  
    $status = $_POST['status'];      

    
    $query = "SELECT room_num, status FROM Rooms WHERE room_num = $room_num";
    $result = mysqli_query($conn, $query);

    
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $db_status = $row['status'];

       
        if ($db_status == 'Under Maintenance') {
            
            $updateQuery = "UPDATE Rooms SET status = 'Available' WHERE room_num = $room_num";
            if (mysqli_query($conn, $updateQuery)) {
                echo "<p style='color: green; font-weight: bold;'>Room $room_num has been marked as Available.</p>";
            } else {
                echo "<p style='color: red; font-weight: bold;'>Error updating room status.</p>";
            }
        } else {
            echo "<p style='color: red; font-weight: bold;'>Room $room_num is not under maintenance.</p>";
        }
    } else {
        echo "<p style='color: red; font-weight: bold;'>Room not found.</p>";
    }
}

$conn->close();

?>