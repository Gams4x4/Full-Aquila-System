<?php
// add_candidate.php
include("db.php");

// Get the raw POST data
$data = json_decode(file_get_contents('php://input'), true);

if ($data) {
    $name = $data['name'];
    $appliedDate = $data['appliedDate'];
    $email = $data['email'];
    $age = $data['age'];
    $contactNumber = $data['contactNumber'];
    $appliedJob = $data['appliedJob'];
    $status = $data['status'];

    // Insert into the database
    $sql = "INSERT INTO applicants (name, applied_date, email, age, contact_number, applied_job, status) 
            VALUES ('$name', '$appliedDate', '$email', '$age', '$contactNumber', '$appliedJob', '$status')";
    if ($con->query($sql) === TRUE) {
        // Respond with success
        echo json_encode(['success' => true, 'id' => $con->insert_id]);
    } else {
        // Respond with failure
        echo json_encode(['success' => false]);
    }
} else {
    echo json_encode(['success' => false]);
}
?>
