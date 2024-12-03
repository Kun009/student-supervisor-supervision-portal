<?php
// save_project_details.php

session_start();
require("config.php");

if (isset($_POST['id'])) {
    $projectId = $_POST['id'];

    $description = mysqli_real_escape_string($con, $_POST['description']);
    $keywords = mysqli_real_escape_string($con, $_POST['keywords']);
    $programmes = mysqli_real_escape_string($con, $_POST['programmes']);
    $overview = mysqli_real_escape_string($con, $_POST['overview']);
    $objectives = mysqli_real_escape_string($con, $_POST['objectives']);

    $updateQuery = "UPDATE project_ideas SET 
                    description = '$description',
                    keywords = '$keywords',
                    programmes = '$programmes',
                    overview = '$overview',
                    objectives = '$objectives'
                    WHERE id = '$projectId'";

    $updateResult = mysqli_query($con, $updateQuery);

    if ($updateResult) {
        echo json_encode(['status' => 'success', 'message' => 'Changes saved successfully.', 'data' => [
            'description' => '<p><b>Description</b>: ' . $description . '</p>',
            'keywords' => '<p><b>Keywords:</b> ' . $keywords . '</p>',
            'programmes' => '<p><b>Programmes: </b>' . $programmes . '</p>',
            'overview' => '<p><b>Overview:</b> ' . $overview . '</p>',
            'objectives' => '<p><b>Objectives:</b> ' . $objectives . '</p>',
        ]]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error saving changes: ' . mysqli_error($con)]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request.']);
}
?>
