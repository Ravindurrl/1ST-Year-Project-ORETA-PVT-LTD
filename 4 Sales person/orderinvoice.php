<?php
include 'config.php';
$sql = "SELECT * FROM orderinvoice";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Order Invoice Management</title>
    

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

    <div class="main-content">
        <h1>Order Invoices</h1>

        <!-- Success/Error Messages -->
        <?php if (!empty($error)): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>

        <?php if (!empty($success)): ?>
            <p class="success"><?php echo $success; ?></p>
        <?php endif; ?>

        <!-- Order Invoice Table -->
        <table id="orderInvoiceTable">
            <thead>
                <tr>
                    <th>Invoice ID</th>
                    <th>Description</th>
                    <th>Discount</th>
                    <th>Invoice Date</th>
                    <th>Order Amount</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <!-- Dynamic rows will be inserted here -->
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['OrderInvoiceID'] . "</td>";
                        echo "<td>" . $row['Description'] . "</td>";
                        echo "<td>" . $row['Discount'] . "</td>";
                        echo "<td>" . $row['OrderInvoiceDate'] . "</td>";
                        echo "<td>" . $row['OrderAmount'] . "</td>";
                        echo "<td>
                                <button onclick=\"window.location.href='invoiceupdate.php?id=" . $row['OrderInvoiceID'] . "'\">Edit</button>
                                <button onclick=\"if(confirm('Are you sure you want to delete this invoice?')) window.location.href='invoiceupdelete.php?id=" . $row['OrderInvoiceID'] . "';\">Delete</button>
                              </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>No invoices found</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <!-- New Button to Add Order Invoice -->
        <button onclick="window.location.href='invoiceadd.php'" style="padding: 10px 20px; background-color: white; color: black; border: none; border-radius: 5px; cursor: pointer; transition: background-color 0.3s ease, transform 0.2s ease;">
            Add New Invoice
        </button>
    </div>
</div>

</body>
</html>
