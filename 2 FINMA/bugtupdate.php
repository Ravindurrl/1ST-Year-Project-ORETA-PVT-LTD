<?php
include 'config.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $budget_id = $_POST['budget_id'];
    $budget_amount = $_POST['budget_amount'];
    $invest_amount = $_POST['invest_amount'];
    $invest_date = $_POST['invest_date'];

    // Update query
    $sql = "UPDATE budget SET Budget_Amount = ?, Invest_Amount = ?, Invest_Date = ? WHERE Budget_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ddsi', $budget_amount, $invest_amount, $invest_date, $budget_id);

    if ($stmt->execute()) {
        echo "Budget updated successfully!";
        header("Location: bugtview.php"); // Redirect to the budget management page
        exit();
    } else {
        echo "Error updating budget: " . $stmt->error;
    }
}

// Fetch the current budget data
if (isset($_GET['id'])) {
    $budget_id = $_GET['id'];
    $sql = "SELECT * FROM budget WHERE Budget_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $budget_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $budget = $result->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Budget</title>
    <style>
body {
    font-family: Arial, sans-serif;
    background-color: rgb(141, 7, 181);
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
}

.container {
    background-color: white;
    padding: 20px;
    border-radius: 8px;
    width: 400px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

h1 {
    text-align: center;
    color: rgb(141, 7, 181);
    margin-bottom: 20px;
}

label {
    display: block;
    margin: 10px 0 5px;
}

input, button {
    width: 100%;
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

button {
    background-color: rgb(141, 7, 181);
    color: white;
    border: none;
    cursor: pointer;
    transition: background-color 0.3s;
}

button:hover {
    background-color: rgb(110, 5, 140);
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
            <li><a href="report-generation.php">Generate Project Report</a></li>
            <li><a href="deliverycostview.php">Calculate Delivery Cost</a></li>
            <li><a href="salaryview.php">Calculate Employee Salary</a></li>
        </ul>
        <!-- Logout Button -->
        <a href="fmlogout.php" class="logout-btn">Logout</a>
    </div>
    <div class="container">
        <h1>Update Budget</h1>
        <form method="POST">
            <input type="hidden" name="budget_id" value="<?php echo $budget['Budget_id']; ?>">
            
            <label for="budget_amount">Budget Amount:</label>
            <input type="number" id="budget_amount" name="budget_amount" value="<?php echo $budget['Budget_Amount']; ?>" required>
            
            <label for="invest_amount">Investment Amount:</label>
            <input type="number" id="invest_amount" name="invest_amount" value="<?php echo $budget['Invest_Amount']; ?>" required>
            
            <label for="invest_date">Investment Date:</label>
            <input type="date" id="invest_date" name="invest_date" value="<?php echo $budget['Invest_Date']; ?>" required>
            
            <button type="submit">Update Budget</button>
        </form>
    </div>
</body>
</html>
