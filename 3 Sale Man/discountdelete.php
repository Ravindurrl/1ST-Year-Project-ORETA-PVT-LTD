<?php
include 'config.php';

// Check if ID is provided in the URL
if (isset($_GET['id'])) {
    $discountID = $_GET['id'];

    // Delete the discount from the database
    $sql = "DELETE FROM discounts WHERE DiscountID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $discountID);
    
    if ($stmt->execute()) {
        $success = "Discount deleted successfully!";
        header("Location: generateDiscount.php");
        exit();
    } else {
        $error = "Error deleting discount: " . $stmt->error;
    }
} else {
    $error = "Discount ID not provided.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Delete Discount</title>
    <link rel="stylesheet" href="Supevisoradd.css">
</head>
<body>
<div class="container">
    <div class="main-content">
        <h1>Delete Discount</h1>

        <!-- Success/Error Messages -->
        <?php if (!empty($error)): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>

        <?php if (!empty($success)): ?>
            <p class="success"><?php echo $success; ?></p>
        <?php endif; ?>
    </div>
</div>

</body>
</html>
