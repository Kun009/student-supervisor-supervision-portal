<?php
require("config.php");

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['proposal_id'])) {
    $proposalId = $_POST['proposal_id'];

    // Update the proposal status to "Accepted" in the database
    $updateQuery = "UPDATE proposal SET proposal_status = 'Accepted', is_read = 1 WHERE proposal_id = '$proposalId'";
    $result = mysqli_query($con, $updateQuery);

    if ($result) {
        echo "success";
        exit;
    } else {
        echo "error";
        exit;
    }
} else {
    echo "error";
    exit;
}
?>
