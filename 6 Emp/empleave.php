<?php
session_start();
include 'config.php'; 
$error = $success = "";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['submitLeaveRequest'])) {
        // Get the input values from the form
        
        $empleave_id = $_POST['empleave_id']; 
        $emp_id = $_POST['emp_id']; 
        $leave_type = $_POST['leave_type'];
        $start_date = $_POST['start_date'];
        $end_date = $_POST['end_date'];  
        $status = "Pending"; 

        // SQL query to insert the leave request
        $sql = "INSERT INTO empleave (empleave_id, emp_id, leave_type, start_date, end_date, leave_status) 
                VALUES (?, ?, ?, ?, ?, ?)";

        // Prepare the SQL statement
        $stmt = $conn->prepare($sql);

        if ($stmt === false) {
            $error = "Error preparing statement: " . $conn->error;
        } else {
            // Bind parameters
            $stmt->bind_param("iissss", $empleave_id, $emp_id, $leave_type, $start_date, $end_date, $status);

            if ($stmt->execute()) {
                $success = "Leave request submitted successfully!";
                header("Location: empleavehist.php");
            } else {
                $error = "Error submitting leave request: " . $stmt->error;
            }

            // Close the statement
            $stmt->close();
        }
    } elseif (isset($_POST['updateStatus'])) {
        // Handle status update
        $leave_id = $_POST['empleave_id'];
        $new_status = $_POST['new_status'];

        // SQL query to update the status
        $sql = "UPDATE empleave SET leave_status = ? WHERE empleave_id = ?";

        $stmt = $conn->prepare($sql);

        if ($stmt === false) {
            $error = "Error preparing statement: " . $conn->error;
        } else {
            // Bind parameters
            $stmt->bind_param("si", $new_status, $leave_id);

            if ($stmt->execute()) {
                $success = "Leave status updated successfully!";
            } else {
                $error = "Error updating status: " . $stmt->error;
            }

            $stmt->close();
        }
    }
}

// Fetch leave requests
$sql = "SELECT * FROM empleave";
$result = $conn->query($sql);

if (!$result) {
    die("Error fetching leave requests: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Leave Requests</title>
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

        .logout-btn:hover {
            background-color: #c0392b;
            transform: translateY(-2px);
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

        /* Form Container Styles */
        .form-container {
            background-color: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            padding: 1.5rem;
            margin-bottom: 30px;
        }

        form {
            display: grid;
            gap: 15px;
        }

        label {
            font-size: 16px;
            color: #34495e;
        }

        input, select, button {
            padding: 10px;
            font-size: 14px;
            border-radius: 5px;
            border: 1px solid #bdc3c7;
            width: 100%;
        }

        button {
            background-color: #2ecc71;
            color: white;
            cursor: pointer;
            border: none;
        }

        button:hover {
            background-color: #27ae60;
        }

        button:disabled {
            background-color: #bdc3c7;
            cursor: not-allowed;
        }

        /* Success/Error Messages */
        .success, .error {
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            font-size: 16px;
        }

        .success {
            background-color: #2ecc71;
            color: white;
        }

        .error {
            background-color: #e74c3c;
            color: white;
        }

        /* Table Styles */
        .table-container {
            background-color: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            padding: 1.5rem;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table th, table td {
            padding: 10px;
            text-align: left;
            border: 1px solid #bdc3c7;
        }

        table th {
            background-color: #34495e;
            color: #fff;
        }

        table tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        table tr:hover {
            background-color: #ecf0f1;
        }

        button[type="submit"] {
            padding: 8px 15px;
            background-color: #3498db;
            border: none;
            color: white;
            cursor: pointer;
            border-radius: 5px;
        }

        button[type="submit"]:hover {
            background-color: #2980b9;
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
 
<div class="sidebar">
    <h2>Employee Dashboard</h2>
    <ul class="sidebar-links">
        <li><a href="attendence.php">Update Attendance</a></li>
        <li><a href="empleave.php">View Leaves</a></li>
        <li><a href="payroll.php">Payroll Information</a></li>
        <li><a href="employeeschedule.php">Track Schedule</a></li>
        <li><a href="timesheets.php">Submit Timesheet</a></li>
    </ul>
    <a href="emplogout.php" class="logout-btn">Logout</a>
</div>
    <!-- Main Content -->
    <div class="main-content">
        <header>
            <h1>Leave Request</h1>
            <p>Submit or manage your leave requests here.</p>
        </header>

        <?php if ($error) { ?>
            <div class="error"><?php echo $error; ?></div>
        <?php } elseif ($success) { ?>
            <div class="success"><?php echo $success; ?></div>
        <?php } ?>

        <div class="form-container">
            <h3>Submit Leave Request</h3>
            <form action="" method="POST">
                <label for="empleave_id">Leave ID</label>
                <input type="number" id="empleave_id" name="empleave_id" required>

                <label for="emp_id">Employee ID</label>
                <input type="number" id="emp_id" name="emp_id" required>

                <label for="leave_type">Leave Type</label>
                <select id="leave_type" name="leave_type" required>
                    <option value="Sick">Sick</option>
                    <option value="Casual">Casual</option>
                    <option value="Annual">Annual</option>
                </select>

                <label for="start_date">Start Date</label>
                <input type="date" id="start_date" name="start_date" required>

                <label for="end_date">End Date</label>
                <input type="date" id="end_date" name="end_date" required>

                <button type="submit" name="submitLeaveRequest">Submit Request</button>
            </form>
        </div>
 <!-- Button to redirect to leave history page -->
 <div class="button-container">
        <button onclick="window.location.href='empleavehist.php'">Go to Leave History</button>
    </div>
    
</body>
</html>