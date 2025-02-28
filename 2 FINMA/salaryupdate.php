<?php
include 'config.php';

if (isset($_GET['id'])) {
    $salaryid = $_GET['id'];
    $result = $conn->query("SELECT * FROM salary WHERE salaryid = $salaryid");
    $salary = $result->fetch_assoc();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $empid = $_POST['empid'];
    $basicsalary = $_POST['basicsalary'];
    $deduction = $_POST['deduction'];
    $increment = $_POST['increment'];
    $net_salary = $basicsalary - $deduction + $increment;

    $stmt = $conn->prepare("
        UPDATE salary SET emp_id = ?, basicsalary = ?, deduction = ?, increment = ?, net_salary = ?
        WHERE salaryid = ?
    ");
    $stmt->bind_param("sddddi", $empid, $basicsalary, $deduction, $increment, $net_salary, $salaryid);

    if ($stmt->execute()) {
        echo "Salary updated successfully.";
        header("Location: salaryview.php");
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Salary</title>
    <style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }
    body {
            font-family: Arial, sans-serif;
            background-color: rgb(141, 7, 181);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            width: 400px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: rgb(141, 7, 181);
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin: 10px 0 5px;
        }

        input, button {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            background-color: rgb(141, 7, 181);
            color: white;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: rgb(110, 5, 140);
        }
    table {
  width: 150%; 
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
    <!-- Main Content -->
    <div class="main-content">
        <h1>Update Salary</h1>
        <form method="POST">
            <label>Employee ID:
                <input type="text" name="empid" value="<?= $salary['emp_id'] ?>" required>
            </label><br>
            <label>Basic Salary:
                <input type="number" step="0.01" name="basicsalary" value="<?= $salary['basicsalary'] ?>" required>
            </label><br>
            <label>Deduction:
                <input type="number" step="0.01" name="deduction" value="<?= $salary['deduction'] ?>" required>
            </label><br>
            <label>Increment:
                <input type="number" step="0.01" name="increment" value="<?= $salary['increment'] ?>" required>
            </label><br>
            <button type="submit" style="background-color: #4CAF50; color: white; border: none; padding: 10px 20px; font-size: 16px; cursor: pointer;">
  Update Salary
</button>

          
        </form>
    </div>
</body>
</html>
