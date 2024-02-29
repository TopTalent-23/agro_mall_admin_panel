<?php
// Start the session
session_start();

// Destroy all session data
session_destroy();

// Redirect to the admin login page after logout
header("Location: ../");
exit();
?>
