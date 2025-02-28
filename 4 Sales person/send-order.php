<?php
include 'config.php';

// Fetch all records from sendorderdeli table
$sql = "SELECT * FROM sendorderdeli";  
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Send Order to Delivery</title>

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
    <div class="main-content">
        <h1>Send Orders to Delivery</h1>

        <!-- Success/Error Messages -->
        <?php if (!empty($error)): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>

        <?php if (!empty($success)): ?>
            <p class="success"><?php echo $success; ?></p>
        <?php endif; ?>

        <!-- Orders Table -->
        <table id="sendOrderTable">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Customer Name</th>
                    <th>Delivery Address</th>
                    <th>Delivery Date</th>
                    <th>Order Invoice ID</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Check if any records are found
                if ($result->num_rows > 0) {
                    // Loop through each record and display in the table
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['OrderID'] . "</td>";
                        echo "<td>" . $row['CustomerName'] . "</td>";
                        echo "<td>" . $row['DeliveryAddress'] . "</td>";
                        echo "<td>" . $row['DeliveryDate'] . "</td>";
                        echo "<td>" . $row['OrderInvoiceID'] . "</td>";
                        echo "<td>
                                <button onclick=\"window.location.href='sendorderupdate.php?id=" . $row['OrderID'] . "'\">Edit</button>
                                <button onclick=\"if(confirm('Are you sure you want to delete this order?')) window.location.href='sendorderdelete.php?id=" . $row['OrderID'] . "';\">Delete</button>
                              </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>No orders found</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <!-- Button to Add New Order -->
        <button onclick="window.location.href='sendorderadd.php'" style="padding: 10px 20px; background-color: white; color: black; border: none; border-radius: 5px; cursor: pointer; transition: background-color 0.3s ease, transform 0.2s ease;">
            Add New Order
        </button>
    </div>
</div>

</body>
</html>
