<?php
require("config.php");

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['proposal_id'])) {
    $proposalId = $_POST['proposal_id'];

    // Fetch the proposal document path from the database
    $query = "SELECT proposal_docs FROM proposal WHERE proposal_id = '$proposalId'";
    $result = mysqli_query($con, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $proposalDocs = $row['proposal_docs'];

        // Send the proposal document path as JSON response with updated path
        echo json_encode(['proposal_docs' =>  $proposalDocs]);
        exit;
    } else {
        // Add a debug message for database errors
        echo json_encode(['error' => 'Database query failed']);
        exit;
    }
} else {
    // Add a debug message for invalid request
    echo json_encode(['error' => 'Invalid request']);
    exit;
}
?>
