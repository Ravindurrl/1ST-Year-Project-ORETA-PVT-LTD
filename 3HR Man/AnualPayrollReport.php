<?php 

include 'config.php';


$year = date('Y'); // Get the current year
$sql = "SELECT p.payrollid, p.payrolldate, 
            SUM(p.basicsalary) * 12 AS total_basicsalary,
            SUM(p.otamount) * 12 AS total_otamount,
            SUM(p.leavededuction) * 12 AS total_leavededuction,
            SUM(p.epfamount) * 12 AS total_epfamount,
            SUM(p.etfamount) * 12 AS total_etfamount,
            SUM(p.bonusamount) * 12 AS total_bonusamount,
            SUM(p.allowance) * 12 AS total_allowance,
            SUM(p.totamount) * 12 AS total_totamount,
            p.emp_id
        FROM payroll p
        WHERE YEAR(p.payrolldate) = $year
        GROUP BY p.emp_id"; 

$result = $conn->query($sql);


if (!$result) {
    
    die("Query failed: " . $conn->error);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Annual Payroll Report</title>
    <link rel="stylesheet" href="Employeeleave.css">
    <style>
        /* Additional styling for the print button */
        .actions {
            margin: 20px 0;
        }
        .actions button {
            padding: 10px 20px;
            font-size: 16px;
        }

       /* Styles for printing */
@media print {
    body {
        margin-bottom: 50px; /* Add space for footer */
    }
    .actions {
        display: none; /* Hides the Print button */
    }
    .footer {
        position: fixed;
        bottom: 0;
        width: 100%;
        text-align: center;
    }

    .footer img {
        width: 100%; /* Make sure the footer image covers the entire width */
        object-fit: cover;
    }
}


    </style>
</head>
<body>
    <div class="letterhead">
        <img src="header.jpg" alt="Company Letterhead">
    </div>

    <div class="container">
        <h1>Annual Payroll Report - <?php echo $year; ?></h1>

        <!-- Print button -->
        <div class="actions">
            <button onclick="printReport()">Print</button>
        </div>

        <table id="payrollReportTable">
            <thead>
                <tr>
                    <th>Employee ID</th>
                    <th>Basic Salary (Annual)</th>
                    <th>OT Amount (Annual)</th>
                    <th>Leave Deduction (Annual)</th>
                    <th>EPF Amount (Annual)</th>
                    <th>ETF Amount (Annual)</th>
                    <th>Bonus Amount (Annual)</th>
                    <th>Allowance (Annual)</th>
                    <th>Total Amount (Annual)</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['emp_id'] . "</td>";
                        echo "<td>" . number_format($row['total_basicsalary'], 2) . "</td>";
                        echo "<td>" . number_format($row['total_otamount'], 2) . "</td>";
                        echo "<td>" . number_format($row['total_leavededuction'], 2) . "</td>";
                        echo "<td>" . number_format($row['total_epfamount'], 2) . "</td>";
                        echo "<td>" . number_format($row['total_etfamount'], 2) . "</td>";
                        echo "<td>" . number_format($row['total_bonusamount'], 2) . "</td>";
                        echo "<td>" . number_format($row['total_allowance'], 2) . "</td>";
                        echo "<td>" . number_format($row['total_totamount'], 2) . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='9'>No payroll data found for this year</td></tr>";
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
            window.print(); 
        }
    </script>
</body>
</html>

<?php

$conn->close();
?>
