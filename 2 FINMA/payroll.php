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

    <div class="main-content">
        <center>
            <h1>Payroll View</h1></center>
        <table>
            <tr>
                <th>Payroll ID</th>
                <th>Emp ID</th>
                <th>Payroll Date</th>
                <th>Basic Salary</th> <!-- Added Basic Salary -->
                <th>OT </th>
                <th>Leave Dedu</th>
                <th>EPF </th>
                <th>ETF </th>
                <th>Bonus</th>
                <th>Allowances</th>
                <th>TotalSAL</th>
                <th>Actions</th>
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
                    <td>
                        <a href="payrollupdate.php">Update</a> | 
                        <a href="payrolldelete.php?id=<?= $row['payrollid'] ?>">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>

        <!-- Add Payroll Button -->
        <center>
            <button onclick="window.location.href='payrolladd.php'">Add Payroll</button>
        </center>
    </div>

</body>
</html>
