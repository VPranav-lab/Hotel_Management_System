<?php
include 'db_conn.php'; 


$sql = "SELECT DISTINCT room_type.type_name, room_type.room_description, rooms.price FROM room_type join rooms on room_type.room_type_id=rooms.room_type_id";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Room Types and Prices</title>
</head>
<body>
    <center><h2>Room Types and Prices</h2></center>
   <center> <table border="1">
        <tr>
            <th>Room Type</th>
            <th>Description</th>
            <th>Price (€) (per day)</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo ($row['type_name']); ?></td>
                <td><?php echo ($row['room_description']); ?></td>
                <td><?php echo ($row['price']); ?></td>
            </tr>
        <?php } ?>
    </table></center>
    <br>
    <a href="room_details.php">Go Back</a>
</body>
</html>

<?php
$conn->close(); 
?>
