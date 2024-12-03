<?php
session_start();
require("config.php");

// Check if the student is logged in
if (!isset($_SESSION['sid'])) {
    exit('Error: Student not logged in');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['message_id'])) {
        $messageId = $_POST['message_id'];

        // Sanitize and validate the input before updating the database
        $messageId = mysqli_real_escape_string($con, $messageId);

        // Update the message status to "is_read = 1" (read)
        $updateQuery = "UPDATE messages SET is_read = 1 WHERE message_id = '$messageId' AND recipient_id = '{$_SESSION['sid']}'";

        $updateResult = mysqli_query($con, $updateQuery);

        if ($updateResult) {
            // Fetch the updated message details to display in the "Read Messages" section
            $fetchQuery = "SELECT sender_name, subject, message FROM messages WHERE message_id = '$messageId' AND recipient_id = '{$_SESSION['sid']}'";
            $fetchResult = mysqli_query($con, $fetchQuery);

            if ($fetchResult && mysqli_num_rows($fetchResult) > 0) {
                $messageRow = mysqli_fetch_assoc($fetchResult);
                $senderName = $messageRow['sender_name'];
                $subject = $messageRow['subject'];
                $messageContent = $messageRow['message'];

                // Prepare the HTML markup for the read message
                $htmlMarkup = '
                    <li class="list-group-item">
                        <h5>' . $senderName . '</h5>
                        <p>' . $subject . '</p>
                        <p>' . $messageContent . '</p>
                        <div>
                            <button class="btn btn-sm btn-secondary mark-unread" data-message-id="' . $messageId . '">Mark as Unread</button>
                            <button class="btn btn-sm btn-danger delete-message" data-message-id="' . $messageId . '">Delete</button>
                        </div>
                    </li>
                ';

                echo $htmlMarkup;
            } else {
                echo 'Error: Unable to fetch updated message details';
            }
        } else {
            echo 'Error: Unable to mark the message as read';
        }
    } else {
        echo 'Error: Missing required parameters';
    }
} else {
    echo 'Error: Invalid request method';
}
?>
