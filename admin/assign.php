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

// CRUD Operations
// Assign Lecturer to Student
if (isset($_POST['assign_lecturer'])) {
    $lid = $_POST['lid'];
    $sid = $_POST['sid'];

    // Fetch lecturer and student names
    $lecturerQuery = "SELECT firstname, lastname FROM lecturer WHERE lid = '$lid'";
    $studentQuery = "SELECT firstname, lastname FROM student WHERE sid = '$sid'";

    $lecturerResult = mysqli_query($con, $lecturerQuery);
    $studentResult = mysqli_query($con, $studentQuery);

    if ($lecturerResult && $studentResult) {
        $lecturerRow = mysqli_fetch_assoc($lecturerResult);
        $studentRow = mysqli_fetch_assoc($studentResult);

        $lecturerName = $lecturerRow['firstname'] . ' ' . $lecturerRow['lastname'];
        $studentName = $studentRow['firstname'] . ' ' . $studentRow['lastname'];

        // Insert into the 'assign' table
        $insertQuery = "INSERT INTO assign (lid, sid, lecturer_name, student_name) VALUES ('$lid', '$sid', '$lecturerName', '$studentName')";
        $insertResult = mysqli_query($con, $insertQuery);

        if ($insertResult) {
            // Redirect to the same page after successful assignment
            header("Location: admin_assign.php");
            exit;
        } else {
            // Handle error if insertion fails
            echo "Error assigning lecturer to student.";
        }
    } else {
        // Handle error if fetching lecturer or student details fails
        echo "Error fetching lecturer or student details.";
    }
}

// Fetch all students
$studentsQuery = "SELECT * FROM student";
$studentsResult = mysqli_query($con, $studentsQuery);

// Fetch all lecturers
$lecturersQuery = "SELECT * FROM lecturer";
$lecturersResult = mysqli_query($con, $lecturersQuery);

// Fetch assigned lecturers and students
$assignQuery = "SELECT * FROM assign";
$assignResult = mysqli_query($con, $assignQuery);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, sid-scalable=0">
    <title>admin - Assign Lecturer to Student</title>
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
    <style>
        .table {
            width: 100%;
            max-width: 100%;
            margin-bottom: 1rem;
            background-color: #ffffff;
        }

        .table td,
        .table th {
            vertical-align: middle;
            border-top: 1px solid #dee2e6;
        }

        .table thead th {
            vertical-align: bottom;
            border-bottom: 2px solid #dee2e6;
        }

        .table tbody + tbody {
            border-top: 2px solid #dee2e6;
        }

        .table-sm td,
        .table-sm th {
            padding: 0.3rem;
        }

        .table-bordered {
            border: 1px solid #dee2e6;
        }

        .table-bordered td,
        .table-bordered th {
            border: 1px solid #dee2e6;
        }

        .table-bordered thead td,
        .table-bordered thead th {
            border-bottom-width: 2px;
        }
    </style>
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
                            <h3 class="page-title">Assign Lecturer to Student</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                                <li class="breadcrumb-item active">Assign Lecturer to Student</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- /Page Header -->

    <!-- Assign Lecturer to Student Form -->
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Assign Lecturer to Student</h3>
                </div>
                <div class="card-body">
                    <form method="post" action="admin_assign.php" onsubmit="return validateAssignment()">
                        <div class="mb-3">
                            <label for="lid" class="form-label">Lecturer ID</label>
                            <select class="form-select" id="lid" name="lid" required>
                                <?php
                                while ($lecturerRow = mysqli_fetch_assoc($lecturersResult)) {
                                    echo "<option value='{$lecturerRow['lid']}'>{$lecturerRow['lid']}</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="sid" class="form-label">Student ID</label>
                            <select class="form-select" id="sid" name="sid" required>
                                <?php
                                while ($studentRow = mysqli_fetch_assoc($studentsResult)) {
                                    echo "<option value='{$studentRow['sid']}'>{$studentRow['sid']}</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary" name="assign_lecturer">Assign Lecturer</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
<!-- Assigned Lecturers and Students Table -->
<div class="row mt-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Assigned Lecturers and Students</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                            <th> ID</th>
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
                                echo '<tr><td colspan="5">No assignments found.</td></tr>';
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
<div class="modal fade" id="deleteAssignmentModal" tabindex="-1" role="dialog" aria-labelledby="deleteAssignmentModalLabel" aria-hidden="true">
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

<!-- jQuery -->
<script src="assets/js/jquery-3.6.0.min.js"></script>
<!-- Bootstrap JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>



<script>
    $('#deleteAssignmentModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Button that triggered the modal
        var id = button.data('id'); // Extract ID from data-id attribute of the button
        var modal = $(this);
        modal.find('#delete_id').val(id); // Set the value of the hidden input field
    });
</script>


    
</body>
 
</html>
