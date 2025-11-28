<?php
session_start();
include('db_conn.php'); 

$message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];

    $hashed_password = hash('sha256', $password);

    $query = "SELECT * FROM guests WHERE username = '$username' AND password = '$hashed_password'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION['user_name'] = $row['username'];
        $_SESSION['firstname'] = $row['first_name'];
        $_SESSION['lastname'] = $row['last_name'];

        header("Location: user_home.php");
        exit;
    } else {
        $message = "Invalid username or password.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Login</title>
</head>
<body>

    <?php if (!empty($message)) {
        echo "<p style='color:red; text-align:center;'>$message</p>";
    } ?>
    <center><fieldset style="width:300px; text-align:middle;">
            <center><h3><legend><strong>Login</strong></legend></h3></center>
    <form method="POST" action="">
        <label>Username:</label><br>
        <input type="text" name="username" required><br><br>

        <label>Password:</label><br>
        <input type="password" name="password" required><br><br>

        <input type="submit" value="Login">
    </form>

    <br>
    <p>If you haven't signed up yet, click <a href="Home_page.php"> here </a> to sign up.</p></center>
</body>
</html>
