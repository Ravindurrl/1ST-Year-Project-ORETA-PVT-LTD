<?php
include 'config.php';

$sql = "SELECT * FROM attendance";  
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Attendance Management</title>

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
        <h1>Attendance List</h1>

        <!-- Success/Error Messages -->
        <?php if (!empty($error)): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>

        <?php if (!empty($success)): ?>
            <p class="success"><?php echo $success; ?></p>
        <?php endif; ?>

        <!-- Attendance Table -->
        <style>/* Table styles with hover effect */
  table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
  } </style>
        <table id="attendanceTable">
            <thead>
                <tr>
                    <th>Attendance ID</th>
                    <th>Status</th>
                    <th>Attendance Date</th>
                    <th>Work Hours</th>
                    <th>Employee ID</th>
                   
                </tr>
            </thead>
            <tbody>
                
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['atid'] . "</td>";
                        echo "<td>" . $row['atestatus'] . "</td>";
                        echo "<td>" . $row['atedate'] . "</td>";
                        echo "<td>" . $row['workhours'] . "</td>";
                        echo "<td>" . $row['emp_id'] . "</td>";
                        echo "<td>
                                
                              </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>No attendance records found</td></tr>";
                }
                ?>
            </tbody>
        </table>

       
</div>

</body>
</html>
