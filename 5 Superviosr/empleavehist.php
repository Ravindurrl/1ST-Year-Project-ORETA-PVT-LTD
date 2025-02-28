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
        $sql = "INSERT INTO `empleave` (empleave_id, emp_id, leave_type, start_date, end_date, leave_status) 
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
        $sql = "UPDATE `empleave` SET leave_status = ? WHERE empleave_id = ?";

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
$sql = "SELECT * FROM `empleave`";
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

    </style>
</head>
<body>
  <!-- Sidebar Navigation -->
  <div class="sidebar">
        <h2>Supervisor Dashboard</h2>
        <ul class="sidebar-links">
            <li><a href="employeeschedule.php">Employee Schedule</a></li>
            <li><a href="supervisorleave.php">Leave Requests</a></li>
            <li><a href="timesheets.php">Timesheet Management</a></li>
            <li><a href="productreq.php">Product Request</a></li>
        </ul>
        <!-- Logout Button -->
        <a href="splogout.php" class="logout-btn">Logout</a>
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

        <!-- Table to display leave request details -->
        <div class="table-container">
            <h3>Leave Request History</h3>
            <table>
                <thead>
                    <tr>
                        <th>Leave ID</th>
                        <th>Employee ID</th>
                        <th>Leave Type</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Loop through the result and display each leave request
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['empleave_id'] . "</td>";
                        echo "<td>" . $row['emp_id'] . "</td>";
                        echo "<td>" . $row['leave_type'] . "</td>";
                        echo "<td>" . $row['start_date'] . "</td>";
                        echo "<td>" . $row['end_date'] . "</td>";
                        echo "<td>" . $row['leave_status'] . "</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
