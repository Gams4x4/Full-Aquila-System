<?php
include("db.php");
$result = $con->query("SELECT * FROM applicants");
$applicants = $result->fetch_all(MYSQLI_ASSOC);
echo json_encode($applicants);
?>
