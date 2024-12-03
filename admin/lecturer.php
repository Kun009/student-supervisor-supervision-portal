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
// Delete Lecturer
if (isset($_POST['delete_lecturer'])) {
    $lid = $_POST['lid'];
    $deleteQuery = "DELETE FROM lecturers WHERE lid = '$lid'";
    $deleteResult = mysqli_query($con, $deleteQuery);
    if ($deleteResult) {
        // Redirect to the same page after successful deletion
        header("Location: lecturer.php");
        exit;
    } else {
        // Handle error if deletion fails
        echo "Error deleting lecturer.";
    }
}

// Fetch all lecturers
$lecturersQuery = "SELECT * FROM lecturer";
$lecturersResult = mysqli_query($con, $lecturersQuery);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, sid-scalable=0">
    <title>Admin - Lecturers</title>
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
                            <h3 class="page-title">Lecturers</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                                <li class="breadcrumb-item active">Lecturers</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- /Page Header -->

                <!-- Lecturers Table -->
                <div class="row mt-4">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">All Lecturers</h3>
                                <!-- Button to trigger add lecturer modal -->
                                <button type="button" class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#addLecturerModal">
                                    Add Lecturer
                                </button>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Lecturer ID</th>
                                                <th>First Name</th>
                                                <th>Last Name</th>
                                                <th>Email</th>
                                                <th>Phone Number</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if ($lecturersResult && mysqli_num_rows($lecturersResult) > 0) {
                                                while ($lecturerRow = mysqli_fetch_assoc($lecturersResult)) {
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $lecturerRow['lid']; ?></td>
                                                        <td><?php echo $lecturerRow['firstname']; ?></td>
                                                        <td><?php echo $lecturerRow['lastname']; ?></td>
                                                        <td><?php echo $lecturerRow['email']; ?></td>
                                                        <td><?php echo $lecturerRow['phoneno']; ?></td>
                                                        <td>
                                                            <!-- Buttons to trigger edit and delete lecturer modals -->
                                                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editLecturerModal<?php echo $lecturerRow['lid']; ?>">
                                                                Edit
                                                            </button>
                                                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteLecturerModal<?php echo $lecturerRow['lid']; ?>">
                                                                Delete
                                                            </button>
                                                        </td>
                                                    </tr>
                                                    <!-- Edit Lecturer Modal -->
<div class="modal fade" id="editLecturerModal<?php echo $lecturerRow['lid']; ?>" tabindex="-1" aria-labelledby="editLecturerModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editLecturerModalLabel">Edit Lecturer</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="update_lecturer.php" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="lid" value="<?php echo $lecturerRow['lid']; ?>">
                    <div class="mb-3">
                        <label for="firstname" class="form-label">First Name</label>
                        <input type="text" class="form-control" id="firstname" name="firstname" value="<?php echo $lecturerRow['firstname']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="lastname" class="form-label">Last Name</label>
                        <input type="text" class="form-control" id="lastname" name="lastname" value="<?php echo $lecturerRow['lastname']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?php echo $lecturerRow['email']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="phoneno" class="form-label">Phone Number</label>
                        <input type="number" class="form-control" id="phoneno" name="phoneno" value="<?php echo $lecturerRow['phoneno']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="faculty" class="form-label">Faculty</label>
                        <input type="text" class="form-control" id="faculty" name="faculty" value="<?php echo $lecturerRow['faculty']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="department" class="form-label">Department</label>
                        <input type="text" class="form-control" id="department" name="department" value="<?php echo $lecturerRow['department']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <!-- Add more input fields for other lecturer details as needed -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

                                                   <!-- Delete Lecturer Modal -->
<div class="modal fade" id="deleteLecturerModal<?php echo $lecturerRow['lid']; ?>" tabindex="-1" aria-labelledby="deleteLecturerModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteLecturerModalLabel">Confirm Deletion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this lecturer?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <!-- Form to submit the lecturer ID to delete_lecturer.php -->
                <form action="delete_lecturer.php" method="POST">
                    <input type="hidden" name="lecturerId" value="<?php echo $lecturerRow['lid']; ?>">
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

                                                    <?php
                                                }
                                            } else {
                                                echo '<tr><td colspan="6">No lecturers found.</td></tr>';
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Lecturers Table -->
            </div>
        </div>
    </div>

  <!-- Add Lecturer Modal -->
<div class="modal fade" id="addLecturerModal" tabindex="-1" aria-labelledby="addLecturerModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addLecturerModalLabel">Add New Lecturer</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Lecturer Form -->
                <form action="add_lecturer.php" method="POST" onsubmit="return validateLecturerId()">
                    <div class="mb-3">
                        <label for="lid" class="form-label">Lecturer ID</label>
                        <input type="text" class="form-control" id="lid" name="lid" required>
                        <small id="lid-error" class="text-danger"></small>
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
                        <input type="number" class="form-control" id="phoneno" name="phoneno" required>
                    </div>
					<div class="mb-3">
                        <label for="faculty" class="form-label">Faculty</label>
                        <input type="text" class="form-control" id="faculty" name="faculty" required>
                    </div>
					<div class="mb-3">
                        <label for="department" class="form-label">Department</label>
                        <input type="text" class="form-control" id="department" name="department" required>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <!-- Add more input fields for other lecturer details as needed -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add Lecturer</button>
                    </div>
                </form>
                <!-- /Lecturer Form -->
            </div>
        </div>
    </div>
</div>
<!-- Error Modal -->
<div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="errorModalLabel">Error</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Place error message here -->
                <p>An error occurred.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


    <!-- Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script>
    function validateLecturerId() {
        var lidInput = document.getElementById('lid');
        var lidError = document.getElementById('lid-error');

        // Check if the lecturer ID is already in the database (you may need to adjust the URL)
        var checkUrl = 'check_lecturer_id.php?lid=' + encodeURIComponent(lidInput.value);

        fetch(checkUrl)
            .then(response => response.json())
            .then(data => {
                if (data.exists) {
                    lidError.textContent = 'Lecturer ID already exists';
                    return false; // Prevent form submission
                } else {
                    lidError.textContent = '';
                    return true; // Allow form submission
                }
            })
            .catch(error => {
                console.error('Error checking lecturer ID:', error);
                return true; // Allow form submission on error (you may want to handle this differently)
            });
    }
</script>
<!-- Add this script in the head section of your HTML -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<script>
$(document).ready(function() {
    $('#lid').on('blur', function() {
        var lecturerId = $(this).val();

        // Send AJAX request to check_lecturer_id.php
        $.ajax({
            type: 'POST',
            url: 'check_lecturer_id.php',
            data: {lid: lecturerId},
            dataType: 'json',
            success: function(response) {
                if (response.exists) {
                    
                }
            },
            error: function() {
                alert('Error checking lecturer ID.');
            }
        });
    });
});
function validateLecturerId() {
    var lidInput = document.getElementById('lid');
    var lidError = document.getElementById('lid-error');

    // Check if the lecturer ID is already in the database (you may need to adjust the URL)
    var checkUrl = 'check_lecturer_id.php?lid=' + encodeURIComponent(lidInput.value);

    return fetch(checkUrl)
        .then(response => response.json())
        .then(data => {
            if (data.exists) {
                lidError.textContent = 'Lecturer ID already exists';
                return false; // Prevent form submission
            } else {
                lidError.textContent = '';
                return true; // Allow form submission
            }
        })
        .catch(error => {
            console.error('Error checking lecturer ID:', error);
            return true; // Allow form submission on error (you may want to handle this differently)
        });
}

</script>

</body>
</html>
