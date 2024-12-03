<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Include the database configuration file
    require("config.php");

    // Get the form data
    $studentId = $_POST['studentId'];
    $firstname = $_POST['editFirstName'];
    $lastname = $_POST['editLastName'];
    $email = $_POST['editEmail'];
    $phoneno = $_POST['editPhone'];
    $password = $_POST['editPassword'];
    
    // Perform any necessary data validation here (e.g., check for empty fields, validate email format, etc.)

    // Hash the password for security (you may also use other encryption methods)
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Prepare and execute the SQL query to update the student data in the database
    $updateQuery = "UPDATE student SET firstname = '$firstname', lastname = '$lastname', email = '$email', phoneno = '$phoneno', password = '$password' WHERE sid = '$studentId'";
    
    $updateResult = mysqli_query($con, $updateQuery);

    if ($updateResult) {
        // Redirect back to the students page with a success message
        header("Location: student.php?success=Student details updated successfully");
        exit;
    } else {
        // Redirect back to the students page with an error message
        header("Location: student.php?error=Error updating student details");
        exit;
    }
} else {
    // If the form is not submitted, redirect back to the students page
    header("Location: student.php");
    exit;
}
?>
