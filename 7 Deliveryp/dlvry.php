<?php
session_start();


if (!isset($_SESSION['username']) || $_SESSION['role'] != 'Delivery Partner') {
    header("Location: dlvlogin.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delivery Partner Dashboard</title>
    <link rel="stylesheet" href="slsprsn.css">
</head>
<body>
    <!-- Sidebar Navigation -->
    <aside class="sidebar">
        <h2>Delivery Partner</h2>
        <ul class="sidebar-links">
         
            <li><a href="proofdelivery.php">📝 Proof of Delivery</a></li>
            <li><a href="assigneddelivery.php">📋 Assigned Orders</a></li>
        </ul>
        <!-- Logout Button -->
        <a href="dlvlogout.php" class="logout-btn">Logout</a>
    </aside>

    <!-- Main Content Area -->
    <main class="main-content">
        <header>
            <h1>Welcome, Delivery Partner</h1>
            <p>Manage your deliveries, submit proofs, and track order status.</p>
        </header>

        <!-- Dashboard Cards -->
        <section class="dashboard-cards">
            
            <div class="card">
                <h3>Proof of Delivery</h3>
                <p>Submit proof of delivery for completed orders.</p>
                <a href="proofdelivery.php" class="card-link">Submit Proof</a>
            </div>
          
            <div class="card">
                <h3>Assigned Orders</h3>
                <p>View the list of orders assigned to you.</p>
                <a href="assigneddelivery.php" class="card-link">View Orders</a>
            </div>
        </section>
    </main>
</body>
</html>
