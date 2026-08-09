<?php

session_start();

// Remove owner session
unset($_SESSION['owner_id']);

// Destroy remaining session data
session_destroy();

// Go back to owner login
header("Location: login.php");
exit();

?>