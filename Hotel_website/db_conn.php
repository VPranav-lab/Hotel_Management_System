<?php
$servername = "localhost"; 
$username = "root"; //root by default 
$password = "Your_password"; // Your db password
$dbname = "name"; //Your database name


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>