<?php
session_start();
require("config.php");

// Check if the user is logged in
if (!isset($_SESSION['aid'])) {
    header("location:index.php");
    exit;
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES['report']) && $_FILES['report']['error'] === 0 && isset($_POST['project_title'])) {
    // Get the uploaded file details
    $file = $_FILES['report'];
    $fileName = $file['name'];
    $fileTmpName = $file['tmp_name'];

    // Move the uploaded file to a directory on the server
    $uploadsDirectory = "../final_reports"; // Set your desired upload directory
    $targetFile = $uploadsDirectory . $fileName;
    if (!move_uploaded_file($fileTmpName, $targetFile)) {
        // Redirect back to the library page with an error message
        header("Location: library.php?error=Error uploading project report");
        exit;
    }

    // Get the project title from the form
    $projectTitle = mysqli_real_escape_string($con, $_POST['project_title']);

    // Prepare and execute the SQL query to add the report to the projects table
    $addQuery = "INSERT INTO projects (project_title, final_report) VALUES ('$projectTitle', '$targetFile')";
    $addResult = mysqli_query($con, $addQuery);

    if ($addResult) {
        // Redirect back to the library page with a success message
        header("Location: library.php?success=Project report added successfully");
        exit;
    } else {
        // Redirect back to the library page with an error message
        header("Location: library.php?error=Error adding project report");
        exit;
    }
} else {
    // If the form is not submitted or there was an issue with file upload or project title, redirect back to the library page
    header("Location: library.php");
    exit;
}
?>
