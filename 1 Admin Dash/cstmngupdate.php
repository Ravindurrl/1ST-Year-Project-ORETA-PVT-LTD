<?php
// Include the database connection 
include 'config.php'; 

// Handling customer update
$error = $success = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['updateCustomer'])) {
        // Get the input values from the form
        $cus_id = $_POST['cus_id'];
        $cus_name = $_POST['cus_name'];
        $cus_tel = $_POST['cus_tel'];
        $cus_address = $_POST['cus_address'];
        $cus_email = $_POST['cus_email'];

        // SQL query to update the customer data
        $sql = "UPDATE customer 
                SET cus_name = ?, cus_tel = ?, cus_address = ?, cus_email = ? 
                WHERE cus_id = ?";

        // Prepare the SQL statement
        $stmt = $conn->prepare($sql);

        // Check if the preparation is successful
        if ($stmt === false) {
            $error = "Error preparing statement: " . $conn->error;
        } else {
            // Bind parameters to the prepared statement
            $stmt->bind_param("sssss", $cus_name, $cus_tel, $cus_address, $cus_email, $cus_id);

            // Execute the query
            if ($stmt->execute()) {
                // Redirect after successful update
                header("Location: cstmngview.php"); // Change to your supervisor table page
                exit();
            } else {
                $error = "Error updating customer: " . $stmt->error;
            }

            // Close the statement
            $stmt->close();
        }
    }
}

// Fetch the customer details for the given cus_id
if (isset($_GET['id'])) {
    $cus_id = $_GET['id'];
    $sql = "SELECT * FROM customer WHERE cus_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $cus_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $customer = $result->fetch_assoc();
    } else {
        $error = "Customer not found!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Customer</title>
  <link rel="stylesheet" href="Supevisoradd.css">
</head>
<body>

  
   <!-- Sidebar Navigation -->
   <div class="sidebar">
        <h2>Admin Dashboard</h2>
        <ul class="sidebar-links"> 
            <li><a href="adm.html">Dashboard</a></li>
            <li><a href="cstmngview.php">Customers</a></li>
            <li><a href="empmngview.php">Employees</a></li>
            <li><a href="Supevisorviewphp.php">Supervisors</a></li>
            <li><a href="managerview.php">Managers</a></li>
            <li><a href="suppliermngview.php">Suppliers</a></li>
            <li><a href="dlvrprtview.php">Delivery Partners</a></li>
            <li><a href="generateDiscount.php">Discounts</a></li>
        </ul>
        <a href="admlogout.php" class="logout-btn">Logout</a>
        
       
    </div>

  <div class="container">
    <h1>Edit Customer</h1>

    <!-- Success/Error Messages -->
    <?php if (!empty($error)): ?>
      <p class="error"><?php echo $error; ?></p>
    <?php endif; ?>

    <?php if (!empty($success)): ?>
      <p class="success"><?php echo $success; ?></p>
    <?php endif; ?>

    <!-- Customer Edit Form -->
    <?php if (isset($customer)): ?>
      <form method="POST">
        <input type="hidden" name="cus_id" value="<?php echo $customer['cus_id']; ?>">

        <label for="cus_name">Customer Name</label>
        <input type="text" name="cus_name" value="<?php echo $customer['cus_name']; ?>" required>

        <label for="cus_tel">Telephone</label>
        <input type="tel" name="cus_tel" value="<?php echo $customer['cus_tel']; ?>" required>

        <label for="cus_address">Address</label>
        <input type="text" name="cus_address" value="<?php echo $customer['cus_address']; ?>" required>

        <label for="cus_email">Email</label>
        <input type="email" name="cus_email" value="<?php echo $customer['cus_email']; ?>" required>

        <button type="submit" name="updateCustomer">Update Customer</button>
      </form>
    <?php endif; ?>
  </div>

</body>
</html>
