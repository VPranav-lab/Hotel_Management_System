<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Confirmation</title>
</head>
<body>
    <center>
        <h2 style="color: green;">Booking Successful!</h2>
        <?php
        if (isset($_GET['res_id']) && isset($_GET['room_num'])) {
            $res_id = $_GET['res_id'];
            $room_num = $_GET['room_num'];
            echo "<p>Reservation ID: <b>$res_id</b></p>";
            echo "<p>Room Number: <b>$room_num</b></p>";
        } else {
            echo "<p style='color: red;'>Invalid request.</p>";
        }
        ?>
        <br>
        <a href="home_page.php">Go Back to Home</a>
    </center>
</body>
</html>
