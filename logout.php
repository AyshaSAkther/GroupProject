<?php
// Start session 
session_start();

// STOP the session to log the user out
session_destroy();

// Send user back to the home page
header("Location: index.php");
exit();
?>