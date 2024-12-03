
Copy code
<?php
session_start();
require("config.php");

// Check if the user is logged in
if (!isset($_SESSION['sid'])) {
    header("location:index.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, sid-scalable=0">
    <title>Student - Library</title>
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
                            <h3 class="page-title">Project Ideas</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                                <li class="breadcrumb-item active">Project Ideas</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- /Page Header -->
<!-- Page Content -->
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Project Titles</h4>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Project Title</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Fetch project titles from the database
                            $query = "SELECT id, project_title FROM project_ideas";
                            $result = mysqli_query($con, $query);
                            $count = 1;

                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<tr>";
                                echo "<td>{$count}</td>";
                                echo "<td class='project-title' data-id='{$row['id']}'>{$row['project_title']}</td>";
                                echo "<td><button class='btn btn-info view-details-btn'>View Details</button></td>";
                                echo "</tr>";
                                $count++;
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
        <!-- /Page Wrapper -->
    </div>
    <!-- /Main Wrapper -->
<!-- Modal for Project Details -->
<div class="modal fade" id="projectDetailsModal" tabindex="-1" role="dialog" aria-labelledby="projectDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="projectDetailsModalLabel">Project Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Display project details here -->
                <div id="projectDetailsContent"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
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
    <script>
    $(document).ready(function () {
        // Handle click event on view details button
        $('.view-details-btn').click(function () {
            var projectId = $(this).closest('tr').find('.project-title').data('id');

            // Make an AJAX request to fetch project details
            $.ajax({
                url: 'fetch_project_details.php', // Replace with your actual file to fetch details
                method: 'POST',
                data: { projectId: projectId },
                success: function (data) {
                    // Display project details in the modal
                    $('#projectDetailsContent').html(data);
                    $('#projectDetailsModal').modal('show');
                },
                error: function () {
                    alert('Error fetching project details.');
                }
            });
        });
    });


    $(document).ready(function () {
    // ... (your existing code)

    // Handle click event on "Message Supervisor" button
    $(document).on('click', '.message-supervisor-btn', function () {
        var supervisorId = $(this).data('lid');
        var supervisorName = $(this).data('name');

        // Set supervisor information in the message modal
        $('#recipientName').val(supervisorName);
        $('#supervisorId').val(supervisorId);

        // Show the message modal
        $('#messageSupervisorModal').modal('show');
    });

    // Handle form submission for composing and sending a message
    $('#composeMessageForm').submit(function (e) {
        e.preventDefault();

        // Get form data
        var supervisorId = $('#supervisorId').val();
        var message = $('#message').val();

        // Make an AJAX request to send the message
        $.ajax({
            url: 'send_messages.php', // Replace with your actual file to send messages
            method: 'POST',
            data: {
                supervisorId: supervisorId,
                message: message
            },
            success: function (response) {
                // Handle success (you might want to show a success message)
                alert('Message sent successfully!');
                // Close the message modal
                $('#messageSupervisorModal').modal('hide');
            },
            error: function () {
                // Handle error (you might want to show an error message)
                alert('Error sending message.');
            }
        });
    });
});

</script>

</body>
</html>
