<?php

session_start();

if(!isset($_SESSION["ID"])){
    
  header("Location:../index.php");
}
elseif($_SESSION["Role"]=="End User" || $_SESSION["Role"]=="Technician")
{
  header("Location:../index.php");
}

?>


<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.101.0">
    <title>Admin</title>
    <link rel="stylesheet" href="dashboard.rtl.css">
    <link rel="stylesheet" href="../../bootstrap-icons-1.9.1/bootstrap-icons.css">
    <link href="../../css/bootstrap.min.css" rel="stylesheet">
    <script src="../../jquery/jquery-3.6.1.min.js"></script>

    <link href="dashboard.css" rel="stylesheet">
</head>
<style>
    body {
    font-size: 1.002vw;
}
table, th, td{
    font-size:1vw;
}

.nav-link:hover{
  background-color:black;
  color:#fff;
  margin: 0 5px 0 5px;
  border-radius:15px;
  transition:1.5s;
}

.card-img-top{
  height:270px;
}
.card{
  width: 400px;
}

#not{
  background-color: #fff;
  margin-top: -15px;
  border: 1px solid #fff;
}
#not:hover{
  border: 1px solid #fff;
}
#imag{
  width:40px;
  height:auto;
}

#notificationCount{
  margin:5px 0 0 -25px;
  color: red;
  font-size: 20px;
  
}

#dash{
  margin:0px 50px 10px 50px;
}

@media(max-width:768px){
    body{
        font-size: 0.65rem;
    }
    table, th, td{
    font-size:0.65rem;
}
#dash{
  margin:0;
}
}
</style>


<body>

    <header class="navbar navbar-dark sticky-top bg-dark md-nowrap p-0  text-light">
        <a class="navbar-brand d-flex" href="#"><img src="../../Images/log3.png" alt="logo" style="width:90px;height:70px; border-radius:100%;">
         
        <h5 class="mt-4 m-2"><?php echo $_SESSION['username'] ;?></h5></a>
            
        
        <button class="navbar-toggler justify-content-end d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon "></span>
  </button>


    </header>

    <div class="container-fluid">
        <div class="row">
            <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
                <div class="position-sticky pt-3 sidebar-sticky">
                    <ul class="nav flex-column">
                        
                       
                        <li class="nav-item mt-5">
                            <a class="nav-link" href="dashboard.php?id=dashboard&&id7=Dashboard">

                                <span data-feather="file" class="align-text-bottom"></span> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                          
                          <a class="nav-link" href="dashboard.php?id=a&&id7=All Tickets">

                              <span data-feather="file" class="align-text-bottom"></span> All Tickets
                          </a>
                      </li>
                        <li class="nav-item">
                            <a class="nav-link" href="dashboard.php?id=b&&id7=Manage Tickets">
                                <span data-feather="file" class="align-text-bottom"></span> Manage Tickets
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="dashboard.php?id=g&&id7=Manage Users">
                                <span data-feather="users" class="align-text-bottom"></span> Manage Users
                            </a>
                        </li>
                        
                        <li class="nav-item">
                            <a class="nav-link" href="dashboard.php?id=f&&id7=Self-Help Articles">
                                <span data-feather="Self-help Articles" class="align-text-bottom"></span> Self-Help Articles
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="adminreport.php?id=6&&id7=Reports">
                                <span data-feather="Reports" class="align-text-bottom"></span> Reports
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="../Authentications/logout.php" onclick="if (!confirm('Are you sure you want to logout?')) { event.preventDefault(); }" >
                                <span data-feather="users" class="align-text-bottom"></span> Log out
                            </a>
                        </li>

                    </ul>
                     

                </div>
            </nav>

        </div>
    </div>
   


    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">



                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-2 pb-2 mb-3 border-bottom">
                <h1 class="h2 p-2"><?php if(isset($_GET["id7"])){
                 echo $_GET["id7"];  
                }?></h1>
             
                    <div class="btn-toolbar mb-2 mb-md-0">
                    <div class="m-2 ">
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
<div class="container d-flex justify-content-end">
 
  <button type="button" class="btn text-dark d-flex" id="not" data-bs-toggle="modal" data-bs-target="#notificationModal">
    
    <img src="../../images/notify.png" class="shadow p-1 rounded" id="imag"> <span id="notificationCount">' . $totalNotifications . '</span>
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
                <h5 class="card-title" style="display:none">Notification ID: ' . $row['notification_id'] . '</h5>
                <h6 class="card-subtitle mb-2 text-muted">Ticket ID: ' . $row['ticket_id'] . '</h6>
                <p class="card-text">Category: ' . $row['category'] . '</p>
                <p class="card-text">Issue: ' . $row['body'] . '</p>
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

mysqli_close($conn);?></div>
                        <div class="dropdown me-2">
                          
                            <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="dropdown">Filter</button>
                            <ul class="dropdown-menu">
                                <li class="dropdown-item"><a href="dashboard.php?id=c">Open Tickets</a></li>
                                <li class="dropdown-item"><a href="dashboard.php?id=d">Closed Tickets</a></li>
                            </ul>
                        </div>
                        <div>
                            <form action="#" method="post" class="form d-flex">
                                <input style="padding:3px; border-radius:4px; border:1px solid grey; margin-right:-3px;" type="search" name="search" id="searchid" placeholder="Ticket # or Dept">
                                <input class="btn btn-sm btn-primary" type="submit" value="Search">

                            </form>
                        </div>
                    </div>
                </div>


                
                <div class="table-responsive shadow p-3">
                
                    <table class="table bg-light table-sm table-hover">
                        
                        <tbody>
                        <?php
// Establish database connection
include '../../php/connect.php';

$id = $_GET['id'];
if($id == 'a' || $id == NULL){
    // Check if search query is set
if(isset($_POST['search']) && !empty($_POST['search'])){
    $search_query = $_POST['search'];
    $sql = "SELECT * FROM Tickets WHERE ID LIKE '%$search_query%' OR Department LIKE '%$search_query%'";
  } else {
    // Prepare SQL statement to select all tickets
    $sql = "SELECT * FROM Tickets";
  }
  
  // Check if filter dates are set
  if(isset($_GET['start_date']) && !empty($_GET['start_date']) && isset($_GET['end_date']) && !empty($_GET['end_date'])){
    $start_date = date('Y-m-d', strtotime($_GET['start_date']));
    $end_date = date('Y-m-d', strtotime($_GET['end_date']));
    $sql .= " WHERE Date_Created BETWEEN '$start_date' AND '$end_date'";
  }
  
  // Execute SQL statement and fetch results
  $result = mysqli_query($conn, $sql);
  
  // Check if there are any results
  if (mysqli_num_rows($result) > 0) {
    echo '
    
    <thead class="bg-dark text-light">
    <tr>
        <th scope="col">#</th>
        <th scope="col">Title</th>
        <th scope="col">Dept</th>
        <th scope="col">Category</th>
        <th scope="col">Description</th>
        <th scope="col">Priority</th>
        <th scope="col">CreatorID</th>
        <th scope="col">AssignedTo</th>
        <th scope="col">Status</th>
        <th scope="col">Date created</th>
    </tr>
</thead>';
    // Display table rows
    while($row = mysqli_fetch_assoc($result)) {
      if($row['Status']== NULL){
          $status = "Open";
      }else{
          $status = $row['Status'];
      }
      
     
      echo "<tr>
              <td>".$row['ID']."</td>
              <td>".$row['Title']."</td>
              <td>".$row['Department']."</td>
              <td>".$row['Category']."</td>
              <td>".$row['Description']."</td>
              <td>".$row['Priority']."</td>
              <td>".$row['Submitted_By']."</td>
              <td>".$row['Assigned_To']."</td>
              <td>".$status."</td>
              <td>".$row['Date_Created']."</td>
            </tr>";
    }
  
    // Close table
    echo "</table>";
  } else {
    echo "No tickets found.";
  }
} elseif ($id == 'c'){
    
        $sql = "SELECT * FROM Tickets WHERE Status = 'Open'";
        // Execute SQL statement and fetch results
  $result = mysqli_query($conn, $sql);

  
  // Check if there are any results
  if (mysqli_num_rows($result) > 0) {
    
    echo '<thead class="bg-dark text-light">
    <tr>
        <th scope="col">#</th>
        <th scope="col">Title</th>
        <th scope="col">Dept</th>
        <th scope="col">Category</th>
        <th scope="col">Description</th>
        <th scope="col">Priority</th>
        <th scope="col">CreatorID</th>
        <th scope="col">AssignedTo</th>
        <th scope="col">Status</th>
        <th scope="col">Date created</th>
    </tr>
</thead>';
  
    // Display table rows
    while($row = mysqli_fetch_assoc($result)) {
     
     
      echo "<tr>
              <td>".$row['ID']."</td>
              <td>".$row['Title']."</td>
              <td>".$row['Department']."</td>
              <td>".$row['Category']."</td>
              <td>".$row['Description']."</td>
              <td>".$row['Priority']."</td>
              <td>".$row['Submitted_By']."</td>
              <td>".$row['Assigned_To']."</td>
              <td>".$row['Status']."</td>
              <td>".$row['Date_Created']."</td>
            </tr>";
    }
  
    // Close table
    echo "</table>";
  } else {
    echo "No tickets found.";
  }
      

}
elseif ($id == 'd'){
    
    $sql = "SELECT * FROM Tickets WHERE Status = 'Closed'";
    // Execute SQL statement and fetch results
$result = mysqli_query($conn, $sql);

// Check if there are any results
if (mysqli_num_rows($result) > 0) {
    echo '<thead class="bg-dark text-light">
      
      <tr>
          <th scope="col">#</th>
          <th scope="col">Title</th>
          <th scope="col">Dept</th>
          <th scope="col">Category</th>
          <th scope="col">Description</th>
          <th scope="col">Priority</th>
          <th scope="col">CreatorID</th>
          <th scope="col">AssignedTo</th>
          <th scope="col">Status</th>
          <th scope="col">Date created</th>
          
      </tr>
  </thead>';
// Display table rows
while($row = mysqli_fetch_assoc($result)) {
  
 
 
  echo "<tr>
          <td>".$row['ID']."</td>
          <td>".$row['Title']."</td>
          <td>".$row['Department']."</td>
          <td>".$row['Category']."</td>
          <td>".$row['Description']."</td>
          <td>".$row['Priority']."</td>
          <td>".$row['Submitted_By']."</td>
          <td>".$row['Assigned_To']."</td>
          <td>".$row['Status']."</td>
          <td>".$row['Date_Created']."</td>
        </tr>";
}

// Close table
echo "</table>";
} else {
echo "No tickets found.";
}
  

}
elseif ($id == 'b'){
    
    $sql = "SELECT * FROM Tickets";
    // Execute SQL statement and fetch results
$result = mysqli_query($conn, $sql);

// Check if there are any results
if (mysqli_num_rows($result) > 0) {
    echo '
    
    <thead class="bg-dark text-light">
    <tr>
        <th scope="col">#</th>
        <th scope="col">Title</th>
        <th scope="col">Dept</th>
        <th scope="col">Category</th>
        <th scope="col">Description</th>
        <th scope="col">Priority</th>
        <th scope="col">CreatorID</th>
        <th scope="col">AssignedTo</th>
        <th scope="col">Status</th>
        <th scope="col">Date created</th>
        <th scope="col">Action</th>
    </tr>
</thead>';
// Display table rows
while($row = mysqli_fetch_assoc($result)) {
 
 
  echo "<tr>
          <td>".$row['ID']."</td>
          <td>".$row['Title']."</td>
          <td>".$row['Department']."</td>
          <td>".$row['Category']."</td>
          <td>".$row['Description']."</td>
          <td>".$row['Priority']."</td>
          <td>".$row['Submitted_By']."</td>
          <td>".$row['Assigned_To']."</td>
          <td>".$row['Status']."</td>
          <td>".$row['Date_Created']."</td>
          
          <td><a class ='btn btn-primary' href='dashboard.php?id=".$row['ID']." '>Edit</td>
        </tr>";
}

// Close table
echo "</table>";
} else {
echo "No tickets found.";
}
  

}
elseif($id == 'f'){
    $sql = "SELECT * FROM Knowledge_base";
    // Execute SQL statement and fetch results
$result = mysqli_query($conn, $sql);

// Check if there are any results
if (mysqli_num_rows($result) > 0) {
    echo '
   
    <thead class="bg-dark text-light">
    <tr>
        <th scope="col">#</th>
        <th scope="col">Title</th>
        <th scope="col">Description</th>
        <th scope="col">Date Created</th>
        <th scope="col">Date Updated</th>
        <th scope="col">Created_By</th>
        <th scope="col">Action</th>
    </tr>
</thead>';
// Display table rows
while($row = mysqli_fetch_assoc($result)) {
 
  echo "<tr>
          <td>".$row['ID']."</td>
          <td>".$row['Title']."</td>
          <td>".$row['Description']."</td>
          <td>".$row['Date_Created']."</td>
          <td>".$row['Date_Updated']."</td>
          <td>".$row['Created_By']."</td>
         
          
          <td><a class ='btn btn-primary' href='article.php?id= ".$row['ID']."'>Edit</td>
        </tr>";
}
  echo "<tfoot>
   <tr>
   <td>
   <a class='btn btn-primary mt-2' href='dashboard.php?id=h'>Create Article </a>
   </td>
   </tr>
  
  </tfoot>";
// Close table
echo "</table>";
} else {
echo "No Articles found.";
echo "<br> <a class='btn btn-primary mt-2' href=dashboard.php?id=h>Create Article</a>";
}
}

elseif($id == 'h'){
    
    echo '

	<!-- Create a form for users to submit data -->
	<form method="post">
		
        <tabel class="bg-light">
        <tr>
          <td>
          <label for="title">Title:</label>
          </td>
          <td>
          <input type="text" id="title" class="form-control col-md-2" id="exampleTextarea" rows="1" name="title" required>
          </td>
        </tr>

        <tr>
          <td>
          <label for="description">Description:</label>
          </td>
          <td>
          <textarea id="description" name="description" class="form-control col-md-4" id="exampleTextarea" rows="3" required></textarea>
          </td>
        </tr>

        <tr>
          <td>
          <label for="created_by">Created By:</label>
          </td>
          <td>
          <input type="number" id="created_by" class="form-control col-md-2" id="exampleTextarea" rows="1" name="created_by" required>
          </td>
        </tr>
        <tr>
          <td>
          </td>
          <td>
          <input class="btn btn-primary" type="submit" value="Create" name="Create">
          </td>
        </tr>

        </tabel>
	</form>';
    // Insert data into the knowledge_base table when the form is submitted
	if (isset($_POST['Create'])) {
		$title = $_POST["title"];
		$description = $_POST["description"];
		$created_by = $_POST["created_by"];

		$sql = "INSERT INTO knowledge_base (Title, Description, Created_By) VALUES ('$title', '$description', '$created_by')";

		if ($conn->query($sql) === TRUE) {
		   echo "<script>alert('Article Created Successfully');</script>";
		} else {
		    echo "Error: " . $sql . "<br>" . $conn->error;
		}
	}

	

}elseif($id == "users"){
  include("view_users.php");

}elseif($id == "technicians"){
  include("view_tech.php");

}

elseif($id == 'g'){
    if(isset($_GET['id2'])){
      echo $_GET['id2'];

    }
    echo '
    <div class="container">
      <div class="row">
        <div class="col-md-6 mt-2">
          <div class="card">
            <img src="../../images/user.jpg" class="card-img-top" alt="User Image">
            <div class="card-body">
              <h5 class="card-title">Total Users</h5>
              <p class="card-text">';
    
    include "../../php/connect.php";
    $sql = "SELECT COUNT(*) AS total_users FROM user WHERE user_status = 'Active'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $totalUsers = $row['total_users'];
    
    echo $totalUsers;
    
    echo '</p>
              <a href="dashboard.php?id=users" class="btn btn-primary">View Users</a>
            </div>
          </div>
        </div>
        
        <div class="col-md-6 mt-2">
          <div class="card">
            <img src="../../images/technician.jpg" class="card-img-top" alt="Technician Image">
            <div class="card-body">
              <h5 class="card-title">Total Technicians</h5>
              <p class="card-text">';
    
    $sql = "SELECT COUNT(*) AS total_technicians FROM technician WHERE user_status = 'Active'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $totalTechnicians = $row['total_technicians'];
    
    echo $totalTechnicians;
    
    echo '</p>
              <a href="dashboard.php?id=technicians" class="btn btn-primary">View Technicians</a>
            </div>
          </div>
        </div>
      </div>
    </div>
    ';
    
  
    
   
    
}elseif($id == "dashboard"){

  // Assuming you have a database connection established
  
  // Function to fetch the count from a specific table using a SQL query
  function fetchCount($tableName) {
    include("../../php/connect.php");
    // Replace the SQL query with the actual query to fetch the count from the specified table
    $query = "SELECT COUNT(*) AS count FROM {$tableName}";
    // Execute the query and fetch the result
    // Here, you can use the database connection and appropriate functions based on the database system you are using
    $result = mysqli_query($conn,$query);
    // Extract the count value from the result
   $result2 = mysqli_fetch_assoc($result);
    /* Extract the count value from the result */;
    $count = $result2["count"];
    // Return the count value
    return $count;
  }
  
  // Fetch the counts from the database tables
  $ticketCount = fetchCount("tickets"); // Replace "tickets" with the actual table name for tickets
  $userCount = fetchCount("user"); // Replace "users" with the actual table name for users
  $technicianCount = fetchCount("technician"); // Replace "technician" with the actual table name for technicians
  $adminCount = fetchCount("admin"); // Replace "administrator" with the actual table name for administrators
  $reportCount = fetchCount("reports"); // Replace "reports" with the actual table name for reports
  $knowledgeCount = fetchCount("knowledge_base"); 
  // Function to generate Bootstrap cards
  function generateCard($count, $title, $iconClass) {
    echo "
    <div class='col-md-4' id='dash'>
      <div class='card text-center m-2 bg-dark shadow text-light'>
        <div class='card-body'>
          <i class='{$iconClass} fa-3x'></i>
          <h5 class='card-title'>{$count}</h5>
          <p class='card-text'>{$title}</p>
        </div>
      </div>
    </div>
    ";
  }
  
  // Display the counts in Bootstrap cards
  echo "
  <div class='row p-5'>
    ";
  
  generateCard($ticketCount, "Tickets", "bi bi-journal");
  generateCard($userCount, "Users", "bi bi-person");
  generateCard($technicianCount, "Technicians", "bi bi-people");
  generateCard($adminCount, "Administrators", "bi bi-person-badge");
  generateCard($reportCount, "Reports", "bi bi-file-earmark-bar-graph");
  generateCard($knowledgeCount, "Articles", "bi bi-journal");
  
  echo "
  </div>
  ";
  
  

  
}


elseif($id){
      // Retrieve course data from the database
$technician_query = "SELECT ID, Username FROM technician";
$Tec_result = mysqli_query($conn, $technician_query );

$technicians = [];
while ($row = mysqli_fetch_assoc($Tec_result)) {
    $technicians[] = $row;
}


    $sql = "SELECT * FROM Tickets where ID = $id";
    // Execute SQL statement and fetch results
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
   echo '
    
     
     
     <h3> Assign Ticket </h3>
    <form action="updateticket.php?id='.$id.'" method="Post">
     
     
     <tr>
       <td><labe for= "ID">Ticket ID<label> </td>
       <td><input type = "text" class="form-control col-md-2" id="exampleTextarea" rows="1" name="ID" value = '.$row['ID'].'> </td>
     </tr>
     <tr>
     <td><labe for= "CreatorID">Creator ID<label> </td>
     <td><input type = "text" class="form-control col-md-2" id="exampleTextarea" rows="1" name="CreatorID" value = '.$row['Submitted_By'].'> </td>
   </tr>
     <tr>
     <td><labe for= "Title">Title<label> </td>
     <td><input type = "text" class="form-control col-md-2" id="exampleTextarea" rows="1" name="Title" value = '.$row['Title'].'> </td>
   </tr>
   <tr>
   <td><labe for= "Category">Category<label> </td>
   <td><input type = "text"class="form-control col-md-2" id="exampleTextarea" rows="1" name="Category" value = '.$row['Category'].'> </td>
 </tr>
 <tr>
   <td><labe for= "description">Description<label> </td>
   <td><textarea name="description" class="form-control col-md-4" id="exampleTextarea" rows="3" style="width:400px; height:80px;">
   '.$row['Description'].'
   </textarea> </td>
 </tr>
 <tr>
   <td><labe for= "Priority">Priority<label> </td>
   <td><input type = "text" class="form-control col-md-2" id="exampleTextarea" rows="1" name="Priority" value = '.$row['Priority'].'> </td>
 </tr>
 <tr>
   <td><labe for= "assigned">Assigned To<label> </td>
   <td><div class="form-group">
                
                <select class="form-control" name="assign" >
                    <option value="">Select Technician</option>';
                     foreach ($technicians as $tech):
                       echo' <option value="'.$tech['ID'].'">'.$tech['Username'].'</option>';
                      endforeach;
               echo' </select>
         </div></td>';
 
 echo '<tr>
   <td><labe for= "Status">Status<label> </td>
   <td><input type = "text" class="form-control col-md-2" id="exampleTextarea" rows="1" name="status" value = '.$row['Status'].'> </td>
 </tr>
 <tr>
 <td> </td>
 <td><input class="btn btn-primary" type = "submit" name="update" value ="Update">
 <input class="btn btn-danger ms-2" type = "submit" name="delete" value ="delete" onclick="return confirm(\'Are you sure?\');"> </td>
 
</tr>


    </form>
   
   ';
}


// Close database connection
mysqli_close($conn);
?>




                        </tbody>
                    </table>
                </div>



                
            </main>

   
    <script src="../../js/bootstrap.bundle.min.js"></script>
    <!-- <script src="dashboard.js"></script>
    

    <script src="dashboard.js"></script> -->

    <script>
  $(document).ready(function() {
    // Handle delete notification button click
    $(".delete-notification").click(function() {
      var notificationId = $(this).data("notification-id");
      
      // Show a confirmation dialog
      if (confirm("Are you sure you want to delete this notification?")) {
        // Perform deletion operation using Ajax
        $.ajax({
          url: "../user/delete_notification.php", // Replace with the actual URL to delete_notification.php
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
</body>

</html>