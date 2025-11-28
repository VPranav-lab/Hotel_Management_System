<?php
session_start();

if (isset($_SESSION['user_name'])) {
    session_unset();  
    session_destroy(); 
}

header("Location: Home_page.php"); 
exit();
?>