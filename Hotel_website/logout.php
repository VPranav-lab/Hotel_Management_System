<?php
session_start();

if (isset($_SESSION['employee_id'])) {
    session_unset();  
    session_destroy(); 
}

header("Location: employee_login.php"); 
exit();
?>