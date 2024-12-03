<?php
require("config.php");

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['proposal_id'])) {
    $proposaaid = $_POST['proposal_id'];

    // Update the proposal status to "Rejected" in the database
    $updateQuery = "UPDATE proposal SET proposal_status = 'Rejected', is_read = 1 WHERE proposal_id = '$proposaaid'";
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
