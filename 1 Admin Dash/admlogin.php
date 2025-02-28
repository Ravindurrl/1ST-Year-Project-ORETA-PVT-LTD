<?php
session_start();
include('config.php');

// Redirect if already logged in
if (isset($_SESSION['username'])) {
    header("Location: " . $_SESSION['role'] . ".html");
    exit;
}

// Login logic
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prevent SQL Injection
    $stmt = $conn->prepare("SELECT * FROM users WHERE Username = ? AND Password = ?");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // User found
        $user = $result->fetch_assoc();
        $_SESSION['username'] = $username;
        $_SESSION['role'] = $user['Role'];

      // Redirect based on role
switch ($_SESSION['role']) {
    case 'Admin':
        header("Location: admn.php");
        break;

    case 'Finance Manager':
        header("Location: fnsdsb.php");
        break;

    case 'Sales Manager':
        header("Location: salesm.php");
        break;

    case 'HR Manager':
        header("Location: hrdsb.php");
        break;

    case 'Sales Person':
        header("Location: slprsn.php");
        break;

    case 'Supervisor':
        header("Location: supervisor.php");
        break;

    case 'Employee':
        header("Location: employee.php");
        break;

    case 'Delivery Partner':
        header("Location: dlvry.php");
        break;

    case 'Supplier':
        header("Location: supplier.php");
        break;

    default:
        echo "Invalid role!";
}

        exit;
    } else {
        echo "Invalid username or password!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="index.css"> 
    </head>
<body>
    <div class="login-container">
        <div class="login-box">
            <div class="logo">
                <img src="logo.png" alt="Logo" />
            </div>
           
        <form action="" method="POST">
            <h2>Login</h2>
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <button type="submit">Login</button>
        </form>
    </div>
        </div>
    </div>
</body>
</html>
