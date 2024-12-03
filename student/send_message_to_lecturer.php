<?php
session_start();
require("config.php");

// Check if the user is logged in
if (!isset($_SESSION['sid'])) {
    header("location:index.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['message'])) {
    $sid = $_SESSION['sid'];
    $lid = $_SESSION['lid'];
    $messageContent = mysqli_real_escape_string($con, $_POST['message']);
    //
   
    // Insert the new message into the database
    $insertQuery = "INSERT INTO messages (sender_id, recipient_id, message) VALUES ('$sid', '$lid', '$messageContent')";
    $insertResult = mysqli_query($con, $insertQuery);

    if ($insertResult) {
        // Message sent successfully, redirect back to the project page
        header("Location: project.php");
        exit;
    } else {
        // Handle the case when the message insertion fails
        exit('Error sending the message. Please try again.');
    }
} else {
    // Handle the case when the script is accessed without form submission or missing message
    header("location: project.php");
    exit;
}
?>
