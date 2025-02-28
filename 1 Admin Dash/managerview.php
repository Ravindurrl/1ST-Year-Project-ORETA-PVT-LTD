<?php
// Include the database connection (config.php should contain the database connection details)
include 'config.php';

// Fetch managers from the database to display in a table
$sql = "SELECT * FROM manager";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Manager Management</title>
  <link rel="stylesheet" href="Supevisoradd.css">
  <script src="mngrmngmnt.js"></script>
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
    <h1>Manager Management</h1>

    <!-- Success/Error Messages -->
    <?php if (!empty($error)): ?>
      <p class="error"><?php echo $error; ?></p>
    <?php endif; ?>

    <?php if (!empty($success)): ?>
      <p class="success"><?php echo $success; ?></p>
    <?php endif; ?>

   
    <!-- Managers Table -->
    <table id="managerTable">
      <thead>
        <tr>
          <th>ID</th>
          <th>Name</th>
          <th>Address</th>
          <th>Email</th>
          <th>Birth Date</th>
          <th>Telephone</th>
          <th>Salary</th>
          <th>Department</th>
          <th>NIC</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['id'] . "</td>";
                echo "<td>" . $row['name'] . "</td>";
                echo "<td>" . $row['address'] . "</td>";
                echo "<td>" . $row['email'] . "</td>";
                echo "<td>" . $row['birthday'] . "</td>";
                echo "<td>" . $row['telephone'] . "</td>";
                echo "<td>" . $row['salary'] . "</td>";
                echo "<td>" . $row['department'] . "</td>";
                echo "<td>" . $row['nic'] . "</td>";
                echo "<td>
                        <button onclick=\"window.location.href='managerupdate.php?id=" . $row['id'] . "'\">Edit</button>
                        <button onclick=\"if(confirm('Are you sure you want to delete this manager?')) window.location.href='managerdelete.php?id=" . $row['id'] . "';\">Delete</button>
                      </td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='10'>No managers found</td></tr>";
        }
        ?>
      </tbody>
    </table>

     <!-- New Button to Add Manager -->
     <button onclick="window.location.href='manageradd.php'" style="padding: 10px 20px; background-color: white; color: black; border: none; border-radius: 5px; cursor: pointer; transition: background-color 0.3s ease, transform 0.2s ease;">
        Add New Manager
    </button>

  </div>

  <script>
    // JavaScript for opening and closing the form modal
    function openAddManagerForm() {
      document.getElementById('managerFormModal').style.display = 'block';
    }

    function closeForm() {
      document.getElementById('managerFormModal').style.display = 'none';
    }
  </script>
</body>
</html>
