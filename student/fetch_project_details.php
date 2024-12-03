<?php
// fetch_project_details.php

// Include your database configuration file
require("config.php");

if (isset($_POST['projectId'])) {
    $projectId = $_POST['projectId'];

    // Fetch project details from the database, including supervisor information
    $query = "SELECT pi.id, pi.project_title, pi.description, pi.overview, pi.programmes, pi.objectives, l.firstname, l.lastname, l.lid as lid
    FROM project_ideas pi
    JOIN lecturer l ON pi.lid = l.lid
    WHERE pi.id = $projectId";

    $result = mysqli_query($con, $query);

    if ($result) {
        $row = mysqli_fetch_assoc($result);

        if ($row) {
            // Display project details, including supervisor information
            echo "<p><strong>Project Title:</strong> " . ($row['project_title'] ?? '') . "</p>";
            echo "<p><strong>Description:</strong> " . ($row['description'] ?? '') . "</p>";
            echo "<p><strong>Overview:</strong> " . ($row['overview'] ?? '') . "</p>";
            echo "<p><strong>Programmes:</strong> " . ($row['programmes'] ?? '') . "</p>";
            echo "<p><strong>Objectives:</strong> " . ($row['objectives'] ?? '') . "</p>";
            
            // Display supervisor information
            echo "<p><strong>Supervisor:</strong> " . ($row['firstname'] ?? '') . " " . ($row['lastname'] ?? '') . "</p>";
            echo "<p><strong>LID:</strong> " . ($row['lid'] ?? '') . "</p>";
            echo '<a href="message.php" class="btn btn-primary message-supervisor-btn" data-lid="' . ($row['lid'] ?? '') . '" data-name="' . ($row['firstname'] ?? '') . ' ' . ($row['lastname'] ?? '') . '">Message Supervisor</a>';
        } else {
            echo "No records found for the given project ID.";
        }
    } else {
        echo "Error fetching project details: " . mysqli_error($con);
    }
} else {
    echo "Invalid request.";
}
?>
