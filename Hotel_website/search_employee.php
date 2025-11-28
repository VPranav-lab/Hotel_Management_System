<?php
session_start();
include 'db_conn.php'; 


if (!isset($_SESSION['emp_id']) || $_SESSION['role'] !== 'General Manager') {
    header("Location: employee_login.php");
    exit();
}

$searchQuery = "";
$empQuery = "SELECT employee_id, first_name, last_name, position, email, mobile FROM Employees"; // Default query


if (isset($_POST['search'])) {
    $searchQuery = mysqli_real_escape_string($conn, trim($_POST['search_query']));
    $empQuery = "SELECT employee_id, first_name, last_name, position, email, mobile FROM Employees WHERE first_name LIKE '%$searchQuery%'";
}

$empResult = mysqli_query($conn, $empQuery);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Employee</title>
</head>
<body>
    <center><h1>Search Employee</h1></center>

    <a href="manager_dashboard.php">Go Back</a>
    
    <hr>

    <hr>

    
    <form method="POST">
        <label for="search_query">Search by First Name:</label>
        <input type="text" id="search_query" name="search_query" value="<?php echo ($searchQuery); ?>">
        <button type="submit" name="search">Search</button>
    </form>

    <hr>

    
    <?php 
    if ($empResult && mysqli_num_rows($empResult) > 0): ?>
        <table border="1">
            <tr>
                <th>Employee ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Position</th>
                <th>Email</th>
                <th>Phone</th>
            </tr>
            <?php while ($row = mysqli_fetch_assoc($empResult)): ?>
                <tr>
                    <td><?php echo $row['employee_id']; ?></td>
                    <td><?php echo ($row['first_name']); ?></td>
                    <td><?php echo ($row['last_name']); ?></td>
                    <td><?php echo ($row['position']); ?></td>
                    <td><?php echo ($row['email']); ?></td>
                    <td><?php echo ($row['mobile']); ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p>No employees found.</p>
    <?php endif; ?>

</body>
</html>
<?php
$conn->close();
?>