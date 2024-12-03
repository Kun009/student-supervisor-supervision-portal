<?php
session_start();
require("config.php");

// Check if the user is logged in
if (!isset($_SESSION['aid'])) {
    header("location:index.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['project_id'])) {
        $projectId = $_POST['project_id'];

        // Update the project_status to 'read' in the projects table
        $updateQuery = "UPDATE projects SET project_status = 'read' WHERE project_id = '$projectId'";
        $result = mysqli_query($con, $updateQuery);

        if ($result) {
            // Marked as read successfully
            header("Location: project.php");
            exit;
        } else {
            // Error updating the database
            exit('Error marking project as read. Please try again.');
        }
    } else {
        // Handle the case when the project_id is not provided
        exit('Project ID not provided.');
    }
} else {
    // Handle the case when the script is accessed without form submission
    header("location: project.php");
    exit;
}
?>
