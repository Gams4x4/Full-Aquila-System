<?php
// Include database connection
include("db.php");

session_start();

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AQUILA CORPS</title>
    <link rel="stylesheet" href="CSS/adapplicants.css">
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
        <p>Applicants</p>
        <div class="container">
        <!-- Add Candidate Button -->
        <button class="add-candidate-btn" onclick="openModal()">Add Candidate</button>

        <!-- Candidate Table -->
        <table class="candidate-table">
            <thead>
                <tr class="heading">
                    
                    <th>ID</th>
                    <th>Candidate Name</th>
                    <th>Applied Date</th>
                    <th>Email Address</th>
                    <th>Age</th>
                    <th>Contact Number</th>
                    <th>Applied Job</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="candidate-table-body">
    <?php
    $sql = "SELECT * FROM applicants";
    $result = $con->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                <td>{$row['id']}</td>
                <td>{$row['name']}</td>
                <td>{$row['applied_date']}</td>
                <td>{$row['email']}</td>
                <td>{$row['age']}</td>
                <td>{$row['contact_number']}</td>
                <td>{$row['applied_job']}</td>
                <td class='status status-" . strtolower(str_replace(' ', '-', $row['status'])) . "'>{$row['status']}</td>
                <td><button onclick='openModal(true, this.parentElement.parentElement)'>Edit</button> <button onclick='deleteCandidate(this.parentElement.parentElement)'>Delete</button></td>
            </tr>";
        }
    }
    ?>
</tbody>

        </table>
        </div>
    </div>
</div>  

<!-- Add/Edit Candidate Modal -->
<div class="modal" id="addCandidateModal">
    <div class="modal-content">
        <h3 id="modalTitle">Add Candidate</h3>
        <input type="text" id="candidateName" placeholder="Candidate Name" required>
        <input type="hidden" id="candidateId" />
        <input type="date" id="appliedDate" required>
        <input type="email" id="emailAddress" placeholder="Email Address" required>
        <input type="number" id="age" placeholder="Age" required>
        <input type="text" id="contactNumber" placeholder="Contact Number" required>
        <input type="text" id="appliedJob" placeholder="Applied Job" required>
        <select id="status">
            <option value="In Process">In Process</option>
            <option value="Selected">Selected</option>
            <option value="Rejected">Rejected</option>
        </select>
        <button onclick="saveCandidate()">Save</button>
        <button class="close-btn" onclick="closeModal()">Cancel</button>
    </div>
</div>

<script>
    let editingRow = null;

    function openModal(isEdit = false, row = null) {
        if (isEdit) {
            editingRow = row;
            document.getElementById('modalTitle').textContent = 'Edit Candidate';
            document.getElementById('candidateName').value = row.cells[1].textContent;
            document.getElementById('appliedDate').value = row.cells[2].textContent;
            document.getElementById('emailAddress').value = row.cells[3].textContent;
            document.getElementById('age').value = row.cells[4].textContent;
            document.getElementById('contactNumber').value = row.cells[5].textContent;
            document.getElementById('appliedJob').value = row.cells[6].textContent;
            document.getElementById('status').value = row.cells[7].textContent;
            document.getElementById('candidateId').value = row.cells[0].textContent;
        } else {
            document.getElementById('candidateName').value = '';
            document.getElementById('appliedDate').value = '';
            document.getElementById('emailAddress').value = '';
            document.getElementById('age').value = '';
            document.getElementById('contactNumber').value = '';
            document.getElementById('appliedJob').value = '';
            document.getElementById('status').value = 'In Process';
            document.getElementById('candidateId').value = '';
        }

        document.getElementById('addCandidateModal').style.display = 'flex';
    }

    function closeModal() {
        document.getElementById('addCandidateModal').style.display = 'none';
    }

    function saveCandidate() {
        const name = document.getElementById('candidateName').value;
        const appliedDate = document.getElementById('appliedDate').value;
        const email = document.getElementById('emailAddress').value;
        const age = document.getElementById('age').value;
        const contactNumber = document.getElementById('contactNumber').value;
        const appliedJob = document.getElementById('appliedJob').value;
        const status = document.getElementById('status').value;
        const id = document.getElementById('candidateId').value;

        const data = {
            name,
            appliedDate,
            email,
            age,
            contactNumber,
            appliedJob,
            status,
            id
        };

        let url = "add_candidate.php"; // Default URL to add new
        if (id) {
            url = "update_candidate.php"; // URL for updating candidate
        }

        fetch(url, {
            method: 'POST',
            body: JSON.stringify(data),
            headers: {
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                if (id) {
                    // Update the row if editing
                    const statusClass = result.status.toLowerCase().replace(' ', '-');
                    editingRow.cells[1].textContent = name;
                    editingRow.cells[2].textContent = appliedDate;
                    editingRow.cells[3].textContent = email;
                    editingRow.cells[4].textContent = age;
                    editingRow.cells[5].textContent = contactNumber;
                    editingRow.cells[6].textContent = appliedJob;
                    editingRow.cells[7].textContent = status;
                    editingRow.cells[7].className = 'status ' + statusClass;
                } else {
                    // Add a new row if adding
                    const tableBody = document.getElementById('candidate-table-body');
                    const newRow = document.createElement('tr');
                    newRow.innerHTML = `
                        <td>${result.id}</td>
                        <td>${name}</td>
                        <td>${appliedDate}</td>
                        <td>${email}</td>
                        <td>${age}</td>
                        <td>${contactNumber}</td>
                        <td>${appliedJob}</td>
                        <td class="status ${status.toLowerCase().replace(' ', '-')}"">${status}</td>
                        <td><button onclick="openModal(true, this.parentElement.parentElement)">Edit</button> <button onclick="deleteCandidate(this.parentElement.parentElement)">Delete</button></td>
                    `;
                    tableBody.appendChild(newRow);
                }
                closeModal();
            } else {
                alert('Failed to save candidate.');
            }
        });
    }

    function deleteCandidate(row) {
        const id = row.cells[0].textContent;

        if (confirm("Are you sure you want to delete this candidate?")) {
            fetch('delete_candidate.php', {
                method: 'POST',
                body: JSON.stringify({ id }),
                headers: {
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(result => {
                if (result.success) {
                    row.remove();
                } else {
                    alert('Failed to delete candidate.');
                }
            });
        }
    }
</script>

</body>
</html>
