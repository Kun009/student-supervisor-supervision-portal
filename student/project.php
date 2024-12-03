<?php
session_start();
require("config.php");

// Check if the user is logged in
if (!isset($_SESSION['sid'])) {
    header("location:index.php");
    exit;
}


// Fetch the student's details
// Fetch the assigned lecturer details
$lecturerQuery = "SELECT lid, lecturer_name FROM assign WHERE sid = '{$_SESSION['sid']}' ";
$lecturerResult = mysqli_query($con, $lecturerQuery);

if (!$lecturerResult) {
    // Handle the case when the query doesn't return any rows or an error occurred
    exit('Error fetching lecturer details');
}
$lecturerResul = mysqli_query($con, $lecturerQuery);
if (!$lecturerResul) {
    // Handle the case when the query doesn't return any rows or an error occurred
    exit('Error fetching lecturer details');
}

$lecturerResu = mysqli_query($con, $lecturerQuery);
if (!$lecturerResu) {
    // Handle the case when the query doesn't return any rows or an error occurred
    exit('Error fetching lecturer details');
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, sid-scalable=0">
    <title>Student - Project Management</title>
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
    <?php include("header.php"); ?>
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
                            <h3 class="page-title">Project Proposal</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                                <li class="breadcrumb-item active">Project Proposal</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- /Page Header -->
    <div class="container">
        <!-- Display Project Titles -->
        <h3>Accepted Projects</h3>
        <ul>
        <h3>Project Title: <?php
    // Fetch and display the project titles where project_status is 'accepted'
    // Replace 'your_db_connection' with the actual database connection code
    $projectsQuery = "SELECT project_title FROM proposal WHERE proposal_status = 'accepted' AND sid = '{$_SESSION['sid']}'";
    $projectsResult = mysqli_query($con, $projectsQuery);

    if ($projectsResult && mysqli_num_rows($projectsResult) > 0) {
        $projectTitles = array();
        while ($row = mysqli_fetch_assoc($projectsResult)) {
            $projectTitles[] = $row['project_title'];
        }
        echo implode(', ', $projectTitles); // Display project titles separated by commas
    } else {
        echo "No accepted projects yet.";
    }
?>
</h3>
 </ul>

     <!-- Upload Ongoing Report -->
<h3>Upload Ongoing Report</h3>
<form action="upload_ongoing_report.php" method="POST" enctype="multipart/form-data">
    <!-- Add the dropdown box for selecting the assigned lecturer -->
    <div class="mb-3">
        <label for="assignedLecturer">Assigned Lecturer:</label>
        <select class="form-control" id="assignedLecturer" name="assigned_lecturer" required>
        <?php while ($lecturerRow = mysqli_fetch_assoc($lecturerResult)) { ?>
                                        <option value="<?php echo $lecturerRow['lid']; ?>"><?php echo $lecturerRow['lecturer_name']  ?></option>
                                    <?php } ?>
        </select>
    </div>
    <div class="mb-3">
        <label for="ongoingReport">Select Ongoing Report File:</label>
        <input type="file" class="form-control" id="ongoingReport" name="ongoing_report" required>
    </div>
    <button type="submit" class="btn btn-primary">Upload Ongoing Report</button>
</form>

 <!-- Upload Interim Report -->
 <h3>Upload Interim Report</h3>
    <form action="upload_interim_report.php" method="POST" enctype="multipart/form-data">
        <!-- Add the dropdown box for selecting the assigned lecturer -->
        <div class="mb-3">
        <label for="assignedLecturer">Assigned Lecturer:</label>
        <select class="form-control" id="assignedLecturer" name="assigned_lecturer" required>
        <?php while ($lecturerRow = mysqli_fetch_assoc($lecturerResul)) { ?>
                                        <option value="<?php echo $lecturerRow['lid']; ?>"><?php echo $lecturerRow['lecturer_name']  ?></option>
                                    <?php } ?>
        </select>
    </div>
        <div class="mb-3">
            <label for="finalReport">Select Final Report File:</label>
            <input type="file" class="form-control" id="interimReport" name="interim_report" required>
        </div>
        <button type="submit" class="btn btn-primary">Upload Final Report</button>
    </form>

    <!-- Upload Final Report -->
    <h3>Upload Final Report</h3>
    <form action="upload_final_report.php" method="POST" enctype="multipart/form-data">
        <!-- Add the dropdown box for selecting the assigned lecturer -->
        <div class="mb-3">
            <label for="assignedLecturer">Assigned Lecturer:</label>
            <select class="form-control" id="assignedLecturer" name="assigned_lecturer" required>
            <?php while ($lecturerRow = mysqli_fetch_assoc($lecturerResu)) { ?>
                                        <option value="<?php echo $lecturerRow['lid']; ?>"><?php echo $lecturerRow['lecturer_name']  ?></option>
                                    <?php } ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="finalReport">Select Final Report File:</label>
            <input type="file" class="form-control" id="finalReport" name="final_report" required>
        </div>
        <button type="submit" class="btn btn-primary">Upload Final Report</button>
    </form>


        <!-- Message Inbox -->
        <h3>Message Inbox</h3>
        <!-- Display received messages from the lecturer -->
        <div>
            <?php
            // Fetch and display messages received by the student (sid) from the lecturer (lid)
            // Replace 'your_db_connection' with the actual database connection code
            // Fetch the student's details, including the lecturer ID (lid)
$studentQuery = "SELECT sid, lid FROM assign WHERE sid = '{$_SESSION['sid']}'";
$studentResult = mysqli_query($con, $studentQuery);

if ($studentResult && mysqli_num_rows($studentResult) > 0) {
    $studentData = mysqli_fetch_assoc($studentResult);
    // Store the lecturer ID in the session for later use
    $_SESSION['lid'] = $studentData['lid'];
} else {
    // Handle the case when the student's details are not found
    exit('Error fetching student details.');
}

            $inboxQuery = "SELECT * FROM messages WHERE recipient_id = '{$_SESSION['lid']}' AND sender_id = '{$_SESSION['sid']}'";
            $inboxResult = mysqli_query($con, $inboxQuery);

            if ($inboxResult && mysqli_num_rows($inboxResult) > 0) {
                while ($message = mysqli_fetch_assoc($inboxResult)) {
                    echo "<p>{$message['message']}</p>";
                }
            } else {
                echo "<p>No messages in the inbox.</p>";
            }
            ?>
        </div>

        <!-- Compose and Send Message to Lecturer -->
        <h3>Compose Message to Lecturer</h3>
        <form action="send_message_to_lecturer.php" method="POST">
            <div class="mb-3">
                <label for="messageContent">Message:</label>
                <textarea class="form-control" id="messageContent" name="message" rows="4" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Send Message</button>
        </form>

        <!-- Display Previous Sent Reports -->
        <h3>Previous Sent Reports</h3>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Report Title</th>
                        <th>Uploaded Date</th>
                        <th>View Report</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Fetch and display previous reports sent by the student (sid)
                    // Replace 'your_db_connection' with the actual database connection code
                    $previousReportsQuery = "SELECT project_title, start_date, project_id FROM projects WHERE sid = '{$_SESSION['sid']}'";
                    $previousReportsResult = mysqli_query($con, $previousReportsQuery);

                    if ($previousReportsResult && mysqli_num_rows($previousReportsResult) > 0) {
                        while ($report = mysqli_fetch_assoc($previousReportsResult)) {
                            echo "<tr>";
                            echo "<td>{$report['project_title']}</td>";
                            echo "<td>{$report['start_date']}</td>";
                            echo "<td><a href='view_report.php?project_id={$report['project_id']}' class='btn btn-primary'>View Report</a></td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='3'>No previous reports.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
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
