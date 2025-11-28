<?php
include 'db_conn.php'; 


$sql = "SELECT service_name, description, price FROM services";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Services Offered</title>
</head>
<body>
    <center><h2>Our Services</h2></center>
   <center> <table border="1">
        <tr>
            <th>Service Name</th>
            <th>Description</th>
            <th>Price (€) (per service/day)</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo ($row['service_name']); ?></td>
                <td><?php echo ($row['description']); ?></td>
                <td><?php echo ($row['price']); ?></td>
            </tr>
        <?php } ?>
    </table></center>
    <br>
    <a href="home_page.php">Go Back to Home</a>
</body>
</html>

<?php
$conn->close(); 
?>
