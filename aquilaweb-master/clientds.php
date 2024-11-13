<?php
session_start(); // Start the session

// Check if the user is logged in AND has the 'client' role
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'client') {
    // Redirect to login page if not authorized 
    header("Location: login.html"); 
    exit();
}

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

// Fetch the number of appointments for the logged-in client
$clientId = $_SESSION['id'];
$sql = "SELECT COUNT(*) AS appointment_count FROM appointments WHERE client_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $clientId);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$appointmentCount = $row['appointment_count'];


// Fetch the latest created_at date for the logged-in client
$clientId = $_SESSION['id'];
$sql = "SELECT MAX(created_at) AS latest_created_at FROM appointments WHERE client_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $clientId);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$latestCreatedAt = $row['latest_created_at'];

// User is authorized as a client - display the client dashboard content
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Client Dashboard</title>
  <link rel="stylesheet" href="CSS/style1.css">
</head>
<body>
  <div class="container">
    <!-- Sidebar -->
    <div class="sidebar">
      <img src="IMG/aquila.png" alt="Logo">
      <h2>AQUILA CORPS</h2>
      <a href="clientds.php" class="nav-link" id="dashboard-link">CLIENT Dashboard</a>
      <a href="clscheduling.php" class="nav-link" id="scheduling-link">Scheduling</a>
      <a href="clpayment.php" class="nav-link" id="payment-link">Payment</a>
      <a href="login.html" class="nav-link" id="settings-link">Logout</a>
      <div class="theme-toggle">
        <button>Light</button>
        <button>Dark</button>
      </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
      <div class="header">
        <h1>Hello, <?php echo $_SESSION['lastname']; ?>! 👋</h1>
        <p>Good Day</p>
      </div>

      <div class="dashboard-cards">
        <div class="card">
          <h3>Projects to Scheduled</h3>
          <div class="value" id="projectsScheduled"><?php echo $appointmentCount; ?></div>
          <div class="updated">Updated: <?php echo date('F j, Y', strtotime($latestCreatedAt)); ?></span></div>
        </div>
        <div class="card">
          <h3>Paid Projects</h3>
          <div class="value" id="paidProjects">1</div>
          <div class="updated">Updated: July 14, 2023</div>
        </div>
      </div>
    </div>
  </div>

  <script>
    // Highlight the active link in the sidebar based on the current page
    const currentPage = window.location.pathname.split("/").pop();
    
    // Map page names to link IDs
    const pageLinkMap = {
      "clientds.php": "dashboard-link",
      "clscheduling.php": "scheduling-link",
      "clpayment.php": "payment-link",
      "clsettings.php": "settings-link"
    };

    // Set the active class on the link that matches the current page
    if (pageLinkMap[currentPage]) {
      document.getElementById(pageLinkMap[currentPage]).classList.add("active");
    }


  </script>
</body>
</html>
