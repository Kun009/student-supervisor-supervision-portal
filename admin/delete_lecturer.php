<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Include the database configuration file
    require("config.php");

    // Get the lecturer ID to be deleted
    $lid = $_POST['lecturerId'];

    // Prepare and execute the SQL query to delete the lecturer from the database
    $deleteQuery = "DELETE FROM lecturer WHERE lid = '$lid'";
    $deleteResult = mysqli_query($con, $deleteQuery);

    if ($deleteResult) {
        // Redirect back to the lecturers page with a success message
        header("Location: lecturer.php?success=Lecturer deleted successfully");
        exit;
    } else {
        // Redirect back to the lecturers page with an error message
        header("Location: lecturer.php?error=Error deleting lecturer");
        exit;
    }
} else {
    // If the form is not submitted, redirect back to the lecturers page
    header("Location: lecturer.php");
    exit;
}
?>
