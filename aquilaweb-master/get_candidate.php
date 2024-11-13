<?php
include("db.php");

$query = "SELECT * FROM applicants";
$result = $conn->query($query);
$applicants = [];

while ($row = $result->fetch_assoc()) {
    $applicants[] = $row;
}

echo json_encode($applicants);
$conn->close();
?>
