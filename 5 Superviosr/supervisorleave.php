<?php
session_start();
include 'config.php'; 
$error = $success = "";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['updateStatus'])) {
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
    <link rel="stylesheet" href="dshboard.css">
    <style>
    /* Table Container Styling */
.table-container {
    background-color: #fff;
    border-radius: 10px;
    padding: 20px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    margin-top: 20px;
}

/* Table Styling */
table {
    width: 100%;
    border-collapse: collapse;
    font-family: 'Arial', sans-serif;
    font-size: 14px;
    margin-top: 10px;
}

/* Table Headers */
table th {
    background-color: #34495e;
    color: white;
    padding: 12px;
    text-align: left;
    text-transform: uppercase;
    border-bottom: 3px solid #2c3e50;
}

/* Table Data Rows */
table td {
    padding: 10px;
    border-bottom: 1px solid #ddd;
    text-align: left;
    color: #555;
}

/* Alternating Row Colors */
table tr:nth-child(even) {
    background-color: #f9f9f9;
}

table tr:nth-child(odd) {
    background-color: #fff;
}

/* Hover Effect on Rows */
table tr:hover {
    background-color: #f1f1f1;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

/* Action Buttons Styling */
button {
    padding: 8px 12px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 14px;
    transition: background-color 0.3s ease, transform 0.2s;
}

/* Approve Button */
button[name="updateStatus"][value="Approve"] {
    background-color: #2ecc71;
    color: white;
}

button[name="updateStatus"][value="Approve"]:hover {
    background-color: #27ae60;
    transform: scale(1.05);
}

/* Decline Button */
button[name="updateStatus"][value="Decline"] {
    background-color: #e74c3c;
    color: white;
}

button[name="updateStatus"][value="Decline"]:hover {
    background-color: #c0392b;
    transform: scale(1.05);
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
    <div class="main-content">
        <header>
            <h1>Leave Request Management</h1>
        </header>

        <?php if ($error) { ?>
            <div class="error"><?php echo $error; ?></div>
        <?php } elseif ($success) { ?>
            <div class="success"><?php echo $success; ?></div>
        <?php } ?>

        <div class="table-container">
            <h3>Leave Requests</h3>
            <table>
                <thead>
                    <tr>
                        <th>Leave ID</th>
                        <th>Employee ID</th>
                        <th>Leave Type</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['empleave_id'] . "</td>";
                        echo "<td>" . $row['emp_id'] . "</td>";
                        echo "<td>" . $row['leave_type'] . "</td>";
                        echo "<td>" . $row['start_date'] . "</td>";
                        echo "<td>" . $row['end_date'] . "</td>";
                        echo "<td>" . $row['leave_status'] . "</td>";
                        echo "<td>
                            <form method='POST' style='display:inline;'>
                                <input type='hidden' name='empleave_id' value='" . $row['empleave_id'] . "'>
                                <button type='submit' name='updateStatus' value='Approve' onclick=\"this.form.new_status.value='Approved'\">Approve</button>
                                <button type='submit' name='updateStatus' value='Decline' onclick=\"this.form.new_status.value='Declined'\">Decline</button>
                                <input type='hidden' name='new_status'>
                            </form>
                        </td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
