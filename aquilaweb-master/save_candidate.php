<?php
// Include database connection
include("db.php");

// Get the raw POST data from the request
$data = json_decode(file_get_contents('php://input'), true);

// Check if the necessary data is present
if (isset($data['name'], $data['appliedDate'], $data['email'], $data['age'], $data['contact'], $data['appliedJob'], $data['status'])) {
    $name = $data['name'];
    $appliedDate = $data['appliedDate'];
    $email = $data['email'];
    $age = $data['age'];
    $contact = $data['contact'];
    $appliedJob = $data['appliedJob'];
    $status = $data['status'];

    // If we have a candidateId (for editing), we update the candidate
    if (!empty($data['candidateId'])) {
        $candidateId = $data['candidateId'];
        $sql = "UPDATE applicants SET name = ?, applied_date = ?, email = ?, age = ?, contact_number = ?, applied_job = ?, status = ? WHERE id = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("ssssiisi", $name, $appliedDate, $email, $age, $contact, $appliedJob, $status, $candidateId);
    } else {
        // Otherwise, we insert a new candidate
        $sql = "INSERT INTO applicants (name, applied_date, email, age, contact_number, applied_job, status) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("ssssiis", $name, $appliedDate, $email, $age, $contact, $appliedJob, $status);
    }

    // Execute the statement
    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => $stmt->error]);
    }

    $stmt->close();
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid input']);
}

$con->close();
?>
