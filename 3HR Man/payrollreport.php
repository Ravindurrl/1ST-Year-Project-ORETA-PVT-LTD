<?php 
include 'config.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HR Manager Dashboard</title>
    <link rel="stylesheet" href="slsprsn.css">
</head>
<body>
    <!-- Sidebar Navigation -->
    <div class="sidebar">
        <h2>HR Manager</h2>
        <ul class="sidebar-links">
            <li><a href="payrollreport.php">Payroll Reports</a></li>
            <li><a href="attendence.php">Monitor Attendance</a></li>
            <li><a href="leavereport.php">Employee Leave Report</a></li>
            <li><a href="ot.php">View Overtime (OT)</a></li>
        </ul>
        <!-- Logout Button -->
        <a href="hrlogout.php" class="logout-btn">Logout</a>
    </div>

    <!-- Main Content Area -->
    <div class="main-content">
        <header>
            <h1>Welcome, HR Manager</h1>
            <p>Manage HR tasks, monitor employee data, and generate reports.</p>
        </header>

        <!-- Dashboard Cards -->
        <section class="dashboard-cards">
            <div class="card">
                <h3>Payroll Reports</h3>
                <p>Generate and view payroll reports</p>
                <a href="MonthlyPayrollReport.php" class="card-link">Monthly Payroll Report</a><br>
                <a href="AnualPayrollReport.php" class="card-link">Annual Payroll Report</a>
            </div>
            <div class="card">
                <h3>Monitor Attendance</h3>
                <p>Track and monitor employee attendance.</p>
                <a href="attendence.php" class="card-link">Monitor Attendance</a>
            </div>
            <div class="card">
                <h3>Employee Leave Report</h3>
                <p>View detailed leave reports for employees.</p>
                <a href="leavereport.php" class="card-link">View Leave Report</a>
            </div>
            <div class="card">
                <h3>View Overtime (OT)</h3>
                <p>Check overtime hours for employees.</p>
                <a href="ot.php" class="card-link">View OT</a>
            </div>
        </section>
    </div>
</body>
</html>