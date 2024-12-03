<?php
// send_message.php

require("config.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sid = $_SESSION['sid'];
    $supervisorId = $_POST['supervisorId'];
    $message = $_POST['message'];

    // Insert the message into the messages table
    $insertQuery = "INSERT INTO messages (sid, lid, message, recipient_id, sender_id, sender_name)
                    VALUES ($sid, $supervisorId, '$message', $supervisorId, $sid, 'Student')";
    
    $result = mysqli_query($con, $insertQuery);

    if ($result) {
        echo "Message sent successfully!";
    } else {
        echo "Error sending message.";
    }
} else {
    echo "Invalid request.";
}
?>
