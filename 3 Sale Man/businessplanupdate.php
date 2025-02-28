


<?php
include 'config.php';

// Check if ID is provided in the URL
if (isset($_GET['id'])) {
    $businessPlanID = $_GET['id'];

    // Fetch the business plan details from the database
    $sql = "SELECT * FROM businessplan WHERE BusinessPlanID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $businessPlanID);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $businessPlan = $result->fetch_assoc();
    } else {
        $error = "Business Plan not found.";
    }
}

// Update business plan details
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $description = $_POST['description'];
    $plannedStarted = $_POST['plannedStarted'];
    $planEnd = $_POST['planEnd'];

    // Update the business plan in the database
    $sql = "UPDATE businessplan SET Description = ?, PlannedStarted = ?, PlanEND = ? WHERE BusinessPlanID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $description, $plannedStarted, $planEnd, $businessPlanID);
    
    if ($stmt->execute()) {
        $success = "Business Plan updated successfully!";
        header("Location: generatebusinessplan.php");
        exit();
    } else {
        $error = "Error updating business plan: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit Business Plan</title>
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
        <h1>Edit Business Plan</h1>

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
        
        <!-- Business Plan Update Form -->
        <form method="POST">
            <label for="description">Description</label>
            <input type="text" name="description" value="<?php echo $businessPlan['Description']; ?>" required><br>

            <label for="plannedStarted">Planned Start Date</label>
            <input type="date" name="plannedStarted" value="<?php echo $businessPlan['PlannedStarted']; ?>" required><br>

            <label for="planEnd">Plan End Date</label>
            <input type="date" name="planEnd" value="<?php echo $businessPlan['PlanEND']; ?>" required><br>

            <button type="submit">Update Business Plan</button>
        </form>
    </div>
</div>

</body>
</html>
