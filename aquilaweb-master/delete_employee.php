<?php
// Include database connection
include("db.php");

// Get the employee ID from the URL
if (isset($_GET['id'])) {
    $employee_id = $_GET['id'];

    // Make sure the ID is a valid number
    if (is_numeric($employee_id)) {
        // Prepare the DELETE query
        $query = "DELETE FROM employees WHERE id = '$employee_id'";

        // Execute the query and check for success
        if ($con->query($query) === TRUE) {
            // Redirect back to the employee list
            header("Location: all_employees.php");
            exit();
        } else {
            echo "Error deleting record: " . $con->error;
        }
    } else {
        echo "Invalid employee ID.";
    }
} else {
    echo "No employee ID provided.";
}
?>
