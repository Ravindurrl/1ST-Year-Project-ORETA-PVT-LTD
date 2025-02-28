<?php

include 'config.php'; 
$error = $success = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['addSalesperson'])) {
        // Get the input values from the form
        $spid = $_POST['spid'];
        $spname = $_POST['spname'];
        $sptel = $_POST['sptel'];
        $spdob = $_POST['spdob'];
        $spaddress = $_POST['spaddress'];

        // SQL query to insert the salesperson data
        $sql = "INSERT INTO salesperson (spid, spname, sptel, spdob, spaddress) 
                VALUES (?, ?, ?, ?, ?)";

        // Prepare the SQL statement
        $stmt = $conn->prepare($sql);

        // Check if the preparation is successful
        if ($stmt === false) {
            $error = "Error preparing statement: " . $conn->error;
        } else {
            // Bind parameters to the prepared statement
            $stmt->bind_param("sssss", $spid, $spname, $sptel, $spdob, $spaddress);

            // Execute the query
            if ($stmt->execute()) {
                // Redirect after successful update
                header("Location:viewsalesperson.php"); 
                exit();
            } else {
                $error = "Error adding salesperson: " . $stmt->error;
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
  <title>Add Salesperson</title>
  <link rel="stylesheet" href="Supevisoradd.css">
</head>
<body>

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


  <div class="container">
    <h1>Add Salesperson</h1>

    <!-- Success/Error Messages -->
    <?php if (!empty($error)): ?>
      <p class="error"><?php echo $error; ?></p>
    <?php endif; ?>

    <?php if (!empty($success)): ?>
      <p class="success"><?php echo $success; ?></p>
    <?php endif; ?>

    <!-- Salesperson Add Form -->
    <form method="POST">
      <label for="spid">Salesperson ID</label>
      <input type="text" name="spid" required>

      <label for="spname">Salesperson Name</label>
      <input type="text"  name="spname" required>

      <label for="sptel">Telephone</label>
      <input type="tel"  name="sptel" required>

      <label for="spdob">Birthday</label>
      <input type="date"  name="spdob" required>

      <label for="spaddress">Address</label>
      <input type="text"  name="spaddress" required>

      <button type="submit" name="addSalesperson">Save Salesperson</button>
    </form>
  </div>

</body>
</html>
