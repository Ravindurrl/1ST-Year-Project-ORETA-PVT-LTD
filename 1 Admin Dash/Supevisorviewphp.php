<?php
include 'config.php'; // Include the database connection

$error = $success = "";

// Handling supervisor addition
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['addSupervisor'])) {
        // Get the input values
        $name = $_POST['sup_name'];
        $address = $_POST['sup_address'];
        $email = $_POST['sup_email'];
        $phoneNo = $_POST['sup_tel'];

        // SQL query to insert the supervisor data
        $sql = "INSERT INTO supervisor (sup_name, sup_address, sup_email, sup_tel) 
                VALUES (?, ?, ?, ?)";

        // Prepare the SQL statement
        $stmt = $conn->prepare($sql);

        // Check if the preparation is successful
        if ($stmt === false) {
            $error = "Error preparing statement: " . $conn->error;
        } else {
            // Bind parameters to the prepared statement
            $stmt->bind_param("ssss", $name, $address, $email, $phoneNo);

            // Execute the query
            if ($stmt->execute()) {
                $success = "Supervisor added successfully!";
            } else {
                $error = "Error adding supervisor: " . $stmt->error;
            }

            // Close the statement
            $stmt->close();
        }
    }
}

// Fetch supervisors from the database to display in a table
$sql = "SELECT * FROM supervisor";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Supevisoradd.css">
    <title>Supervisor Management</title>
    <script src="sprvsrmngmnt.js"></script>
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
        <h1>Supervisor Management</h1>
    </div>

    <?php if (!empty($error)): ?>
        <p class="error"><?php echo $error; ?></p>
    <?php endif; ?>

    <?php if (!empty($success)): ?>
        <p class="success"><?php echo $success; ?></p>
    <?php endif; ?>

    <!-- Supervisor List Table -->
    <h2>List of Supervisors</h2>
    <table>
        <thead>
            <tr>
                <th>Supervisor ID</th>
                <th>Name</th>
                <th>Address</th>
                <th>Email</th>
                <th>Phone No</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['sup_id'] . "</td>";
                    echo "<td>" . $row['sup_name'] . "</td>";
                    echo "<td>" . $row['sup_address'] . "</td>";
                    echo "<td>" . $row['sup_email'] . "</td>";
                    echo "<td>" . $row['sup_tel'] . "</td>";
                    echo "<td>
                            <button onclick=\"window.location.href='Supevisorupdate.php?id=" . $row['sup_id'] . "'\">Edit</button>
                            <button onclick=\"if(confirm('Are you sure you want to delete this supervisor?')) window.location.href='Supevisordelete.php?id=" . $row['sup_id'] . "';\">Delete</button>
                          </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6'>No supervisors found</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <!-- Button styled with a link -->
    <button onclick="window.location.href='Supevisoradd.php'" style="padding: 10px 20px; background-color: white; color: black; border: none; border-radius: 5px; cursor: pointer; transition: background-color 0.3s ease, transform 0.2s ease;">
        Add New Supervisor
    </button>

    <script>
        // JavaScript for form validation
        document.querySelector('form').onsubmit = function(event) {
            const name = document.querySelector('[name="sup_name"]').value;
            if (!name) {
                alert('Please fill out the name field.');
                event.preventDefault();
            }
        };
    </script>
</div>

</body>
</html>
