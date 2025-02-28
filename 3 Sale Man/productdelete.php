<?php
include 'config.php';

// Check if ID is provided in the URL
if (isset($_GET['id'])) {
    $productID = $_GET['id'];

    // SQL query to delete the product
    $sql = "DELETE FROM products WHERE ProductID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $productID);

    // Execute the query
    if ($stmt->execute()) {
        $success = "Product deleted successfully!";
        header("Location: viewproducts.php"); // Redirect to the Products view page
        exit();
    } else {
        $error = "Error deleting product: " . $stmt->error;
    }
} else {
    $error = "Product ID not provided.";
}
?>