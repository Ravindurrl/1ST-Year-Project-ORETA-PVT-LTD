<?php
include 'config.php'; 

// Handling OrderInvoice update
$error = $success = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['updateOrderInvoice'])) {
        // Get the input values from the form
        $orderInvoiceID = $_POST['orderInvoiceID'];
        $description = $_POST['description'];
        $discount = $_POST['discount'];
        $orderInvoiceDate = $_POST['orderInvoiceDate'];
        $orderAmount = $_POST['orderAmount'];

        // SQL query to update the OrderInvoice data
        $sql = "UPDATE OrderInvoice 
                SET Description = ?, Discount = ?, OrderInvoiceDate = ?, OrderAmount = ? 
                WHERE OrderInvoiceID = ?";

        // Prepare the SQL statement
        $stmt = $conn->prepare($sql);

        // Check if the preparation is successful
        if ($stmt === false) {
            $error = "Error preparing statement: " . $conn->error;
        } else {
            // Bind parameters to the prepared statement
            $stmt->bind_param("sdsdi", $description, $discount, $orderInvoiceDate, $orderAmount, $orderInvoiceID);

            // Execute the query
            if ($stmt->execute()) {
                $success = "OrderInvoice updated successfully!";
                header("Location: vieworders.php");
                exit();
            } else {
                $error = "Error updating OrderInvoice: " . $stmt->error;
            }

            // Close the statement
            $stmt->close();
        }
    }
}

// Fetch the OrderInvoice data to pre-fill the form
if (isset($_GET['id'])) {
    $orderInvoiceID = $_GET['id'];
    $sql = "SELECT * FROM OrderInvoice WHERE OrderInvoiceID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $orderInvoiceID);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $description = $row['Description'];
        $discount = $row['Discount'];
        $orderInvoiceDate = $row['OrderInvoiceDate'];
        $orderAmount = $row['OrderAmount'];
    } else {
        $error = "OrderInvoice not found!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Update OrderInvoice</title>

    
    <link rel="stylesheet" href="Supevisoradd.css">
    <div class="container">
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
</head>
<body>

<div class="container">
    <h1>Update OrderInvoice</h1>

    <!-- Success/Error Messages -->
    <?php if (!empty($error)): ?>
        <p class="error"><?php echo $error; ?></p>
    <?php endif; ?>

    <?php if (!empty($success)): ?>
        <p class="success"><?php echo $success; ?></p>
    <?php endif; ?>

    <!-- OrderInvoice Update Form -->
    <form method="POST">
        <input type="hidden" name="orderInvoiceID" value="<?php echo $orderInvoiceID; ?>">

        <label for="description">Description</label>
        <input type="text" name="description" value="<?php echo $description; ?>" required>

        <label for="discount">Discount</label>
        <input type="number" step="0.01" name="discount" value="<?php echo $discount; ?>" required>

        <label for="orderInvoiceDate">Order Invoice Date</label>
        <input type="date" name="orderInvoiceDate" value="<?php echo $orderInvoiceDate; ?>" required>

        <label for="orderAmount">Order Amount</label>
        <input type="number" step="0.01" name="orderAmount" value="<?php echo $orderAmount; ?>" required>

        <button type="submit" name="updateOrderInvoice">Update OrderInvoice</button>
    </form>
</div>

</body>
</html>
