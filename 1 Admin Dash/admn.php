<?php
session_start();

// Check if the user is logged in, if not redirect to login page
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'Admin') {
    header("Location: admlogin.php");
    exit;
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        /* Reset styles */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

/* Body styling */
body {
    font-family: 'Arial', sans-serif;
    display: flex;
    background-color: #f4f4f4;
    color: #333;
}

/* Sidebar Styling */
.sidebar {
    width: 260px;
    background-color: #2b2e4a;
    color: #fff;
    padding: 2rem 1rem;
    height: 100vh;
    position: fixed;
    top: 0;
    left: 0;
    border-radius: 0 10px 10px 0;
    box-shadow: 4px 0 12px rgba(0, 0, 0, 0.15);
}

.sidebar h2 {
    text-align: center;
    margin-bottom: 2rem;
    color: #ffcc29;
    font-size: 1.8rem;
    font-weight: bold;
}

.sidebar-links {
    list-style-type: none;
}

.sidebar-links li {
    margin: 1rem 0;
}

.sidebar-links a {
    color: #fff;
    text-decoration: none;
    display: block;
    padding: 0.75rem 1rem;
    border-radius: 8px;
    transition: background 0.3s ease, transform 0.2s;
}

.sidebar-links a:hover {
    background-color: #3d3f5c;
    transform: translateX(5px);
}

/* Logout Button */
.logout-btn {
    background-color: #e74c3c;
    color: #fff;
    text-decoration: none;
    padding: 0.5rem 1rem;
    border-radius: 8px;
    font-weight: bold;
    transition: background-color 0.3s, transform 0.2s;
}



/* Main Content Styling */
.main-content {
    margin-left: 260px;
    padding: 2rem;
    width: calc(100% - 260px);
    min-height: 100vh;
    background-color: #fafafa;
}

/* Header Styling */
header {
    margin-bottom: 2rem;
    animation: fadeIn 1.5s ease;
}

header h1 {
    font-size: 2.5rem;
    color: #333;
}

header p {
    color: #666;
    font-size: 1.1rem;
    margin-top: 0.5rem;
}

/* Dashboard Cards */
.dashboard-cards {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
}

.card {
    background-color: #fff;
    border-radius: 12px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    padding: 1.5rem;
    text-align: center;
    transition: transform 0.3s, box-shadow 0.3s;
    position: relative;
    overflow: hidden;
}

.card:before {
    content: '';
    position: absolute;
    top: -50%;
    left: -50%;
    width: 200%;
    height: 200%;
    background: rgba(255, 204, 41, 0.1);
    transform: rotate(45deg);
    transition: 0.5s;
}

.card:hover:before {
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
}

.card h3 {
    color: #2b2e4a;
    font-size: 1.5rem;
    margin-bottom: 1rem;
    position: relative;
    z-index: 1;
}

.card p {
    color: #666;
    font-size: 1rem;
    margin-bottom: 1.5rem;
    position: relative;
    z-index: 1;
}

.card-link {
    color: #2b2e4a;
    text-decoration: none;
    font-weight: bold;
    position: relative;
    z-index: 1;
    transition: color 0.3s ease;
}

.card:hover {
    transform: translateY(-8px);
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
}

.card-link:hover {
    color: #ffcc29;
}

/* Animation Keyframes */
@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(-20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Responsive Styling */
@media (max-width: 768px) {
    .sidebar {
        width: 220px;
    }
    
    .main-content {
        margin-left: 220px;
    }
}

@media (max-width: 480px) {
    .sidebar {
        width: 100%;
        height: auto;
        position: relative;
        border-radius: 0;
    }

    .main-content {
        margin-left: 0;
    }

    .dashboard-cards {
        grid-template-columns: 1fr;
    }
}

    </style>
</head>
<body>
    <!-- Sidebar Navigation -->
    <div class="sidebar">
        <h2>Admin Dashboard</h2>
        <ul class="sidebar-links"> 
            <li><a href="admn.php">Dashboard</a></li>
            <li><a href="cstmngview.php">Customers</a></li>
            <li><a href="empmngview.php">Employees</a></li>
            <li><a href="Supevisorviewphp.php">Supervisors</a></li>
            <li><a href="managerview.php">Managers</a></li>
            <li><a href="suppliermngview.php">Suppliers</a></li>
            <li><a href="dlvrprtview.php">Delivery Partners</a></li>
            <li><a href="generateDiscount.php">Discounts</a></li>
        </ul>
        <a href="admlogout.php" class="logout-btn">Logout</a>
        
       
    </div>

    <!-- Main Content Area -->
    <div class="main-content">
        <header>
            <h1>Welcome, Admin</h1>
            <p>Manage your store efficiently with the dashboard.</p>
        </header>

        <!-- Dashboard Cards -->
               <!-- Dashboard Cards -->
               <section class="dashboard-cards">
                <div class="card">
                    <h3>Customers</h3>
                    <p>Manage registered customers</p>
                    <a href="cstmngview.php" class="card-link">View</a>
                </div>
                <div class="card">
                    <h3>Employees</h3>
                    <p>Manage employee details</p>
                    <a href="empmngview.php" class="card-link">View</a>
                </div>
                <div class="card">
                    <h3>Supervisors</h3>
                    <p>Manage supervisors</p>
                    <a href="Supevisorviewphp.php" class="card-link">View</a>
                </div>
                <div class="card">
                    <h3>Managers</h3>
                    <p>Manage manager accounts</p>
                    <a href="managerview.php" class="card-link">View</a>
                </div>
                <div class="card">
                    <h3>Suppliers</h3>
                    <p>Manage product suppliers</p>
                    <a href="suppliermngview.php" class="card-link">View</a>
                </div>
                <div class="card">
                    <h3>Delivery Partners</h3>
                    <p>Assign and manage delivery partners</p>
                    <a href="dlvrprtview.php" class="card-link">View</a>
                </div>
                <div class="card">
                    <h3>Discounts</h3>
                    <p>Set and manage discounts</p>
                    <a href="generateDiscount.php" class="card-link">View</a>
                </div>
            </section>
        </div>
    

</body>
</html>
