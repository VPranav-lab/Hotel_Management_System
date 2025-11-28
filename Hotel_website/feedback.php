<?php

include('db_conn.php');


$error = "";
$success = "";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Give Feedback</title>
</head>
<body>
    <center><h2>Give Us Your Feedback</h2></center>

   

    
    <form method="POST" action="">
        <label for="first_name">First Name:</label>
        <input type="text" name="first_name" id="first_name" required><br><br>

        <label for="last_name">Last Name:</label>
        <input type="text" name="last_name" id="last_name" required><br><br>

        <label for="room_number">Room Number You Stayed In:</label>
        <input type="text" name="room_number" id="room_number" required><br><br>

        <label for="rating">Rating (out of 5):</label>
        <select name="rating" id="rating" required>
            <option value="">Select Rating</option>
            <option value="1">1 - Poor</option>
            <option value="2">2 - Fair</option>
            <option value="3">3 - Good</option>
            <option value="4">4 - Very Good</option>
            <option value="5">5 - Excellent</option>
        </select><br><br>

        <label for="suggestions">Suggestions (Optional):</label><br>
        <textarea name="suggestions" id="suggestions" rows="4" cols="40"></textarea><br><br>
        <a href="user_home.php"><button type="button">Go Back to Home</button></a>
        
        <input type="submit" value="Submit Feedback">
        <?php
    
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        
        $first_name = trim($_POST['first_name']);
        $last_name = trim($_POST['last_name']);
        $room_number = trim($_POST['room_number']);
        $rating = trim($_POST['rating']);
        $suggestions = trim($_POST['suggestions']);

        
        if (empty($first_name) || empty($last_name) || empty($room_number) || empty($rating)) {
            $error = "Please fill all required fields.";
        } 
        if($room_number<151 || $room_number>200){
            $error = "Please enter a valid room number.";
        }else {
            
            $query = "INSERT INTO Feedback (first_name, last_name, room_num, rating, suggestions) 
                      VALUES (?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($stmt, "sssis", $first_name, $last_name, $room_number, $rating, $suggestions);

            if (mysqli_stmt_execute($stmt)) {
                $success = "Successfully Rated!";
            } else {
                $error = "Error submitting feedback. Please try again.";
            }

            
            mysqli_stmt_close($stmt);
        }
    }
    ?>

    
    <?php if (!empty($error)) { echo "<p style='color: red;'>$error</p>"; } ?>

    
    <?php if (!empty($success)) { echo "<p style='color: green;'>$success</p>"; } ?>

    </form>
</body>
</html>
<?php
$conn->close();
?>


