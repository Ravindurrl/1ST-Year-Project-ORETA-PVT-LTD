<?php
session_start();


if (!isset($_SESSION['username']) || $_SESSION['role'] != 'Supervisor') {
    header("Location: splogin.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supervisor Dashboard</title>
    <link rel="stylesheet" href="dshboard.css">
</head>
<body>
    <!-- Sidebar Navigation -->
    <div class="sidebar">
        <h2>Supervisor Dashboard</h2>
        <ul class="sidebar-links">
            <li><a href="employeeschedule.php">Employee Schedule</a></li>
            <li><a href="supervisorleave.php">Leave Requests</a></li>
            <li><a href="timesheets.php">Timesheet Management</a></li>
            <li><a href="productreq.php">Product Request</a></li>
        </ul>
        <!-- Logout Button -->
        <a href="splogout.php" class="logout-btn">Logout</a>
    </div>

    <!-- Main Content Area -->
    <div class="main-content">
        <header>
            <h1>Welcome, Supervisor</h1>
            <p>Manage employee schedules, leave requests, and timesheets.</p>
        </header>

        <!-- Dashboard Cards -->
        <section class="dashboard-cards">
            <div class="card">
                <h3>Employee Schedule</h3>
                <p>View, create, and update employee schedules.</p>
                <a href="employeeschedule.php" class="card-link">Manage Schedule</a>
            </div>
            <div class="card">
                <h3>Leave Requests</h3>
                <p>Review and approve employee leave requests.</p>
                <a href="supervisorleave.php" class="card-link">View Requests</a>
            </div>
            <div class="card">
                <h3>Timesheet Management</h3>
                <p>Submit and approve employee timesheets.</p>
                <a href="timesheets.php" class="card-link">Manage Timesheets</a>
            </div>
            <div class="card">
                <h3>Request Product</h3>
                <p>Request Product from supplier .</p>
                <a href="productreq.php" class="card-link">Product Request</a>
            </div>
        </section>
    </div>
</body>
</html>
