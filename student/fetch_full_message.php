<?php
// fetch_full_message.php
session_start();
require("config.php");
// ... (Database connection and other necessary code) ...

if (isset($_POST['message_id'])) {
    $messageId = $_POST['message_id'];

    // Fetch the full message, sender's ID, and sender's name from the database
    // Assuming you have a "messages" table with columns "message_id", "message", "sender_id", and "sender_name"
    $query = "SELECT message, sender_id, sender_name FROM messages WHERE message_id = '$messageId'";
    $result = mysqli_query($con, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        $response = array(
            'message' => $row['message'],
            'senderId' => $row['sender_id'],
            'senderName' => $row['sender_name']
        );

        // Return the response as JSON
        header('Content-Type: application/json');
        echo json_encode($response);
    } else {
        // Handle the case when the query doesn't return any rows or an error occurred
        echo json_encode(array('error' => 'Error fetching the full message.'));
    }
} else {
    // Handle the case when the message_id parameter is not provided in the POST request
    echo json_encode(array('error' => 'Message ID not provided.'));
}
?>
