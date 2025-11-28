<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Login</title>
</head>
<body>
    <center><h2>Employee Login</h2></center>
    <a href="home_page.php">Go Back to Home</a>
    
    <form action="employee_login.php" method="POST">
        Employee ID: <input type="text" name="emp_id" required><br>
        Password: <input type="password" name="password" required><br>
        <button type="submit">Login</button>
    </form>
</body>
</html>


<?php
session_start();
include 'db_conn.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $emp_id = trim($_POST['emp_id']);
    $password = trim($_POST['password']);

    
    if (!is_numeric($emp_id)) {
        die("Invalid Employee ID format.");
    }

    
    $query = "SELECT employee_id, password, position FROM Employees WHERE employee_id = ?";
    $stmt = mysqli_prepare($conn, $query);

    
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $emp_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);

       
        if (mysqli_stmt_num_rows($stmt) > 0) {
            mysqli_stmt_bind_result($stmt, $db_emp_id, $db_password, $role);
            mysqli_stmt_fetch($stmt);

            
            if (hash("sha256", $password) === $db_password) {
                $_SESSION['emp_id'] = $db_emp_id;
                $_SESSION['role'] = $role;

                
                if ($role === "General Manager") {
                    header("Location: manager_dashboard.php");
                } elseif ($role === "Receptionist") {
                    header("Location: reseptionist_dashboard.php");
                } elseif ($role === "Housekeeping") {
                    header("Location: housekeeping_dashboard.php");
                } else {
                    echo "Unknown role. Please contact admin.";
                }
                exit();
            } else {
                echo "<p style='color:red;'>Invalid password.</p>";
            }
        } else {
            echo "<p style='color:red;'>Employee ID not found.</p>";
        }
        mysqli_stmt_close($stmt);
    } else {
        die("Database error: " . mysqli_error($conn)); 
    }
}

mysqli_close($conn);
?>
