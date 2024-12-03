<?php
session_start();
require("config.php");

// Check if the user is logged in
if (!isset($_SESSION['lid'])) {
    header("location:index.php");
    exit;
}

// Function to insert a new complaint into the database
function insertComplaint($con, $complaintType, $complaintMessage)
{
    $lid = $_SESSION['lid'];
    $complaintMessage = mysqli_real_escape_string($con, $complaintMessage);
    $query = "INSERT INTO complaints (lid, complaint_type, complaint_message) VALUES ('$lid', '$complaintType', '$complaintMessage')";
    $result = mysqli_query($con, $query);

    return $result;
}

// Check if the form is submitted for lodging a complaint
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['complaint_type']) && isset($_POST['complaint_message'])) {
    $complaintType = $_POST['complaint_type'];
    $complaintMessage = $_POST['complaint_message'];

    if (!empty($complaintType) && !empty($complaintMessage)) {
        $insertResult = insertComplaint($con, $complaintType, $complaintMessage);
        if ($insertResult) {
            // Redirect back to the page with a success message
            header("Location: help.php?success=Complaint lodged successfully");
            exit;
        } else {
            // Redirect back to the page with an error message
            header("Location: help.php?error=Error lodging complaint");
            exit;
        }
    }
}

// Function to get the complaints lodged by the logged-in student
function getStudentComplaints($con, $lid)
{
    $query = "SELECT * FROM complaints WHERE lid = '$lid'";
    $result = mysqli_query($con, $query);
    $complaints = array();

    while ($row = mysqli_fetch_assoc($result)) {
        $complaints[] = $row;
    }

    return $complaints;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, lid-scalable=0">
    <title>Lecturer - Help Center</title>
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
                            <h3 class="page-title">Help Center</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                                <li class="breadcrumb-item active">Help Center</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- /Page Header -->

                <!-- Complaint Form -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Lodge a Complaint</h4>
                            </div>
                            <div class="card-body">
                                <form action="help.php" method="POST">
                                    <div class="mb-3">
                                        <label for="complaint_type" class="form-label">Complaint Type</label>
                                        <input type="text" class="form-control" id="complaint_type" name="complaint_type" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="complaint_message" class="form-label">Complaint Message</label>
                                        <textarea class="form-control" id="complaint_message" name="complaint_message" rows="4" required></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Submit Complaint</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Complaint Form -->

                <!-- Student Complaints -->
                <div class="row mt-4">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Your Complaints</h4>
                            </div>
                            <div class="card-body">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Complaint Type</th>
                                            <th>Complaint Message</th>
                                            <th>Admin Reply</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $lid = $_SESSION['lid'];
                                        $studentComplaints = getStudentComplaints($con, $lid);
                                        foreach ($studentComplaints as $complaint) {
                                            echo '<tr>';
                                            echo '<td>' . $complaint['complaint_type'] . '</td>';
                                            echo '<td>' . $complaint['complaint_message'] . '</td>';
                                            echo '<td>' . $complaint['complaint_reply'] . '</td>';
                                            echo '</tr>';
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Student Complaints -->
            </div>
        </div>
        <!-- /Page Wrapper -->
    </div>

    <!-- jQuery -->
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
