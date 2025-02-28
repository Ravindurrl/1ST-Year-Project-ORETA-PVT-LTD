<?php
session_start();


if (!isset($_SESSION['username']) || $_SESSION['role'] != 'Employee') {
    header("Location: emplogin.php");
    exit;
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Dashboard</title>
    <link rel="stylesheet" href="slsprsn.css">
</head>
<body>
    <!-- Sidebar Navigation -->
    <div class="sidebar">
        <h2>Employee Dashboard</h2>
        <ul class="sidebar-links">
            <li><a href="#update-attendance">Update Attendance</a></li>
            <li><a href="empleave.php">View Leaves</a></li>
            <li><a href="payroll.php">Payroll Information</a></li>
            <li><a href="employeeschedule.php">Track Schedule</a></li>
            <li><a href="timesheets.php">Submit Timesheet</a></li>
        </ul>
        <!-- Logout Button -->
        <a href="emplogout.php" class="logout-btn">Logout</a>
    </div>

    <!-- Main Content Area -->
    <div class="main-content">
        <header>
            <h1>Welcome, Employee</h1>
            <p>Access your work schedule, payroll information, attendance, and more.</p>
        </header>

        <!-- Dashboard Cards -->
        <section class="dashboard-cards">
            <div class="card">
                <h3>Check Attendance</h3>
                <p>view attendance.</p>
                <a href="#update-attendance" class="card-link">Update</a>
            </div>
            <div class="card">
                <h3>View Leaves</h3>
                <p>Check leave status and history.</p>
                <a href="empleave.php" class="card-link">View Leaves</a>
            </div>
            <div class="card">
                <h3>Payroll Information</h3>
                <p>Access your payroll and payment details.</p>
                <a href="payroll.php" class="card-link">View Payroll</a>
            </div>
            <div class="card">
                <h3>Track Schedule</h3>
                <p>View your assigned work schedule.</p>
                <a href="employeeschedule.php" class="card-link">Track Schedule</a>
            </div>
            <div class="card">
                <h3>Submit Timesheet</h3>
                <p>Submit your timesheet for review.</p>
                <a href="timesheets.php" class="card-link">Submit Timesheet</a>
            </div>
        </section>
    </div>
</body>
</html>
