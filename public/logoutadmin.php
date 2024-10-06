<?php
session_start();
$_SESSION = array(); // clear all session data using empty array
session_destroy(); //remove all session entries
header('Location: adminlogin.php');
exit(); // terminate script run

// simply: This code starts a session, clears all session variables,
// destroys the session, and then halts the script execution,
// effectively logging the user out.
?>