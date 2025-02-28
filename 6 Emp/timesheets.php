<?php
include 'config.php';

// Fetch all timesheets
$sql = "SELECT * FROM timesheet";  
$result = $conn->query($sql);

// Handle status update
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_status'])) {
    $timesheetId = $_POST['timesheetId'];
    $status = $_POST['status']; // Get the selected status

    // Update query to set the status
    $updateSql = "UPDATE timesheet SET Status = ? WHERE timesheetId = ?";
    $stmt = $conn->prepare($updateSql);
    if (!$stmt) {
        die("Error preparing SQL: " . $conn->error); // Debug error
    }

    // Bind the parameters and execute the query
    $stmt->bind_param('si', $status, $timesheetId);
    if ($stmt->execute()) {
        $success = "Timesheet status updated successfully!";
    } else {
        $error = "Failed to update timesheet status: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Timesheet Management</title>
    <link rel="stylesheet" href="Supevisoradd.css"> 
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

<div class="main-content">
    <h1>Timesheet List</h1>

    <!-- Display messages -->
    <?php if (!empty($error)): ?>
        <p class="error"><?php echo $error; ?></p>
    <?php endif; ?>

    <?php if (!empty($success)): ?>
        <p class="success"><?php echo $success; ?></p>
    <?php endif; ?>

    <table id="timesheetTable">
        <thead>
            <tr>
                <th>Timesheet ID</th>
                <th>Timesheet Date</th>
                <th>Details</th>
                <th>Employee ID</th>
                <th>Status</th>
                <th>Update Status</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $status = $row['Status'] ?? 'Not Yet'; // Default to 'Not Yet'
                    echo "<tr>";
                    echo "<td>" . $row['timesheetId'] . "</td>"; 
                    echo "<td>" . $row['timesheetDate'] . "</td>";
                    echo "<td>" . $row['timesheetDetails'] . "</td>";
                    echo "<td>" . $row['emp_id'] . "</td>";
                    echo "<td>" . $status . "</td>";
                    echo "<td>
                            <form method='POST' style='margin: 0;'>
                                <input type='hidden' name='timesheetId' value='" . $row['timesheetId'] . "'>
                                <select name='status'>
                                    <option value='Not Yet'" . ($status === 'Not Yet' ? ' selected' : '') . ">Not Yet</option>
                                    <option value='Done'" . ($status === 'Done' ? ' selected' : '') . ">Done</option>
                                </select>
                                <button type='submit' name='update_status'>Submit</button>
                            </form>
                          </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6'>No timesheets found</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <button onclick="window.location.href='timesheetadd.php'" style="padding: 10px 20px; background-color: white; color: black; border: none; border-radius: 5px; cursor: pointer; transition: background-color 0.3s ease, transform 0.2s ease;">
        Add New Timesheet
    </button>
</div>

</body>
</html>
