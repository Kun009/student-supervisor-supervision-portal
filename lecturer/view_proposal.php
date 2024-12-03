<?php
require("config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['proposal_id'])) {
    // Get the proposal ID from the AJAX request
    $proposalId = $_POST['proposal_id'];

    // Fetch the proposal details from the database based on the proposal ID
    $query = "SELECT * FROM proposal WHERE proposal_id = '$proposalId'";
    $result = mysqli_query($con, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $proposalData = mysqli_fetch_assoc($result);

        // You can echo the JSON encoded proposal data back to the AJAX request
        echo json_encode($proposalData);
        exit;
    }
}
