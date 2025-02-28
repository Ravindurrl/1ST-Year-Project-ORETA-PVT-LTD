<?php
session_start();


if (!isset($_SESSION['username']) || $_SESSION['role'] != 'Supplier') {
    header("Location: splogin.php");
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
    
    <aside class="sidebar">
        <h2>Supplier</h2>
        <ul class="sidebar-links">
         
            <li><a href="productreq.php">📝 Product Request</a></li>
            
        </ul>
        <!-- Logout Button -->
        <a href="splogout.php" class="logout-btn">Logout</a>
    </aside>

    <!-- Main Content Area -->
    <main class="main-content">
        <header>
            <h1>Welcome, Supplier </h1>
            <p>Manage Product requests.</p>
        </header>

        <!-- Dashboard Cards -->
        <section class="dashboard-cards">
            
            <div class="card">
                <h3>Product Requests</h3>
                <p>View Prodcut Request From Oreta Store.</p>
                <a href="productreq.php" class="card-link">Submit Proof</a>
            </div>
          
           
    </main>
</body>
</html>
