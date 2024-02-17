<?php
$conn = mysqli_connect("localhost", "root", "", "readify_lms");

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Optional: Set charset to UTF-8
mysqli_set_charset($conn, "utf8");
?>
