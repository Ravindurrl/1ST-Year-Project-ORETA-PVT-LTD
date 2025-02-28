<?php

include 'config.php'; 

$message = ""; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['admin-id'];
    $name = $_POST['admin-name'];
    $email = $_POST['admin-email'];
    $nic = $_POST['admin-nic'];
    $phone = $_POST['admin-phone'];
    $birthday = $_POST['admin-birthday'];
    $username = $_POST['admin-username'];
    $password = password_hash($_POST['admin-password'], PASSWORD_BCRYPT); 
    $sql = "INSERT INTO admindata (ID, Name, Email, NIC_No, Telephone_Number, Birthday, Username, Password) 
            VALUES ('$id', '$name', '$email', '$nic', '$phone', '$birthday', '$username', '$password')";

    if ($conn->query($sql) === TRUE) {
        $message = "Administrator data added successfully!";
    } else {
        $message = "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Administrator Signup</title>
  <link rel="stylesheet" href="administorsingup.css">
</head>

<body>
  <div class="login-wrapper">
    <div class="login-box">
      <?php if (!empty($message)) { echo "<p>$message</p>"; } ?>
      <form method="POST" action="">
        <div class="form-group">
          <label for="admin-id">ID</label>
          <input type="text" id="admin-id" name="admin-id" required>
        </div>
        <div class="form-group">
          <label for="admin-name">Name</label>
          <input type="text" id="admin-name" name="admin-name" required>
        </div>
        <div class="form-group">
          <label for="admin-email">Email</label>
          <input type="email" id="admin-email" name="admin-email" required>
        </div>
        <div class="form-group">
          <label for="admin-nic">NIC No.</label>
          <input type="text" id="admin-nic" name="admin-nic" required>
        </div>
        <div class="form-group">
          <label for="admin-phone">Telephone Number</label>
          <input type="tel" id="admin-phone" name="admin-phone" required>
        </div>
        <div class="form-group">
          <label for="admin-birthday">Birthday</label>
          <input type="date" id="admin-birthday" name="admin-birthday" required>
        </div>
        <div class="form-group">
          <label for="admin-username">Username</label>
          <input type="text" id="admin-username" name="admin-username" required>
        </div>
        <div class="form-group">
          <label for="admin-password">Password</label>
          <input type="password" id="admin-password" name="admin-password" required>
        </div>
        <button type="submit" class="login-button">Submit</button>
      </form>
    </div>
  </div>
</body>

</html>
