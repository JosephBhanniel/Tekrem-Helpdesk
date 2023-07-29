<?php

// connect to database
include '../../php/connect.php';


// get user ID from URL parameter
$user_id = $_GET['updateid'];

// get updated user data from form submission
$username = $_POST['username'];
$password = $_POST['password'];
$email = $_POST['email'];
$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$role = $_POST['role'];
$department = $_POST['department'];
$service = $_POST['service'];

// update user in database
$sql = "UPDATE technician SET 
        Username='$username', 
        Password='$password', 
        Email='$email', 
        Firstname='$firstname', 
        Lastname='$lastname', 
        user_type='$role',
        service_type ='$service',
        Dept='$department'
        WHERE ID=$user_id";

if (mysqli_query($conn, $sql)) {
  header("Location: dashboard.php?id=g");
} else {
  echo "Error updating user: " . mysqli_error($conn);
}

mysqli_close($conn);

?>
