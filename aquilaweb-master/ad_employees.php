<?php
// Include database connection
include("db.php");

session_start();

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.html");
    exit();
}

// Check if there is a search query
$searchQuery = isset($_GET['search']) ? $_GET['search'] : '';

// Prepare SQL query with search functionality
if (!empty($searchQuery)) {
    // Using CONCAT to match first name and last name as a single string for full name search
    $stmt = $con->prepare("SELECT * FROM employees WHERE CONCAT(first_name, ' ', last_name) LIKE ?");
    $searchTerm = '%' . $searchQuery . '%';
    $stmt->bind_param("s", $searchTerm);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    // Default query to select all employees if no search term is provided
    $result = $con->query("SELECT * FROM employees");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employees - AQUILA CORPS</title>
    <link rel="stylesheet" href="CSS/all_employees.css"> <!-- Link to the CSS file -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
</head>
<body>

<!-- Sidebar -->
<div class="sidebar">
    <h1>
        <img src="IMG/aquila.png" alt="Logo">
        AQUILA CORPS
    </h1>
    <a href="ad_dashboard.php"><p>Dashboard</p></a>
    <a href="ad_employees.php"><p>Employees</p></a>
    <a href="ad_applicants.php"><p>Applicants</p></a>
    <a href="all_departments.php"><p>Departments</p></a>
    <a href="attendance.php"><p>Attendance</p></a>
    <a href="jobs.php"><p>Jobs</p></a>
    
    <a href="leaves.php"><p>Leaves</p></a>
    
    <a href="login.html"><p>Logout</p></a>
</div>

<!-- Main Content -->
<div class="main-content">
    <div class="content-overlay">
        <p>Employees</p>
        <div class="container">
            <header>
                <div class="filterEntries">
                    <div class="entries">
                        Show 
                        <select id="table_size">
                            <option value="10">10</option>
                            <option value="20">20</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select> 
                        entries
                    </div>
                    <div class="srch_btn">
                        <form action="ad_employees.php" method="get" id="searchForm">
                            <label for="search">Search Employee:</label>
                            <input type="search" id="search" name="search" placeholder="Enter full name" value="<?php echo htmlspecialchars($searchQuery); ?>">
                            <button type="submit">Search</button>
                            <button type="button" onclick="clearSearch()">Cancel</button>
                        </form>
                    </div>
                </div>
                <div class="addMemberBtn">
                    <button onclick="openAddEmployeePopup()">Add Employee</button>
                </div>
            </header>
            <table>
                <thead>
                    <tr class="heading">
                        <th>Number</th>
                        <th>Full Name</th>
                        <th>Age</th>
                        <th>City</th>
                        <th>Position</th>
                        <th>Salary</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody class="userInfo">
                    <?php
                    $i = 1;
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $i++ . "</td>";
                        echo "<td>" . htmlspecialchars($row['first_name']) . " " . htmlspecialchars($row['last_name']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['age']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['city']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['position']) . "</td>";
                        echo "<td>" . number_format($row['salary'], 0, '.', ',') . "</td>";
                        echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['phone']) . "</td>";
                        echo "<td>
                            <button onclick=\"openEditEmployeePopup(" . $row['id'] . ", '" . addslashes($row['first_name']) . "', '" . addslashes($row['last_name']) . "', '" . $row['age'] . "', '" . addslashes($row['city']) . "', '" . addslashes($row['position']) . "', '" . $row['salary'] . "', '" . $row['email'] . "', '" . $row['phone'] . "')\">Edit</button>
                            <a href='delete_employee.php?id=" . $row['id'] . "'><button>Delete</button></a>
                        </td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
            <footer>
                <span class="showEntries">Showing 1 to 10 of 50 entries</span>
                <div class="pagination">
                    <!-- Pagination buttons can be dynamically generated -->
                </div>
            </footer>
        </div>
    </div>
</div>

<!-- Edit Employee Popup Form -->
<div class="dark_bg" id="editEmployeePopup" style="display: none;">
    <div class="popup">
        <header>
            <h2 class="modalTitle">Edit Employee</h2>
            <button class="closeBtn" onclick="closeEditEmployeePopup()">&times;</button>
        </header>
        <div class="body">
            <form action="edit_employee.php" method="POST" enctype="multipart/form-data" id="editEmployeeForm">
                <input type="hidden" name="id" id="editId">
                <div class="form_control">
                    <label for="editFName">First Name:</label>
                    <input type="text" name="first_name" id="editFName" required>
                </div>
                <div class="form_control">
                    <label for="editLName">Last Name:</label>
                    <input type="text" name="last_name" id="editLName" required>
                </div>
                <div class="form_control">
                    <label for="editAge">Age:</label>
                    <input type="number" name="age" id="editAge" required>
                </div>
                <div class="form_control">
                    <label for="editCity">City:</label>
                    <input type="text" name="city" id="editCity" required>
                </div>
                <div class="form_control">
                    <label for="editPosition">Position:</label>
                    <input type="text" name="position" id="editPosition" required>
                </div>
                <div class="form_control">
                    <label for="editSalary">Salary:</label>
                    <input type="text" name="salary" id="editSalary" required>
                </div>
                <div class="form_control">
                    <label for="editEmail">Email:</label>
                    <input type="email" name="email" id="editEmail" required>
                </div>
                <div class="form_control">
                    <label for="editPhone">Phone:</label>
                    <input type="number" name="phone" id="editPhone" required>
                </div>
                <button type="submit" class="submitBtn">Save Changes</button>
            </form>
        </div>
    </div>
</div>

<!-- Add Employee Popup Form -->
<div class="dark_bg" id="addEmployeePopup" style="display: none;">
    <div class="popup">
        <header>
            <h2 class="modalTitle">Add New Employee</h2>
            <button class="closeBtn" onclick="closeAddEmployeePopup()">&times;</button>
        </header>
        <div class="body">
            <form action="add_employee.php" method="POST" enctype="multipart/form-data" id="addEmployeeForm">
                <div class="form_control">
                    <label for="fName">First Name:</label>
                    <input type="text" name="first_name" id="fName" required>
                </div>
                <div class="form_control">
                    <label for="lName">Last Name:</label>
                    <input type="text" name="last_name" id="lName" required>
                </div>
                <div class="form_control">
                    <label for="age">Age:</label>
                    <input type="number" name="age" id="age" required>
                </div>
                <div class="form_control">
                    <label for="city">City:</label>
                    <input type="text" name="city" id="city" required>
                </div>
                <div class="form_control">
                    <label for="position">Position:</label>
                    <input type="text" name="position" id="position" required>
                </div>
                <div class="form_control">
                    <label for="salary">Salary:</label>
                    <input type="text" name="salary" id="salary" required>
                </div>
                <div class="form_control">
                    <label for="email">Email:</label>
                    <input type="email" name="email" id="email" required>
                </div>
                <div class="form_control">
                    <label for="phone">Phone:</label>
                    <input type="number" name="phone" id="phone" required>
                </div>
                <button type="submit" class="submitBtn">Add Employee</button>
            </form>
        </div>
    </div>
</div>

<!-- JavaScript for Popup Forms and Clear Search -->
<script>
function openEditEmployeePopup(id, firstName, lastName, age, city, position, salary, email, phone) {
    document.getElementById('editEmployeePopup').style.display = 'flex';

    document.getElementById('editId').value = id;
    document.getElementById('editFName').value = firstName;
    document.getElementById('editLName').value = lastName;
    document.getElementById('editAge').value = age;
    document.getElementById('editCity').value = city;
    document.getElementById('editPosition').value = position;
    document.getElementById('editSalary').value = salary;
    document.getElementById('editEmail').value = email;
    document.getElementById('editPhone').value = phone;
    
}

function closeEditEmployeePopup() {
    document.getElementById('editEmployeePopup').style.display = 'none';
}

function openAddEmployeePopup() {
    document.getElementById('addEmployeePopup').style.display = 'flex';
}

function closeAddEmployeePopup() {
    document.getElementById('addEmployeePopup').style.display = 'none';
}

function clearSearch() {
    // Redirect to the same page without search parameters
    window.location.href = 'ad_employees.php';
}
</script>

</body>
</html>
