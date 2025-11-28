<?php
include 'db_conn.php'; 
session_start(); 
if (!isset($_SESSION['emp_id']) || $_SESSION['role'] !== 'Receptionist') {
    header("Location: employee_login.php");
    exit();
}

$roomQuery = "SELECT distinct room_type.room_type_id, room_type.type_name, room_type.capacity, rooms.price FROM room_type join rooms on room_type.room_type_id=rooms.room_type_id";
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
    <a href="reseptionist_dashboard.php">Go Back</a>
    <form action="book_room.php" method="POST">
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
        <select name="room_type" id="room_type" required>
            <?php while ($row = mysqli_fetch_assoc($roomResult)) { ?>
                <option value="<?= $row['room_type_id'] ?>" data-capacity="<?= $row['capacity'] ?>" data-price="<?= $row['price'] ?>">
                    <?= $row['type_name'] ?> (€<?= $row['price'] ?>/night)
                </option>
            <?php } ?>
        </select><br>

        Number of People: 
        <select name="num_people" id="num_people" required></select><br>

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
        <option value="Cash">Cash</option>
            <option value="Credit Card">Credit Card</option>
            <option value="Debit Card">Debit Card</option>
        </select><br>

        <h3>Total Amount: <span id="total_amount">€0</span></h3>
        
        <button type="submit">Confirm Booking</button>
    </form>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let roomTypeSelect = document.getElementById("room_type");
            let numPeopleSelect = document.getElementById("num_people");
            let totalAmount = document.getElementById("total_amount");
            
            let checkInInput = document.querySelector('input[name="check_in"]');
            checkInInput.value = new Date().toISOString().split('T')[0]

            function updateCapacity() {
                let selectedOption = roomTypeSelect.options[roomTypeSelect.selectedIndex];
                let maxCapacity = selectedOption.getAttribute("data-capacity");
                let pricePerNight = selectedOption.getAttribute("data-price");

                numPeopleSelect.innerHTML = "";
                for (let i = 1; i <= maxCapacity; i++) {
                    let option = document.createElement("option");
                    option.value = i;
                    option.textContent = i;
                    numPeopleSelect.appendChild(option);
                }
            }

            function calculateTotal() {
                let selectedOption = roomTypeSelect.options[roomTypeSelect.selectedIndex];
                let pricePerNight = parseFloat(selectedOption.getAttribute("data-price"));
                let checkIn = document.querySelector('input[name="check_in"]').value;
                let checkOut = document.querySelector('input[name="check_out"]').value;

                let startDate = new Date(checkIn);
                let endDate = new Date(checkOut);
                let nights = (endDate - startDate) / (1000 * 60 * 60 * 24);

                let total = pricePerNight * nights;

                document.querySelectorAll('input[name^="services"]:checked').forEach(service => {
                    let servicePrice = parseFloat(service.value);
                    let serviceId = service.name.match(/\d+/)[0];
                    let serviceQty = document.querySelector(`input[name="service_qty[${serviceId}]"]`).value;
                    if (serviceQty) {
                        total += servicePrice * parseInt(serviceQty);
                    }
                });

                totalAmount.textContent = "€" + (total.toFixed(2) || "0");
            }

            roomTypeSelect.addEventListener("change", updateCapacity);
            document.querySelectorAll('input[name^="services"]').forEach(service => {
                service.addEventListener("change", calculateTotal);
            });
            document.querySelectorAll('input[name^="service_qty"]').forEach(serviceQty => {
                serviceQty.addEventListener("input", calculateTotal);
            });
            document.querySelectorAll('input[type="date"]').forEach(dateInput => {
                dateInput.addEventListener("change", calculateTotal);
            });

            updateCapacity();
        });
    </script>
    
</body>
</html>
<?php
include 'db_conn.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $age = $_POST['age'];
    $id_type = $_POST['id_type'];
    $doc_number = $_POST['doc_number'];
    $mobile = $_POST['mobile'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $room_type = $_POST['room_type'];
    $num_people = $_POST['num_people'];
    $check_in = date("Y-m-d H:i:s");
    $check_out = $_POST['check_out'];
    $payment_method = $_POST['payment_method'];
    if(isset($_POST['services'])){
        $services = $_POST['services'];
    }
    
    if(isset($_POST['service_qty'])){
        $service_quantities = $_POST['service_qty'];
    }
    
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
    
    mysqli_query($conn, "INSERT INTO Guests (first_name, last_name, age, doc_type, doc_number, mobile, email, address) 
    VALUES ('$first_name', '$last_name', $age, '$id_type', '$doc_number', '$mobile', '$email', '$address')");

    $querry1 = mysqli_query($conn, "SELECT guest_id FROM guests WHERE doc_number = '$doc_number'") ;
    $row2 = mysqli_fetch_assoc($querry1);
    $guest_id = $row2['guest_id'];
    
    mysqli_query($conn, "INSERT INTO Reservations (guest_id, room_num, check_in, check_out, res_type, res_status) 
    VALUES ($guest_id, $room_num, '$check_in', '$check_out','At Hotel', 'Checked-In')");
    $querry2 = mysqli_query($conn, "SELECT res_id FROM reservations WHERE guest_id = '$guest_id'") ;
    $row3 = mysqli_fetch_assoc($querry2);
    $res_id = $row3['res_id'];
    

    $services_amount = 0;

    foreach ($service_quantities as $service_id => $qty) {
        
        $serviceQuery = "SELECT price FROM Services WHERE service_id = $service_id";
        $serviceResult = mysqli_query($conn, $serviceQuery);
        $service = mysqli_fetch_assoc($serviceResult);
        $qty = (int)$qty;
        if ($qty > 0) {
            $service_price = $service['price'];
            $total_price = $service_price * $qty;
            $services_amount += $total_price;

            
            $stmt = mysqli_prepare($conn, "INSERT INTO guest_services (guest_id, service_id, quantity, total_price) 
                               VALUES (?, ?, ?, ?)");
            mysqli_stmt_bind_param($stmt, "iiii", $guest_id, $service_id, $qty, $total_price);
            
            if (!mysqli_stmt_execute($stmt)) {
                die("Error inserting into guest_services table: " . mysqli_error($conn));
            }
        }
    }
    
    $total_payment = $room_amount + $services_amount;
    $payment_date = date("Y-m-d H:i:s");

    
    $stmt1 = mysqli_prepare($conn, "INSERT INTO payments (res_id, room_amount, services_amount, total_amount, payment_date, pay_method) 
    VALUES (?, ?, ?, ?, ?, ?)");

    
    mysqli_stmt_bind_param($stmt1, "iiiiss", $res_id, $room_amount, $services_amount, $total_payment, $payment_date, $payment_method);

   
    if (!mysqli_stmt_execute($stmt1)) {
        die("Error inserting into payments table: " . mysqli_error($conn));
    }

    mysqli_query($conn, "UPDATE Rooms SET status = 'Booked' WHERE room_num = $room_num");

    echo "<p style='color: green; font-weight: bold;'>Booking successful with registration number $res_id! Room $room_num assigned.</p>";
}
//$conn->close(); 
?>
