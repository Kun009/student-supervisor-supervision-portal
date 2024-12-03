<?php
session_start();
require("config.php");

// Check if the admin is logged in
if (!isset($_SESSION['lid'])) {
    header("location:index.php");
    exit;
}

// Check if the form was submitted
if (isset($_POST['delete_assignment'])) {
    // Get the assignment ID to be deleted
    $delete_id = $_POST['delete_id'];

    // Debugging: Print the assignment ID
    echo "Assignment ID to delete: " . $delete_id . "<br>";

    // Query to delete the assignment
    $deleteQuery = "DELETE FROM assign WHERE id = '$delete_id'";

    // Debugging: Print the delete query
    echo "Delete Query: " . $deleteQuery . "<br>";

    // Perform the deletion
    $deleteResult = mysqli_query($con, $deleteQuery);

    if ($deleteResult) {
        // Redirect back to the admin assignment page after successful deletion
        header("Location: student.php");
        exit;
    } else {
        // Handle error if deletion fails
        echo "Error deleting assignment: " . mysqli_error($con);
    }
} else {
    // Redirect to the admin assignment page if the form was not submitted
    header("Location: assign.php");
    exit;
}
?>
