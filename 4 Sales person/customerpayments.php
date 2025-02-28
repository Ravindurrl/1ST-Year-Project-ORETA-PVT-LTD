<?php
include 'config.php';

// Fetch CustomerPayments data
$sql = "SELECT * FROM CustomerPayments";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Customer Payments</title>

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

    <!-- Main Content -->
    <div class="main-content">
        <h1>Customer Payments</h1>

        <!-- Success/Error Messages -->
        <?php if (!empty($error)): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>

        <?php if (!empty($success)): ?>
            <p class="success"><?php echo $success; ?></p>
        <?php endif; ?>

        <!-- Payments Table -->
        <table id="paymentsTable">
            <thead>
                <tr>
                    <th>Payment ID</th>
                   
                    <th>Payment Type</th>
                    <th>Payment Date</th>
                    <th>Payment Amount</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <!-- Dynamic rows will be inserted here -->
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['payment_id'] . "</td>";
                       
                        echo "<td>" . $row['payment_type'] . "</td>";
                        echo "<td>" . $row['payment_date'] . "</td>";
                        echo "<td>" . $row['payment_amount'] . "</td>";
                        echo "<td>
                                <button onclick=\"window.location.href='updatepayment.php?id=" . $row['payment_id'] . "'\">Edit</button>
                                <button onclick=\"if(confirm('Are you sure you want to delete this payment?')) window.location.href='deletepayment.php?id=" . $row['payment_id'] . "';\">Delete</button>
                              </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>No payments found</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <!-- New Button to Add Payment -->
        <button onclick="window.location.href='addpayments.php'" style="padding: 10px 20px; background-color: white; color: black; border: none; border-radius: 5px; cursor: pointer; transition: background-color 0.3s ease, transform 0.2s ease;">
            Add New Payment
        </button>
    </div>
</div>

</body>
</html>
