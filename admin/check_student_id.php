<?php
require("config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["sid"])) {
    $sid = mysqli_real_escape_string($con, $_POST["sid"]);
    $checkQuery = "SELECT sid FROM student WHERE sid = '$sid'";
    $checkResult = mysqli_query($con, $checkQuery);

    if (mysqli_num_rows($checkResult) > 0) {
        // Student ID already exists
        echo "exists";
    } else {
        // Student ID is unique
        echo "unique";
    }
} else {
    // Handle invalid or missing POST data
    echo "error";
}
?>
