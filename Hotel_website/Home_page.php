<?php
include 'db_conn.php';
session_start();
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['signup'])) {
    $username = trim($_POST['username']);
    $password = hash('sha256', $_POST['password']);

    $firstname = trim($_POST['firstname']);
    $lastname = trim($_POST['lastname']);
    $id_type = $_POST['id_type'];
    $doc_number = $_POST['doc_number'];
    $age = intval($_POST['age']);
    $mobile = trim($_POST['mobile']);
    $email = trim($_POST['email']);
    $address = trim($_POST['address']);

    $_SESSION['user_name'] = $username;
    $_SESSION['firstname'] = $firstname;
    $_SESSION['lastname'] = $lastname;

    
    $check = "SELECT * FROM guests WHERE username = '$username'";
    $result = mysqli_query($conn, $check);

    if (mysqli_num_rows($result) > 0) {
        $message = "Username already exists. Please choose another.";
    } else {
        $insert = "INSERT INTO guests 
            (first_name, last_name, username, password, age, doc_type, doc_number, mobile, email, address)
            VALUES 
            ('$firstname', '$lastname', '$username', '$password', $age, '$id_type', '$doc_number', '$mobile', '$email', '$address')";

        if (mysqli_query($conn, $insert)) {
            header("Location: user_home.php");
            exit();
        } else {
            $message = "Signup failed. Please try again.";
        }
    }
}
?>


<html>
<head>
    <title>Hotel Management System</title>
</head>
<body>
    <center><h1>Welcome to Our Hotel</h1></center>
    <ul>
        <li><a href='employee_login.php'>Employee Login</a></li>
        <li><a href='room_details.php'>See Room Details & Availability</a></li>
        <li><a href='services.php'>See Offered Services</a></li>
        <li><a href='feedback.php'>Give Feedback</a></li>
    </ul>

    <?php if (!empty($message)) echo "<p style='color:red;'>$message</p>"; ?>

   
    <center><fieldset style="width:280px; text-align:middle;">
            <center><legend><strong>Signup</strong></legend></center>
            <form method="POST" action="">
            First Name:<br>
            <input type="text" name="firstname" required><br><br>
            Last Name:<br>
            <input type="text" name="lastname" required><br><br>
            Username:<br>
            <input type="text" name="username" required><br><br>
            Password:<br>
            <input type="password" name="password" required><br><br>

            ID Type: 
            <select name="id_type">
                <option value="National ID">National ID</option>
                <option value="Driving License">Driving License</option>
                <option value="Passport">Passport</option>
            </select><br>
            Document Number:<br>
            <input type="text" name="doc_number" required><br><br>

            Age:<br>
            <input type="number" name="age" required><br><br>
            Mobile:<br>
            <input type="text" name="mobile" required><br><br>
            Email:<br>
            <input type="email" name="email" required><br><br>
            Address:<br>
            <textarea name="address" rows="3" required></textarea><br><br>

            <input type="submit" name="signup" value="Signup">
       
        <br><br>
        If already signed up <a href='user_login.php'>click here</a> for login.
    </form>
    </center>
</body>
</html>
