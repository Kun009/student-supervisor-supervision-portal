<?php
// search_reports.php

// Include the database configuration
require("config.php");

// Get the search term and category from the AJAX request
$searchTerm = $_POST['search'];
$categoryFilter = $_POST['category'];

// Prepare the SQL query
$query = "SELECT project_title, final_report FROM projects WHERE final_report IS NOT NULL AND final_report <> '' AND final_report <> 'N/A'";

// Add conditions for search term and category, if they are provided
if (!empty($searchTerm)) {
    $query .= " AND project_title LIKE '%$searchTerm%'";
}

if (!empty($categoryFilter)) {
    $query .= " AND category = '$categoryFilter'";
}

// Execute the query
$result = mysqli_query($con, $query);

if ($result) {
    // Fetch and return the search results
    $searchResults = array();

    while ($row = mysqli_fetch_assoc($result)) {
        $searchResults[] = $row;
    }

    echo json_encode($searchResults);
} else {
    // Handle the case when the query fails
    echo "Error executing search query";
}

// Close the database connection
mysqli_close($con);
?>
