<?php
require("config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['proposal_id'])) {
    // Get the proposal ID from the AJAX request
    $proposalId = $_POST['proposal_id'];

    // Delete the proposal from the database
    $deleteQuery = "DELETE FROM proposal WHERE proposal_id = '$proposalId'";
    $result = mysqli_query($con, $deleteQuery);

    // You can send a response back to the AJAX request
    // For example, echo "success" if the deletion was successful
    if ($result) {
        echo "success";
        exit;
    } else {
        echo "error";
        exit;
    }
}
