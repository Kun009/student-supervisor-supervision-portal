<?php
session_start();
require("config.php");

// Check if the admin is logged in
if (!isset($_SESSION['aid'])) {
    header("location:index.php");
    exit;
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $lid = mysqli_real_escape_string($con, $_POST['lid']);
    $firstname = mysqli_real_escape_string($con, $_POST['firstname']);
    $lastname = mysqli_real_escape_string($con, $_POST['lastname']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $phoneno = mysqli_real_escape_string($con, $_POST['phoneno']);
    $faculty = mysqli_real_escape_string($con, $_POST['faculty']);
    $department = mysqli_real_escape_string($con, $_POST['department']);
    $password = mysqli_real_escape_string($con, $_POST['password']);

    // Check if the lecturer ID already exists
    $checkQuery = "SELECT lid FROM lecturer WHERE lid = '$lid'";
    $checkResult = mysqli_query($con, $checkQuery);

    if (mysqli_num_rows($checkResult) > 0) {
        // Display an error message using JavaScript and Bootstrap modal
        echo '<script>alert("Lecturer ID already exists. Please choose a different Lecturer ID."); window.location.href = "student.php";</script>';
    
    } else {
        // Proceed with the insertion if the lecturer ID is unique
        $insertQuery = "INSERT INTO lecturer (lid, firstname, lastname, email, phoneno, faculty, department, password) 
                        VALUES ('$lid', '$firstname', '$lastname', '$email', '$phoneno', '$faculty', '$department', '$password')";
        $insertResult = mysqli_query($con, $insertQuery);

        if ($insertResult) {
            // Redirect to the lecturer page after successful insertion
            header("Location: lecturer.php?success=Lecturer added successfully");
            exit;
        } else {
            // Redirect to the lecturer page with an error message
            header("Location: lecturer.php?error=Error adding lecturer");
            exit;
        }
    }
} else {
    // If the form is not submitted, redirect back to the lecturer page
    header("Location: lecturer.php");
    exit;
}
?>
