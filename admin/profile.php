<?php
session_start();
require("config.php");

////code

if(!isset($_SESSION['aid']))
{
	header("location:index.php");
}

// Assuming you have a database connection, execute a query to fetch the admin details
// Modify this query according to your database structure and table names
$query = "SELECT aid, firstname, lastname, photo, email, phoneno, address, aid FROM admin WHERE aid = '{$_SESSION['aid']}'";
$result = mysqli_query($con, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $aid = $row['aid'];
    $firstName = $row['firstname'];
    $lastName = $row['lastname'];
    $photo = $row['photo'];
    $email = $row['email'];
    $phoneNo = $row['phoneno'];
    $address = $row['address'];
    
    $aid = $row['aid'];
} else {
    // Handle the case when the query doesn't return any rows or an error occurred
    // You can redirect the user or display an error message
    exit('Error fetching admin details');
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, sid-scalable=0">
    <title>admin - Dashboard</title>
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/logo.jpg">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <!-- Fontawesome CSS -->
    <link rel="stylesheet" href="assets/css/font-awesome.min.css">
    <!-- Feathericon CSS -->
    <link rel="stylesheet" href="assets/css/feathericon.min.css">
    <link rel="stylesheet" href="assets/plugins/morris/morris.css">
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
                            <h3 class="page-title" style="color:black;margin-top:13px;text-transform:capitalize;">Welcome <?php echo $firstName . ' ' . $lastName; ?></h3>
                            <p></p>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item active">Dashboard</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- /Page Header -->
                <!-- User Persona -->
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <img src="<?php echo $photo; ?>" alt="Profile Picture" class="img-fluid">
                            </div>
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-6">
                                        <p><strong>admin ID:</strong> <?php echo $aid; ?></p>
                                        <p><strong>First Name:</strong> <?php echo $firstName; ?></p>
                                        <p><strong>Last Name:</strong> <?php echo $lastName; ?></p>
                                        <p><strong>Email:</strong> <?php echo $email; ?></p>
                                    </div>
                                    <div class="col-md-6">
                                        <p><strong>Phone No:</strong> <?php echo $phoneNo; ?></p>
                                        <p><strong>Address:</strong> <?php echo $address; ?></p>
                                        
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /User Persona -->
				<div class="mt-3 text-center">
    <button class="btn btn-primary" onclick="updateProfile()">Update Profile</button>
</div>
            </div>
        </div>
        <!-- /Page Wrapper -->
    </div>
    <!-- /Main Wrapper -->
    <!-- jQuery -->
	<!-- Custom JS -->
<script src="assets/js/script.js"></script>
<script>
    function updateProfile() {
        // Add your update profile code here
        // For example, you can redirect the user to the update profile page using:
        window.location.href = 'update_profile.php';
    }
</script>

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
