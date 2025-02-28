<?php
include 'config.php'; 
$error = $success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['addSalesTarget'])) {
        
        $salesTargetID = $_POST['salesTargetID']; // Optional for auto-increment
        $nameOfSalesTarget = $_POST['nameOfSalesTarget'];
        $startDate = $_POST['startDate'];
        $endDate = $_POST['endDate'];
        $description = $_POST['description'];

        // SQL query to insert the sales target data
        $sql = "INSERT INTO sales_target (SalesTargetID, NameofSalesTarget, StartDate, EndDate, Description) 
                VALUES (?, ?, ?, ?, ?)";

        // Prepare the SQL statement
        $stmt = $conn->prepare($sql);

        // Check if the preparation is successful
        if ($stmt === false) {
            $error = "Error preparing statement: " . $conn->error;
        } else {
            // Bind parameters to the prepared statement
            $stmt->bind_param("issss", $salesTargetID, $nameOfSalesTarget, $startDate, $endDate, $description);

            // Execute the query
            if ($stmt->execute()) {
                // Success
                $success = "Sales Target added successfully!";
                header("Location: viewsalestarget.php"); 
                exit();
            } else {
                // Error
                $error = "Error adding Sales Target: " . $stmt->error;
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
    <title>Add Sales Target</title>
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
        column-width: 20px;
    }</style>
    <!-- Sales Target Add Form -->
    <div class="main-content">
        <h1>Add New Sales Target</h1>
        <form method="POST">
            <label for="salesTargetID">Sales Target ID</label>
            <input type="number" name="salesTargetID" placeholder="Leave empty for auto-increment" min="1"><br>

            <label for="nameOfSalesTarget">Name of Sales Target</label>
            <input type="text" name="nameOfSalesTarget" required><br>

            <label for="startDate">Start Date</label>
            <input type="date" name="startDate" required><br>

            <label for="endDate">End Date</label>
            <input type="date" name="endDate" required><br>

            <label for="description">Description</label>
            <textarea name="description" required></textarea><br>

            <button type="submit" name="addSalesTarget">Save Sales Target</button>
        </form>
    </div>
</div>

</body>
</html>
