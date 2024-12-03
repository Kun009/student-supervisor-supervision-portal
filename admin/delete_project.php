<?php
// delete_project.php

session_start();
require("config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    $projectIdToDelete = $_POST['id'];

    // Perform the deletion
    $deleteQuery = "DELETE FROM project_ideas WHERE id = '$projectIdToDelete'";
    $deleteResult = mysqli_query($con, $deleteQuery);

    if ($deleteResult) {
        echo json_encode(['status' => 'success', 'message' => 'Project deleted successfully.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error deleting project: ' . mysqli_error($con)]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request.']);
}
?>
