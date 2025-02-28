<?php 
include 'config.php';

// Fetch data from the empleave table
$sql = "SELECT e.empleave_id, e.emp_id, e.leave_type, e.start_date, e.end_date, e.leave_status
        FROM empleave e"; 
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
    <title>Employee Leave Reports</title>
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
        <h1>Employee Leave Reports</h1>

        <!-- Print button -->
        <div class="actions">
            <button onclick="printReport()">Print</button>
        </div>

        <table id="leaveReportTable">
            <thead>
                <tr>
                    <th>Employee ID</th>
                    <th>Leave Type</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Leave Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['emp_id'] . "</td>";
                        echo "<td>" . $row['leave_type'] . "</td>";
                        echo "<td>" . $row['start_date'] . "</td>";
                        echo "<td>" . $row['end_date'] . "</td>";
                        echo "<td>" . $row['leave_status'] . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No leave reports found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <div class="footer">
        <img src="foter.jpg" alt="Company Footer">
    </div>

    <script src="EmployeeLeave.js"></script>
    <script>
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
