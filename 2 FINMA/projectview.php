<?php
include 'config.php'; 

// SQL query to fetch project details
$sql = "SELECT * FROM projects";
$result = $conn->query($sql);
?>

<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Project Management</title>
  <style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    body {
      font-family: Arial, sans-serif;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
      background-color: rgb(141, 7, 181);
    }

    .container {
      width: 80%;
      max-width: 900px;
      text-align: center;
    }

    h1 {
      color: #ffffff;
    }

    button {
      padding: 10px 20px;
      margin-top: 20px;
      cursor: pointer;
      background-color: #007bff;
      color: white;
      border: none;
      border-radius: 5px;
      transition: background-color 0.3s ease, transform 0.2s ease;
    }

    /* Hover effect for button */
    button:hover {
      background-color: #0056b3;
      transform: scale(1.05);
    }

    table {
  width: 100%; 
  border-collapse: collapse;
  margin-top: 20px;
}
    table, th, td {
      border: 1px solid #ddd;
      padding: 8px;
      transition: background-color 0.3s ease;
      background-color: white;
    }

    th {
      background-color: #007bff;
      color: white;
    }

    tbody tr:hover {
      background-color: #f1f1f1;
    }

    /* Sidebar Styling */
    .sidebar {
      width: 260px;
      background-color: #2b2e4a;
      color: #fff;
      padding: 2rem 1rem;
      height: 100vh;
      position: fixed;
      top: 0;
      left: 0;
      border-radius: 0 10px 10px 0;
      box-shadow: 4px 0 12px rgba(0, 0, 0, 0.15);
    }

    .sidebar h2 {
      text-align: center;
      margin-bottom: 2rem;
      color: #ffcc29;
      font-size: 1.8rem;
      font-weight: bold;
    }

    .sidebar-links {
      list-style-type: none;
      padding-left: 0;
    }

    .sidebar-links li {
      margin: 1rem 0;
    }

    .sidebar-links a {
      color: #fff;
      text-decoration: none;
      display: block;
      padding: 0.75rem 1rem;
      border-radius: 8px;
      transition: background 0.3s ease, transform 0.2s;
    }

    .sidebar-links a:hover {
      background-color: #3d3f5c;
      transform: translateX(5px);
    }

    /* Logout Button */
    .logout-btn {
      background-color: #e74c3c;
      color: #fff;
      text-decoration: none;
      padding: 0.5rem 1rem;
      border-radius: 8px;
      font-weight: bold;
      transition: background-color 0.3s, transform 0.2s;
    }

    .logout-btn:hover {
      background-color: #c0392b;
      transform: translateY(-2px);
    }

  </style>
</head>
<body>
  <!-- Sidebar Navigation -->
  <div class="sidebar">
        <h2>Finance Manager</h2>
        <ul class="sidebar-links">
            <li><a href="finpaymnt.php">Payment Management</a></li>
            <li><a href="bugtview.php">Budget & Investment</a></li>
            <li><a href="projectview.php">Calculate Project Cost</a></li>
            <li><a href="report-generation.php">Generate Project Report</a></li>
            <li><a href="deliverycostview.php">Calculate Delivery Cost</a></li>
            <li><a href="salaryview.php">Calculate Employee Salary</a></li>
        </ul>
        <!-- Logout Button -->
        <a href="fmlogout.php" class="logout-btn">Logout</a>
    </div>
    <div class="container">
    <h1>Project cost </h1><br><br>
    <!-- Projects Table -->
    <table id="projectsTable">
      <thead>
        <tr>
          <th>Project ID</th>
          <th>Project Name</th>
          <th>Project Cost</th>
          <th>Project Type</th>
          <th>Project Date</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody id="projectsList">
        <!-- Dynamic rows will be inserted here -->
        <?php
        if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['ProjectID'] . "</td>";
            echo "<td>" . $row['ProjectName'] . "</td>";
            echo "<td>" . $row['ProjectCost'] . "</td>";
            echo "<td>" . $row['ProjectType'] . "</td>";
            echo "<td>" . $row['ProjectDate'] . "</td>";
            echo "<td>
                    <button onclick=\"window.location.href='projectupdate.php?id=" . $row['ProjectID'] . "'\">Edit</button>
                    <button onclick=\"if(confirm('Are you sure you want to delete this project?')) window.location.href='projectdelete.php?id=" . $row['ProjectID'] . "';\">Delete</button>
                  </td>";
            echo "</tr>";
          }
        } else {
          echo "<tr><td colspan='6'>No projects found</td></tr>";
        }
        ?>
      </tbody>
    </table><br>

     <!-- New Button to Add Budget -->
     <button onclick="window.location.href='projectadd.php'" style="padding: 10px 20px; background-color: white; color: black; border: none; border-radius: 5px; cursor: pointer; transition: background-color 0.3s ease, transform 0.2s ease;">
        Add New Project
    </button>

  </div>
</body>
</html>
