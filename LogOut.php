<?php
session_start();
?>

<?php
//Remove all session variables
session_unset();

//Destroy the session
session_destroy();

//Redirect to login page
header('Location: JoinPage.php');
?>