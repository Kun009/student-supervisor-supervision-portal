<?php
session_start();
require("config.php");

// Check if the user is logged in
if (!isset($_SESSION['sid'])) {
    header("location:index.php");
    exit;
}

// Check if the project_id is provided in the URL
if (isset($_GET['project_id'])) {
    $reportId = $_GET['project_id'];

    // Fetch the report details from the database using the provided project_id
    $reportQuery = "SELECT * FROM projects WHERE project_id = '$reportId'";
    $reportResult = mysqli_query($con, $reportQuery);

    if ($reportResult && mysqli_num_rows($reportResult) > 0) {
        $report = mysqli_fetch_assoc($reportResult);
        // Here, you can display the report details or provide a download link for the report file
        // For example:
        // Display the report title
        echo "<h3>{$report['project_title']}</h3>";
        // Display the report date
        echo "<p>Uploaded Date: {$report['start_date']}</p>";
        // Provide a download link for the report file
        echo "<a href='{$report['ongoing_report']}' download>Download Report</a>";
    } else {
        // Handle the case when the report is not found
        echo "Report not found.";
    }
} else {
    // Handle the case when the project_id is not provided in the URL
    echo "Report ID not provided.";
}
?>
