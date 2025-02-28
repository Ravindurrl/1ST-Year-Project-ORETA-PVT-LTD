<?php

include 'config.php'; 
$error = $success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['addOrderInvoice'])) {
        // Get the input values from the form
        $orderInvoiceID = $_POST['orderInvoiceID'];
        $description = $_POST['description'];
        $discount = $_POST['discount'];
        $orderInvoiceDate = $_POST['orderInvoiceDate'];
        $orderAmount = $_POST['orderAmount'];

        // SQL query to insert the order invoice data
        $sql = "INSERT INTO OrderInvoice (OrderInvoiceID, Description, Discount, OrderInvoiceDate, OrderAmount) 
                VALUES (?, ?, ?, ?, ?)";

        // Prepare the SQL statement
        $stmt = $conn->prepare($sql);

        // Check if the preparation is successful
        if ($stmt === false) {
            $error = "Error preparing statement: " . $conn->error;
        } else {
            // Bind parameters to the prepared statement
            $stmt->bind_param("isdss", $orderInvoiceID, $description, $discount, $orderInvoiceDate, $orderAmount);

            // Execute the query
            if ($stmt->execute()) {
                // Redirect after successful addition
                header("Location:vieworders.php"); 
                exit();
            } else {
                $error = "Error adding order invoice: " . $stmt->error;
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
    <title>Add Order Invoice</title>
    <link rel="stylesheet" href="Supevisoradd.css">
</head>
<body>
 <!-- Sidebar Navigation -->
 <div class="sidebar">
        <h2>Salesperson Dashboard</h2>
        <ul class="sidebar-links">
            <li><a href="viewinventory.php">View Inventory</a></li>
            <li><a href="send-order.php">Send Order to Delivery</a></li>
            <li><a href="sales-target.php">Sales Target</a></li>
            <li><a href="orderinvoice.php">View Order Invoice</a></li>
            <li><a href="customerpayments.php">Customer Payments</a></li>
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
    <div class="container">
    <h1>Add Order Invoice</h1>
    <style> 
    
/* Form styling */
form {
    display: grid;
    gap: 10px;
}
    </style>
    <!-- Order Invoice Add Form -->
    <form method="POST">
        <label for="orderInvoiceID">Order Invoice ID</label>
        <input type="number" name="orderInvoiceID" placeholder="Leave empty for auto-increment" min="1"><br>

        <label for="description">Description</label>
        <input type="text" name="description" required><br>

        <label for="discount">Discount</label>
        <input type="number" name="discount" step="0.01" required><br>

        <label for="orderInvoiceDate">Order Invoice Date</label>
        <input type="date" name="orderInvoiceDate" required><br>

        <label for="orderAmount">Order Amount</label>
        <input type="number" name="orderAmount" step="0.01" required><br>

        <button type="submit" name="addOrderInvoice">Save Order Invoice</button>
    </form>
</div>

</body>
</html>
