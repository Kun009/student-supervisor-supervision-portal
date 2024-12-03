<?php
session_start();
require("config.php");

// Check if the student is logged in
if (!isset($_SESSION['sid'])) {
    header("location:index.php");
    exit;
}

// Fetch the student's details
$query = "SELECT firstname, lastname FROM student WHERE sid = '{$_SESSION['sid']}'";
$result = mysqli_query($con, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $firstName = $row['firstname'];
    $lastName = $row['lastname'];
} else {
    // Handle the case when the query doesn't return any rows or an error occurred
    exit('Error fetching student details');
}

// Fetch assigned lecturer details for the logged-in student
$assignedLecturerQuery = "SELECT * FROM assign WHERE sid = '{$_SESSION['sid']}'";
$assignedLecturerResult = mysqli_query($con, $assignedLecturerQuery);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, sid-scalable=0">
    <title>Student - Project Proposal</title>
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/logo.jpg">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <!-- Fontawesome CSS -->
    <link rel="stylesheet" href="assets/css/font-awesome.min.css">
    <!-- Feathericon CSS -->
    <link rel="stylesheet" href="assets/css/feathericon.min.css">
    <!-- Main CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
    <!--[if lt IE 9]>
        <script src="assets/js/html5shiv.min.js"></script>
        <script src="assets/js/respond.min.js"></script>
    <![endif]-->
</head>
<body>
    <!-- Main Wrapper -->
    <div class="main-wrapper">
        <!-- Header -->
        <?php include("header.php"); ?>
        <!-- /Header -->
        <!-- Page Wrapper -->
        <div class="page-wrapper">
            <div class="content container-fluid">
                <!-- Page Header -->
                <div class="page-header">
                    <div class="row">
                        <div class="col-sm-12">
                            <h3 class="page-title">Supervisor Details</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                                <li class="breadcrumb-item active">Supervisor</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- /Page Header -->
            
            <h2>Welcome, <?php echo $firstName . ' ' . $lastName; ?></h2>

            <!-- Display assigned lecturer details -->
            <?php if ($assignedLecturerResult && mysqli_num_rows($assignedLecturerResult) > 0): ?>
                <h3>Your Assigned Lecturer</h3>
                <table border="1">
                    <thead>
                        <tr>
                            <th>Lecturer ID</th>
                            <th>Lecturer Name</th>
                            <!-- Add more columns if needed -->
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($assignedLecturerRow = mysqli_fetch_assoc($assignedLecturerResult)): ?>
                            <tr>
                                <td><?php echo $assignedLecturerRow['lid']; ?></td>
                                <td><?php echo $assignedLecturerRow['lecturer_name']; ?></td>
                                <!-- Add more cells if needed -->
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No assigned lecturer found.</p>
            <?php endif; ?>

            <!-- Add more content as needed -->

        </div>
    </div>

    <!-- Include necessary JavaScript libraries -->
    <script src="assets/js/jquery-3.2.1.min.js"></script>
    <!-- Bootstrap Core JS -->
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <!-- Slimscroll JS -->
    <script src="assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>
    <script src="assets/plugins/raphael/raphael.min.js"></script>
    <script src="assets/plugins/morris/morris.min.js"></script>
    <script src="assets/js/chart.morris.js"></script>
    <!-- Custom JS -->
    <script src="assets/js/script.js"></script>
</body>
</html>
