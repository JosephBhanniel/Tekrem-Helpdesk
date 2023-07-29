<?php
// Assuming you have established a database connection
include("../../php/connect.php");
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Check if the notificationId parameter is present in the request
  if (isset($_POST["notificationId"])) {
    $notificationId = $_POST["notificationId"];

    // Perform the deletion operation in the database
    $deleteQuery = "DELETE FROM notifications WHERE notification_id = ?";
    $stmt = $conn->prepare($deleteQuery);
    $stmt->bind_param("i", $notificationId);

    if ($stmt->execute()) {
      // Deletion successful
      echo "Notification deleted successfully.";
    } else {
      // Deletion failed
      echo "Failed to delete notification.";
    }
  } else {
    // Required parameter missing
    echo "Missing notificationId parameter.";
  }
} else {
  // Invalid request method
  echo "Invalid request method.";
}
?>
