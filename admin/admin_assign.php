<?php
session_start();
require("config.php");

// Check if the admin is logged in
if (!isset($_SESSION['aid'])) {
    header("location:index.php");
    exit;
}

// Fetch the admin's details
$query = "SELECT firstname, lastname FROM admin WHERE aid = '{$_SESSION['aid']}'";
$result = mysqli_query($con, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $firstName = $row['firstname'];
    $lastName = $row['lastname'];
} else {
    // Handle the case when the query doesn't return any rows or an error occurred
    exit('Error fetching admin details');
}

// CRUD Operations
// Assign Lecturer to Student
if (isset($_POST['assign_lecturer'])) {
    $lid = $_POST['lid'];
    $sid = $_POST['sid'];

    // Fetch lecturer and student names
    $lecturerQuery = "SELECT firstname, lastname FROM lecturer WHERE lid = '$lid'";
    $studentQuery = "SELECT firstname, lastname FROM student WHERE sid = '$sid'";

    $lecturerResult = mysqli_query($con, $lecturerQuery);
    $studentResult = mysqli_query($con, $studentQuery);

    if ($lecturerResult && $studentResult) {
        $lecturerRow = mysqli_fetch_assoc($lecturerResult);
        $studentRow = mysqli_fetch_assoc($studentResult);

        $lecturerName = $lecturerRow['firstname'] . ' ' . $lecturerRow['lastname'];
        $studentName = $studentRow['firstname'] . ' ' . $studentRow['lastname'];

        // Insert into the 'assign' table
        $insertQuery = "INSERT INTO assign (lid, sid, lecturer_name, student_name) VALUES ('$lid', '$sid', '$lecturerName', '$studentName')";
        $insertResult = mysqli_query($con, $insertQuery);

        if ($insertResult) {
            // Redirect to the same page after successful assignment
            header("Location: admin_assign.php");
            exit;
        } else {
            // Handle error if insertion fails
            echo "Error assigning lecturer to student.";
        }
    } else {
        // Handle error if fetching lecturer or student details fails
        echo "Error fetching lecturer or student details.";
    }
} else {
    // If the form is not submitted, redirect back to the admins page
    header("Location: assign.php");
    exit;
}

// Fetch all students
$studentsQuery = "SELECT * FROM student";
$studentsResult = mysqli_query($con, $studentsQuery);

// Fetch all lecturers
$lecturersQuery = "SELECT * FROM lecturer";
$lecturersResult = mysqli_query($con, $lecturersQuery);

// Fetch assigned lecturers and students
$assignQuery = "SELECT * FROM assign";
$assignResult = mysqli_query($con, $assignQuery);
?>