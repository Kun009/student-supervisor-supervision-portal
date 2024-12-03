<?php
session_start();
require("config.php");

// Check if the lecturer is logged in
if (!isset($_SESSION['lid'])) {
    exit('Error: Lecturer not logged in');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['recipient_id']) && isset($_POST['message'])) {
        $recipientId = $_POST['recipient_id'];
        $messageContent = $_POST['message'];

        // Sanitize and validate the inputs before inserting into the database
        $recipientId = mysqli_real_escape_string($con, $recipientId);
        $messageContent = mysqli_real_escape_string($con, $messageContent);

        // Get the current date and time for the message
        $dateSent = date('Y-m-d H:i:s');

        // Get the sender_id from the current logged-in lecturer
        $senderId = $_SESSION['lid'];

        // Fetch the lecturer's details to get the firstname and lastname
        $lecturerQuery = "SELECT firstname, lastname FROM lecturer WHERE lid = '$senderId'";
        $lecturerResult = mysqli_query($con, $lecturerQuery);

        if ($lecturerResult && mysqli_num_rows($lecturerResult) > 0) {
            $lecturerData = mysqli_fetch_assoc($lecturerResult);
            $senderName = $lecturerData['firstname'] . ' ' . $lecturerData['lastname'];

            // Generate a unique message_id
            $messageId = uniqid();

            // Insert the message into the messages table
            $insertQuery = "INSERT INTO messages (lid, message, sid, recipient_id, is_read, date_sent, sender_id, sender_name) 
                            VALUES ('$lid', '$messageContent', '$recipientId', '$recipientId', '0', '$dateSent', '$senderId', '$senderName')";

            $insertResult = mysqli_query($con, $insertQuery);

            if ($insertResult) {
                echo 'success';
            } else {
                echo 'Error: Unable to send message';
            }
        } else {
            echo 'Error: Lecturer details not found';
        }
    } else {
        echo 'Error: Missing required parameters';
    }
} else {
    echo 'Error: Invalid request method';
}
?>
