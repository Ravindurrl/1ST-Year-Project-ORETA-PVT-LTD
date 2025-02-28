<?php
include 'config.php';

// Check if PaymentID is provided in the URL
if (isset($_GET['id'])) {
    $paymentID = $_GET['id'];

    // SQL query to delete the payment record
    $sql = "DELETE FROM CustomerPayments WHERE payment_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $paymentID);

    if ($stmt->execute()) {
        $success = "Payment record deleted successfully!";
        header("Location: customerpayments.php"); 
        exit();
    } else {
        $error = "Error deleting payment record: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
} else {
    $error = "Payment ID not provided.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Delete Customer Payment</title>
    <link rel="stylesheet" href="Supevisoradd.css">
</head>
<body>

<div class="container">
    <!-- Sidebar Navigation -->
    <div class="sidebar">
        <h2>Salesperson Dashboard</h2>
        <ul class="sidebar-links">
            <li><a href="viewinventory.php">View Inventory</a></li>
            <li><a href="send-order.php">Send Order to Delivery</a></li>
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

    <!-- Delete Confirmation Message -->
    <div class="delete-confirmation">
        <p>Are you sure you want to delete this payment record?</p>
        <form method="GET">
            <button type="submit" class="confirm-delete">Yes, Delete</button>
            <a href="customerpayments.php" class="cancel-delete">Cancel</a>
        </form>
    </div>

</div>

</body>
</html>
