<?php
session_start();
include 'config.php'; 

$error = $success = "";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['submitDeliveryAssignment'])) {
        // Get input values
        $assigned_deliveryid = $_POST['assigned_deliveryid'];
        $delivery_partner_id = $_POST['delivery_partner_id'];
        $delstatus = $_POST['delstatus'];

        // SQL query to insert the delivery assignment
        $sql = "INSERT INTO assigned_delivery (assigned_deliveryid, delivery_partner_id, delstatus) VALUES (?, ?, ?)";

        // Prepare the SQL statement
        $stmt = $conn->prepare($sql);

        if ($stmt === false) {
            $error = "Error preparing statement: " . $conn->error;
        } else {
            // Bind parameters
            $stmt->bind_param("sis", $assigned_deliveryid, $delivery_partner_id, $delstatus);

            if ($stmt->execute()) {
                $success = "New delivery assignment added successfully.";
            } else {
                $error = "Error adding delivery assignment: " . $stmt->error;
            }

            $stmt->close();
        }
    }
}

// Fetch delivery assignments
$sql = "SELECT assigned_deliveryid, delivery_partner_id, delstatus FROM assigned_delivery";
$result = $conn->query($sql);

if (!$result) {
    die("Error fetching assigned deliveries: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assigned Deliveries</title>
    
    <link rel="stylesheet" href="Supevisoradd.css">
</head>
<body>
<div class="container">
    <!-- Sidebar Navigation -->
    <div class="sidebar">
        <h2>Sales & Marketing Manager</h2>
        <ul class="sidebar-links">
            <li><a href="viewsalesperson.php">View Sales Person</a></li>
            <li><a href="vieworders.php">View Orders</a></li>
            <li><a href="deliverypartner.php">View Delivery Partners</a></li>
            <li><a href="generateDiscount.php">Generate Discount</a></li>
            <li><a href="viewsalestarget.php">View Sales Target</a></li>
            <li><a href="viewproducts.php">View Products</a></li>
            <li><a href="generatebusinessplan.php">Generate Business Plan</a></li>
            <li><a href="viewinventory.php">View Inventory</a></li>
            <li><a href="eventview.php">View Event</a></li>

        </ul>
        <!-- Logout Button -->
        <a href="slmlogout.php" class="logout-btn">Logout</a>
    </div>
        <div class="main-content">
            <h1>Add Assigned Delivery</h1>

            <?php if ($error): ?>
                <div class="error"><?php echo $error; ?></div>
            <?php elseif ($success): ?>
                <div class="success"><?php echo $success; ?></div>
            <?php endif; ?>

            <form method="POST" action="">
                <label for="assigned_deliveryid">Assigned Delivery ID:</label>
                <input type="text" name="assigned_deliveryid" id="assigned_deliveryid" required><br><br>

                <label for="delivery_partner_id">Delivery Partner ID:</label>
                <input type="number" name="delivery_partner_id" id="delivery_partner_id" required><br><br>

                <label for="delstatus">Delivery Status:</label>
                <select name="delstatus" id="delstatus" required>
                    <option value="Assigned">Assigned</option>
                    <option value="notyet">notyet</option>
                </select><br><br>

                <button type="submit" name="submitDeliveryAssignment">Add Delivery</button>
            </form>

            <h2>Assigned Deliveries</h2>
            <table>
                <thead>
                    <tr>
                        <th>Assigned Delivery ID</th>
                        <th>Delivery Partner ID</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['assigned_deliveryid']; ?></td>
                            <td><?php echo $row['delivery_partner_id']; ?></td>
                            <td><?php echo $row['delstatus']; ?></td>

                            <td>
                    <!-- Add Delete Button with confirmation prompt -->
                    <button onclick="if(confirm('Are you sure you want to delete this assigned delivery?')) window.location.href='deliverypartnerdelete.php?id=<?php echo $row['assigned_deliveryid']; ?>';">
                        Delete
                    </button>
                </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
