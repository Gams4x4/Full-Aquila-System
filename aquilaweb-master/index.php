<?php

// Define the path to your login.php file
$login_path = 'login.html'; 

// Redirect the user to the login page
header("Location: " . $login_path);
exit;

?>