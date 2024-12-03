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

// Fetch assigned students for the logged-in lecturer
$assignQuery = "SELECT * FROM assign WHERE lid = '{$_SESSION['lid']}'";
$assignResult = mysqli_query($con, $assignQuery);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, sid-scalable=0">
    <title>lecturer - Students</title>
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
                            <h3 class="page-title">Students</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                                <li class="breadcrumb-item active">Students</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- /Page Header -->

          <!-- Assigned Students Table -->
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Assigned Students</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Lecturer ID</th>
                                    <th>Student ID</th>
                                    <th>Lecturer Name</th>
                                    <th>Student Name</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($assignResult && mysqli_num_rows($assignResult) > 0) {
                                    while ($assignRow = mysqli_fetch_assoc($assignResult)) {
                                        echo "<tr>";
                                        echo "<td>{$assignRow['id']}</td>";
                                        echo "<td>{$assignRow['lid']}</td>";
                                        echo "<td>{$assignRow['sid']}</td>";
                                        echo "<td>{$assignRow['lecturer_name']}</td>";
                                        echo "<td>{$assignRow['student_name']}</td>";
                                        echo "<td>
                                                <button class='btn btn-danger btn-sm delete-btn' 
                                                        data-bs-toggle='modal' data-bs-target='#deleteAssignmentModal'
                                                        data-id='{$assignRow['id']}'>
                                                    Delete
                                                </button>
                                            </td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo '<tr><td colspan="6">No assignments found.</td></tr>';
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Deleting Assignment -->
    <div class="modal fade" id="deleteAssignmentModal" tabindex="-1" role="dialog" aria-labelledby="deleteAssignmentModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteAssignmentModalLabel">Delete Assignment</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this assignment?</p>
                    <form method="post" action="delete_assignment.php" id="deleteAssignmentForm">
                        <input type="hidden" id="delete_id" name="delete_id">
                        <button type="submit" class="btn btn-danger" name="delete_assignment">Yes, Delete</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


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
    <!-- Custom JS -->
    <script>
    $(document).ready(function() {
        // Show student details and project title when student name is clicked
        $('.student-name').click(function() {
            var studentId = $(this).data('student-id');
            // Perform AJAX request to fetch student details and project title based on studentId
            // Display the details in a modal or a pop-up
            // You can use Bootstrap's modal or any other pop-up library
        });

        // Handle messaging functionality when message icon is clicked
        $('.message-icon').click(function() {
            var studentId = $(this).data('student-id');
            // Set the selected student's SID in the hidden input field of the modal form
            $('#student_id').val(studentId);
        });
    });
</script>

    <!-- jQuery -->
    <script src="assets/js/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

    <script>
        $(document).ready(function () {
            $('.delete-btn').click(function () {
                var id = $(this).data('id');
                $('#delete_id').val(id);
            });
        });
    </script>
</body>
</html>
