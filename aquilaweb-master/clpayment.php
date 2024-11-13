<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Payment</title>
  <link rel="stylesheet" href="CSS/style3.css">
</head>
<body>
  <div class="container">
    <!-- Sidebar -->
    <div class="sidebar">
      <img src="logo.png" alt="Logo">
      <h2>AQUILA CORPS</h2>
      <a href="clientds.php" class="nav-link">Dashboard</a>
      <a href="clscheduling.php" class="nav-link">Scheduling</a>
      <a href="clpayment.php" class="nav-link active">Payment</a>
      <a href="settings.php" class="nav-link">Settings</a>
      <div class="theme-toggle">
        <button>Light</button>
        <button>Dark</button>
      </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
      <div class="header">
        <h1>Payment</h1>
        <p>Review and manage your payment records here.</p>
      </div>

      <div class="content-section">
        <h3>Recent Transactions</h3>
        <ul class="transactions-list">
          <li>Project Alpha - Paid - $1000 - July 20, 2023</li>
          <li>Project Beta - Pending - $500 - August 10, 2023</li>
          <li>Project Gamma - Paid - $800 - August 15, 2023</li>
        </ul>
      </div>
    </div>
  </div>
</body>
</html>
