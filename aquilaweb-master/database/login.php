<?php
// Database credentials
$host = "localhost";
$dbname = "aquiladb";
$username = "root";
$password = "";

// Create a connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process login when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $input_username = $_POST['username'];
    $input_password = $_POST['password'];

    // Prepare SQL query to fetch the hashed password and role for the given username
    $sql = "SELECT * FROM user WHERE username = ?"; // Select both password and role
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $input_username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        // Fetch the stored hashed password and role from the database
        $row = $result->fetch_assoc();
        $stored_password_hash = $row['password'];
        $username_id = $row['id'];
        $user_role = $row['role']; // Get the user's role
        $last_name = $row['last_name'];

        // Verify the password using password_verify
        if (password_verify($input_password, $stored_password_hash)) {
            // Login successful - Redirect based on role
            if ($user_role === 'admin') {
                session_start(); // Start a new session
                $_SESSION['username'] = $input_username;
                $_SESSION['role'] = 'admin';
                echo 'success_admin'; // Signal for admin redirect
                exit();
            } else if ($user_role === 'client') { // Explicitly check for client role
                session_start();
                $_SESSION['username'] = $input_username;
                $_SESSION['lastname'] = $last_name;
                $_SESSION['role'] = 'client'; 
                $_SESSION['id'] = $username_id; 
                echo 'success'; // Signal for client redirect
                exit();
            }
        } else {
            // Incorrect password
            echo 'Invalid username or password'; 
            exit();
        }
    } else {
        // Username not found
        echo 'Invalid username or password'; 
        exit();
    }

    $stmt->close();
}

$conn->close();
?>
