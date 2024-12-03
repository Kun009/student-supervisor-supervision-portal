<?php
session_start();
require("config.php");

// Check if the lecturer is logged in
if (!isset($_SESSION['lid'])) {
    header("location:index.php");
    exit;
}

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Fetch data from the form
    $projectTitle = mysqli_real_escape_string($con, $_POST['projectTitle']);
    $description = mysqli_real_escape_string($con, $_POST['description']);
    $keywords = mysqli_real_escape_string($con, $_POST['keywords']);
    $programmes = mysqli_real_escape_string($con, $_POST['programmes']);
    $overview = mysqli_real_escape_string($con, $_POST['overview']);
    $objectives = mysqli_real_escape_string($con, $_POST['objectives']);

    // Insert the new project idea into the database
    $insertQuery = "INSERT INTO project_ideas (lid, project_title, description, keywords, programmes, overview, objectives) 
                    VALUES ('{$_SESSION['lid']}', '$projectTitle', '$description', '$keywords', '$programmes', '$overview', '$objectives')";
    
    $insertResult = mysqli_query($con, $insertQuery);

    if ($insertResult) {
        // Redirect to the proposals page or any other desired location
        header("Location: idea.php");
        exit;
    } else {
        // Handle the case when insertion fails
        echo "Error committing project idea.";
    }
} else {
    // If the form is not submitted through POST method, redirect to the proposals page
    header("Location: proposal.php");
    exit;
}
?>
