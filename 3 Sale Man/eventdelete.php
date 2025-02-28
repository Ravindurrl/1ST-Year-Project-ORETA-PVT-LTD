<?php
include 'config.php';


if (isset($_POST['event_id'])) {
    $event_id = $_POST['event_id'];

   
    $sql = "DELETE FROM events WHERE Event_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $event_id);

    if ($stmt->execute()) {
        
        header("Location: eventview.php");
        exit(); 
    } else {
        echo "Error deleting event: " . $conn->error;
    }
} else {
    // If no event ID was provided
    echo "No event ID provided.";
}
?>
