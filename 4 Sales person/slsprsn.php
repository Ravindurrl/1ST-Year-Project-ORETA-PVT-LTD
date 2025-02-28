<?php
session_start();


if (!isset($_SESSION['username']) || $_SESSION['role'] != 'Sales Person') {
    header("Location: slplogin.php");
    exit;
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Salesperson Dashboard</title>
    <link rel="stylesheet" href="slsprsn.css">
</head>
<body>
     <!-- Sidebar Navigation -->
     <div class="sidebar">
        <h2>Salesperson Dashboard</h2>
        <ul class="sidebar-links">
            <li><a href="viewinventory.php">View Inventory</a></li>
            <li><a href="send-order.php">Send Order to Delivery</a></li>
            <li><a href="sales-target.php">Sales Target</a></li>
            <li><a href="orderinvoice.php">View Order Invoice</a></li>
            <li><a href="customerpayments.php">Customer Payments</a></li>
        </ul>
        <!-- Logout Button -->
        <a href="slplogout.php" class="logout-btn">Logout</a>
    </div>

    <!-- Main Content Area -->
    <div class="main-content">
        <header>
            <h1>Welcome, Salesperson</h1>
            <p>Access inventory, sales reports, targets, and order invoices.</p>
        </header>

        <!-- Dashboard Cards -->
        <section class="dashboard-cards">
            <div class="card">
                <h3>View Inventory</h3>
                <p>Check available stock and inventory details.</p>
                <a href="viewinventory.php" class="card-link">Go to Inventory</a>
            </div>
            <div class="card">
                <h3>Send Order to Delivery</h3>
                <p>Prepare orders and send them for delivery.</p>
                <a href="send-order.php" class="card-link">Send Order</a>
            </div>
            <div class="card">
                <h3>View Sales Target</h3>
                <p>Check your current sales targets and progress.</p>
                <a href="sales-target.php" class="card-link">View Target</a>
            </div>
            <div class="card">
                <h3>View Order Invoice</h3>
                <p>Review invoices for completed orders.</p>
                <a href="vieworders.php" class="card-link">View Invoice</a>
            </div>
            <div class="card">
                <h3>Customer Payment</h3>
                <p>Review Customer Payments.</p>
                <a href="customerpayments.php" class="card-link">Customer Payment</a>
            </div>
        </section>
    </div>
</body>
</html>
