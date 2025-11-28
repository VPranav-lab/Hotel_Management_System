<?php
include 'db_conn.php';  

$roomQuery = "SELECT DISTINCT room_type.room_type_id, room_type.type_name, room_type.capacity, rooms.price FROM room_type JOIN rooms ON room_type.room_type_id=rooms.room_type_id";
$roomResult = mysqli_query($conn, $roomQuery);

$serviceQuery = "SELECT * FROM Services";
$serviceResult = mysqli_query($conn, $serviceQuery);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book a Room</title>
</head>
<body>
    <center><h2>Book a Room</h2></center>
    <a href="home_page.php">Go Back to Home</a>
    <form action="" method="POST">
        <h3>Guest Details</h3>
        First Name: <input type="text" name="first_name" required><br>
        Last Name: <input type="text" name="last_name" required><br>
        Age: <input type="number" name="age" min="18" required><br>
        ID Type: 
        <select name="id_type">
            <option value="National ID">National ID</option>
            <option value="Driving License">Driving License</option>
            <option value="Passport">Passport</option>
        </select><br>
        Document Number: <input type="text" name="doc_number" required><br>
        Mobile: <input type="text" name="mobile" required><br>
        Email: <input type="email" name="email" required><br>
        Address: <textarea name="address" required></textarea><br>

        <h3>Room Preferences</h3>
        Select Room Type: 
        <select name="room_type" required>
            <?php while ($row = mysqli_fetch_assoc($roomResult)) { ?>
                <option value="<?= $row['room_type_id'] ?>" data-price="<?= $row['price'] ?>">
                    <?= $row['type_name'] ?> (€<?= $row['price'] ?>/night)
                </option>
            <?php } ?>
        </select><br>

        Check-in Date: <input type="date" name="check_in" required><br>
        Check-out Date: <input type="date" name="check_out" required><br>

        <h3>Optional Services</h3>
        <?php while ($service = mysqli_fetch_assoc($serviceResult)) { ?>
            <input type="checkbox" name="services[<?= $service['service_id'] ?>]" value="<?= $service['price'] ?>"> 
            <?= $service['service_name'] ?> (€<?= $service['price'] ?> per use)
            <input type="number" name="service_qty[<?= $service['service_id'] ?>]" min="1" placeholder="Qty (if selected)">
            <br>
        <?php } ?>

        <h3>Payment</h3>
        <label>Payment Method:</label>
        <select name="payment_method">
            <option value="Credit Card">Credit Card</option>
            <option value="Debit Card">Debit Card</option>
        </select><br>

        <h3>Total Amount: <span id="total_amount">€0</span></h3>
        <p style="color: red; font-weight: bold;">Note: The amount is not refundable once paid.</p>

        <button type="submit" name="submit">Confirm Booking</button>
    </form>

    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $room_type = $_POST['room_type'];
        $check_in = $_POST['check_in'];
        $check_out = $_POST['check_out'];

        $roomQuery = "SELECT room_num, price FROM Rooms WHERE room_type_id = $room_type AND status = 'Available' LIMIT 1";
        $roomResult = mysqli_query($conn, $roomQuery);
        $room = mysqli_fetch_assoc($roomResult);

        if (!$room) {
            die("No available rooms for the selected type.");
        }

        $room_num = $room['room_num'];
        $room_price = $room['price'];
        $check_in_date = new DateTime($check_in);
        $check_out_date = new DateTime($check_out);
        $stay_duration = $check_in_date->diff($check_out_date)->days;
        $room_amount = $stay_duration * $room_price;

        $services_amount = 0;
        if (isset($_POST['services'])) {
            foreach ($_POST['services'] as $service_id => $service_price) {
                $qty = $_POST['service_qty'][$service_id] ?? 1;
                $services_amount += $service_price * $qty;
            }
        }

        $total_payment = $room_amount + $services_amount;
        echo "<h3>Total Amount: €" . number_format($total_payment, 2) . "</h3>";
        echo "<p style='color: red; font-weight: bold;'>Note: The amount is not refundable once paid.</p>";
    }
    ?>
</body>
</html>
