<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Include the database configuration file
    require("config.php");

    // Get the form data
    $aid = $_POST['aid'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $phoneno = $_POST['phoneno'];
    $password = $_POST['password'];
    $photo = $_POST['photo']; // Assuming you have a file upload for the photo
    $address = $_POST['address'];

    // Prepare and execute the SQL query to update the admin data in the database
    $updateQuery = "UPDATE admin SET firstname = '$firstname', lastname = '$lastname', email = '$email', phoneno = '$phoneno', password = '$password', photo = '$photo', address = '$address' WHERE aid = '$aid'";
    $updateResult = mysqli_query($con, $updateQuery);

    if ($updateResult) {
        // Redirect back to the admins page with a success message
        header("Location: admin.php?success=Admin updated successfully");
        exit;
    } else {
        // Redirect back to the admins page with an error message
        header("Location: admin.php?error=Error updating admin");
        exit;
    }
} else {
    // If the form is not submitted, redirect back to the admins page
    header("Location: admin.php");
    exit;
}
?>