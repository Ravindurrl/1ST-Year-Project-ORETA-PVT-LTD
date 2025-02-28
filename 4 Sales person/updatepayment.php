<?php
include 'config.php';


if (isset($_GET['id'])) {
    $paymentID = $_GET['id'];

    // Fetch existing payment data
    $sql = "SELECT * FROM CustomerPayments WHERE payment_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $paymentID);
    
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            // Fetch the current payment data
            $row = $result->fetch_assoc();
            $cus_id = $row['cus_id'];
            $paymentType = $row['payment_type'];
            $paymentDate = $row['payment_date'];
            $paymentAmount = $row['payment_amount'];
        } else {
            $error = "Payment record not found.";
        }
    } else {
        $error = "Error fetching payment record: " . $stmt->error;
    }

    // Check if the form is submitted to update the payment data
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $cus_id = $_POST['cus_id'];
        $paymentType = $_POST['paymentType'];
        $paymentDate = $_POST['paymentDate'];
        $paymentAmount = $_POST['paymentAmount'];

        // SQL query to update the payment record
        $sql = "UPDATE CustomerPayments SET cus_id = ?, payment_type = ?, payment_date = ?, payment_amount = ? WHERE payment_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("issdi", $cus_id, $paymentType, $paymentDate, $paymentAmount, $paymentID);

        if ($stmt->execute()) {
            $success = "Payment record updated successfully!";
            header("Location: customerpayments.php");
            exit();
        } else {
            $error = "Error updating payment record: " . $stmt->error;
        }
    }
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
    <title>Update Customer Payment</title>
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

    <!-- Customer Payment Update Form -->
    <?php if (isset($cus_id)): ?>
        <form method="POST">
            <label for="cus_id">Customer</label>
            <select name="cus_id" required>
                <option value="">Select Customer</option>
                <?php
                // Fetch customers for the dropdown
                $customerQuery = "SELECT cus_id, cus_name FROM Customer";
                $customerResult = $conn->query($customerQuery);

                if ($customerResult->num_rows > 0) {
                    while ($row = $customerResult->fetch_assoc()) {
                        echo "<option value=\"" . $row['cus_id'] . "\"" . ($row['cus_id'] == $cus_id ? ' selected' : '') . ">" . $row['cus_name'] . " (ID: " . $row['cus_id'] . ")</option>";
                    }
                } else {
                    echo "<option value=\"\">No customers found</option>";
                }
                ?>
            </select><br>

            <label for="paymentType">Payment Type</label>
            <select name="paymentType" required>
                <option value="Cash" <?php echo ($paymentType == 'Cash') ? 'selected' : ''; ?>>Cash</option>
                <option value="Card" <?php echo ($paymentType == 'Card') ? 'selected' : ''; ?>>Card</option>
                <option value="Bank Transfer" <?php echo ($paymentType == 'Bank Transfer') ? 'selected' : ''; ?>>Bank Transfer</option>
            </select><br>

            <label for="paymentDate">Payment Date</label>
            <input type="date" name="paymentDate" value="<?php echo $paymentDate; ?>" required><br>

            <label for="paymentAmount">Payment Amount</label>
            <input type="number" step="0.01" name="paymentAmount" value="<?php echo $paymentAmount; ?>" required><br>

            <button type="submit">Update Payment</button>
        </form>
    <?php endif; ?>
</div>

</body>
</html>
