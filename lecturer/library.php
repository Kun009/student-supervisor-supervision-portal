<?php
session_start();
require("config.php");

// Check if the user is logged in
if (!isset($_SESSION['lid'])) {
    header("location:index.php");
    exit;
}
// Retrieve the final project reports from the projects table (excluding empty, null, and N/A)
$query = "SELECT final_report FROM projects WHERE final_report IS NOT NULL AND final_report <> '' AND final_report <> 'N/A'";
$result = mysqli_query($con, $query);

if (!$result) {
    // Handle the case when the query doesn't return any rows or an error occurred
    exit('Error fetching final project reports');
}

// Create an array to store the final reports
$finalReports = array();

// Fetch the final reports and add them to the array
while ($row = mysqli_fetch_assoc($result)) {
    $finalReports[] = $row['final_report'];
}

// Define the available categories
$categories = array("Reports", "Articles", "Journals", "Books", "Publications");

// Define the external resources with their respective links
$externalResources = array(
    "Google Scholar" => "https://scholar.google.com/",
    "JSTOR" => "https://www.jstor.org/",
    "Library of Congress" => "https://www.loc.gov/",
    "PubMed Central" => "https://www.ncbi.nlm.nih.gov/pmc/",
    "Science.gov" => "https://www.science.gov/",
    "Digital Commons Network" => "https://network.bepress.com/",
    "ResearchGate" => "https://www.researchgate.net/",
    "WorldCat" => "https://www.worldcat.org/",
    "Your University Library" => "https://www.youruniversitylibrary.com/"
);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, sid-scalable=0">
    <title>Lecturer- Library</title>
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
    <!-- Bootstrap CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
<!-- jQuery -->
<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.min.js"></script>
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

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
                            <h3 class="page-title">Library</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                                <li class="breadcrumb-item active">Library</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- /Page Header -->
<!-- Add Report Button -->
<div class="mb-3">
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addReportModal">
        Add Report
    </button>
</div>

             <!-- Search and Filter -->
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <input type="text" class="form-control" id="searchInput" placeholder="Search">
                    <button type="button" class="btn btn-primary" id="searchButton">Search</button>

                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <select class="form-control" id="categoryFilter">
                        <option value="">All Categories</option>
                        <?php foreach ($categories as $category) { ?>
                            <option value="<?php echo $category; ?>"><?php echo $category; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
           
        </div>
    </div>
</div>
<!-- Add this div where you want to display search results -->
<div class="library-content"></div>

<!-- Rest of your HTML code... -->

<!-- /Search and Filter -->

           <!-- Library Content -->
<div class="row">
    <div class="col-md-8">
        <?php
        // Fetch and display project reports with their corresponding project titles
        $reportsQuery = "SELECT project_title, final_report FROM projects WHERE final_report IS NOT NULL AND final_report <> '' AND final_report <> 'N/A'";
        $reportsResult = mysqli_query($con, $reportsQuery);

        if ($reportsResult && mysqli_num_rows($reportsResult) > 0) {
            while ($report = mysqli_fetch_assoc($reportsResult)) {
                ?>
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title"><?php echo $report['project_title']; ?></h4>
                        <p><?php echo $report['final_report']; ?></p>
                    </div>
                    <div class="card-footer">
                       
                        <a href="<?php echo $report['final_report']; ?>" target="_blank" class="btn btn-success">Download</a>
                        
                    </div>
                </div>
                <?php
            }
        } else {
            echo "<p>No project reports found.</p>";
        }
        ?>
    </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">External Resources</h4>
                    <ul class="list-group">
                        <?php foreach ($externalResources as $resourceName => $resourceLink) { ?>
                            <li class="list-group-item">
                                <a href="<?php echo $resourceLink; ?>" target="_blank"><?php echo $resourceName; ?></a>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /Library Content -->

<!-- Add Report Modal -->
<div class="modal fade" id="addReportModal" tabindex="-1" aria-labelledby="addReportModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addReportModalLabel">Add Project Report</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="add_report.php" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="projectTitle" class="form-label">Project Title</label>
                        <input type="text" class="form-control" id="projectTitle" name="project_title" required>
                    </div>
                    <div class="mb-3">
                        <label for="report" class="form-label">Upload Project Report</label>
                        <input type="file" class="form-control" id="report" name="report" required>
                    </div>
                    <!-- Add more input fields for other report details as needed -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add Report</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- ... (Rest of the code remains the same) ... -->

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
    <script src="https://cdn.jsdelivr.net/npm/typeahead.js@0.11.1/dist/typeahead.bundle.min.js"></script>

    <!-- Custom JS -->
    <script src="assets/js/script.js"></script>
    <script>
    // Define an array of available project reports for predictive search
    var availableReports = <?php echo json_encode($finalReports); ?>;

    // Initialize typeahead for predictive search
    // Initialize typeahead for predictive search
$(document).ready(function () {
    // Initialize typeahead for predictive search
    var reports = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        local: availableReports
    });

    $('#searchInput').typeahead({
        hint: true,
        highlight: true,
        minLength: 1
    }, {
        name: 'reports',
        source: reports
    });

    // Add an event listener for the search button
    $('#searchButton').click(function () {
        searchReports();
    });

    // Add an event listener for the category filter change
    $('#categoryFilter').change(function () {
        searchReports();
    });
});

// Function to perform search based on user input
function searchReports() {
    var searchTerm = $('#searchInput').val();
    var categoryFilter = $('#categoryFilter').val();

    // Perform an AJAX request to fetch search results
    $.ajax({
        type: 'POST',
        url: 'search_reports.php',
        data: { search: searchTerm, category: categoryFilter },
        dataType: 'json',
        success: function (response) {
            console.log('Search Response:', response); // Log the response to the console
            // Update the content with the search results
            updateLibraryContent(response);
        },
        error: function (error) {
            console.error('Error performing search:', error);
        }
    });
}

// Function to update library content based on search results
function updateLibraryContent(searchResults) {
    var libraryContent = $('.library-content');

    // Clear existing content
    libraryContent.empty();

    // Check if there are search results
    if (searchResults.length > 0) {
        $.each(searchResults, function (index, result) {
            var card = $('<div class="card">');
            var cardBody = $('<div class="card-body">');
            var cardTitle = $('<h4 class="card-title">').text(result.project_title);
            var cardText = $('<p>').text(result.final_report);

            cardBody.append(cardTitle, cardText);

            // Add download and preview buttons
            var downloadButton = $('<a href="' + result.final_report + '" target="_blank" class="btn btn-success">Download</a>');
            var previewButton = $('<a href="#" class="btn btn-info">Preview</a>');

            // Append buttons to card footer
            var cardFooter = $('<div class="card-footer">');
            cardFooter.append(downloadButton, previewButton);

            card.append(cardBody, cardFooter);
            libraryContent.append(card);
        });
    } else {
        // Display a message when no results are found
        libraryContent.append('<p>No matching results found.</p>');
    }
}


</script>
</body>
</html>


