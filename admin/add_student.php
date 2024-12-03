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
    $sid = mysqli_real_escape_string($con, $_POST['sid']);
    $firstname = mysqli_real_escape_string($con, $_POST['firstname']);
    $lastname = mysqli_real_escape_string($con, $_POST['lastname']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $phoneno = mysqli_real_escape_string($con, $_POST['phoneno']);
    $address = mysqli_real_escape_string($con, $_POST['address']);
    $password = mysqli_real_escape_string($con, $_POST['password']);
    $photo = mysqli_real_escape_string($con, $_POST['photo']);
    $department = mysqli_real_escape_string($con, $_POST['department']);
    $faculty = mysqli_real_escape_string($con, $_POST['faculty']);

    // Check if the student ID already exists
    $checkQuery = "SELECT sid FROM student WHERE sid = '$sid'";
    $checkResult = mysqli_query($con, $checkQuery);

    if (mysqli_num_rows($checkResult) > 0) {
        // Display an error message using JavaScript and Bootstrap modal
        echo '<script>alert("Student ID already exists. Please choose a different Student ID."); window.location.href = "student.php";</script>';
    
             
    } else {
        // Proceed with the insertion if the student ID is unique
        $insertQuery = "INSERT INTO student (sid, firstname, lastname, email, phoneno, address, password, photo, department, faculty) VALUES ('$sid', '$firstname', '$lastname', '$email', '$phoneno', '$address', '$password', '$photo', '$department', '$faculty')";
        $insertResult = mysqli_query($con, $insertQuery);

        if ($insertResult) {
            // Redirect to the student page after successful insertion
            header("Location: student.php");
            exit;
        } else {
            // Handle error if insertion fails
            echo "Error adding student.";
            header("Location: student.php");
            exit;
        }
    }
}
?>
