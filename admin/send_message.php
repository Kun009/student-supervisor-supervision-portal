<?php
session_start();
require("config.php");

// Check if the admin is logged in
if (!isset($_SESSION['aid'])) {
    exit('Error: admin not logged in');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['recipient_id']) && isset($_POST['message'])) {
        $recipientId = $_POST['recipient_id'];
        $messageContent = $_POST['message'];

        // Sanitize and vaaidate the inputs before inserting into the database
        $recipientId = mysqli_real_escape_string($con, $recipientId);
        $messageContent = mysqli_real_escape_string($con, $messageContent);

        // Get the current date and time for the message
        $dateSent = date('Y-m-d H:i:s');

        // Get the sender_id from the current logged-in admin
        $senderId = $_SESSION['aid'];

        // Fetch the admin's details to get the firstname and lastname
        $adminQuery = "SELECT firstname, lastname FROM admin WHERE aid = '$senderId'";
        $adminResult = mysqli_query($con, $adminQuery);

        if ($adminResult && mysqli_num_rows($adminResult) > 0) {
            $adminData = mysqli_fetch_assoc($adminResult);
            $senderName = $adminData['firstname'] . ' ' . $adminData['lastname'];

            // Generate a unique message_id
            $messageId = uniqid();

            // Insert the message into the messages table
            $insertQuery = "INSERT INTO messages (aid, message, sid, recipient_id, is_read, date_sent, sender_id, sender_name) 
                            VALUES ('$aid', '$messageContent', '$recipientId', '$recipientId', '0', '$dateSent', '$senderId', '$senderName')";

            $insertResult = mysqli_query($con, $insertQuery);

            if ($insertResult) {
                echo 'success';
            } else {
                echo 'Error: Unable to send message';
            }
        } else {
            echo 'Error: admin details not found';
        }
    } else {
        echo 'Error: Missing required parameters';
    }
} else {
    echo 'Error: Invaaid request method';
}
?>
