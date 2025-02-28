<?php
session_start();

// Check if the user is logged in, if not redirect to login page
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'Sales Manager') {
    header("Location: slmlogin.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales and Marketing Manager Dashboard</title>
    <link rel="stylesheet" href="slsprsn.css">
</head>
<body>
    <!-- Sidebar Navigation -->
    <div class="sidebar">
        <h2>Sales & Marketing Manager</h2>
        <ul class="sidebar-links">
            <li><a href="viewsalesperson.php">View Sales Person</a></li>
            <li><a href="vieworders.php">View Orders</a></li>
            <li><a href="deliverypartner.php">View Delivery Partners</a></li>
            <li><a href="generateDiscount.php">Generate Discount</a></li>
            <li><a href="viewsalestarget.php">View Sales Target</a></li>
            <li><a href="viewproducts.php">View Products</a></li>
            <li><a href="generatebusinessplan.php">Generate Business Plan</a></li>
            <li><a href="viewinventory.php">View Inventory</a></li>
            <li><a href="eventview.php">View Event</a></li>

        </ul>
        <!-- Logout Button -->
        <a href="slmlogout.php" class="logout-btn">Logout</a>
    </div>

    <!-- Main Content Area -->
    <div class="main-content">
        <header>
            <h1>Welcome, Sales & Marketing Manager</h1>
            <p>Manage sales tasks, monitor stock, and generate reports.</p>
        </header>

        <!-- Dashboard Cards -->
        <section class="dashboard-cards">
            <div class="card">
                <h3>View Sales Person</h3>
                <p>Monitor and manage sales team members</p>
                <a href="viewsalesperson.php" class="card-link">View Details</a>
            </div>
            <div class="card">
                <h3>View Orders</h3>
                <p>Track customer orders and statuses</p>
                <a href="vieworders.php" class="card-link">View Orders</a>
            </div>
            
            <div class="card">
                <h3>View Delivery Partners</h3>
                <p>Manage delivery partners and assignments</p>
                <a href="deliverypartner.php" class="card-link">View Partners</a>
            </div>
            <div class="card">
                <h3>Generate Discount</h3>
                <p>Create and manage Discount </p>
                <a href="generateDiscount.php" class="card-link">Generate Discount</a>
            </div>
            <div class="card">
                <h3>View Sales Target</h3>
                <p>Review and update sales targets</p>
                <a href="viewsalestarget.php" class="card-link">View Targets</a>
            </div>
            <div class="card">
                <h3>View Products</h3>
                <p>Browse and manage product listings</p>
                <a href="viewproducts.php" class="card-link">View Products</a>
            </div>
            <div class="card">
                <h3>Generate Business Plan</h3>
                <p>Develop and manage business strategies</p>
                <a href="generatebusinessplan.php" class="card-link">Generate Plan</a>
            </div>
           
            <div class="card">
                <h3>View Inventory</h3>
                <p>Review and track inventory levels</p>
                <a href="viewinventory.php" class="card-link">View Inventory</a>
            </div>
            <div class="card">
                <h3>View Event</h3>
                <p>Review Events</p>
                <a href="eventview.php" class="card-link">View Events</a>
            </div>
        </section>
    </div>
</body>
</html>
