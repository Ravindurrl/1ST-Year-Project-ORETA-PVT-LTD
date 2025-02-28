<?php
include 'config.php';

$result = $conn->query("SELECT * FROM payroll");

?>

<!DOCTYPE html>
<html lang="en">
<head>
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
        <center>
            <h1>Payroll View</h1></center>
        <table>
            <tr>
                <th>Payroll ID</th>
                <th>Emp ID</th>
                <th>Payroll Date</th>
                <th>Basic Salary</th>
                <th>OT</th>
                <th>Leave Dedu</th>
                <th>EPF</th>
                <th>ETF</th>
                <th>Bonus</th>
                <th>Allowances</th>
                <th>TotalSAL</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()) : ?>
                <tr>
                    <td><?= $row['payrollid'] ?></td>
                    <td><?= $row['emp_id'] ?></td>
                    <td><?= $row['payrolldate'] ?></td>
                    <td><?= $row['basicsalary'] ?></td>
                    <td><?= $row['otamount'] ?></td>
                    <td><?= $row['leavededuction'] ?></td>
                    <td><?= $row['epfamount'] ?></td>
                    <td><?= $row['etfamount'] ?></td>
                    <td><?= $row['bonusamount'] ?></td>
                    <td><?= $row['allowance'] ?></td>
                    <td><?= $row['totamount'] ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    </div>

</body>
</html>
