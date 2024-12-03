<?php
// fetch_project_details.php

session_start();
require("config.php");

// Check if the project_id is set in the POST request
if (isset($_POST['id'])) {
    $projectId = $_POST['id'];

    // Fetch additional details from the database
    $detailsQuery = "SELECT project_title, description, keywords, programmes, overview, objectives FROM project_ideas WHERE id = '$projectId'";
    $detailsResult = mysqli_query($con, $detailsQuery);

    // Check for errors
    if (!$detailsResult) {
        echo json_encode(['status' => 'error', 'message' => 'Error executing the query: ' . mysqli_error($con)]);
        exit;
    }

    if (mysqli_num_rows($detailsResult) > 0) {
        $details = mysqli_fetch_assoc($detailsResult);

        // Output details in the desired JSON format
        echo '<p><b>Description</b>: ' . $details['description'] . '</p>';
        echo '<p><b>Keywords:</b> ' . $details['keywords'] . '</p>';
        echo '<p><b>Programmes: </b>' . $details['programmes'] . '</p>';
        echo '<p><b>Overview:</b> ' . $details['overview'] . '</p>';
        echo '<p><b>Objectives:</b> ' . $details['objectives'] . '</p>';
       
    } else {
        echo json_encode(['status' => 'error', 'message' => 'No details found for the given project ID.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request.']);
}
?>
