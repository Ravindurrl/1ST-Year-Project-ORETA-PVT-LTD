<?php
include 'config.php'; 
$error = $success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['addSendOrder'])) {
        // Get the input values from the form
        $orderID = $_POST['orderID'];
        $customerName = $_POST['customerName'];
        $deliveryAddress = $_POST['deliveryAddress'];
        $deliveryDate = $_POST['deliveryDate'];
        $orderInvoiceID = $_POST['orderInvoiceID'];

        // SQL query to insert the sendorderdeli data
        $sql = "INSERT INTO sendorderdeli (OrderID, CustomerName, DeliveryAddress, DeliveryDate, OrderInvoiceID) 
                VALUES (?, ?, ?, ?, ?)";

        // Prepare the SQL statement
        $stmt = $conn->prepare($sql);

        // Check if the preparation is successful
        if ($stmt === false) {
            $error = "Error preparing statement: " . $conn->error;
        } else {
            // Bind parameters to the prepared statement
            $stmt->bind_param("isssi", $orderID, $customerName, $deliveryAddress, $deliveryDate, $orderInvoiceID);

            // Execute the query
            if ($stmt->execute()) {
                // Success
                $success = "Order sent to delivery successfully!";
                header("Location:send-order.php");  
                exit();
            } else {
                // Error
                $error = "Error adding send order: " . $stmt->error;
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
    <title>Add Send Order to Delivery</title>
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
    <style> 
        /* Form styling */
        form {
            display: grid;
            gap: 10px;
        }
        </style>
    <div class="main-content">
        <h1>Add New Send Order to Delivery</h1>
        <form method="POST">
            <label for="orderID">Order ID</label>
            <input type="number" name="orderID" placeholder="Enter Order ID" min="1" required><br>

            <label for="customerName">Customer Name</label>
            <input type="text" name="customerName" placeholder="Enter Customer Name" required><br>

            <label for="deliveryAddress">Delivery Address</label>
            <input type="text" name="deliveryAddress" placeholder="Enter Delivery Address" required><br>

            <label for="deliveryDate">Delivery Date</label>
            <input type="date" name="deliveryDate" required><br>

            <label for="orderInvoiceID">Order Invoice ID</label>
            <input type="number" name="orderInvoiceID" placeholder="Enter Order Invoice ID" min="1" required><br>

            <button type="submit" name="addSendOrder">Save Send Order</button>
        </form>
    </div>

</body>
</html>
