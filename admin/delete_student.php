<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Include the database configuration file
    require("config.php");

    // Get the student ID to be deleted
    $sid = $_POST['studentId'];

    // Prepare and execute the SQL query to delete the student from the database
    $deleteQuery = "DELETE FROM student WHERE sid = '$sid'";
    $deleteResult = mysqli_query($con, $deleteQuery);

    if ($deleteResult) {
        // Redirect back to the students page with a success message
        header("Location: student.php?success=Student deleted successfully");
        exit;
    } else {
        // Redirect back to the students page with an error message
        header("Location: student.php?error=Error deleting student");
        exit;
    }
} else {
    // If the form is not submitted, redirect back to the students page
    header("Location: student.php");
    exit;
}
?>
