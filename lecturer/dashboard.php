<?php
session_start();
require("config.php");

////code

if(!isset($_SESSION['lid']))
{
	header("location:index.php");
}


$query = "SELECT lid, firstname, lastname, photo, email, phoneno, address, department, faculty, lid FROM lecturer WHERE lid = '{$_SESSION['lid']}'";
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
} else {
 
    exit('Error fetching lecturer details');
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, lid-scalable=0">
    <title>lecturer - Dashboard</title>
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
                                <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.css">
    <style>
        .big-button-container {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            grid-gap: 20px;
            margin-top: 50px;
        }

        .big-button {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            width: 200px;
            height: 200px;
            border-radius: 8px;
            background-color: #f8f9fa;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
            text-decoration: none;
            color: #212529;
            transition: background-color 0.3s;
        }

        .big-button:hover {
            background-color: #e9ecef;
        }

        .big-button i {
            font-size: 60px;
            margin-bottom: 10px;
        }

        .big-button span {
            font-size: 20px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="big-button-container">
                <a href="dashboard.php" class="big-button">
                    <i class="fe fe-home"></i>
                    <span>Dashboard</span>
                </a>
                <a href="idea.php" class="big-button">
                    <i class="fe fe-sunrise"></i>
                    <span>Project Ideas</span>
                </a>
                <a href="proposal.php" class="big-button">
                    <i class="fe fe-edit"></i>
                    <span>Proposal</span>
                </a>
                <a href="project.php" class="big-button">
                    <i class="fe fe-folder"></i>
                    <span>Project</span>
                </a>
                <a href="library.php" class="big-button">
                    <i class="fe fe-book"></i>
                    <span>Library</span>
                </a>
                <a href="message.php" class="big-button">
                    <i class="fe fe-mail"></i>
                    <span>Message</span>
                </a>
                <a href="help.php" class="big-button">
                    <i class="fe fe-magic"></i>
                    <span>Help & Support</span>
                </a>
                <a href="profile.php" class="big-button">
                    <i class="fe fe-sid"></i>
                    <span>Profile</span>
                </a>
                <a href="logout.php" class="big-button">
                    <i class="fe fe-logout"></i>
                    <span>Sign Out</span>
                </a>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
    <script>
        feather.replace();
    </script>
</body>
</html>

                            </ul>
                        </div>
                    </div>
                </div>
                <!-- /Page Header -->
                
        </div>
        <!-- /Page Wrapper -->
    </div>
    <!-- /Main Wrapper -->
    <!-- jQuery -->
	<!-- Custom JS -->
<script src="assets/js/script.js"></script>
<script>
    function updateProfile() {
       
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
