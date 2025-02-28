<?php
// Include the database connection 
include 'config.php'; 

// Handling manager update
$error = $success = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['updateManager'])) {
        // Get the input values from the form
        $id = $_POST['id'];
        $name = $_POST['name'];
        $address = $_POST['address'];
        $email = $_POST['email'];
        $birthday = $_POST['birthday'];
        $telephone = $_POST['telephone'];
        $salary = $_POST['salary'];
        $department = $_POST['department'];
        $nic = $_POST['nic'];

        // SQL query to update the manager data
        $sql = "UPDATE manager 
                SET name = ?, address = ?, email = ?, birthday = ?, telephone = ?, salary = ?, department = ?, nic = ? 
                WHERE id = ?";

        // Prepare the SQL statement
        $stmt = $conn->prepare($sql);

        // Check if the preparation is successful
        if ($stmt === false) {
            $error = "Error preparing statement: " . $conn->error;
        } else {
            // Bind parameters to the prepared statement
            $stmt->bind_param("sssssdssi", $name, $address, $email, $birthday, $telephone, $salary, $department, $nic, $id);

            // Execute the query
            if ($stmt->execute()) {
                // Redirect after successful update
                header("Location: managerview.php"); // Change to your manager view page
                exit();
            } else {
                $error = "Error updating manager: " . $stmt->error;
            }

            // Close the statement
            $stmt->close();
        }
    }
}

// Fetch the manager details for the given ID
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM manager WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $manager = $result->fetch_assoc();
    } else {
        $error = "Manager not found!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Manager</title>
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
    <h1>Edit Manager</h1>

    <!-- Success/Error Messages -->
    <?php if (!empty($error)): ?>
      <p class="error"><?php echo $error; ?></p>
    <?php endif; ?>

    <?php if (!empty($success)): ?>
      <p class="success"><?php echo $success; ?></p>
    <?php endif; ?>

    <!-- Manager Edit Form -->
    <?php if (isset($manager)): ?>
      <form method="POST">
        <input type="hidden" name="id" value="<?php echo $manager['id']; ?>">

        <label for="name">Manager Name</label>
        <input type="text" name="name" value="<?php echo $manager['name']; ?>" required>

        <label for="address">Address</label>
        <input type="text" name="address" value="<?php echo $manager['address']; ?>" required>

        <label for="email">Email</label>
        <input type="email" name="email" value="<?php echo $manager['email']; ?>" required>

        <label for="birthday">Birth Date</label>
        <input type="date" name="birthday" value="<?php echo $manager['birthday']; ?>" required>

        <label for="telephone">Telephone</label>
        <input type="tel" name="telephone" value="<?php echo $manager['telephone']; ?>" required>

        <label for="salary">Salary</label>
        <input type="number" name="salary" value="<?php echo $manager['salary']; ?>" required>

        <label for="department">Department</label>
        <input type="text" name="department" value="<?php echo $manager['department']; ?>" required>

        <label for="nic">NIC</label>
        <input type="text" name="nic" value="<?php echo $manager['nic']; ?>" required>

        <button type="submit" name="updateManager">Update Manager</button>
      </form>
    <?php endif; ?>
  </div>

</body>
</html>
