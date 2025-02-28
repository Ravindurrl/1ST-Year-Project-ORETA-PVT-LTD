<?php
include 'config.php';

$error = $success = "";

if (isset($_GET['id'])) {
    $productRequestId = $_GET['id'];

    
    $sql = "DELETE FROM productrequests WHERE product_request_id = ?";


    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        $error = "Error preparing statement: " . $conn->error;
    } else {
        
        $stmt->bind_param("i", $productRequestId);

        if ($stmt->execute()) {
            $success = "Product request deleted successfully!";
            header("Location: productreqview.php");
            exit();
        } else {
            $error = "Error deleting product request: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    }
} else {
    $error = "No product request ID provided!";
}
?>