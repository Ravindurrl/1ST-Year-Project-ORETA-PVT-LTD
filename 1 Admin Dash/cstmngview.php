<?php
include 'config.php'; 

$error = $success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['addCustomer'])) {
        // Get the input values
        $cus_id = $_POST['cus_id'];
        $cus_name = $_POST['cus_name'];
        $cus_tel = $_POST['cus_tel'];
        $cus_address = $_POST['cus_address'];
        $cus_email = $_POST['cus_email'];

        // SQL query to insert the customer data
        $sql = "INSERT INTO customer (cus_id, cus_name, cus_tel, cus_address, cus_email) 
                VALUES (?, ?, ?, ?, ?)";

        // Prepare the SQL statement
        $stmt = $conn->prepare($sql);

        // Check if the preparation is successful
        if ($stmt === false) {
            $error = "Error preparing statement: " . $conn->error;
        } else {
            // Bind parameters to the prepared statement
            $stmt->bind_param("sssss", $cus_id, $cus_name, $cus_tel, $cus_address, $cus_email);

            // Execute the query
            if ($stmt->execute()) {
                $success = "Customer added successfully!";
            } else {
                $error = "Error adding customer: " . $stmt->error;
            }

            // Close the statement
            $stmt->close();
        }
    }
}

// Fetch customers from the database to display in a table
$sql = "SELECT * FROM customer";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Supevisoradd.css">
    <script src="customer.js"></script>
    <title>Customer Management</title>
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
    <div class="profile-header">
      <br>  <h1>Customer Management</h1><br>
    </div>

    <?php if (!empty($error)): ?>
        <p class="error"><?php echo $error; ?></p>
    <?php endif; ?>

    <?php if (!empty($success)): ?>
        <p class="success"><?php echo $success; ?></p>
    <?php endif; ?>

    <!-- Customer List Table -->
    <br><h2>List of Customers</h2><br>
    <table>
        <thead>
            <tr>
                <th>Customer ID</th>
                <th>Name</th>
                <th>Phone</th>
                <th>Address</th>
                <th>Email</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['cus_id'] . "</td>";
                    echo "<td>" . $row['cus_name'] . "</td>";
                    echo "<td>" . $row['cus_tel'] . "</td>";
                    echo "<td>" . $row['cus_address'] . "</td>";
                    echo "<td>" . $row['cus_email'] . "</td>";
                    echo "<td>
                            <button onclick=\"window.location.href='cstmngupdate.php?id=" . $row['cus_id'] . "'\">Edit</button>
                            <button onclick=\"if(confirm('Are you sure you want to delete this customer?')) window.location.href='cstmngdelete.php?id=" . $row['cus_id'] . "';\">Delete</button>
                          </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6'>No customers found</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <!-- Button styled with a link -->
    <button onclick="window.location.href='cstmadd.php'" style="padding: 10px 20px; background-color: white; color: black; border: none; border-radius: 5px; cursor: pointer; transition: background-color 0.3s ease, transform 0.2s ease;">
        Add New Customer
    </button>

</div>

</body>
</html>
