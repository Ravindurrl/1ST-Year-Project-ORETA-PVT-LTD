<?php
include 'config.php'; 

if (isset($_GET['id'])) {
    $payment_id = $_GET['id'];

    // Delete query
    $sql = "DELETE FROM finpayments WHERE fin_pay_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $payment_id);

    if ($stmt->execute()) {
        echo "Payment deleted successfully!";
        header("Location: finpaymnt.php"); // Redirect back to the payment list page
        exit();
    } else {
        echo "Error deleting payment: " . $stmt->error;
    }
} else {
    echo "No payment ID provided!";
}
?>
