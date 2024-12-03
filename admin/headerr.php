<?php

require("config.php");

// code

if(!isset($_SESSION['aid']))
{
	header("location:index.php");
}

// Assuming you have a database connection, execute a query to fetch the first name
// Modify this query according to your database structure and table names
$query = "SELECT firstname FROM admin WHERE aid = '{$_SESSION['aid']}'";
$result = mysqli_query($con, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $firstName = $row['firstname'];
} else {
    // Handle the case when the query doesn't return any rows or an error occurred
    $firstName = 'Unknown'; // Set a default value
}

// Check if the admin has any unread messages
$unreadQuery = "SELECT COUNT(*) AS unreadCount FROM messages WHERE recipient_id = '{$_SESSION['aid']}' AND is_read = 0";
$unreadResult = mysqli_query($con, $unreadQuery);
$unreadRow = mysqli_fetch_assoc($unreadResult);
$unreadCount = $unreadRow['unreadCount'];

?>
<div class="header">
    <!-- Logo -->
    <div class="header-left">
        <a href="dashboard.php" class="logo">
            <img src="assets/img/logo.jpg" alt="Logo" width="30" height="50">
            UNIVERSITY OF <br> GREENWICH
        </a>
        <a href="dashboard.php" class="logo logo-small">
            <img src="assets/img/logo.jpg" alt="Logo" width="30" height="30">
        </a>
    </div>
    <!-- /Logo -->
    
    <a href="javascript:void(0);" id="toggle_btn">
        <i class="fe fe-text-align-left"></i>
    </a>

    <!-- Mobile Menu Toggle -->
    <a class="mobile_btn" id="mobile_btn">
        <i class="fa fa-bars"></i>
    </a>
    <!-- /Mobile Menu Toggle -->

    <!-- Header Right Menu -->
    <ul class="nav sid-menu">
        <!-- sid Menu -->
        <li class="nav-item dropdown app-dropdown">
            <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
                <span class="sid-img"><img class="rounded-circle" src="assets/img/profiles/avatar-01.png" alt="Ryan Taylor"></span>
                <h4 style="color:black;margin-top:13px;text-transform:capitalize;"><?php echo $firstName; ?></h4>
                <?php if ($unreadCount > 0) { ?>
                    <span class="badge badge-danger"><?php echo $unreadCount; ?></span>
                <?php } ?>
            </a>
			<div class="dropdown-menu">
							<div class="sid-header">
								<div class="avatar avatar-sm">
									<img src="assets/img/profiles/avatar-01.png" alt=" Image" class="avatar-img rounded-circle">
								</div>
								<div class="sid-text">
								<h4 style="color:white;margin-top:13px;text-transform:capitalize;"><?php echo $firstName; ?></h4>
									<p class="text-muted mb-0">admin</p>
								</div>
							</div>
							<a class="dropdown-item" href="profile.php">Profile</a>
							<a class="dropdown-item" href="logout.php">Sign Out</a>
						</div>
            <!-- Rest of the code -->
        </li>
    </ul>
    <!-- /Header Right Menu -->
</div>
	<!-- /sid Menu -->
					
    </ul>
				<!-- /Header Right Menu -->
				
            </div>
			
			<!-- header --->
			
			
			
						<!-- Sidebar -->
            <div class="sidebar" id="sidebar">
                <div class="sidebar-inner slimscroll">
					<div id="sidebar-menu" class="sidebar-menu">
						<ul>
							<li class="menu-title"> 
								<span>Main</span>
							</li>
							<li> 
							<a href="dashboard.php"><i class="fe fe-home"></i> <span>Dashboard</span></a>
<a href="proposal.php"><i class="fe fe-edit"></i> <span>Proposal</span></a>
<a href="project.php"><i class="fe fe-folder"></i> <span>Project</span></a>
<a href="library.php"><i class="fe fe-book"></i> <span>Library</span></a>
<a href="student.php"><i class="fe fe-sid"></i> <span>Student</span></a>
<a href="lecturer.php"><i class="fe fe-sid"></i> <span>Lecturer</span></a>
<a href="admin.php"><i class="fe fe-sid"></i> <span>Admin</span></a>
<a href="assign.php"><i class="fe fe-edit"></i> <span>Assign</span></a>
<a href="message.php"><i class="fe fe-mail"></i> <span>Message</span></a>
<a href="help.php"><i class="fe fe-magic"></i> <span>Help and Support</span></a>
<a href="profile.php"><i class="fe fe-sid"></i> <span>Profile</span></a>
<a href="logout.php"><i class="fe fe-logout"></i> <span>Sign Out</span></a>

							</li>
							
							
							
						
							
						</ul>
					</div>
                </div>
            </div>
			<style>/* CSS for nav sid-menu */
.nav.sid-menu {
  display: flex;
  flex-direction: row-reverse;
  align-items: center;
  margin-right: 15px; /* Adjust the margin as needed */
  
  height: 50px; /* Add this line with the desired height value */
}


/* CSS for reversing the order of sid-menu items */
.nav.sid-menu li {
  order: -1;
  margin-left: 10px; /* Adjust the margin as needed */
}

/* CSS to align the h4 element within the sid-menu */
.nav.sid-menu h4 {
  color: white;
  margin-right: 10px; /* Adjust the margin as needed */
  text-transform: capitalize;
  line-height: 1; /* Add this line to remove any extra vertical spacing */
}

</style>
			<!-- /Sidebar -->
