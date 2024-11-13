<?php
// update_candidate.php
include("db.php");

// Get the raw POST data
$data = json_decode(file_get_contents('php://input'), true);

if ($data) {
    $id = $data['id'];
    $name = $data['name'];
    $appliedDate = $data['appliedDate'];
    $email = $data['email'];
    $age = $data['age'];
    $contactNumber = $data['contactNumber'];
    $appliedJob = $data['appliedJob'];
    $status = $data['status'];

    // Update the candidate in the database
    $sql = "UPDATE applicants SET name='$name', applied_date='$appliedDate', email='$email', age='$age', 
            contact_number='$contactNumber', applied_job='$appliedJob', status='$status' WHERE id='$id'";

    if ($con->query($sql) === TRUE) {
        echo json_encode(['success' => true, 'status' => $status]);
    } else {
        echo json_encode(['success' => false]);
    }
} else {
    echo json_encode(['success' => false]);
}
?>
