<!DOCTYPE html>
<html>
<head>
  <title>Notification Table</title>
  <link rel="stylesheet" href="../../css/bootstrap.min.css">
 
  <script src="../../jquery/jquery-3.6.1.min.js"></script>
</head>
<body>
<?php
  // Connect to the database
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'tek_helpdesk';

$conn = mysqli_connect($host, $username, $password, $database);

if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

// Query to get the number of notifications
$query = "SELECT COUNT(*) as total FROM notifications";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);
$totalNotifications = $row['total'];

// Query to get all notifications
$query = "SELECT * FROM notifications";
$result = mysqli_query($conn, $query);

echo '
<div class="container">
  <h2>Notifications</h2>
  <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#notificationModal">
    <span class="glyphicon glyphicon-bell"></span>
    Notifications (<span id="notificationCount">' . $totalNotifications . '</span>)
  </button>
  
  <div class="modal fade" id="notificationModal" tabindex="-1" role="dialog" aria-labelledby="notificationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="notificationModalLabel">All Notifications</h5>
          <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div style="max-height: 300px; overflow-y: auto;">';
while ($row = mysqli_fetch_assoc($result)) {
  echo '
            <div class="card mb-3 ">
              <div class="card-body">
                <h5 class="card-title">Notification ID: ' . $row['notification_id'] . '</h5>
                <h6 class="card-subtitle mb-2 text-muted">Ticket ID: ' . $row['ticket_id'] . '</h6>
                <p class="card-text">Category: ' . $row['category'] . '</p>
                <p class="card-text">Body: ' . $row['body'] . '</p>
                <p class="card-text">Created At: ' . $row['created_at'] . '</p>
                <button type="button" class="btn btn-danger delete-notification" data-notification-id="' . $row['notification_id'] . '">Delete</button>
              </div>
            </div>';
}
echo '
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
</div>';

mysqli_close($conn);?>

<script src="../../jquery/jquery-3.6.1.min.js"></script>
<script src="../../js/bootstrap.bundle.min.js"></script>
<script>
  $(document).ready(function() {
    // Handle delete notification button click
    $(".delete-notification").click(function() {
      var notificationId = $(this).data("notification-id");
      
      // Show a confirmation dialog
      if (confirm("Are you sure you want to delete this notification?")) {
        // Perform deletion operation using Ajax
        $.ajax({
          url: "delete_notification.php", // Replace with the actual URL to delete_notification.php
          method: "POST",
          data: { notificationId: notificationId },
          success: function(response) {
            // Handle the response from the server after successful deletion
            
            // For example, you can update the UI or refresh the notification list
            // Here, I'm reloading the page to demonstrate the update
            location.reload();
          },
          error: function(xhr, status, error) {
            // Handle the error case if deletion operation fails
            console.error(error);
          }
        });
      }
    });
  });
</script>



  <script src="../../js/bootstrap.bundle.min.js "></script>
</body>
</html>

