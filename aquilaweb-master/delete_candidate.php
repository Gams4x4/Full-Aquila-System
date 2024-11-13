<?php
// Include database connection
include("db.php");

// Get the raw POST data from the request
$data = json_decode(file_get_contents('php://input'), true);

// Check if the candidate ID is provided
if (isset($data['id'])) {
    $candidateId = $data['id'];

    // Delete the candidate from the database
    $sql = "DELETE FROM applicants WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $candidateId);

    // Execute the statement
    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => $stmt->error]);
    }

    $stmt->close();
} else {
    echo json_encode(['success' => false, 'error' => 'No candidate ID provided']);
}

$conn->close();
?>
