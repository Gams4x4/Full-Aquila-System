<?php
// ... (database connection code) ...

$username = "admin1"; 
$password = "peru";

// Hash the password
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

echo "HASHED: " . $hashed_password ;


?>
