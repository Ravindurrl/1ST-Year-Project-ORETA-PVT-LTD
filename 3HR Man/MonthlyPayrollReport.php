<?php 
// Include the database configuration file
include 'config.php';

// Fetch payroll data from the payroll table
$sql = "SELECT p.payrollid, p.payrolldate, p.basicsalary, p.otamount, p.leavededuction, p.epfamount, p.etfamount, p.bonusamount, p.allowance, p.totamount, p.emp_id
        FROM payroll p
        WHERE MONTH(p.payrolldate) = MONTH(CURRENT_DATE) AND YEAR(p.payrolldate) = YEAR(CURRENT_DATE)"; // Filter for current month and year

$result = $conn->query($sql);

// Check if the query was successful
if (!$result) {
    // Query failed, display the error message
    die("Query failed: " . $conn->error);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monthly Payroll Report</title>
    <link rel="stylesheet" href="EmployeeLeave.css">
</head>
<body>
    <style>

@media print {
    
    th:nth-child(1), td:nth-child(1) {
        display: none;
    }
    .footer {
        position: fixed;
        bottom: 0;
        width: 100%;
        text-align: center;
    }
    .actions {
        display: none;
    }
    .footer img {
        width: 100%;
        object-fit: cover;
    }
}



    </style>
    <div class="letterhead">
        <img src="header.jpg" alt="Company Letterhead">
    </div>

    <div class="container">
        <h1>Monthly Payroll Report</h1>

        <!-- Print button -->
        <div class="actions">
            <button onclick="printReport()">Print</button>
        </div>

        <table id="payrollReportTable">
            <thead>
                <tr>
                   <th>Employee ID</th>
                    <th>Payroll Date</th>
                    <th>Basic Salary</th>
                    <th>OT Amount</th>
                    <th>Leave Deduction</th>
                    <th>EPF Amount</th>
                    <th>ETF Amount</th>
                    <th>Bonus Amount</th>
                    <th>Allowance</th>
                    <th>Total Amount</th>
             
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['emp_id'] . "</td>";
                        echo "<td>" . $row['payrolldate'] . "</td>";
                        echo "<td>" . number_format($row['basicsalary'], 2) . "</td>";
                        echo "<td>" . number_format($row['otamount'], 2) . "</td>";
                        echo "<td>" . number_format($row['leavededuction'], 2) . "</td>";
                        echo "<td>" . number_format($row['epfamount'], 2) . "</td>";
                        echo "<td>" . number_format($row['etfamount'], 2) . "</td>";
                        echo "<td>" . number_format($row['bonusamount'], 2) . "</td>";
                        echo "<td>" . number_format($row['allowance'], 2) . "</td>";
                        echo "<td>" . number_format($row['totamount'], 2) . "</td>";
                        
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='11'>No payroll data found for this month</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <div class="footer">
        <img src="foter.jpg" alt="Company Footer">
    </div>

    <script>
        // Function to print the payroll report
        function printReport() {
            window.print(); // Trigger the browser's print dialog
        }
    </script>
</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
