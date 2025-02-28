<?php
include 'config.php'; 

// Fetch payments from the database to display in a table
$sql = "SELECT * FROM finpayments";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Financial Payment Management</title>
  <style>
 * {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
}

body {
    font-family: Arial, sans-serif;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
    background-color: rgb(141, 7, 181);
}

.container {
    width: 80%;
    max-width: 900px;
    text-align: center;
}

h1 {
    color: #ffffff;
}

button {
    padding: 10px 20px;
    margin: 10px 0;
    cursor: pointer;
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 5px;
    transition: background-color 0.3s ease, transform 0.2s ease;
}

/* Hover effect for button */
button:hover {
    background-color: #0056b3;
    transform: scale(1.05);
}

/* Table styles with hover effect */
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

table, th, td {
    border: 1px solid #ddd;
    padding: 8px;
    transition: background-color 0.3s ease;
    background-color: white;
}

th {
    background-color: #007bff;
    color: white;
}

tbody tr:hover {
    background-color: #f1f1f1;
}

/* Modal with animation */
.modal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    justify-content: center;
    align-items: center;
    opacity: 0;
    animation: fadeIn 0.5s forwards;
}

.modal-content {
    background-color: white;
    padding: 20px;
    border-radius: 5px;
    width: 300px;
    transform: scale(0.8);
    animation: popIn 0.3s forwards;
}

/* Close button */
.close {
    float: right;
    font-size: 20px;
    cursor: pointer;
}

/* Input styles */
input[type="text"], input[type="email"], input[type="tel"] {
    width: 100%;
    padding: 8px;
    margin: 8px 0;
}

/* Animations */
@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

@keyframes popIn {
    from { transform: scale(0.8); }
    to { transform: scale(1); }
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

  </style>
</head>
<body>
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

  <div class="container">
    <h1>Financial Payment Management</h1>

    <!-- Payments Table -->
    <table id="paymentTable">
      <thead>
        <tr>
          <th>Payment ID</th>
          <th>Payment Type</th>
          <th>Payment Date</th>
          <th>Payment Amount</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody id="paymentList">
        <!-- Dynamic rows will be inserted here -->
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['fin_pay_id'] . "</td>";
                echo "<td>" . $row['Payment_type'] . "</td>";
                echo "<td>" . $row['Payment_date'] . "</td>";
                echo "<td>" . $row['Payment_amount'] . "</td>";
                echo "<td>
                        <button onclick=\"window.location.href='paymentupdate.php?id=" . $row['fin_pay_id'] . "'\">Edit</button>
                        <button onclick=\"if(confirm('Are you sure you want to delete this payment?')) window.location.href='paymentdelete.php?id=" . $row['fin_pay_id'] . "';\">Delete</button>
                      </td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='5'>No payments found</td></tr>";
        }
        ?>
      </tbody>
    </table>

    <!-- New Button to Add Payment -->
    <button onclick="window.location.href='paymentadd.php'" style="padding: 10px 20px; background-color: white; color: black; border: none; border-radius: 5px; cursor: pointer; transition: background-color 0.3s ease, transform 0.2s ease;">
        Add New Payment
    </button>
  </div>
</body>
</html>
