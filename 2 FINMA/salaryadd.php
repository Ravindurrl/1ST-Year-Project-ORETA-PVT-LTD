<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $empid = $_POST['empid'];
    $basicsalary = $_POST['basicsalary'];
    $deduction = $_POST['deduction'];
    $increment = $_POST['increment'];
    $net_salary = $basicsalary - $deduction + $increment;

    $stmt = $conn->prepare("
        INSERT INTO salary (emp_id, basicsalary, deduction, increment, net_salary) 
        VALUES (?, ?, ?, ?, ?)
    ");
    $stmt->bind_param("sdddd", $empid, $basicsalary, $deduction, $increment, $net_salary);

    if ($stmt->execute()) {
        echo "Salary added successfully.";
        header("Location: salaryview.php");
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Salary</title>
    <style>
        /* General Page Styling */
body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: rgb(141, 7, 181);
}

h1 {
    color: #333;
    text-align: center;
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
      padding-left: 0;
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
    position: absolute;
    bottom: 20px;
    left: 20px;
    background-color: #e74c3c;
    color: white;
    padding: 10px 20px;
    text-decoration: none;
    border-radius: 5px;
}

.logout-btn:hover {
    background-color: #c0392b;
}

/* Main Content Area */
.main-content {
    margin-left: 270px;
    padding: 20px;
}

/* Form Styling */
form {
    max-width: 600px;
    margin: 0 auto;
    background-color: white;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
}

form label {
    display: block;
    margin-bottom: 10px;
    font-weight: bold;
}

form input[type="text"],
form input[type="number"],
form input[type="submit"],
form button {
    width: 100%;
    padding: 10px;
    margin: 5px 0;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 16px;
}

form input[type="submit"],
form button {
    background-color: #3498db;
    color: white;
    cursor: pointer;
}

form input[type="submit"]:hover,
form button:hover {
    background-color: #2980b9;
}

/* Table Styling */
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
    background-color: white;
    box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
}

table, th, td {
    border: 1px solid #ddd;
}

th, td {
    padding: 12px;
    text-align: center;
}

th {
    background-color: #3498db;
    color: white;
}

tr:hover {
    background-color: #f1f1f1;
}

    </style>
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

    <!-- Main Content -->
    <div class="main-content">
    <h1 style="color: white;">Add Salary</h1>

        <form method="POST">
            <label>Employee ID:
                <input type="text" name="empid" required>
            </label><br>
            <label>Basic Salary:
                <input type="number" step="0.01" name="basicsalary" required>
            </label><br>
            <label>Deduction:
                <input type="number" step="0.01" name="deduction" required>
            </label><br>
            <label>Increment:
                <input type="number" step="0.01" name="increment" required>
            </label><br>
            <button type="submit">Add Salary</button>
        </form>
    </div>
</body>
</html>
