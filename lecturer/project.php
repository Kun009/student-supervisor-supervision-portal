<?php
session_start();
require("config.php");

// Check if the lecturer is logged in
if (!isset($_SESSION['lid'])) {
    header("location:index.php");
    exit;
}

// Fetch the lecturer's details
$query = "SELECT firstname, lastname FROM lecturer WHERE lid = '{$_SESSION['lid']}'";
$result = mysqli_query($con, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $firstName = $row['firstname'];
    $lastName = $row['lastname'];
} else {
    // Handle the case when the query doesn't return any rows or an error occurred
    exit('Error fetching lecturer details');
}
function getStudentName($con, $sid) {
    $query = "SELECT firstname, lastname FROM student WHERE sid = '$sid'";
    $result = mysqli_query($con, $query);
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        return $row['firstname'] . ' ' . $row['lastname'];
    }
    return 'N/A';
}
// Fetch all projects assigned to the lecturer with project_status = 'unread'
$projectQuery = "SELECT * FROM projects WHERE lid = '{$_SESSION['lid']}' AND project_status = 'unread'";
$projectResult = mysqli_query($con, $projectQuery);

if (!$projectResult) {
    // Handle the case when the query doesn't return any rows or an error occurred
    exit('Error fetching projects');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, sid-scalable=0">
    <title>Lecturer - Projects</title>
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
                            <h3 class="page-title">Projects</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                                <li class="breadcrumb-item active">Projects</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- /Page Header -->

                <!-- Unread Projects -->
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Unread Projects</h4>
                        <?php if (mysqli_num_rows($projectResult) > 0) { ?>
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Student Name</th>
                                            <th>Project Title</th>
                                            <th>Status</th>
                                            <th>Start Date</th>
                                            
                                            <th>Ongoing Report</th>
                                            <th>Interim Report</th>
                                            <th>Final Report</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while ($projectRow = mysqli_fetch_assoc($projectResult)) { ?>
                                            <tr>
                                                <td>
                                                    <?php
                                                    $studentId = $projectRow['sid'];
                                                    $studentQuery = "SELECT firstname, lastname FROM student WHERE sid = '$studentId'";
                                                    $studentResult = mysqli_query($con, $studentQuery);
                                                    if ($studentResult && mysqli_num_rows($studentResult) > 0) {
                                                        $studentData = mysqli_fetch_assoc($studentResult);
                                                        echo $studentData['firstname'] . ' ' . $studentData['lastname'];
                                                    } else {
                                                        echo 'Unknown Student';
                                                    }
                                                    ?>
                                                </td>
                                                <td><?php echo $projectRow['project_title']; ?></td>
                                                <td><?php echo $projectRow['project_status']; ?></td>
                                                <td><?php echo $projectRow['start_date']; ?></td>
                                                
                                                <td>
    <?php
    // Display the link to the ongoing report if available
    if (!empty($projectRow['ongoing_report'])) {
        echo '<a href="' . $projectRow['ongoing_report'] . '" target="_blank" style="color: blue;">View Ongoing Report</a>';
    } else {
        echo 'N/A';
    }
    ?>
</td>
<td>
    <?php
    // Display the link to the interim report if available
    if (!empty($projectRow['interim_report'])) {
        echo '<a href="' . $projectRow['interim_report'] . '" target="_blank" style="color: blue;">View Interim Report</a>';
    } else {
        echo 'N/A';
    }
    ?>
</td>
<td>
    <?php
    // Display the link to the final report if available
    if (!empty($projectRow['final_report'])) {
        echo '<a href="' . $projectRow['final_report'] . '" target="_blank" style="color: blue;">View Final Report</a>';
    } else {
        echo 'N/A';
    }
    ?>
</td>

                                                <td>
                                                    <!-- Message Icon (Open Modal) -->
                                                    <button type="button" class="btn btn-info btn-sm message-student" data-student-id="<?php echo $projectRow['sid']; ?>" data-student-name="<?php echo getStudentName($con, $projectRow['sid']); ?>">Message</button>
    </a>
                                                    <!-- Mark as Read Button -->
                                                    <form action="mark_as_read.php" method="POST">
                                        <input type="hidden" name="project_id" value="<?php echo $projectRow['project_id']; ?>">
                                        <button type="submit" class="btn btn-primary">Mark as Read</button>
                                    </form>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php } else { ?>
                            <p>No unread projects.</p>
                        <?php } ?>
                    </div>
                </div>
                <!-- /Unread Projects -->

                <!-- Read Projects -->
<div class="card">
    <div class="card-body">
        <h4 class="card-title">Read Projects</h4>
        <?php
        // Fetch the projects with project_status = 'read' for the lecturer
        $readProjectsQuery = "SELECT * FROM projects WHERE lid = '{$_SESSION['lid']}' AND project_status = 'read'";
        $readProjectsResult = mysqli_query($con, $readProjectsQuery);

        if (!$readProjectsResult) {
            // Handle the case when the query doesn't return any rows or an error occurred
            exit('Error fetching read projects');
        }

        if (mysqli_num_rows($readProjectsResult) > 0) {
            ?>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Student Name</th>
                            <th>Project Title</th>
                            <th>Status</th>
                            <th>Start Date</th>
                           
                            <th>Ongoing Report</th>
                            <th>Interim Report</th>
                            <th>Final Report</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($readProjectRow = mysqli_fetch_assoc($readProjectsResult)) {
                            ?>
                            <tr>
                                <td>
                                    <?php
                                    $studentId = $readProjectRow['sid'];
                                    $studentQuery = "SELECT firstname, lastname FROM student WHERE sid = '$studentId'";
                                    $studentResult = mysqli_query($con, $studentQuery);
                                    if ($studentResult && mysqli_num_rows($studentResult) > 0) {
                                        $studentData = mysqli_fetch_assoc($studentResult);
                                        echo $studentData['firstname'] . ' ' . $studentData['lastname'];
                                    } else {
                                        echo 'Unknown Student';
                                    }
                                    ?>
                                </td>
                                <td><?php echo $readProjectRow['project_title']; ?></td>
                                <td><?php echo $readProjectRow['project_status']; ?></td>
                                <td><?php echo $readProjectRow['start_date']; ?></td>
                              
                                <td>
                                    <?php
                                    // Display the link to the ongoing report if available
                                    if (!empty($readProjectRow['ongoing_report'])) {
                                        echo '<a href="' . $readProjectRow['ongoing_report'] . '" target="_blank">View Ongoing Report</a>';
                                    } else {
                                        echo 'N/A';
                                    }
                                    ?>
                                </td>
                                
                                <td>
                                    <?php
                                    // Display the link to the ongoing report if available
                                    if (!empty($readProjectRow['interim_report'])) {
                                        echo '<a href="' . $readProjectRow['interim_report'] . '" target="_blank">View Interim Report</a>';
                                    } else {
                                        echo 'N/A';
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    // Display the link to the final report if available
                                    if (!empty($readProjectRow['final_report'])) {
                                        echo '<a href="' . $readProjectRow['final_report'] . '" target="_blank">View Final Report</a>';
                                    } else {
                                        echo 'N/A';
                                    }
                                    ?>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        <?php } else { ?>
            <p>No read projects.</p>
        <?php } ?>
    </div>
</div>
<!-- /Read Projects -->


                
                <!-- /Message Modal -->
            </div>
        </div>
        <!-- /Page Wrapper -->
    </div>
    <!-- View Ongoing Report Modal -->
    <!-- ... (same as in the previous code) ... -->
    <!-- /View Ongoing Report Modal -->
<!-- Message Modal -->
<div class="modal fade" id="messageModal" tabindex="-1" role="dialog" aria-labelledby="messageModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="messageModalLabel">Send Message</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="messageRecipientId" value="">
                <div class="form-group">
                    <label for="messageRecipientName">Recipient Name:</label>
                    <input type="text" class="form-control" id="messageRecipientName" value="" readonly>
                </div>
                <div class="form-group">
                    <label for="messageRecipientSid">Student ID (SID):</label>
                    <input type="text" class="form-control" id="messageRecipientSid" value="" readonly>
                </div>
                <div class="form-group">
                    <label for="messageContent">Message:</label>
                    <textarea class="form-control" id="messageContent" rows="4" placeholder="Type your message here..."></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="sendMessageBtn">Send Message</button>
            </div>
        </div>
    </div>
</div>
    <!-- jQuery -->
<script src="assets/js/jquery-3.2.1.min.js"></script>
<!-- Bootstrap Core JS -->
<script src="assets/js/popper.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<!-- Custom JS -->
<!-- ... (previous code) ... -->

<!-- jQuery -->
<script src="assets/js/jquery-3.6.0.min.js"></script>
<!-- Bootstrap Core JS -->
<script src="assets/js/bootstrap.min.js"></script>
<!-- Custom JS -->
<script>
    $(document).ready(function() {
        // ... Existing AJAX functions ...

        // Message Student
        $('.message-student').click(function() {
            var studentId = $(this).data('student-id');
            var studentName = $(this).data('student-name');

            // Set recipient's information in the message modal
            $('#messageRecipientId').val(studentId);
            $('#messageRecipientName').val(studentName);
            $('#messageRecipientSid').val(studentId); // You can display SID here as well if you want

            // Show the message modal
            $('#messageModal').modal('show');
        });

        // Send Message Button Click
        $('#sendMessageBtn').click(function() {
            var recipientId = $('#messageRecipientId').val();
            var messageContent = $('#messageContent').val();

            // Perform AJAX request to insert the message into the database
            $.ajax({
                url: 'send_message.php',
                method: 'POST',
                data: { recipient_id: recipientId, message: messageContent },
                success: function(response) {
                    // Handle the response
                    if (response === 'success') {
                        // Close the message modal
                        $('#messageModal').modal('hide');

                        // Optionally, display a success message or update the UI
                        // For example, show an alert:
                        alert('Message sent successfully!');
                    } else {
                        alert('Message sent successfully!');
                        window.location.reload();
                    }
                },
                error: function() {
                    alert('Error sending message.');
                }
            });
        });
    });
</script>
</body>
</html>

</body>
</html>


</body>
</html>
