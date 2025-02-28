<?php
include 'config.php';
$error = $success = "";

// Check if the order ID is provided in the URL
if (isset($_GET['id'])) {
    $orderID = $_GET['id'];

    // Fetch the current data for the order
    $sql = "SELECT * FROM sendorderdeli WHERE OrderID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $orderID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Store the current values in variables for the form
        $customerName = $row['CustomerName'];
        $deliveryAddress = $row['DeliveryAddress'];
        $deliveryDate = $row['DeliveryDate'];
        $orderInvoiceID = $row['OrderInvoiceID'];
    } else {
        $error = "Order not found.";
    }

    // Update the order details if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $customerName = $_POST['customerName'];
        $deliveryAddress = $_POST['deliveryAddress'];
        $deliveryDate = $_POST['deliveryDate'];
        $orderInvoiceID = $_POST['orderInvoiceID'];

        // SQL query to update the sendorderdeli record
        $sql = "UPDATE sendorderdeli SET CustomerName = ?, DeliveryAddress = ?, DeliveryDate = ?, OrderInvoiceID = ? WHERE OrderID = ?";
        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            $error = "Error preparing statement: " . $conn->error;
        } else {
            $stmt->bind_param("sssii", $customerName, $deliveryAddress, $deliveryDate, $orderInvoiceID, $orderID);
            if ($stmt->execute()) {
                $success = "Order updated successfully!";
                header("Location: send-order.php");
                exit();
            } else {
                $error = "Error updating order: " . $stmt->error;
            }
        }
    }
} else {
    $error = "No order ID provided.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Send Order</title>
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

<div class="main-content">
<style> 

/* Form styling */
form {
    display: grid;
    gap: 10px;
}
</style>
    <h1>Update Send Order</h1>
    <form method="POST">
        <label for="customerName">Customer Name</label>
        <input type="text" name="customerName" value="<?php echo $customerName; ?>" required><br>

        <label for="deliveryAddress">Delivery Address</label>
        <input type="text" name="deliveryAddress" value="<?php echo $deliveryAddress; ?>" required><br>

        <label for="deliveryDate">Delivery Date</label>
        <input type="date" name="deliveryDate" value="<?php echo $deliveryDate; ?>" required><br>

        <label for="orderInvoiceID">Order Invoice ID</label>
        <input type="number" name="orderInvoiceID" value="<?php echo $orderInvoiceID; ?>" required><br>

        <button type="submit">Update Order</button>
    </form>
</div>

</body>
</html>
