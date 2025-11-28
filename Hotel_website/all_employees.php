<?php
include 'db_conn.php'; 


$sql = "SELECT employee_id, first_name, last_name, position, email, mobile FROM Employees";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Employee details</title>
</head>
<body>
    <center><h2>All Employee Details</h2></center>
   <center> <table border="1">
        <tr>
            <th>Employee ID</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Position</th>
            <th>Email</th>
            <th>Phone</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
            <td><?php echo $row['employee_id']; ?></td>
                    <td><?php echo ($row['first_name']); ?></td>
                    <td><?php echo ($row['last_name']); ?></td>
                    <td><?php echo ($row['position']); ?></td>
                    <td><?php echo ($row['email']); ?></td>
                    <td><?php echo ($row['mobile']); ?></td>
            </tr>
        <?php } ?>
    </table></center>
    <br>
    <a href="search_employee.php">Go Back</a>
</body>
</html>

<?php
$conn->close(); 
?>
