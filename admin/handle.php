<?php
session_start();
require("config.php");

// Check if the admin is logged in
if (!isset($_SESSION['aid'])) {
    header("location:index.php");
    exit;
}

// Check if the form is submitted for replying to a complaint
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['complaint_id']) && isset($_POST['complaint_reply'])) {
    $complaintId = $_POST['complaint_id'];
    $replyMessage = $_POST['complaint_reply'];

    if (!empty($complaintId) && !empty($replyMessage)) {
        $replyMessage = mysqli_real_escape_string($con, $replyMessage);
        $query = "UPDATE complaints SET complaint_reply = '$replyMessage' WHERE lid = $complaintId";
        $result = mysqli_query($con, $query);

        if ($result) {
            // Redirect back to the page with a success message
            header("Location: help.php?success=Reply sent successfully");
            exit;
        } else {
            // Redirect back to the page with an error message
            header("Location: help.php?error=Error sending reply");
            exit;
        }
    } else {
        // Redirect back to the page with an error message
        header("Location: help.php?error=Invalid data");
        exit;
    }
}
?>