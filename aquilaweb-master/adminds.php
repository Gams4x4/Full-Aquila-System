<?php
session_start(); // Start the session

// Check if the user is logged in and has the 'admin' role
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    // Redirect to login page if not authorized
    header("Location: login.html");
    exit();
}

// User is authorized - display the admin content
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ADMIN Dashboard</title>
  <link rel="stylesheet" href="CSS/style1.css">
</head>
<body>
  <div class="container">
    <!-- Sidebar -->
    <div class="sidebar">
      <img src="logo.png" alt="Logo">
      <h2>AQUILA CORPS</h2>
      <a href="adminds.php" class="nav-link" id="dashboard-link">ADMIN Dashboard</a>
      <a href="scheduling.php" class="nav-link" id="scheduling-link">Scheduling</a>
      <a href="payment.php" class="nav-link" id="payment-link">Payment</a>
      <a href="settings.php" class="nav-link" id="settings-link">Settings</a>
      <div class="theme-toggle">
        <button>Light</button>
        <button>Dark</button>
      </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
      <div class="header">
      <h1>Hello, <?php echo $_SESSION['username']; ?>! 👋</h1>
        <p>Good Day</p>
      </div>

      <div class="dashboard-cards">
        <div class="card">
          <h3>Projects to Scheduled</h3>
          <div class="value" id="projectsScheduled">0</div>
          <div class="updated">Updated: <span id="lastUpdated"></span></div>
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
      "adminds.php": "dashboard-link",
      "scheduling.php": "scheduling-link",
      "payment.php": "payment-link",
      "settings.php": "settings-link"
    };

    // Set the active class on the link that matches the current page
    if (pageLinkMap[currentPage]) {
      document.getElementById(pageLinkMap[currentPage]).classList.add("active");
    }

    // Function to update "Projects to Scheduled" count and date
    function updateProjectsScheduled() {
      const appointments = JSON.parse(localStorage.getItem("appointments")) || [];
      document.getElementById("projectsScheduled").textContent = appointments.length;
      
      const now = new Date();
      document.getElementById("lastUpdated").textContent = now.toLocaleDateString();
    }

    // Update on page load
    document.addEventListener("DOMContentLoaded", updateProjectsScheduled);

    // Listen for changes in localStorage (for real-time update across tabs)
    window.addEventListener("storage", function(event) {
      if (event.key === "appointments") {
        updateProjectsScheduled();
      }
    });
  </script>
</body>
</html>
