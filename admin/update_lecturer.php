<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Include the database configuration file
    require("config.php");

    // Get the form data
    $lid = $_POST['lid'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $phoneno = $_POST['phoneno'];
    $faculty = $_POST['faculty'];
    $department = $_POST['department'];
    $password = $_POST['password'];
	
    // Perform any necessary data validation here (e.g., check for empty fields, validate email format, etc.)

    // Hash the password for security (you may also use other encryption methods)
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Prepare and execute the SQL query to update the lecturer data in the database
    $updateQuery = "UPDATE lecturer 
                    SET firstname = '$firstname', lastname = '$lastname', email = '$email', phoneno = '$phoneno', 
                    faculty = '$faculty', department = '$department', password = '$password' 
                    WHERE lid = '$lid'";

    $updateResult = mysqli_query($con, $updateQuery);

    if ($updateResult) {
        // Redirect back to the lecturers page with a success message
        header("Location: lecturer.php?success=Lecturer updated successfully");
        exit;
    } else {
        // Redirect back to the lecturers page with an error message
        header("Location: lecturer.php?error=Error updating lecturer");
        exit;
    }
} else {
    // If the form is not submitted, redirect back to the lecturers page
    header("Location: lecturer.php");
    exit;
}
?>
