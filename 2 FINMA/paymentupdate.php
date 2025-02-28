<?php
include 'config.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the values from the form
    $payment_id = $_POST['payment_id'];
    $payment_type = $_POST['payment_type'];
    $payment_date = $_POST['payment_date'];
    $payment_amount = $_POST['payment_amount'];

    
    $sql = "UPDATE finpayments SET Payment_type = ?, Payment_date = ?, Payment_amount = ? WHERE fin_pay_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ssdi', $payment_type, $payment_date, $payment_amount, $payment_id);

    if ($stmt->execute()) {
        echo "Payment updated successfully!";
        header("Location: finpaymnt.php"); 
        exit();
    } else {
        echo "Error updating payment: " . $stmt->error;
    }
}

// Fetch the current payment data
if (isset($_GET['id'])) {
    $payment_id = $_GET['id'];
    $sql = "SELECT * FROM finpayments WHERE fin_pay_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $payment_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $payment = $result->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Payment</title>
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
    justify-content: center; /* Center horizontally */
    align-items: center;
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
    <h1>Update Payment</h1>
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
    <form method="POST">
        <input type="hidden" name="payment_id" value="<?php echo $payment['fin_pay_id']; ?>">
        <label for="payment_type">Payment Type:</label>
        <select id="payment_type" name="payment_type" required>
            <option value="cash" <?php echo ($payment['Payment_type'] == 'cash') ? 'selected' : ''; ?>>Cash</option>
            <option value="card" <?php echo ($payment['Payment_type'] == 'card') ? 'selected' : ''; ?>>Card</option>
        </select>
        <br>
        <label for="payment_date">Payment Date:</label>
        <input type="date" id="payment_date" name="payment_date" value="<?php echo $payment['Payment_date']; ?>" required>
        <br>
        <label for="payment_amount">Payment Amount:</label>
        <input type="number" id="payment_amount" name="payment_amount" value="<?php echo $payment['Payment_amount']; ?>" required>
        <br>
        <button type="submit">Update Payment</button>
    </form>
</body>
</html>
