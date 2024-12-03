<?php
session_start();
require("config.php");

// Check if the user is logged in
if(!isset($_SESSION['lid'])) {
    header("location:index.php");
    exit;
}

// Fetch the existing lecturer details
$query = "SELECT lid, firstname, lastname, photo, email, phoneno, address, department, faculty, lid, password FROM lecturer WHERE lid = '{$_SESSION['lid']}'";
$result = mysqli_query($con, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $lid = $row['lid'];
    $firstName = $row['firstname'];
    $lastName = $row['lastname'];
    $photo = $row['photo'];
    $email = $row['email'];
    $phoneNo = $row['phoneno'];
    $address = $row['address'];
    $department = $row['department'];
    $faculty = $row['faculty'];
    $lid = $row['lid'];
    $password = $row['password'];
} else {
    // Handle the case when the query doesn't return any rows or an error occurred
    exit('Error fetching lecturer details');
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the submitted form data
    $newEmail = $_POST['email'];
    $newPhoneNo = $_POST['phoneNo'];
    $newAddress = $_POST['address'];
    $newDepartment = $_POST['department'];
    $newFaculty = $_POST['faculty'];
    $newPassword = $_POST['password'];

    // Validate and process the profile picture upload if a new image is selected
    // Validate and process the profile picture upload if a new image is selected
    if (!empty($_FILES['photo']['name'])) {
        // Specify the upload directory
        $uploadDirectory = 'uploads/';

        // Generate a unique filename
        $newFileName = uniqid() . '_' . $_FILES['photo']['name'];

        // Get the temporary file path
        $tmpFilePath = $_FILES['photo']['tmp_name'];

        // Set the target file path
        $targetFilePath = $uploadDirectory . $newFileName;

        // Move the uploaded file to the target directory
        if (move_uploaded_file($tmpFilePath, $targetFilePath)) {
            // Update the photo field in the database
            $photo = $targetFilePath;
            $updatePhotoQuery = "UPDATE lecturer SET photo = '$photo' WHERE lid = '$lid'";
            mysqli_query($con, $updatePhotoQuery);
        } else {
            // Handle the case when the file upload fails
            echo "Failed to upload the profile picture.";
        }
    }


    // Update the other details in the database
    $updateQuery = "UPDATE lecturer SET email = '$newEmail', phoneno = '$newPhoneNo', address = '$newAddress', department = '$newDepartment', faculty = '$newFaculty', password = '$newPassword' WHERE lid = '$lid'";
    if (mysqli_query($con, $updateQuery)) {
        // Redirect to the dashboard or any other page you want
        header("location:dashboard.php");
        exit;
    } else {
        // Handle the case when the update query fails
        echo "Failed to update the profile.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, sid-scalable=0">
    <title>lecturer - Update Profile</title>
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
                            <h3 class="page-title">Update Profile</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                                <li class="breadcrumb-item active">Update Profile</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- /Page Header -->

                <!-- Update Profile Form -->
                <div class="card">
                    <div class="card-body">
                        <form action="" method="POST" enctype="multipart/form-data">
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" class="form-control" name="email" value="<?php echo $email; ?>" required>
                            </div>
                            <div class="form-group">
                                <label>Phone No</label>
                                <input type="text" class="form-control" name="phoneNo" value="<?php echo $phoneNo; ?>" required>
                            </div>
                            <div class="form-group">
                                <label>Address</label>
                                <input type="text" class="form-control" name="address" value="<?php echo $address; ?>" required>
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input type="text" class="form-control" name="password" value="<?php echo $password; ?>" required>
                            </div>
                            <div class="form-group">
                                <label>Profile Picture</label>
                                <input type="file" class="form-control" name="photo">
                            </div>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </form>
                    </div>
                </div>
                <!-- /Update Profile Form -->
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
