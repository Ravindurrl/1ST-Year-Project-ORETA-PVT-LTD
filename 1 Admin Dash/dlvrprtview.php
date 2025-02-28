<?php
include 'config.php'; 

$error = $success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['addDeliveryPartner'])) {
        // Get the input values
        $id = $_POST['delivery_partner_id'];
        $name = $_POST['delivery_partner_name'];
        $phone = $_POST['delivery_partner_tel'];
       

        // SQL query to insert the delivery partner data
        $sql = "INSERT INTO delivery_partner (Delivery_Partner_Id, Delivery_Partner_Name, Delivery_Partner_Tel, ) 
                VALUES (?, ?, ?, ?)";

        // Prepare the SQL statement
        $stmt = $conn->prepare($sql);

        // Check if the preparation is successful
        if ($stmt === false) {
            $error = "Error preparing statement: " . $conn->error;
        } else {
            // Bind parameters to the prepared statement
            $stmt->bind_param("ssss", $id, $name, $phone);

            // Execute the query
            if ($stmt->execute()) {
                $success = "Delivery partner added successfully!";
            } else {
                $error = "Error adding delivery partner: " . $stmt->error;
            }

            // Close the statement
            $stmt->close();
        }
    }
}

// Fetch delivery partners from the database to display in a table
$sql = "SELECT * FROM delivery_partner";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Supevisoradd.css">
    <script src="dlvrmngmnt.js"></script>
    <title>Delivery Partner Management</title>
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
      <br>  <h1>Delivery Partner Management</h1><br>
    </div>

    <?php if (!empty($error)): ?>
        <p class="error"><?php echo $error; ?></p>
    <?php endif; ?>

    <?php if (!empty($success)): ?>
        <p class="success"><?php echo $success; ?></p>
    <?php endif; ?>

    <!-- Delivery Partner List Table -->
    <br><h2>List of Delivery Partners</h2><br>
    <table>
        <thead>
            <tr>
                <th>Partner ID</th>
                <th>Name</th>
                <th>Phone</th>
              
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['Delivery_Partner_Id'] . "</td>";
                    echo "<td>" . $row['Delivery_Partner_Name'] . "</td>";
                    echo "<td>" . $row['Delivery_Partner_Tel'] . "</td>";
                  
                    echo "<td>
                            <button onclick=\"window.location.href='dlvrprtupdate.php?id=" . $row['Delivery_Partner_Id'] . "'\">Edit</button>
                            <button onclick=\"if(confirm('Are you sure you want to delete this delivery partner?')) window.location.href='dlvrprtdelete.php?id=" . $row['Delivery_Partner_Id'] . "';\">Delete</button>
                          </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No delivery partners found</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <!-- Button styled with a link -->
    <button onclick="window.location.href='dlvrprtadd.php'" style="padding: 10px 20px; background-color: white; color: black; border: none; border-radius: 5px; cursor: pointer; transition: background-color 0.3s ease, transform 0.2s ease;">
        Add New Delivery Partner
    </button>

</div>

</body>
</html>
