
Copy code
<?php
session_start();
require("config.php");

// Check if the user is logged in
if (!isset($_SESSION['aid'])) {
    header("location:index.php");
    exit;
}
// Fetch project ideas committed by the logged-in lecturer
$projectQuery = "SELECT project_title, id FROM project_ideas ";
$projectResult = mysqli_query($con, $projectQuery);

if (!$projectResult) {
    // Handle the case when the query doesn't return any rows or an error occurred
    exit('Error fetching project ideas.');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, sid-scalable=0">
    <title>Lecturer- Idea</title>
<!-- Favicon -->
<link rel="shortcut icon" type="image/x-icon" href="./assets/img/logo.jpg">
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
                            <h3 class="page-title">Project Ideas</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                                <li class="breadcrumb-item active">Project Ideas</li>
                            </ul>
                        </div>
                    </div>
                    <!-- Button to trigger new project idea modal -->
<button type="button" class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#newProjectIdeaModal" >
    Create New Project Idea
</button>
                </div>
                <!-- /Page Header -->

             <!-- Display Project Ideas -->
<div class="row">
<?php while ($projectRow = mysqli_fetch_assoc($projectResult)) { ?>
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <?php
                // Check if the project title is set
                $projectTitle = isset($projectRow['project_title']) ? $projectRow['project_title'] : 'Untitled Project';
                ?>
                <h5 class="card-title"><?php echo $projectTitle; ?></h5>
                <!-- Set data-project-id attribute with the correct project ID -->
                <a href="#" class="btn btn-primary view-details-btn" data-toggle="modal" data-target="#projectDetailsModal" data-project-id="<?php echo $projectRow['id']; ?>" data-project-title="<?php echo $projectTitle; ?>">View Details</a>
                <button class="btn btn-danger delete-btn" data-toggle="modal" data-target="#deleteConfirmationModal" data-project-id="<?php echo $projectRow['id']; ?>">Delete</button>
              
            </div>
        </div>
    </div>
<?php } ?>

</div>
 <!-- Project Details Modal -->
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
                                <div id="projectDetailsContent">
                                    <!-- Project details will be displayed here dynamically -->
                                </div>
                            </div>
                            
                            <div class="modal-footer">
                            <button type="button" class="btn btn-warning" id="editDetailsBtn">Edit</button>
            
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Project Details Modal -->
                <!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteConfirmationModal" tabindex="-1" role="dialog" aria-labelledby="deleteConfirmationModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteConfirmationModalLabel">Confirm Delete</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this project?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Yes</button>
            </div>
        </div>
    </div>
</div>

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
                        <label for="lid" class="form-label">Lecturer ID</label>
                        <input type="text" class="form-control" id="lid" name="lid" required>
                    </div>        
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
                        <button type="button" class="close" data-dismiss="modal">Close</button>
                        <button type="submit" id="commitProjectIdeaBtn" class="btn btn-primary">Commit Project Idea</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- /Display Project Ideas --> 
        <!-- /Page Wrapper -->
    </div>
    <!-- /Main Wrapper -->

    <!-- jQuery -->
    <script src="assets/js/jquery-3.2.1.min.js"></script>
    <!-- Bootstrap Core JS -->
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <!-- Bootstrap JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

    <!-- Slimscroll JS -->
    <script src="assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>
    <script src="assets/plugins/raphael/raphael.min.js"></script>
    <script src="assets/plugins/morris/morris.min.js"></script>
    <script src="assets/js/chart.morris.js"></script>
    <!-- Custom JS -->
    <script src="assets/js/script.js"></script>
   
    <!-- JavaScript code to handle the click event and fetch details -->
<script>
$(document).ready(function () {
    var editMode = false;
    var projectId;

    $('.view-details-btn').click(function () {
        projectId = $(this).data('project-id');
        var currentButton = $(this);

        $.ajax({
            url: 'fetch_project_details.php',
            type: 'POST',
            data: { id: projectId },
            success: function (response) {
                var projectDetailsHtml = '<p><b>Project Title:</b> ' + currentButton.data('project-title') + '</p>' + response;

                $('#projectDetailsContent').html(projectDetailsHtml);

                var details = JSON.parse(response);

                // Set the values of input fields in the modal form
                $('#description').val(details.data.description);
                $('#keywords').val(details.data.keywords);
                $('#programmes').val(details.data.programmes);
                $('#overview').val(details.data.overview);
                $('#objectives').val(details.data.objectives);
            },
            error: function () {
                alert('Error fetching project details.');
            }
        });
    });

    $('#editDetailsBtn').click(function () {
        if (!editMode) {
            // Enable edit mode
            $('#projectDetailsContent p').each(function () {
                var text = $(this).text().split(': ')[0];
                var fieldValue = $(this).text().split(': ')[1];
                $(this).replaceWith('<div class="form-group"><label for="' + text.toLowerCase() + '">' + text + '</label><textarea class="form-control" id="' + text.toLowerCase() + '">' + fieldValue + '</textarea></div>');
            });

            $(this).text('Save');
        } else {
            // Save changes and exit edit mode
            var updatedDetails = {
                description: $('#description').val(),
                keywords: $('#keywords').val(),
                programmes: $('#programmes').val(),
                overview: $('#overview').val(),
                objectives: $('#objectives').val(),
            };

            // Perform AJAX request to save changes
            $.ajax({
                url: 'save_project_details.php',
                type: 'POST',
                data: {
                    id: projectId,
                    description: updatedDetails.description,
                    keywords: updatedDetails.keywords,
                    programmes: updatedDetails.programmes,
                    overview: updatedDetails.overview,
                    objectives: updatedDetails.objectives
                },
                success: function (response) {
    console.log(response);

    if (response.status === 'success') {
        var detailsHtml = response.data.description + response.data.keywords + response.data.programmes + response.data.overview + response.data.objectives;
        $('#projectDetailsContent').html(detailsHtml);
        $('#editDetailsBtn').text('Edit');

        // Close the modal
        $('#projectDetailsModal').modal('hide');

        // Display a success message (you can customize this based on your needs)
        alert('Changes saved successfully.');
        window.location.reload();
    } else {
        // Display an error message if the server response indicates an error
        alert('Changes saved successfully.');
        window.location.reload();
        $('#projectDetailsModal').modal('hide');

    }
},

            });
        }

        editMode = !editMode;
    });
});

</script>

<script>
   $(document).ready(function () {
    var projectIdToDelete;

    $('.delete-btn').click(function () {
        projectIdToDelete = $(this).data('project-id');
    });
   
    var deleteConfirmationModal = new bootstrap.Modal(document.getElementById('deleteConfirmationModal'));

deleteConfirmationModal._element.addEventListener('hidden.bs.modal', function () {
    // Clear any previous data when the modal is hidden
    // You can remove this line if not needed
    $('#deleteConfirmationModal').find('.modal-body').html('');
    // Clear the projectIdToDelete variable
    projectIdToDelete = undefined;
});

    $('#confirmDeleteBtn').click(function () {
    // Perform AJAX request to delete project
    $.ajax({
        url: 'delete_project.php',
        type: 'POST',
        data: {
            id: projectIdToDelete
        },
        success: function (response) {
            console.log(response);

            if (response.status === 'success') {
                // Close the deleteConfirmationModal on success
                $('#deleteConfirmationModal').modal('hide');

                // Reload the page or update the project list
                window.location.reload();
            } else {
                // Display an error message if the server response indicates an error
                alert('Project Idea Successfully Deleted');
                window.location.reload();
            }
        },
        error: function () {
            // Close the deleteConfirmationModal on error
            $('#deleteConfirmationModal').modal('hide');

            alert('Error deleting project.');
            window.location.reload();
            
        }
    });
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
</body>

</html>


