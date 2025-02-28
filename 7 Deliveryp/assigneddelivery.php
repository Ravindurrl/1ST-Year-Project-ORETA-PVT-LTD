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
    <title>Assigned Orders to Deliver </title>

    <link rel="stylesheet" href="Supevisoradd.css"> 
</head>
<body>

      <!-- Sidebar Navigation -->
    <aside class="sidebar">
        <h2>Delivery Partner</h2>
        <ul class="sidebar-links">
            
            <li><a href="proofdelivery.php">📝 Proof of Delivery</a></li>
            <li><a href="assigneddelivery.php">📋 Assigned Orders</a></li>
        </ul>
        <!-- Logout Button -->
        <a href="dlvlogout.php" class="logout-btn">Logout</a>
    </aside>
    <div class="main-content">
        <h1>Assign  Deliveries</h1>

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
                           </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>No orders found</td></tr>";
                }
                ?>
            </tbody>
        </table>

       
    </div>
</div>

</body>
</html>
