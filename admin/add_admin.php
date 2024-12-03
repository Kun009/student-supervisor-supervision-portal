<?php
require("config.php");

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $aid = mysqli_real_escape_string($con, $_POST['aid']);
    $firstname = mysqli_real_escape_string($con, $_POST['firstname']);
    $lastname = mysqli_real_escape_string($con, $_POST['lastname']);
    $password = mysqli_real_escape_string($con, $_POST['password']);
    $email = mysqli_real_escape_string($con, $_POST['email']);

    // Check if the admin ID already exists
    $checkQuery = "SELECT aid FROM admin WHERE aid = '$aid'";
    $checkResult = mysqli_query($con, $checkQuery);

    if ($checkResult && mysqli_num_rows($checkResult) > 0) {
        // Admin ID already exists, display alert and do not insert
        echo '<script>alert("Admin ID already exists. Please choose a different Admin ID."); window.location.href = "admin.php";</script>';
    } else {
        // Admin ID does not exist, proceed with insertion
        $insertQuery = "INSERT INTO admin (aid, firstname, lastname, password, email) VALUES ('$aid', '$firstname', '$lastname', '$password', '$email')";
        $insertResult = mysqli_query($con, $insertQuery);

        if ($insertResult) {
            // Insertion successful, redirect to the admin page
            header("Location: admin.php");
            exit;
        } else {
            // Handle error if insertion fails
            echo "Error adding admin.";
        }
    }
} else {
    // Redirect if the form is not submitted
    header("Location: admin.php");
    exit;
}
?>
