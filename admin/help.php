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
    <title>Help Center</title>
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
                            <h3 class="page-title">Help Center</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                                <li class="breadcrumb-item active">Help Center</li>
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
                <h3 class="card-title">Student Complains</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Student ID</th>
                                <th>Complaint Type</th>
                                <th>Complaint Message</th>
                                <th>Reply</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            require("config.php");
                            // Fetch all projects
                            $projectQuery = "SELECT * FROM complaints WHERE sid != 'N/A' AND sid != '' AND sid != 0 AND sid IS NOT NULL";
                            $projectResult = mysqli_query($con, $projectQuery);

                            if ($projectResult && mysqli_num_rows($projectResult) > 0) {
                                while ($projectRow = mysqli_fetch_assoc($projectResult)) {
                                    ?>
                                    <tr>
                                        <td><?php echo $projectRow['sid']; ?></td>
                                        <td><?php echo $projectRow['complaint_type']; ?></td>
                                        <td><?php echo $projectRow['complaint_message']; ?></td>
                                        <td>
                                            <?php if (empty($projectRow['complaint_reply'])) { ?>
                                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#replyModal<?php echo $projectRow['sid']; ?>">Reply</button>
                                                <!-- Reply Modal for each complaint -->
                                                <div class="modal fade" id="replyModal<?php echo $projectRow['sid']; ?>" tabindex="-1" aria-labelledby="replyModalLabel<?php echo $projectRow['sid']; ?>" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="replyModalLabel<?php echo $projectRow['sid']; ?>">Reply to Complaint</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form action="handle_reply.php" method="POST">
                                                                    <input type="hidden" name="complaint_id" value="<?php echo $projectRow['sid']; ?>">
                                                                    <div class="mb-3">
                                                                        <label for="complaint_reply" class="form-label">Reply Message</label>
                                                                        <textarea class="form-control" id="complaint_reply" name="complaint_reply" rows="4" required></textarea>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                        <button type="submit" class="btn btn-primary">Send Reply</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php } else {
                                                echo "Already Replied";
                                            } ?>
                                        </td>
                                    </tr>
                                    <?php
                                }
                            } else {
                                echo '<tr><td colspan="4">No complain found.</td></tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
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
                            <th>Lecturer ID</th>
                                        <th>Complaint Type </th>
                                        <th>Complaint Message</th>
                                        <th>Reply</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            require("config.php");
                            // Fetch projects with non-empty and non-"N/A" final reports
                            $projectQuery = "SELECT * FROM complaints WHERE lid != 'N/A' AND lid != '' AND lid != 0 AND lid IS NOT NULL" ;
                            $projectResult = mysqli_query($con, $projectQuery);

                            if ($projectResult && mysqli_num_rows($projectResult) > 0) {
                                while ($projectRow = mysqli_fetch_assoc($projectResult)) {
                                    ?>
                                    <tr>
                                        <td><?php echo $projectRow['lid']; ?></td>
                                        <td><?php echo $projectRow['complaint_type']; ?></td>
                                        <td><?php echo $projectRow['complaint_message']; ?></td>
                                        <td><?php echo $projectRow['complaint_reply']; ?></td>
                                        <td>
                                            <?php if (empty($projectRow['complaint_reply'])) { ?>
                                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#replyModal<?php echo $projectRow['lid']; ?>">Reply</button>
                                                <!-- Reply Modal for each complaint -->
                                                <div class="modal fade" id="replyModal<?php echo $projectRow['lid']; ?>" tabindex="-1" aria-labelledby="replyModalLabel<?php echo $projectRow['lid']; ?>" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="replyModalLabel<?php echo $projectRow['lid']; ?>">Reply to Complaint</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form action="handle.php" method="POST">
                                                                    <input type="hidden" name="complaint_id" value="<?php echo $projectRow['lid']; ?>">
                                                                    <div class="mb-3">
                                                                        <label for="complaint_reply" class="form-label">Reply Message</label>
                                                                        <textarea class="form-control" id="complaint_reply" name="complaint_reply" rows="4" required></textarea>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                        <button type="submit" class="btn btn-primary">Send Reply</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php } else {
                                                echo "Already Replied";
                                            } ?>
                                        </td>
                                        <td>
                                        
                                    </tr>
                                    <?php
                                }
                            } else {
                                echo '<tr><td colspan="5">No complain found.</td></tr>';
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


