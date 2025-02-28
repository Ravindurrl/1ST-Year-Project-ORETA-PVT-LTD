<?php
include 'config.php'; 

$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize input data
    $cus_name = mysqli_real_escape_string($conn, $_POST['cus_name']);
    $cus_tel = mysqli_real_escape_string($conn, $_POST['cus_tel']);
    $cus_address = mysqli_real_escape_string($conn, $_POST['cus_address']);
    $cus_email = mysqli_real_escape_string($conn, $_POST['cus_email']);

    // Validate inputs
    if (empty($cus_name) || empty($cus_tel) || empty($cus_address) || empty($cus_email)) {
        $error = "All fields are required!";
    } else {
        // Insert data into the customer table
        $sql = "INSERT INTO customer (cus_name, cus_tel, cus_address, cus_email) 
                VALUES ('$cus_name', '$cus_tel', '$cus_address', '$cus_email')";

        if ($conn->query($sql) === TRUE) {
            $success = "Customer registered successfully!";
            header("cstmr.html"); 
        } else {
            $error = "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Signup</title>
    <link rel="stylesheet" href="singup.css">
</head>

<body>
    <div class="signup-wrap">
        <div class="signup-html">
            <div class="logo">
                <img src="logo.png" alt="Logo">
            </div>
            
            <!-- Success/Error Messages -->
            <?php if (!empty($error)): ?>
                <p class="error" style="color: red;"> <?php echo $error; ?> </p>
            <?php endif; ?>

            <?php if (!empty($success)): ?>
                <p class="success" style="color: green;"> <?php echo $success; ?> </p>
            <?php endif; ?>

            <form method="POST" action="">
                <div class="group">
                    <label for="name" class="label">Customer Name</label>
                    <input id="name" name="cus_name" type="text" class="input" placeholder="Enter your name" required>
                </div>
                <div class="group">
                    <label for="telephone" class="label">Customer Telephone</label>
                    <input id="telephone" name="cus_tel" type="tel" class="input" placeholder="Enter your telephone" required>
                </div>
                <div class="group">
                    <label for="address" class="label">Customer Address</label>
                    <input id="address" name="cus_address" type="text" class="input" placeholder="Enter your address" required>
                </div>
                <div class="group">
                    <label for="email" class="label">Customer Email</label>
                    <input id="email" name="cus_email" type="email" class="input" placeholder="Enter your email" required>
                </div>
                <div class="group">
                    <button type="submit" class="button">Sign Up</button>
                </div>
                <div class="hr"></div>
               
            </form>
            <div class="group" style="text-align: center; margin-top: 20px;">
                <a href="cstmr.html" style="padding: 10px 20px; background-color: #f0f0f0; color: #333; text-decoration: none; border: 1px solid #ccc; border-radius: 5px;">Go Back</a>
            </div>
        </div>
    </div>
</body>

</html>
