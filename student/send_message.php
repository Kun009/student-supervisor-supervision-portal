<?php
session_start();
require("config.php");

// Check if the user is logged in
if (!isset($_SESSION['sid']) && !isset($_SESSION['lid'])) {
    header("location:index.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the lecturer or student is sending the message
    if (isset($_SESSION['lid']) && isset($_POST['recipientId'])) {
        // Lecturer is sending a message to a student
        $senderId = $_SESSION['lid'];
        $recipientId = $_POST['recipientId']; // Assuming student ID is provided as the recipient ID
        $subject = $_POST['subject'];
        $table = "messages"; // Correct the table name to "messages"
        $senderColumnName = "lid"; // Assuming the column name for lecturer ID is "lid"
        $recipientColumnName = "sid"; // Assuming the column name for student ID is "sid"
    } elseif (isset($_SESSION['sid'])) {
        // Student is replying to a message from a lecturer
        $senderId = $_SESSION['sid'];
        $recipientId = $_POST['recipientId']; // Assuming lecturer ID is provided as the recipient ID
        $subject = $_POST['subject'];
        $table = "messages"; // Correct the table name to "messages"
        $senderColumnName = "sid"; // Assuming the column name for student ID is "sid"
        $recipientColumnName = "lid"; // Assuming the column name for lecturer ID is "lid"
    } else {
        // Handle the case when the user is not logged in or invalid request
        exit('Invalid request.');
    }
    $subject = $_POST['subject'];
    
    $messageText = $_POST['message'];

    // Perform any necessary validations on the inputs (e.g., check if the recipient exists, message is not empty, etc.)

    // Save the message in the appropriate table based on the sender and recipient type
    $insertQuery = "INSERT INTO $table ($senderColumnName, $recipientColumnName, message_text, subject) VALUES ('$senderId', '$recipientId', '$messageText', '$subject')";

    $result = mysqli_query($con, $insertQuery);

    if ($result) {
        // Message successfully sent, you can redirect back to the message.php page or show a success message
        header("location:message.php");
        exit;
    } else {
        // Handle the case when there's an error while saving the message
        exit('Error sending message. Please try again.');
    }
} else {
    // Handle the case when the script is accessed without form submission
    header("location:message.php");
    exit;
}
?>
