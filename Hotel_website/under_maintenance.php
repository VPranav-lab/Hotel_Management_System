<?php
include 'db_conn.php'; 
session_start();
if (!isset($_SESSION['emp_id']) || $_SESSION['role'] !== 'Housekeeping') {
    header("Location: employee_login.php");
    exit();
}

$sql = "SELECT room_num from rooms where status = 'Under Maintenance'";

$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Under maintenance</title>
</head>
<body>
    <center><h2>Rooms Under Maintenance</h2></center>

    <a href="housekeeping_dashboard.php">Go Back</a>
   <center> <table border="1">
        <tr>
            <th>Room Number</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo ($row['room_num']); ?></td>
            </tr>
        <?php } ?>
    </table></center>
    <br>
    
</body>
</html>

<?php
$conn->close(); 
?>
