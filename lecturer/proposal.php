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

// Function to get student's first and last name by sid
function getStudentName($con, $sid) {
    $query = "SELECT firstname, lastname FROM student WHERE sid = '$sid'";
    $result = mysqli_query($con, $query);
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        return $row['firstname'] . ' ' . $row['lastname'];
    }
    return 'N/A';
}

$unreadProposalsQuery = "SELECT * FROM proposal WHERE lid = '{$_SESSION['lid']}' AND is_read = 0";
$unreadProposalsResult = mysqli_query($con, $unreadProposalsQuery);

if (!$unreadProposalsResult) {
    // Handle the case when the query doesn't return any rows or an error occurred
    exit('Error fetching unread proposals');
}

// Fetch all read proposals assigned to the lecturer
$readProposalsQuery = "SELECT * FROM proposal WHERE lid = '{$_SESSION['lid']}' AND is_read = 1";
$readProposalsResult = mysqli_query($con, $readProposalsQuery);

if (!$readProposalsResult) {
    // Handle the case when the query doesn't return any rows or an error occurred
    exit('Error fetching read proposals');
}








?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, sid-scalable=0">
    <title>Lecturer - Proposals</title>
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
                            <h3 class="page-title">Proposals</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                                <li class="breadcrumb-item active">Proposals</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- /Page Header -->
<!-- Button to trigger new project idea modal -->
<button type="button" class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#newProjectIdeaModal" >
    Create New Project Idea
</button>
 
<br><br>
              <!-- Unread Proposals List -->
<div class="card">
    <div class="card-body">
        <h4 class="card-title">Unread Proposals</h4>
        <?php if (mysqli_num_rows($unreadProposalsResult) > 0) { ?>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Student Name</th>
                            <th>Project Title</th>
                            <th>Message</th>
                            <th>Proposal Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($proposalRow = mysqli_fetch_assoc($unreadProposalsResult)) { ?>
                            <tr>
                                <td><?php echo getStudentName($con, $proposalRow['sid']); ?></td>
                                <td><?php echo $proposalRow['project_title']; ?></td>
                                <td><?php echo $proposalRow['message']; ?></td>
                                <td><?php echo $proposalRow['proposal_status']; ?></td>
                                <td>
                                    <a href="#" class="btn btn-primary btn-sm download-proposal" data-proposal-id="<?php echo $proposalRow['proposal_id']; ?>">Download</a>
                                    <button type="button" class="btn btn-success btn-sm accept-proposal" data-proposal-id="<?php echo $proposalRow['proposal_id']; ?>">Accept</button>
                                    <button type="button" class="btn btn-danger btn-sm reject-proposal" data-proposal-id="<?php echo $proposalRow['proposal_id']; ?>">Reject</button>
                                    <button type="button" class="btn btn-info btn-sm message-student" data-student-id="<?php echo $proposalRow['sid']; ?>" data-student-name="<?php echo getStudentName($con, $proposalRow['sid']); ?>">Message</button>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        <?php } else { ?>
            <p>No unread proposals.</p>
        <?php } ?>
    </div>
</div>
<!-- /Unread Proposals List -->
<!-- Read Proposals List -->
<div class="card">
    <div class="card-body">
        <h4 class="card-title">Read Proposals</h4>
        <?php if (mysqli_num_rows($readProposalsResult) > 0) { ?>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Student Name</th>
                            <th>Project Title</th>
                            <th>Message</th>
                            <th>Proposal Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($proposalRow = mysqli_fetch_assoc($readProposalsResult)) { ?>
                            <tr>
                                <td><?php echo getStudentName($con, $proposalRow['sid']); ?></td>
                                <td><?php echo $proposalRow['project_title']; ?></td>
                                <td><?php echo $proposalRow['message']; ?></td>
                                <td><?php echo $proposalRow['proposal_status']; ?></td>
                                <td>
    <a href="#" class="btn btn-primary btn-sm download-proposal" data-proposal-id="<?php echo $proposalRow['proposal_id']; ?>">Download</a>
    <button type="button" class="btn btn-danger btn-sm delete-proposal" data-proposal-id="<?php echo $proposalRow['proposal_id']; ?>">Delete</button>
    <button type="button" class="btn btn-info btn-sm message-student" data-student-id="<?php echo $proposalRow['sid']; ?>">Message</button>
</td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        <?php } else { ?>
            <p>No read proposals.</p>
        <?php } ?>
    </div>
</div>
<!-- /Read Proposals List -->

            </div>
        </div>
        <!-- /Page Wrapper -->
    </div>
    <!-- Proposal Modal -->
<div class="modal fade" id="proposalModal" tabindex="-1" role="dialog" aria-labelledby="proposalModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="proposalModalLabel">View Proposal</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h6 id="proposalModalTitle"></h6>
                <p id="proposalModalContent"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- /Proposal Modal -->
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
            <button type="button" class="btn btn-secondary" id= "close" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="sendMessageBtn">Send Message</button>
            </div>
        </div>
    </div>
</div>
<!-- /Message Modal -->
<!-- New Project Idea Modal -->
<div class="modal fade" id="newProjectIdeaModal" tabindex="-1"  aria-labelledby="newProjectIdeaModalLabel" aria-hidden="true">
    <div class="modal-dialog" >
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newProjectIdeaModalLabel">Create New Project Idea</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            <form id="newProjectIdeaForm" action="commit_project_idea.php" method="POST">
                    <div class="mb-3">
                        <label for="projectTitle" class="form-label">Project Title</label>
                        <input type="text" class="form-control" id="projectTitle" name="projectTitle" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description of Topic Area</label>
                        <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="keywords" class="form-label">Keywords</label>
                        <input type="text" class="form-control" id="keywords" name="keywords" required>
                    </div>
                    <div class="mb-3">
                        <label for="programmes" class="form-label">MSc Programmes/Courses</label>
                        <input type="text" class="form-control" id="programmes" name="programmes" required>
                    </div>
                    <div class="mb-3">
                        <label for="overview" class="form-label">Overview of the Project</label>
                        <textarea class="form-control" id="overview" name="overview" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="objectives" class="form-label">Project Aims/Objectives</label>
                        <textarea class="form-control" id="objectives" name="objectives" rows="3" required></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" id= "close" data-dismiss="modal">Close</button>
                        <button type="submit" id="commitProjectIdeaBtn" class="btn btn-primary">Commit Project Idea</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
    <!-- /Main Wrapper -->
<!-- Bootstrap JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

 <!-- jQuery -->
 <script src="assets/js/jquery-3.2.1.min.js"></script>

<!-- Bootstrap Core JS -->
<script src="assets/js/popper.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
    <!-- Custom JS -->
    <script>
    $(document).ready(function() {
        // View Proposal
        $('.view-proposal').click(function() {
            var proposalId = $(this).data('proposal-id');
            // Perform AJAX request to fetch proposal details based on proposalId
            $.ajax({
                url: 'view_proposal.php',
                method: 'POST',
                data: { proposal_id: proposalId },
                dataType: 'json',
                success: function(response) {
                    // Handle the response and display the proposal details in a modal or a pop-up
                    // Example: Show proposal details in a modal
                    if (response) {
                        $('#proposalModalTitle').text(response.project_title);
                        $('#proposalModalContent').text(response.proposal_docs);
                        $('#proposalModal').modal('show');
                    } else {
                        alert('Error fetching proposal details.');
                    }
                },
                error: function() {
                    alert('Error fetching proposal details.');
                }
            });
        });

        // Accept Proposal
        $('.accept-proposal').click(function() {
            var proposalId = $(this).data('proposal-id');
            // Perform AJAX request to update proposal_status to "Accepted" based on proposalId
            $.ajax({
                url: 'accept_proposal.php',
                method: 'POST',
                data: { proposal_id: proposalId },
                success: function(response) {
                    // Handle the response
                    if (response === 'success') {
                        // Refresh the page or update the UI accordingly
                        location.reload();
                    } else {
                        alert('Error accepting proposal.');
                    }
                },
                error: function() {
                    alert('Error accepting proposal.');
                }
            });
        });

        // Reject Proposal
        $('.reject-proposal').click(function() {
            var proposalId = $(this).data('proposal-id');
            // Perform AJAX request to update proposal_status to "Rejected" based on proposalId
            $.ajax({
                url: 'reject_proposal.php',
                method: 'POST',
                data: { proposal_id: proposalId },
                success: function(response) {
                    // Handle the response
                    if (response === 'success') {
                        // Refresh the page or update the UI accordingly
                        location.reload();
                    } else {
                        alert('Error rejecting proposal.');
                    }
                },
                error: function() {
                    alert('Error rejecting proposal.');
                }
            });
        });

        // Delete Proposal
        $('.delete-proposal').click(function() {
            var proposalId = $(this).data('proposal-id');
            // Perform AJAX request to delete the proposal based on proposalId
            $.ajax({
                url: 'delete_proposal.php',
                method: 'POST',
                data: { proposal_id: proposalId },
                success: function(response) {
                    // Handle the response
                    if (response === 'success') {
                        // Refresh the page or update the UI accordingly
                        location.reload();
                    } else {
                        alert('Error deleting proposal.');
                    }
                },
                error: function() {
                    alert('Error deleting proposal.');
                }
            });
        });
    });
</script>
<script>
    $(document).ready(function() {
        // ... Other existing AJAX functions ...

        // Download Proposal
        $('.download-proposal').click(function() {
            var proposalId = $(this).data('proposal-id');
            // Perform AJAX request to fetch proposal document path based on proposalId
            $.ajax({
                url: 'get_proposal_document.php',
                method: 'POST',
                data: { proposal_id: proposalId },
                dataType: 'json',
                success: function(response) {
                    // Handle the response and initiate file download
                    if (response && response.proposal_docs) {
                        var downloadLink = document.createElement('a');
                        downloadLink.href = response.proposal_docs;
                        downloadLink.download = 'Proposal_Document.docx';
                        downloadLink.click();
                    } else {
                        alert('Error fetching proposal document.');
                    }
                },
                error: function() {
                    alert('Error fetching proposal document.');
                }
            });
        });

        // ... Other existing AJAX functions ...
    });
</script>
<!-- ... Rest of the HTML code ... -->
<!-- ... Rest of the HTML code ... -->
<script>
    $(document).ready(function() {
        // ... Existing AJAX functions ...

        // Message Student
        $('.message-student').click(function() {
            var studentId = $(this).data('student-id');

            // Perform AJAX request to fetch the student's name based on studentId
            $.ajax({
                url: 'get_student_name.php', // Update the URL to the actual PHP script to fetch student name
                method: 'POST',
                data: { student_id: studentId },
                dataType: 'json',
                success: function(response) {
                    // Handle the response
                    if (response && response.student_name) {
                        // Set recipient's information in the message modal
                        $('#messageRecipientId').val(studentId);
                        $('#messageRecipientName').val(response.student_name);
                        $('#messageRecipientSid').val(studentId); // You can display SID here as well if you want

                        // Show the message modal
                        $('#messageModal').modal('show');
                    } else {
                        alert('Error fetching student name.');
                    }
                },
                error: function() {
                    alert('Error fetching student name.');
                }
            });
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
<script>
    $(document).ready(function() {
        // Close the modal when the close button is clicked
        $('#newProjectIdeaModal button#close').click(function() {
            $('#newProjectIdeaModal').modal('hide');
        });
    });
</script>
<script>
    $(document).ready(function() {
        // Close the modal when the close button is clicked
        $('#newProjectIdeaModal button.close').click(function() {
            $('#newProjectIdeaModal').modal('hide');
        });
    });
</script>


<script>
    $(document).ready(function() {
        // Close the modal when the close button is clicked
        $('#messageModal button#close').click(function() {
            $('#messageModal').modal('hide');
        });
    });
</script>
<script>
    $(document).ready(function() {
        // Close the modal when the close button is clicked
        $('#messageModal button.close').click(function() {
            $('#messageModal').modal('hide');
        });
    });
</script>
<!-- ... Rest of the HTML code ... -->

<!-- Custom JS -->

<!-- ... Existing code ... -->
 


</body>
</html>


