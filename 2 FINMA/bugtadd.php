<?php
include 'config.php'; 

$error = $success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['addInvestment'])) {
        // Get the input values from the form
        $budget_id = $_POST['budget_id'];
        $budget_amount = $_POST['budget_amount'];
        $invest_amount = $_POST['invest_amount'];
        $invest_date = $_POST['invest_date'];

        // SQL query to insert the investment data
        $sql = "INSERT INTO budget (Budget_id, Budget_Amount, Invest_Amount, Invest_Date) 
                VALUES (?, ?, ?, ?)";

        // Prepare the SQL statement
        $stmt = $conn->prepare($sql);

        // Check if the preparation is successful
        if ($stmt === false) {
            $error = "Error preparing statement: " . $conn->error;
        } else {
            // Bind parameters to the prepared statement
            $stmt->bind_param("idss", $budget_id, $budget_amount, $invest_amount, $invest_date);

            // Execute the query
            if ($stmt->execute()) {
                $success = "Investment added successfully!";
                header("Location: bugtview.php"); // Redirect to the same page
            } else {
                $error = "Error adding investment: " . $stmt->error;
            }

            // Close the statement
            $stmt->close();
        }
    }
}
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Budget and Investment Management</title>
   <style>  
   
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: rgb(141, 7, 181);
            display: flex;
            height: 100vh;
        }

        .container {
            background-color: #ffffff;
            color: #333333;
            border-radius: 8px;
            padding: 20px;
            width: 90%;
            max-width: 400px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin: auto;
            text-align: center;
        }

        h1 {
            margin-bottom: 20px;
            font-size: 1.8rem;
            color: rgb(141, 7, 181);
        }

        label {
            display: block;
            text-align: left;
            font-size: 1rem;
            margin: 10px 0 5px;
        }

        input, select {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: rgb(141, 7, 181);
            border: none;
            color: white;
            font-size: 1rem;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: rgb(110, 5, 140);
        }

        .error {
            color: red;
            font-size: 0.9rem;
            margin-bottom: 10px;
        }

        .success {
            color: green;
            font-size: 0.9rem;
            margin-bottom: 10px;
        }

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
 <!-- Sidebar Navigation -->
 <div class="sidebar">
        <h2>Finance Manager</h2>
        <ul class="sidebar-links">
            <li><a href="finpaymnt.php">Payment Management</a></li>
            <li><a href="bugtview.php">Budget & Investment</a></li>
            <li><a href="projectview.php">Calculate Project Cost</a></li>
            <li><a href="#report-generation">Generate Project Report</a></li>
            <li><a href="deliverycostview.php">Calculate Delivery Cost</a></li>
            <li><a href="salaryview.php">Calculate Employee Salary</a></li>
        </ul>
        <!-- Logout Button -->
        <a href="fmlogout.php" class="logout-btn">Logout</a>
    </div>
    
  <div class="container">
    <h1>Add New Budget</h1>

    <!-- Success/Error Messages -->
    <?php if (!empty($error)): ?>
        <p class="error"><?php echo $error; ?></p>
    <?php endif; ?>

    <?php if (!empty($success)): ?>
        <p class="success"><?php echo $success; ?></p>
    <?php endif; ?>

    <form action="bugtadd.php" method="post">
        <label for="budget_id">Budget ID</label>
        <input type="text" id="budget_id" name="budget_id" required>

        <label for="budget_amount">Budget Amount</label>
        <input type="number" id="budget_amount" name="budget_amount" step="0.01" required>

        <label for="invest_amount">Investment Amount</label>
        <input type="number" id="invest_amount" name="invest_amount" step="0.01" required>

        <label for="invest_date">Investment Date</label>
        <input type="date" id="invest_date" name="invest_date" required>

        <button type="submit" name="addInvestment">Save Budget</button>
    </form>
</div>
</body>
</html>