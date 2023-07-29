<?php
// get the ID parameter from the form action URL
$id = $_GET['id'];

// check if the form has been submitted
if(isset($_POST['update'])) {
  // retrieve the form data
  $ticketID = $_POST['ID'];
  $creatorID = $_POST['CreatorID'];
  $title = $_POST['Title'];
  $category = $_POST['Category'];
  $description = $_POST['description'];
  $priority = $_POST['Priority'];
  $assignedToID = $_POST['assign'];
  $status = $_POST['status'];

  // connect to the database
  $db = new mysqli('localhost', 'root', '', 'tek_helpdesk');

  // check if AssignedToID already exists
  $check_query = "SELECT * FROM technician WHERE ID='$assignedToID' ";
  $check_result = $db->query($check_query);
  if ($check_result->num_rows == 0) {
    // alert the user that the assignedToID does not exist
    echo ("<SCRIPT LANGUAGE='JavaScript'>
    window.alert('Technician does not exixt. Please enter a valid ID.')
    window.location.href='javascript:history.go(-1)';
    </SCRIPT>");
  } else {
    // prepare the SQL query
   { $query = "UPDATE tickets SET
    ID = '$ticketID',
    Submitted_By = '$creatorID',
    Title = '$title',
    Category = '$category',
    Priority = '$priority',
    Assigned_To = '$assignedToID',
    Status = '$status'
    WHERE ID = '$id'";

    // execute the query
    $result = $db->query($query);

    // check if the query was successful
    if ($result) {
      // echo "Ticket updated successfully";
      header("Location: dashboard.php?id=b");
    } else {
      echo "Error updating ticket: " . $db->error;
    }
  }

  // close the database connection
  $db->close();
}}

if(isset($_POST['delete'])) {
  // connect to the database
  $db = new mysqli('localhost', 'root', '', 'tek_helpdesk');
  
   // prepare the SQL query to delete from reports table
   $delete_reports_query = "DELETE FROM reports WHERE TicketID='$id'";
   // execute the query
   $delete_reports_result = $db->query($delete_reports_query);

  // prepare the SQL query to delete from tickets table
  $delete_tickets_query = "DELETE FROM tickets WHERE ID='$id'";
  // execute the query
  $delete_tickets_result = $db->query($delete_tickets_query);

 

  // check if both queries were successful
  if ($delete_tickets_result && $delete_reports_result) {
    // echo "Ticket deleted successfully";
    header("Location: dashboard.php?id=b");
  } else {
    echo "Error deleting ticket: " . $db->error;
  }

  // close the database connection
  $db->close();
}
?>
