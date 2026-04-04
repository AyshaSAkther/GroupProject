<?php
// Connect to the database
$conn = mysqli_connect("localhost", "root", "", "donation_db");

// Stop the page if the connection fails
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>