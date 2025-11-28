<?php
session_start();
include 'db_conn.php'; 


if (!isset($_SESSION['emp_id']) || $_SESSION['role'] !== 'General Manager') {
    header("Location: employee_login.php");
    exit();
}

$searchQuery = "";
$empQuery = "SELECT guests.first_name, guests.last_name, r.room_num, r.check_in, r.check_out, r.res_type, r.res_status from guests join reservations as r on guests.guest_id=r.guest_id;
"; 


if (isset($_POST['search'])) {
    $searchQuery = mysqli_real_escape_string($conn, trim($_POST['search_query']));
    $empQuery = "SELECT guests.first_name, guests.last_name, r.room_num, r.check_in, r.check_out, r.res_type, r.res_status from guests join reservations as r on guests.guest_id=r.guest_id
                WHERE first_name LIKE '%$searchQuery%'";
}

$empResult = mysqli_query($conn, $empQuery);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search reservations</title>
</head>
<body>
    <center><h1>Search reservations</h1></center>

    <a href="manager_dashboard.php">Go Back</a>
    
    <hr>

    <hr>

    
    <form method="POST">
        <label for="search_query">Search by First Name:</label>
        <input type="text" id="search_query" name="search_query" value="<?php echo ($searchQuery); ?>">
        <button type="submit" name="search">Search</button>
    </form>

    <hr>

    
    <?php 
    if ($empResult && mysqli_num_rows($empResult) > 0): ?>
        <table border="1">
            <tr>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Room Number</th>
                <th>check-in date</th>
                <th>Check_out date</th>
                <th>Reservation Type</th>
                <th>Reservation Status</th>
            </tr>
            <?php while ($row = mysqli_fetch_assoc($empResult)): ?>
                <tr>
                    <td><?php echo ($row['first_name']); ?></td>
                    <td><?php echo ($row['last_name']); ?></td>
                    <td><?php echo ($row['room_num']); ?></td>
                    <td><?php echo ($row['check_in']); ?></td>
                    <td><?php echo ($row['check_out']); ?></td>
                    <td><?php echo ($row['res_type']); ?></td>
                    <td><?php echo ($row['res_status']); ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p>No reservations found.</p>
    <?php endif; ?>

</body>
</html>
<?php
$conn->close();
?>