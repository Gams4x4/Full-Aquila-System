<?php
include("db.php"); // Include your database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $age = $_POST['age'];
    $city = $_POST['city'];
    $position = $_POST['position'];
    $salary = $_POST['salary'];
    
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    
    // Insert employee data into the database
    $stmt = $con->prepare("INSERT INTO employees (first_name, last_name, age, city, position, salary, email, phone) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssissdss", $first_name, $last_name, $age, $city, $position, $salary, $email, $phone);
    
    if ($stmt->execute()) {
        echo "<script>
            alert('Employee added successfully!');
            window.location.href = 'ad_employees.php';
        </script>";
    } else {
        echo "<script>
            alert('Failed to add employee. Please try again.');
            window.history.back();
        </script>";
    }

    $stmt->close();
    $con->close();
}
?>
