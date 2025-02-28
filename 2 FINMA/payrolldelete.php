<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

include 'config.php';

if (isset($_GET['id'])) {
    $payrollid = $_GET['id'];

    
    $sql = "DELETE FROM payroll WHERE payrollid = ?";

    // Prepare the statement
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        // Error preparing the statement
        echo "Error preparing statement: " . $conn->error;
        exit();
    }

    // Bind the payrollid parameter
    $stmt->bind_param('i', $payrollid);

    // Execute the statement
    if ($stmt->execute()) {
        // Successfully deleted
        echo "Payroll record deleted successfully!";
        header("Location: payroll.php");
        exit();
    } else {
        // Error executing the query
        echo "Error deleting payroll: " . $stmt->error;
    }
} else {
    
    echo "Payroll ID not specified.";
}
?>
