<?php
include 'config.php'; 

// Handling salesperson update
$error = $success = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['updateSalesperson'])) {
        // Get the input values from the form
        $spid = $_POST['spid'];
        $spname = $_POST['spname'];
        $sptel = $_POST['sptel'];
        $spdob = $_POST['spdob'];
        $spaddress = $_POST['spaddress'];

        // SQL query to update the salesperson data
        $sql = "UPDATE salesperson 
                SET spname = ?, sptel = ?, spdob = ?, spaddress = ? 
                WHERE spid = ?";

        // Prepare the SQL statement
        $stmt = $conn->prepare($sql);

        // Check if the preparation is successful
        if ($stmt === false) {
            $error = "Error preparing statement: " . $conn->error;
        } else {
            // Bind parameters to the prepared statement
            $stmt->bind_param("sssss", $spname, $sptel, $spdob, $spaddress, $spid);

            // Execute the query
            if ($stmt->execute()) {
                $success = "Salesperson updated successfully!";
                header("Location:viewsalesperson.php ");
            } else {
                $error = "Error updating salesperson: " . $stmt->error;
            }

            // Close the statement
            $stmt->close();
        }
    }
}

// Fetch the salesperson's data to pre-fill the form
if (isset($_GET['id'])) {
    $spid = $_GET['id'];
    $sql = "SELECT * FROM salesperson WHERE spid = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $spid);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $spname = $row['spname'];
        $sptel = $row['sptel'];
        $spdob = $row['spdob'];
        $spaddress = $row['spaddress'];
    } else {
        $error = "Salesperson not found!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Update Salesperson</title>

    <!-- Link to external CSS for styling -->
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

    <h1>Update Salesperson</h1>

    <!-- Success/Error Messages -->
    <?php if (!empty($error)): ?>
        <p class="error"><?php echo $error; ?></p>
    <?php endif; ?>

    <?php if (!empty($success)): ?>
        <p class="success"><?php echo $success; ?></p>
    <?php endif; ?>

    <!-- Salesperson Update Form -->
    <form method="POST">
        <input type="hidden" name="spid" value="<?php echo $spid; ?>">

        <label for="spname">Salesperson Name</label>
        <input type="text" name="spname" value="<?php echo $spname; ?>" required>

        <label for="sptel">Telephone</label>
        <input type="tel" name="sptel" value="<?php echo $sptel; ?>" required>

        <label for="spdob">Birthday</label>
        <input type="date" name="spdob" value="<?php echo $spdob; ?>" required>

        <label for="spaddress">Address</label>
        <input type="text" name="spaddress" value="<?php echo $spaddress; ?>" required>

        <button type="submit" name="updateSalesperson">Update Salesperson</button>
    </form>
</div>

</body>
</html>
