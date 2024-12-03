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



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, sid-scalable=0">
    <title>Admin - Project</title>
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
</head>
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
                            <h3 class="page-title">Project</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                                <li class="breadcrumb-item active">Project Reports</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- /Page Header -->

              <!-- Unread Proposals List -->
              <div class="container mt-5">
        <!-- ... (Previous dashboard code) ... -->

        <!-- Proposal Section -->
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Ongoing Reports</h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead>
                                    <tr>
                                        <th>Project Title</th>
                                        <th>Submitted Date </th>
                                        <th>Student ID (sid)</th>
                                        <th>Lecturer ID (lid)</th>
                                        <th>Ongoing Report</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    require("config.php");
                                    // Fetch all projects
                                    $projectQuery = "SELECT * FROM projects";
                                    $projectResult = mysqli_query($con, $projectQuery);

                                    if ($projectResult && mysqli_num_rows($projectResult) > 0) {
                                        while ($projectRow = mysqli_fetch_assoc($projectResult)) {
                                            ?>
                                            <tr>
                                                <td><?php echo $projectRow['project_title']; ?></td>
                                                <td><?php echo $projectRow['start_date']; ?></td>
                                                <td><?php echo $projectRow['sid']; ?></td>
                                                <td><?php echo $projectRow['lid']; ?></td>
                                                <td>
                                                    <?php
                                                    // Display the link to view the ongoing report
                                                    if (!empty($projectRow['ongoing_report'])) {
                                                        echo '<a href="' . $projectRow['ongoing_report'] . '" target="_blank">View Ongoing Report</a>';
                                                    } else {
                                                        echo 'N/A';
                                                    }
                                                    ?>
                                                </td>
                                               
                                            </tr>
                                            <?php
                                        }
                                    } else {
                                        echo '<tr><td colspan="6">No projects found.</td></tr>';
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
    <!-- Final Reports Section -->
<div class="row mt-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Final Reports</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Project Title</th>
                                <th>Submitted Date</th>
                                <th>Student ID (sid)</th>
                                <th>Lecturer ID (lid)</th>
                                <th>Final Report</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            require("config.php");
                            // Fetch projects with non-empty and non-"N/A" final reports
                            $projectQuery = "SELECT * FROM projects WHERE final_report != 'N/A' AND final_report != '' AND final_report IS NOT NULL";
                            $projectResult = mysqli_query($con, $projectQuery);

                            if ($projectResult && mysqli_num_rows($projectResult) > 0) {
                                while ($projectRow = mysqli_fetch_assoc($projectResult)) {
                                    ?>
                                    <tr>
                                        <td><?php echo $projectRow['project_title']; ?></td>
                                        <td><?php echo $projectRow['start_date']; ?></td>
                                        <td><?php echo $projectRow['sid']; ?></td>
                                        <td><?php echo $projectRow['lid']; ?></td>
                                        <td>
                                            <?php
                                            // Display the link to view the final report
                                            echo '<a href="' . $projectRow['final_report'] . '" target="_blank">View Final Report</a>';
                                            ?>
                                        </td>
                                    </tr>
                                    <?php
                                }
                            } else {
                                echo '<tr><td colspan="5">No projects with final reports found.</td></tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>


</body>
</html>


