<?php
include 'config.php';

$error = $success = "";

if (isset($_GET['id'])) {
    $orderInvoiceID = $_GET['id'];

    // SQL query to delete the OrderInvoice record
    $sql = "DELETE FROM OrderInvoice WHERE OrderInvoiceID = ?";

    // Prepare the SQL statement
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        $error = "Error preparing statement: " . $conn->error;
    } else {
        // Bind the parameter
        $stmt->bind_param("i", $orderInvoiceID);

        // Execute the query
        if ($stmt->execute()) {
            $success = "OrderInvoice deleted successfully!";
            header("Location: vieworders.php");
            exit();
        } else {
            $error = "Error deleting OrderInvoice: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    }
} else {
    $error = "Invalid request: OrderInvoiceID is missing.";
}
?>