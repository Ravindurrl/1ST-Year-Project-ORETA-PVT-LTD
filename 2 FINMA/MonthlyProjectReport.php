<?php 
// Include the database configuration file
include 'config.php';

// Fetch project data from the projects table
$sql = "SELECT ProjectID, ProjectName, ProjectCost, ProjectType, ProjectDate 
        FROM projects 
        WHERE MONTH(ProjectDate) = MONTH(CURRENT_DATE) AND YEAR(ProjectDate) = YEAR(CURRENT_DATE)"; // Filter for current month and year

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
    <title>Monthly Project Report</title>
    <link rel="stylesheet" href="Employeeleave.css">
</head>
<body>
    <style>
        /* Hide Project ID column during printing */
        @media print {
            /* Hide the Project ID column (1st column) */
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
                display: none; /* Hides the Print button */
            }
            .footer img {
                width: 100%; /* Make sure the footer image covers the entire width */
                object-fit: cover;
            }
        }
    </style>

    <div class="letterhead">
        <img src="header.jpg" alt="Company Letterhead">
    </div>

    <div class="container">
        <h1>Monthly Project Report</h1>

        <!-- Print button -->
        <div class="actions">
            <button onclick="printReport()">Print</button>
        </div>

        <table id="projectReportTable">
            <thead>
                <tr>
                    <th>Project ID</th>
                    <th>Project Name</th>
                    <th>Project Cost</th>
                    <th>Project Type</th>
                    <th>Project Date</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['ProjectID'] . "</td>";
                        echo "<td>" . $row['ProjectName'] . "</td>";
                        echo "<td>" . number_format($row['ProjectCost'], 2) . "</td>";
                        echo "<td>" . $row['ProjectType'] . "</td>";
                        echo "<td>" . $row['ProjectDate'] . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No project data found for this month</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <div class="footer">
        <img src="foter.jpg" alt="Company Footer">
    </div>

    <script>
        // Function to print the project report
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
