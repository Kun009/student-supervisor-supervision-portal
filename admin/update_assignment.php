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

// Update Assignment (Edit Assignment)
if (isset($_POST['edit_assignment'])) {
    $edit_lid = $_POST['edit_lid'];
    $edit_sid = $_POST['edit_sid'];

    // Fetch lecturer and student names
    $lecturerQuery = "SELECT firstname, lastname FROM lecturer WHERE lid = '$edit_lid'";
    $studentQuery = "SELECT firstname, lastname FROM student WHERE sid = '$edit_sid'";

    $lecturerResult = mysqli_query($con, $lecturerQuery);
    $studentResult = mysqli_query($con, $studentQuery);

    if ($lecturerResult && $studentResult) {
        $lecturerRow = mysqli_fetch_assoc($lecturerResult);
        $studentRow = mysqli_fetch_assoc($studentResult);

        $lecturerName = $lecturerRow['firstname'] . ' ' . $lecturerRow['lastname'];
        $studentName = $studentRow['firstname'] . ' ' . $studentRow['lastname'];

        // Update the 'assign' table
        $updateQuery = "UPDATE assign SET lid = '$edit_lid', lecturer_name = '$lecturerName' WHERE sid = '$edit_sid'";
        $updateResult = mysqli_query($con, $updateQuery);

        if ($updateResult) {
            // Redirect to the same page after successful update
            header("Location: admin_assign.php");
            exit;
        } else {
            // Handle error if update fails
            echo "Error updating assignment.";
        }
    } else {
        // Handle error if fetching lecturer or student details fails
        echo "Error fetching lecturer or student details.";
    }
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
