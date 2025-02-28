<?php
include 'config.php'; 

$error = $success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['addEmployee'])) {
        // Get the input values from the form
        $name = $_POST['emp_name'];
        $phone = $_POST['emp_tel'];
        $dob = $_POST['emp_dob'];
        $nic = $_POST['emp_nic'];
        $email = $_POST['emp_email'];

        // SQL query to insert the employee data
        $sql = "INSERT INTO employee (emp_name, emp_tel, emp_dob, NIC_no, emp_email) 
                VALUES (?, ?, ?, ?, ?)";

        // Prepare the SQL statement
        $stmt = $conn->prepare($sql);

        // Check if the preparation is successful
        if ($stmt === false) {
            $error = "Error preparing statement: " . $conn->error;
        } else {
            // Bind parameters to the prepared statement
            $stmt->bind_param("sssss", $name, $phone, $dob, $nic, $email);

            // Execute the query
            if ($stmt->execute()) {
                $success = "Employee added successfully!";
            } else {
                $error = "Error adding employee: " . $stmt->error;
            }

            // Close the statement
            $stmt->close();
        }
    }
}

// Fetch employees from the database to display in a table
$sql = "SELECT * FROM employee";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Supevisoradd.css">
    <script src="employeemngmnt.js"> </script>
    <title>Employee Management</title>
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
        <br><h1>Employee Management</h1><br>
    </div>

    <?php if (!empty($error)): ?>
        <p class="error"><?php echo $error; ?></p>
    <?php endif; ?>

    <?php if (!empty($success)): ?>
        <p class="success"><?php echo $success; ?></p>
    <?php endif; ?>

    <!-- Employee List Table -->
    <br><h2>List of Employees</h2><br>
    <table>
        <thead>
            <tr>
                <th>Employee ID</th>
                <th>Name</th>
                <th>Phone</th>
                <th>DOB</th>
                <th>NIC</th>
                <th>Email</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['emp_id'] . "</td>";
                    echo "<td>" . $row['emp_name'] . "</td>";
                    echo "<td>" . $row['emp_tel'] . "</td>";
                    echo "<td>" . $row['emp_dob'] . "</td>";
                    echo "<td>" . $row['NIC_no'] . "</td>";
                    echo "<td>" . $row['emp_email'] . "</td>";
                    echo "<td>
                            <button onclick=\"window.location.href='empmngupdate.php?id=" . $row['emp_id'] . "'\">Edit</button>
                            <button onclick=\"if(confirm('Are you sure you want to delete this employee?')) window.location.href='empdelete.php?id=" . $row['emp_id'] . "';\">Delete</button>
                          </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='7'>No employees found</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <!-- Button styled with a link -->
    <button onclick="window.location.href='empaddphp.php'" style="padding: 10px 20px; background-color: white; color: black; border: none; border-radius: 5px; cursor: pointer; transition: background-color 0.3s ease, transform 0.2s ease;">
        Add New Employee
    </button>

</div>

</body>
</html>
