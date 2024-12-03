<?php
// Include your database connection file
require("config.php");

// Check if the student ID is provided in the POST request
if(isset($_POST['student_id'])) {
    // Sanitize the input to prevent SQL injection
    $studentId = mysqli_real_escape_string($con, $_POST['student_id']);

    // Query to fetch the student's name based on the provided student ID
    $query = "SELECT firstname, lastname FROM student WHERE sid = '$studentId'";
    $result = mysqli_query($con, $query);

    // Check if the query was successful
    if($result && mysqli_num_rows($result) > 0) {
        // Fetch the student's name from the result set
        $row = mysqli_fetch_assoc($result);
        $studentName = $row['firstname'] . ' ' . $row['lastname'];

        // Prepare the response array
        $response = array(
            'student_name' => $studentName
        );

        // Send the response as JSON
        echo json_encode($response);
    } else {
        // If no matching student found, send an error response
        echo json_encode(array('error' => 'Student not found'));
    }
} else {
    // If student ID is not provided, send an error response
    echo json_encode(array('error' => 'Student ID not provided'));
}
?>
