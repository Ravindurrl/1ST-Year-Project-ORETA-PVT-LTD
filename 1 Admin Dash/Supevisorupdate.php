<?php
include 'config.php'; // Include the database connection

$error = $success = "";

// Handle the update form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['updateSupervisor'])) {
    // Retrieve form data
    $sup_id = $_POST['sup_id'];
    $name = $_POST['sup_name'];
    $address = $_POST['sup_address'];
    $email = $_POST['sup_email'];
    $phoneNo = $_POST['sup_tel'];

    // Validate inputs (basic validation)
    if (empty($name) || empty($address) || empty($email) || empty($phoneNo)) {
        $error = "All fields are required.";
    } else {
        // Prepare the SQL update query
        $sql = "UPDATE supervisor 
                SET sup_name = ?, sup_address = ?, sup_email = ?, sup_tel = ? 
                WHERE sup_id = ?";

        $stmt = $conn->prepare($sql);

        if ($stmt === false) {
            $error = "Error preparing statement: " . $conn->error;
        } else {
            // Bind parameters and execute the query
            $stmt->bind_param("ssssi", $name, $address, $email, $phoneNo, $sup_id);

            if ($stmt->execute()) {
                // Redirect after successful update
                header("Location: Supevisorviewphp.php."); // Change to your supervisor table page
                exit();
            } else {
                $error = "Error updating supervisor: " . $stmt->error;
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
    <link rel="stylesheet" href="Supevisoradd.css">
    <title>Update Supervisor</title>
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
    <h1>Update Supervisor Details</h1>

    <?php if (!empty($error)): ?>
        <p class="error"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>

    <?php if (!empty($success)): ?>
        <p class="success"><?php echo htmlspecialchars($success); ?></p>
    <?php endif; ?>

    <?php
    // Fetch the supervisor details if `id` is provided in GET
    if (isset($_GET['id'])) {
        $sup_id = $_GET['id'];

        $sql = "SELECT * FROM supervisor WHERE sup_id = ?";
        $stmt = $conn->prepare($sql);

        if ($stmt === false) {
            echo "<p class='error'>Error preparing statement: " . $conn->error . "</p>";
        } else {
            $stmt->bind_param("i", $sup_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $supervisor = $result->fetch_assoc();
            $stmt->close();
        }
    }

    if (!empty($supervisor)): ?>
    <form method="POST" action="Supevisorupdate.php">
        <input type="hidden" name="sup_id" value="<?php echo htmlspecialchars($supervisor['sup_id']); ?>">

        <label for="sup_name">Name:</label>
        <input type="text" name="sup_name" value="<?php echo htmlspecialchars($supervisor['sup_name']); ?>" required>

        <label for="sup_address">Address:</label>
        <input type="text" name="sup_address" value="<?php echo htmlspecialchars($supervisor['sup_address']); ?>" required>

        <label for="sup_email">Email:</label>
        <input type="email" name="sup_email" value="<?php echo htmlspecialchars($supervisor['sup_email']); ?>" required>

        <label for="sup_tel">Phone No:</label>
        <input type="text" name="sup_tel" value="<?php echo htmlspecialchars($supervisor['sup_tel']); ?>" required>

        <button type="submit" name="updateSupervisor">Update Supervisor</button>
    </form>
    <?php else: ?>
        <p>No supervisor found to update.</p>
    <?php endif; ?>
</div>
</body>
</html>
