<?php
session_start();
require("config.php");

// Check if the student is logged in
if (!isset($_SESSION['lid'])) {
    exit('Error: Student not logged in');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['message_id'])) {
        $messageId = $_POST['message_id'];

        // Sanitize and validate the input
        $messageId = mysqli_real_escape_string($con, $messageId);

        // Check if the message belongs to the logged-in student
        $checkQuery = "SELECT * FROM messages WHERE message_id = '$messageId' AND recipient_id = '{$_SESSION['lid']}'";
        $checkResult = mysqli_query($con, $checkQuery);

        if ($checkResult && mysqli_num_rows($checkResult) > 0) {
            // Perform the actual delete operation
            $deleteQuery = "DELETE FROM messages WHERE message_id = '$messageId'";
            $deleteResult = mysqli_query($con, $deleteQuery);

            if ($deleteResult) {
                // Send a success response
                echo 'success';
            } else {
                echo 'Error: Unable to delete the message';
            }
        } else {
            echo 'Error: Message not found or does not belong to the student';
        }
    } else {
        echo 'Error: Missing required parameters';
    }
} else {
    echo 'Error: Invalid request method';
}
?>
