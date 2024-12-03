<?php
session_start();
require("config.php");

// Check if the user is logged in
if (!isset($_SESSION['sid'])) {
    header("location:index.php");
    exit;
}

// Fetch the student's details
$query = "SELECT sid, firstname, lastname FROM student WHERE sid = '{$_SESSION['sid']}'";
$result = mysqli_query($con, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $sid = $row['sid'];
    $firstName = $row['firstname'];
    $lastName = $row['lastname'];
} else {
    // Handle the case when the query doesn't return any rows or an error occurred
    exit('Error fetching student details');
}

// Check if the proposal form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $projectTitle = $_POST['projectTitle'];
    $proposalDoc = $_FILES['proposalDoc']['name'];
    $proposalStatus = 'Pending';
    $message = $_POST['message'];
    $lid = $_POST['lid'];

    // Validate and process the proposal document upload
    if (!empty($proposalDoc)) {
        // Specify the upload directory
        $uploadDirectory = '../proposal_docs/';

        // Generate a unique filename
        $newFileName = uniqid() . '_' . $proposalDoc;

        // Get the temporary file path
        $tmpFilePath = $_FILES['proposalDoc']['tmp_name'];

        // Set the target file path
        $targetFilePath = $uploadDirectory . $newFileName;

        // Move the uploaded file to the target directory
        if (move_uploaded_file($tmpFilePath, $targetFilePath)) {
            // Insert the proposal details into the database
            $insertQuery = "INSERT INTO proposal (sid, project_title, proposal_docs, proposal_status, message, lid) VALUES ('$sid', '$projectTitle', '$targetFilePath', '$proposalStatus', '$message', '$lid')";

            if (mysqli_query($con, $insertQuery)) {
                // Redirect to the proposal list page or any other page you want
                header("location:proposal.php");
                exit;
            } else {
                // Handle the case when the insertion into the database fails
                echo "Failed to save the proposal details.";
            }
        } else {
            // Handle the case when the file upload fails
            echo "Failed to upload the proposal document.";
        }
    }
}

// Fetch the assigned lecturer details
$lecturerQuery = "SELECT lid, lecturer_name FROM assign WHERE sid = '{$_SESSION['sid']}' ";
$lecturerResult = mysqli_query($con, $lecturerQuery);

if (!$lecturerResult) {
    // Handle the case when the query doesn't return any rows or an error occurred
    exit('Error fetching lecturer details');
}

?>

<!DOCTYPE html>
<!-- The rest of the HTML code remains the same -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, sid-scalable=0">
    <title>Student - Supervisor</title>
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
                            <h3 class="page-title">Project Proposal</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                                <li class="breadcrumb-item active">Project Proposal</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- /Page Header -->

                <!-- Proposal Submission Form -->
                <div class="card">
                    <div class="card-body">
                        <form action="" method="POST" enctype="multipart/form-data">
                            <div class="form-group">
                                <label>Project Title</label>
                                <input type="text" class="form-control" name="projectTitle" required>
                            </div>
                            <div class="form-group">
                                <label>Proposal Document</label>
                                <input type="file" class="form-control" name="proposalDoc" required>
                            </div>
                            <div class="form-group">
                                <label>Assigned Lecturer</label>
                                <select class="form-control" name="lid" required>
                                    <?php while ($lecturerRow = mysqli_fetch_assoc($lecturerResult)) { ?>
                                        <option value="<?php echo $lecturerRow['lid']; ?>"><?php echo $lecturerRow['lecturer_name']  ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Message to Lecturer</label>
                                <textarea class="form-control" name="message" rows="4"></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit Proposal</button>
                        </form>
                    </div>
                </div>
                <!-- /Proposal Submission Form -->
            </div>
        </div>
        <!-- /Page Wrapper -->
    </div>
    <!-- /Main Wrapper -->

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
