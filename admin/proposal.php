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
    <title>admin - Proposals</title>
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
                            <h3 class="page-title">Proposals</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                                <li class="breadcrumb-item active">Proposals</li>
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
                        <h3 class="card-title">Proposals</h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Lecturer ID (lid)</th>
                                        <th>Student ID (sid)</th>
                                        <th>Project Title</th>
                                        <th>Proposal Document</th>
                                        <th>Proposal Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    require("config.php");
                                    // Fetch all proposals
                                    $proposalQuery = "SELECT * FROM proposal";
                                    $proposalResult = mysqli_query($con, $proposalQuery);

                                    if ($proposalResult && mysqli_num_rows($proposalResult) > 0) {
                                        while ($proposalRow = mysqli_fetch_assoc($proposalResult)) {
                                            ?>
                                            <tr>
                                                <td><?php echo $proposalRow['lid']; ?></td>
                                                <td><?php echo $proposalRow['sid']; ?></td>
                                                <td><?php echo $proposalRow['project_title']; ?></td>
                                                <td>
                                                    <?php
                                                    // Display the link to view the proposal document
                                                    if (!empty($proposalRow['proposal_docs'])) {
                                                        echo '<a href="' . $proposalRow['proposal_docs'] . '" target="_blank">View Document</a>';
                                                    } else {
                                                        echo 'N/A';
                                                    }
                                                    ?>
                                                </td>
                                                <td><?php echo $proposalRow['proposal_status']; ?></td>
                                            </tr>
                                            <?php
                                        }
                                    } else {
                                        echo '<tr><td colspan="5">No proposals found.</td></tr>';
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


