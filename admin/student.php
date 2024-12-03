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
// Delete Student
if (isset($_POST['delete_student'])) {
    $sid = $_POST['sid'];
    $deleteQuery = "DELETE FROM students WHERE sid = '$sid'";
    $deleteResult = mysqli_query($con, $deleteQuery);
    if ($deleteResult) {
        // Redirect to the same page after successful deletion
        header("Location: student.php");
        exit;
    } else {
        // Handle error if deletion fails
        echo "Error deleting student.";
    }
}

// Fetch all students
$studentsQuery = "SELECT * FROM student";
$studentsResult = mysqli_query($con, $studentsQuery);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, sid-scalable=0">
    <title>admin - Students</title>
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
        #watermark {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            opacity: 0.5; /* Adjust the opacity as needed */
            pointer-events: none; /* Make sure the watermark doesn't interfere with user interactions */
        }
    </style>
</head>
<body>
<img id="watermark" src="/admin/assets/img/namelogo.png" alt="Watermark">
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

             

                <!-- Students Table -->
                <div class="row mt-4">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">All Students</h3>
                                <!-- Button to trigger add student modal -->
                                <button type="button" class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#addStudentModal">
                                    Add Student
                                </button>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Student ID</th>
                                                <th>First Name</th>
                                                <th>Last Name</th>
                                                <th>Email</th>
                                                <th>Phone Number</th>
                                                <th>Address</th>
                                                <th>Department</th>
                                                <th>Faculty</th>
                                                
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if ($studentsResult && mysqli_num_rows($studentsResult) > 0) {
                                                while ($studentRow = mysqli_fetch_assoc($studentsResult)) {
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $studentRow['sid']; ?></td>
                                                        <td><?php echo $studentRow['firstname']; ?></td>
                                                        <td><?php echo $studentRow['lastname']; ?></td>
                                                        <td><?php echo $studentRow['email']; ?></td>
                                                        <td><?php echo $studentRow['phoneno']; ?></td>
                                                        <td><?php echo $studentRow['address']; ?></td>
                                                        <td><?php echo $studentRow['department']; ?></td>
                                                        <td><?php echo $studentRow['faculty']; ?></td>
                                                      
                                                        <td>
                                                            <!-- Buttons to trigger edit and delete student modals -->
                                                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editStudentModal<?php echo $studentRow['sid']; ?>">
                                                                Edit
                                                            </button>
                                                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteStudentModal<?php echo $studentRow['sid']; ?>">
                                                                Delete
                                                            </button>
                                                        </td>
                                                    </tr>
                                                    <!-- Edit Student Modal -->
<div class="modal fade" id="editStudentModal<?php echo $studentRow['sid']; ?>" tabindex="-1" aria-labelledby="editStudentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editStudentModalLabel">Edit Student Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Edit student form -->
                <form action="update_student.php" method="post">
                    <div class="mb-3">
                        <label for="editFirstName" class="form-label">First Name</label>
                        <input type="text" class="form-control" id="editFirstName" name="editFirstName" value="<?php echo $studentRow['firstname']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="editLastName" class="form-label">Last Name</label>
                        <input type="text" class="form-control" id="editLastName" name="editLastName" value="<?php echo $studentRow['lastname']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="editEmail" class="form-label">Email</label>
                        <input type="email" class="form-control" id="editEmail" name="editEmail" value="<?php echo $studentRow['email']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="editPhone" class="form-label">Phone Number</label>
                        <input type="text" class="form-control" id="editPhone" name="editPhone" value="<?php echo $studentRow['phoneno']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="editPassword" class="form-label">Password</label>
                        <input type="password" class="form-control" id="editPassword" name="editPassword" required>
                    </div>
                    <input type="hidden" name="studentId" value="<?php echo $studentRow['sid']; ?>">
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
                                                <!-- Delete Student Modal -->
<div class="modal fade" id="deleteStudentModal<?php echo $studentRow['sid']; ?>" tabindex="-1" aria-labelledby="deleteStudentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteStudentModalLabel">Confirm Deletion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this student?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form action="delete_student.php" method="post">
                    <input type="hidden" name="studentId" value="<?php echo $studentRow['sid']; ?>">
                    <button type="submit" class="btn btn-danger" name="delete_student">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>
                                                    <?php
                                                }
                                            } else {
                                                echo '<tr><td colspan="7">No students found.</td></tr>';
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Students Table -->
            </div>
        </div>
    </div>

    <!-- Add Student Modal -->
    <div class="modal fade" id="addStudentModal" tabindex="-1" aria-labelledby="addStudentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addStudentModalLabel">Add Student</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addStudentForm" method="POST" action="add_student.php">
                <div class="mb-3">
                        <label for="sid" class="form-label">Student ID</label>
                        <input type="text" class="form-control" id="sid" name="sid" required>
                        <span id="sidError" class="text-danger"></span>
                    </div>
                    <div class="mb-3">
                        <label for="firstname" class="form-label">First Name</label>
                        <input type="text" class="form-control" id="firstname" name="firstname" required>
                    </div>
                    <div class="mb-3">
                        <label for="lastname" class="form-label">Last Name</label>
                        <input type="text" class="form-control" id="lastname" name="lastname" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="phoneno" class="form-label">Phone Number</label>
                        <input type="number" class="form-control" id="phoneno" name="phoneno"  pattern="[0-9]+" required>
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Address</label>
                        <input type="address" class="form-control" id="address" name="address" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                  
                    <div class="mb-3">
                        <label for="department" class="form-label">Department</label>
                        <input type="text" class="form-control" id="department" name="department" required>
                    </div>
                    <div class="mb-3">
                        <label for="faculty" class="form-label">Faculty</label>
                        <input type="text" class="form-control" id="faculty" name="faculty" required>
                    </div>
                    <button type="submit" class="btn btn-primary" onclick="checkStudentId()">Add Student</button>
                </form>
            </div>
        </div>
    </div>
</div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery -->
    <script src="assets/js/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    
<script>
function checkStudentId() {
    var studentId = document.getElementById("sid").value;

    $.ajax({
        type: "POST",
        url: "check_student_id.php",  // Create a new PHP file for handling AJAX requests
        data: { sid: studentId },
        success: function(response) {
            if (response === "exists") {
                $("#sidError").html("Student ID already exists. Please choose a different one.");
            } else {
                $("#sidError").html("");
                // If the student ID is unique, you can proceed with form submission
                $("#addStudentForm").submit();
            }
        }
    });
}
</script>
</body>
</html>
