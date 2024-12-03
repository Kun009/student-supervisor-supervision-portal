<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Include the database configuration file
    require("config.php");

    // Get the admin ID to be deleted
    $aid = $_POST['aid'];

    // Fetch admin details before deletion for further use or logging if needed
    $selectQuery = "SELECT * FROM admin WHERE aid = '$aid'";
    $adminDetails = mysqli_query($con, $selectQuery);
    $adminData = mysqli_fetch_assoc($adminDetails);

    // Prepare and execute the SQL query to delete the admin from the database
    $deleteQuery = "DELETE FROM admin WHERE aid = '$aid'";
    $deleteResult = mysqli_query($con, $deleteQuery);

    if ($deleteResult) {
        // Redirect back to the admins page with a success message
        header("Location: admin.php?success=Admin deleted successfully. Admin Details: " . json_encode($adminData));
        exit;
    } else {
        // Redirect back to the admins page with an error message
        header("Location: admin.php?error=Error deleting admin");
        exit;
    }
} else {
    // If the form is not submitted, redirect back to the admins page
    header("Location: admin.php");
    exit;
}
?>