<?php
session_start();
$service = $_SESSION["service_type"];
if(!isset($_SESSION["ID"])){
    header("Location:../Authentications/login.php");
  }
  elseif($_SESSION["Role"]=="Adminstrator" || $_SESSION["Role"]=="End User")
  {
    header("Location:../Authentications/login.php");
  }

?>



<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="generator" content="Hugo 0.101.0">
    <title>IT Agent</title>
    <link rel="canonical" href="offcanvas.css">
    <link href="../usertickets.css" rel="stylesheet">
    <link rel="icon" href="../../Images/log3.png" type="image/x-icon">
    <link href="../../css/bootstrap.min.css" rel="stylesheet">
    <link href="../admin/dashboard.css" rel="stylesheet">
    <script src="../../jquery/jquery-3.6.1.min.js"></script>
    <style>
        h3{
            margin: 4px;
        }

        .container{
			font-size: 14px;
			margin-top: 80px;
		}

        @media(max-width:768px){
            .container{
                font-size: 10px;
            }
            th,input{
                font-size:10px;
            }
        }
        #ticks{
            margin-top:-80px;
        }

        #not{
  
  margin-top: -120px;
  border: 1px solid #F8F9FA;
}
#not:hover{
  border: 1px solid #F8F9FA;
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
    </style>
</head>

<body class="bg-light">

    <nav class="navbar navbar-expand-lg fixed-top navbar-dark bg-dark" aria-label="Main navigation">
        <div class="container-fluid">
            <a class="navbar-brand" href="#"><img src="../../Images/log3.png" alt="logo" width="90" height="70" id="logo"></a>
            <div class=" me-2 text-light d-flex " >
                 <?php echo '<h3>'.$_SESSION['username'].'</h3> '?>
                 
                 </div>
            <button class="navbar-toggler p-0 border-0" type="button" id="navbarSideCollapse" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    

            <div class="navbar-collapse offcanvas-collapse" id="navbarsExampleDefault">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 ">  
                    </li>
                    <li class="nav-item">
                        <a class="nav-link me-3 py-1 " href="report.php" id="link">Submit Report</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link me-3 py-1" href="viewreports.php" id="link">View Reports</a>
                    </li>
                   


                </ul>
                <a href="../Authentications/logout.php" class="nav-link me-3"  id="link" onclick="if (!confirm('Are you sure you want to logout?')) { event.preventDefault(); }">Log out</a>
            </div>
        </div>
    </nav>


    <main class="container-fluid my-5 mt-5 overflow-x-auto">


        <div class="container" >
        <d class="m-2 ">
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
$query = "SELECT COUNT(*) as total FROM notifications where category = '$service'";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);
$totalNotifications = $row['total'];

// Query to get all notifications
$query = "SELECT * FROM notifications where category = '$service'";
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

mysqli_close($conn);?></d>
        <h6 class="border-bottom pb-2 mb-0 ms-3  " id="ticks">Assigned Tickets</h6>
        
        <div class="d-flex justify-content-end" >
         
        <div class="dropdown me-2 mt-2">
                            <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="dropdown">Filter</button>
                            <ul class="dropdown-menu">
                                <li class="dropdown-item"><a href="itagent.php?id=assigned">Assigned Tickets</a></li>
                                <li class="dropdown-item"><a href="itagent.php?id=open">All Tickets</a></li>
                            </ul>
                        </div>
        <div>
            <form action="#" class="form d-flex mt-2">
              <input style="padding:3px; border-radius:4px; border:1px solid grey; margin-right:-3px;" type="search" name="search" id="searchid" placeholder="Ticket # or 0 for All">
              <input class="btn btn-sm btn-primary" type="submit" value="Search">

             </form>
            </div> 
        </div>
            <div class="table table-responsive d-flex text-muted pt-3 ms-3">
                <table class="table  hover shadow">
                    <thead class="bg-dark text-light">
                    <th>CreatorID</th>
                    <th>Ticket#</th>
                    <th>Title#</th>
                    <th>Category</th>
                    <th>Description</th>
                    <th>Assigned To</th>
                    <th>Department</th>
                    <th>Status</th>
                    <th>Action</th>
                   
                    </thead>


                    <tbody>
                           <?php
                           Include '../../php/connect.php';
                           if(isset($_GET['id'])) {
                            
                          if($_GET['id'] == 'dash'){
                           if(isset($_SESSION['ID'])){
                            
                            
                             $sql2 = "SELECT* FROM tickets WHERE Assigned_To = $_SESSION[ID] OR Category = '$service'";
                            // Execute SQL statement and fetch results
                            $result = mysqli_query($conn, $sql2);

                            // Check if there are any results
                            if (mysqli_num_rows($result) > 0) {

                                

                            // Display table rows
                            while($row = mysqli_fetch_assoc($result)) {
                                if($row['Status']== NULL){
                                    $status = "Open";
                                }else{
                                    $status = $row['Status'];
                                }
                               
                                // echo "<tr>
                                //         <td>".$row['CreatorID']."</td>
                                //         <td>".$row['ID']."</td>
                                //         <td>".$row['Title']."</td>
                                //         <td>".$row['Category']."</td>
                                //         <td>".$row['Description']."</td>
                                //         <td>".$row['AssignedToID']."</td>
                                //         <td>".$row['Dept']."</td>
                                //         <td>".$status."</td>
                                //         <td><a class='btn p-2  btn-primary' style='font-size: 14px;' href='operation.php'>View Ticket</a></td>
                                        
                                //     </tr>";
                            }}
                            
                           }
                           // Check if search query is set
if(isset($_GET['search']) && !empty($_GET['search'])){
    $search_query = $_GET['search'];
    $sql = "SELECT * FROM Tickets WHERE ID LIKE '%$search_query%'  AND AssignedToID = $_SESSION[ID] OR Category = '$service'";
  } else {
    // Prepare SQL statement to select all tickets
    $sql = "SELECT * FROM Tickets WHERE Assigned_To = $_SESSION[ID] OR Category = '$service'";
  }
  
  // Check if filter dates are set
  if(isset($_GET['start_date']) && !empty($_GET['start_date']) && isset($_GET['end_date']) && !empty($_GET['end_date'])){
    $start_date = date('Y-m-d', strtotime($_GET['start_date']));
    $end_date = date('Y-m-d', strtotime($_GET['end_date']));
    $sql .= " WHERE DateCreated BETWEEN '$start_date' AND '$end_date'";
  }
  
  // Execute SQL statement and fetch results
  $result = mysqli_query($conn, $sql);
  
  // Check if there are any results
  if (mysqli_num_rows($result) > 0) {
  
    // Display table rows
    while($row = mysqli_fetch_assoc($result)) {
      if($row['Status']== NULL){
          $status = "Open";
      }else{
          $status = $row['Status'];
      }
     
      echo "<tr>
                                        <td>".$row['Submitted_By']."</td>
                                        <td>".$row['ID']."</td>
                                        <td>".$row['Title']."</td>
                                        <td>".$row['Category']."</td>
                                        <td>".$row['Description']."</td>
                                        <td>".$row['Assigned_To']."</td>
                                        <td>".$row['Department']."</td>
                                        <td>".$status."</td>
                                        <td><a class='btn p-2  btn-primary' style='font-size: 14px;' href='operation.php?id=".$row['ID']."'>View Ticket</a></td>
                                        
                                    </tr>";
    }
  
    
  } else {
    echo "<tr>
     <td> No tickets found </td?
    </tr>.";
  }} 
  elseif ($_GET['id'] == 'assigned'){
    
     // Prepare SQL statement to select all tickets
     $sql = "SELECT * FROM Tickets WHERE Assigned_To = $_SESSION[ID]";
    // Execute SQL statement and fetch results
$result = mysqli_query($conn, $sql);


// Check if there are any results
if (mysqli_num_rows($result) > 0) {



// Display table rows
while($row = mysqli_fetch_assoc($result)) {
    if($row['Status']== NULL){
        $status = "Open";
    }else{
        $status = $row['Status'];
    }
   
 
    echo "<tr>
    <td>".$row['Submitted_By']."</td>
    <td>".$row['ID']."</td>
    <td>".$row['Title']."</td>
    <td>".$row['Category']."</td>
    <td>".$row['Description']."</td>
    <td>".$row['Assigned_To']."</td>
    <td>".$row['Department']."</td>
    <td>".$status."</td>
    <td><a class='btn p-2  btn-primary' style='font-size: 14px;' href='operation.php?id=".$row['ID']."'>View Ticket</a></td>
    
</tr>";
}

// Close table
echo "</table>";
} 
  

}
elseif ($_GET['id'] == 'open'){

 // Prepare SQL statement to select all tickets
 $sql = "SELECT * FROM Tickets WHERE Assigned_To = $_SESSION[ID] OR Category = '$service'";
// Execute SQL statement and fetch results
$result = mysqli_query($conn, $sql);

// Check if there are any results
if (mysqli_num_rows($result) > 0) {

// Display table rows
while($row = mysqli_fetch_assoc($result)) {

    if($row['Status']== NULL){
        $status = "Open";
    }else{
        $status = $row['Status'];
    }
   

    echo "<tr>
    <td>".$row['Submitted_By']."</td>
    <td>".$row['ID']."</td>
    <td>".$row['Title']."</td>
    <td>".$row['Category']."</td>
    <td>".$row['Description']."</td>
    <td>".$row['Assigned_To']."</td>
    <td>".$row['Department']."</td>
    <td>".$status."</td>
    <td><a class='btn p-2  btn-primary' style='font-size: 14px;' href='operation.php?id=".$row['ID']."'>View Ticket</a></td>
    
</tr>";
}

// Close table
echo "</table>";
} else {
echo "No tickets found.";
}
  
                           }}
                           
                           ?>
                        </tbody>

                </table>
            </div>

        </div>
                        

    </main>


    <script src="../../js/bootstrap.bundle.min.js"></script>

    <script src="../admin/offcanvas.js"></script>
    
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