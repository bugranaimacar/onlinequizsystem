<?php
// Initialize the session
session_start();
 
// Unset all of the session variables
unset($_SESSION['examid']);
$_SESSION['basari'] = 1;
	 header('Location: exams.php');
	 
// Redirect to login page
header("location: exams.php");
exit;
?>