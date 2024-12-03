<?php
// Include your database connection configuration
require("config.php");

// Check if the lecturer ID is provided in the request
if(isset($_GET['lid'])) {
    $lid = mysqli_real_escape_string($con, $_GET['lid']);

    // Query to check if the lecturer ID already exists
    $checkQuery = "SELECT COUNT(*) as count FROM lecturer WHERE lid = '$lid'";
    $checkResult = mysqli_query($con, $checkQuery);

    if ($checkResult) {
        $row = mysqli_fetch_assoc($checkResult);
        $exists = ($row['count'] > 0);
        echo '<script>alert("Lecturer ID already exists. Please choose a different Lecturer ID."); window.location.href = "student.php";</script>';
    
        // Return JSON response
        echo json_encode(['exists' => $exists]);
    } else {
        // Return JSON response indicating an error
        echo json_encode(['error' => 'Database query error']);
    }
} else {
    // Return JSON response indicating missing lecturer ID
    echo json_encode(['error' => 'Lecturer ID not provided']);
}
?>
