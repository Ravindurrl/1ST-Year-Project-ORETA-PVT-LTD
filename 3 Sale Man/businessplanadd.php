<?php
include 'config.php'; 
$error = $success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['addBusinessPlan'])) {
        // Get the input values from the form
        $businessPlanID = $_POST['businessPlanID'];
        $description = $_POST['description'];
        $plannedStarted = $_POST['plannedStarted'];  
        $planEnd = $_POST['planEnd'];                

        // SQL query to insert the business plan data
        $sql = "INSERT INTO businessplan (BusinessPlanID, Description, PlannedStarted, PlanEND) 
                VALUES (?, ?, ?, ?)";

        // Prepare the SQL statement
        $stmt = $conn->prepare($sql);

        // Check if the preparation is successful
        if ($stmt === false) {
            $error = "Error preparing statement: " . $conn->error;
        } else {
            // Bind parameters to the prepared statement
            $stmt->bind_param("isss", $businessPlanID, $description, $plannedStarted, $planEnd);

            // Execute the query
            if ($stmt->execute()) {
                // Success
                $success = "Business Plan added successfully!";
                header("Location: generatebusinessplan.php"); 
                exit();
            } else {
                // Error
                $error = "Error adding business plan: " . $stmt->error;
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
    <title>Add Business Plan</title>
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
    }
        </style>
    <!-- Business Plan Add Form -->
    <div class="main-content">
        <h1>Add New Business Plan</h1>
        <form method="POST">
            <label for="businessPlanID">Business Plan ID</label>
            <input type="number" name="businessPlanID" placeholder="Leave empty for auto-increment" min="1"><br>

            <label for="description">Description</label>
            <input type="text" name="description" required><br>

            <label for="plannedStarted">Planned Start Date</label>
            <input type="date" name="plannedStarted" required><br>

            <label for="planEnd">Plan End Date</label>
            <input type="date" name="planEnd" required><br>

            <button type="submit" name="addBusinessPlan">Save Business Plan</button>
        </form>
    </div>
</div>

</body>
</html>
