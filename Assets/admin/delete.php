<?php

// connect to database
include '../../php/connect.php';
// get user ID from URL parameter
$user_id = $_GET['deleteid'];
$user_id2 = $_GET['delete'];
if(isset($_GET['deleteid'])){
  $user_id = $_GET['deleteid'];

// delete user from database
$sql = "UPDATE user SET user_status = 'Deleted' WHERE ID =$user_id";
$result = mysqli_query($conn, $sql);

if ($result) {
    $notication = "<span class='alert alert-success m-5' style='font-size:1.05vw;'> User deleted Successfully! </span>";
    header('location:dashboard.php?id=g&&id2='.$notication.'');
} else {
  echo "Error deleting user: " . mysqli_error($conn);
}
}

// get user ID from URL parameter
if(isset($_GET['delete'])){
  $user_id2 = $_GET['delete'];

// delete user from database
$sql = "UPDATE technician SET user_status = 'Deleted' WHERE ID =$user_id2";
$result = mysqli_query($conn, $sql);

if ($result) {
    $notication = "<span class='alert alert-success' style='font-size:1.05vw; margin-left:400px; margin-bottom:-50px;'> User deleted Successfully! </span>";
    header('location:dashboard.php?id=g&&id2='.$notication.'');
} else {
  echo "Error deleting user: " . mysqli_error($conn);
}
}

mysqli_close($conn);



  // // prepare the SQL query to delete from knowledge table
  // $delete_knowledge_query = "DELETE FROM knowledge_base WHERE Created_By='$user_id'";
  // // execute the query
  // $delete_knowledge_result = $db->query($delete_knowledge_query);

  // // prepare the SQL query to delete from reports table
  // $delete_reports_query = "DELETE FROM reports WHERE TechnicianID='$user_id'";
  // // execute the query
  // $delete_reports_result = $db->query($delete_reports_query);

  //  // prepare the SQL query to delete from tickets table
  //  $delete_tickets_query = "DELETE FROM tickets WHERE Assigned_To='$user_id'";
  //  // execute the query
  //  $delete_tickets_result = $db->query($delete_tickets_query);

  //   // prepare the SQL query to delete from tickets table
  //   $delete_tickets1_query = "DELETE FROM tickets WHERE Submitted_By='$user_id'";
  //   // execute the query
  //   $delete_tickets1_result = $db->query($delete_tickets1_query);

  
  //   // prepare the SQL query to delete from tickets table
  //   $delete_users_query = "DELETE FROM users WHERE ID='$user_id'";
  //   // execute the query
  //   $delete_users_result = $db->query($delete_users_query);

?>
