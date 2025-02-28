<?php
include 'config.php'; 
$error = $success = "";

// Fetch Customer IDs
$customerQuery = "SELECT cus_id, cus_name FROM Customer";
$customerResult = $conn->query($customerQuery);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['addPayment'])) {
        // Get the input values from the form
        $cus_id = $_POST['cus_id'];
        $paymentType = $_POST['paymentType'];
        $paymentDate = $_POST['paymentDate'];  
        $paymentAmount = $_POST['paymentAmount'];                 

        // SQL query to insert the payment data
        $sql = "INSERT INTO CustomerPayments (cus_id, payment_type, payment_date, payment_amount) 
                VALUES (?, ?, ?, ?)";

        // Prepare the SQL statement
        $stmt = $conn->prepare($sql);

        // Check if the preparation is successful
        if ($stmt === false) {
            $error = "Error preparing statement: " . $conn->error;
        } else {
            // Bind parameters to the prepared statement
            $stmt->bind_param("issd", $cus_id, $paymentType, $paymentDate, $paymentAmount);

            // Execute the query
            if ($stmt->execute()) {
                // Success
                $success = "Customer payment added successfully!";
                header("Location: customerpayments.php"); 
                exit();
            } else {
                // Error
                $error = "Error adding customer payment: " . $stmt->error;
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
    <title>Add Customer Payment</title>
    <link rel="stylesheet" href="Supevisoradd.css">
</head>
<body>

<!-- Sidebar Navigation -->
<div class="sidebar">
    <h2>Salesperson Dashboard</h2>
    <ul class="sidebar-links">
        <li><a href="viewinventory.php">View Inventory</a></li>
        <li><a href="sendorder.php">Send Order to Delivery</a></li>
        <li><a href="sales-target.php">Sales Target</a></li>
        <li><a href="orderinvoice.php">View Order Invoice</a></li>
    </ul>
    <!-- Logout Button -->
    <a href="slplogout.php" class="logout-btn">Logout</a>
</div>

<!-- Success/Error Messages -->
<?php if (!empty($error)): ?>
    <p class="error"><?php echo $error; ?></p>
<?php endif; ?>

<?php if (!empty($success)): ?>
    <p class="success"><?php echo $success; ?></p>
<?php endif; ?>

<style> 
/* Form styling */
form {
    display: grid;
    gap: 10px;
}
</style>

<!-- Payment Add Form -->
<div class="main-content">
    <h1>Add New Customer Payment</h1>
    <form method="POST">
        <label for="cus_id">Customer</label>
        <select name="cus_id" required>
    <option value="">Select Customer</option>
    <?php
    if ($customerResult->num_rows > 0) {
        while ($row = $customerResult->fetch_assoc()) {
            // Displaying customer name and other details
            echo "<option value=\"" . $row['cus_id'] . "\">" . $row['cus_name'] . " (ID: " . $row['cus_id'] . ") - " . $row['cus_email'] . " - " . $row['cus_phone'] . "</option>";
        }
    } else {
        echo "<option value=\"\">No customers found</option>";
    }
    ?>
</select>
    <br>

        <label for="paymentType">Payment Type</label>
        <select name="paymentType" required>
            <option value="">Select Payment Type</option>
            <option value="Cash">Cash</option>
            <option value="Card">Card</option>
            <option value="Bank Transfer">Bank Transfer</option>
        </select><br>

        <label for="paymentDate">Payment Date</label>
        <input type="date" name="paymentDate" required><br>

        <label for="paymentAmount">Payment Amount</label>
        <input type="number" step="0.01" name="paymentAmount" placeholder="Enter payment amount" required><br>

        <button type="submit" name="addPayment">Save Payment</button>
    </form>
</div>

</body>
</html>
