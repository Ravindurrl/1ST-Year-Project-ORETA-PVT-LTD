<?php
session_start();

// Check if the user is logged in, if not redirect to login page
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'Finance Manager') {
    header("Location: fmlogin.php");
    exit;
}
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Finance Manager Dashboard</title>
    <link rel="stylesheet" href="dshboard.css">
</head>
<body>
    <!-- Sidebar Navigation -->
    <div class="sidebar">
        <h2>Finance Manager</h2>
        <ul class="sidebar-links">
            <li><a href="finpaymnt.php">Payment Management</a></li>
            <li><a href="bugtview.php">Budget & Investment</a></li>
            <li><a href="projectview.php">Calculate Project Cost</a></li>
            <li><a href="report-generation.php">Generate Project Report</a></li>
            <li><a href="deliverycostview.php">Calculate Delivery Cost</a></li>
            <li><a href="salaryview.php">Calculate Employee Salary</a></li>
        </ul>
        <!-- Logout Button -->
        <a href="fmlogout.php" class="logout-btn">Logout</a>
    </div>

    <!-- Main Content Area -->
    <div class="main-content">
        <header>
            <h1>Welcome, Finance Manager</h1>
            <p>Manage financial operations and generate important reports.</p>
        </header>

        <!-- Dashboard Cards -->
        <section class="dashboard-cards">
            <div class="card">
                <h3>Payment Management</h3>
                <p>Manage all payment records and transactions</p>
                <a href="finpaymnt.php" class="card-link">Manage Payments</a>
            </div>
            <div class="card">
                <h3>Budget & Investment</h3>
                <p>Manage budgets and investments for projects</p>
                <a href="bugtview.php" class="card-link">Manage Budgets</a>
            </div>
            <div class="card">
                <h3>Project Cost</h3>
                <p>Calculate and track project costs</p>
                <a href="projectview.php" class="card-link">Calculate Cost</a>
            </div>
            <div class="card">
                <h3>Project Report</h3>
                <p>Generate cost and revenue reports</p>
                <a href="report-generation.php" class="card-link">Generate Report</a>
            </div>
            <div class="card">
                <h3>Delivery Cost</h3>
                <p>Calculate delivery expenses</p>
                <a href="deliverycostview.php" class="card-link">Calculate Delivery Cost</a>
            </div>
            <div class="card">
                <h3>Employee Salary</h3>
                <p>Calculate salary based on attendance and hours</p>
                <a href="salaryview.php" class="card-link">Calculate Salary</a>
            </div>
        
        </section>
    </div>
</body>
</html>
