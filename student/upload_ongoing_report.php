<?php
session_start();
require("config.php");

// Check if the user is logged in
if (!isset($_SESSION['sid'])) {
    header("location:index.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES['ongoing_report'])) {
    $sid = $_SESSION['sid'];
    $uploadDir = "../ongoing_reports/"; // Directory to store ongoing reports
    $fileName = $_FILES['ongoing_report']['name'];
    $tempName = $_FILES['ongoing_report']['tmp_name'];

    // You may want to add more checks and validations on the uploaded file, such as file type, size, etc.

    // Retrieve the selected lecturer's lid from the form submission
    $lid = $_POST['assigned_lecturer'];

    // Fetch the project_title from the proposal table
    $fetchProjectTitleQuery = "SELECT project_title FROM proposal WHERE sid = '$sid' AND proposal_status = 'accepted'";
    $fetchProjectTitleResult = mysqli_query($con, $fetchProjectTitleQuery);

    if (!$fetchProjectTitleResult || mysqli_num_rows($fetchProjectTitleResult) === 0) {
        exit('Error fetching project title from the proposal. Please try again.');
    }

    $projectTitleRow = mysqli_fetch_assoc($fetchProjectTitleResult);
    $projectTitle = $projectTitleRow['project_title'];

    // Get the current date as the start_date
    $startDate = date("Y-m-d");

    // Move the uploaded file to the destination directory
    if (move_uploaded_file($tempName, $uploadDir . $fileName)) {
        // File uploaded successfully, save the file path, project_title, and start_date in the database
        $insertQuery = "INSERT INTO projects (sid, lid, project_title, start_date, ongoing_report, project_status) VALUES ('$sid','$lid', '$projectTitle', '$startDate', '$uploadDir$fileName', 'unread')";
        $result = mysqli_query($con, $insertQuery);
        if ($result) {
            // Ongoing report uploaded successfully
            header("Location: project.php");
            exit;
        } else {
            // Error inserting the data in the database
            exit('Error uploading ongoing report. Please try again.');
        }
    } else {
        // Error moving the uploaded file to the destination directory
        exit('Error uploading ongoing report. Please try again.');
    }
} else {
    // Handle the case when the script is accessed without form submission or missing file
    header("location: project.php");
    exit;
}
?>