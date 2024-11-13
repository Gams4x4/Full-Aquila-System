<?php
include("db.php");  // Ensure you include the database connection

// Get the search query from the GET request
$searchQuery = isset($_GET['q']) ? $_GET['q'] : '';

// Prepare the SQL query to search by full name (first name + last name)
$sql = "SELECT * FROM employees WHERE CONCAT(first_name, ' ', last_name) LIKE '%$searchQuery%'";

// Execute the query
$result = $con->query($sql);
$i = 1;
$output = '';  // Initialize output variable to store HTML rows

// Loop through the results and generate HTML table rows
while ($row = $result->fetch_assoc()) {
    $output .= "<tr>";
    $output .= "<td>" . $i++ . "</td>";
    $output .= "<td>" . htmlspecialchars($row['first_name']) . " " . htmlspecialchars($row['last_name']) . "</td>";
    $output .= "<td>" . htmlspecialchars($row['age']) . "</td>";
    $output .= "<td>" . htmlspecialchars($row['city']) . "</td>";
    $output .= "<td>" . htmlspecialchars($row['position']) . "</td>";
    $output .= "<td>" . number_format($row['salary'], 0, '.', ',') . "</td>";
    $output .= "<td>" . htmlspecialchars($row['email']) . "</td>";
    $output .= "<td>" . htmlspecialchars($row['phone']) . "</td>";
    $output .= "<td>
                 <button onclick=\"openEditEmployeePopup(" . $row['id'] . ", '" . addslashes($row['first_name']) . "', '" . addslashes($row['last_name']) . "', '" . $row['age'] . "', '" . addslashes($row['city']) . "', '" . addslashes($row['position']) . "', '" . $row['salary'] . "', '"  . $row['email'] . "', '" . $row['phone'] . "')\">Edit</button>
                 <a href='delete_employee.php?id=" . $row['id'] . "'><button>Delete</button></a>
                 </td>";
    $output .= "</tr>";
}

// Return the generated HTML rows to the front-end
echo $output;
?>
