<?php
// require_once '../twilio/autoload.php';

include("../../php/connect.php");
session_start();
if(!isset($_SESSION["ID"])){
    header("Location:../Authentications/login.php");
  }
  elseif($_SESSION["Role"]=="Administrator" || $_SESSION["Role"]=="Technician")
  {
    header("Location:../Authentications/login.php");
  }elseif($_SESSION['Role'] == "End User"){
        // Establish database connection
  
    if(isset($_POST['submit'])){
        
// Get form data from user
$title = mysqli_real_escape_string($conn, $_POST['title']);
$dept = mysqli_real_escape_string($conn, $_POST['dept']);
$category = mysqli_real_escape_string($conn, $_POST['category']);
$description = mysqli_real_escape_string($conn, $_POST['description']);
$priority = mysqli_real_escape_string($conn, $_POST['priority']);
$creatorID = mysqli_real_escape_string($conn, $_POST['ID']);
$dateCreated = date("Y-m-d H:i:s");
$statusID = 1; // Default status is "Open"

// Validate form data
if (empty($title) || empty($dept) || empty($category) || empty($description) || empty($priority) || empty($creatorID)) {
  die("Error: All fields are required.");
}

if (!filter_var($creatorID, FILTER_VALIDATE_INT)) {
  die("Error: Creator ID must be an integer.");
}

if (!in_array($priority, array("Low", "Medium", "High"))) {
  die("Error: Invalid priority level.");
}

// Prepare SQL statement to insert ticket
$sql = "INSERT INTO tickets (Title, Department, Category, Description, Priority, Submitted_By, Date_Created)
        VALUES ('$title', '$dept', '$category', '$description', '$priority', '$creatorID', '$dateCreated')";

// Check if the ticket is successfully inserted
if (mysqli_query($conn, $sql)) {
  // Get the ID of the inserted ticket
  $ticketId = mysqli_insert_id($conn);

  // Insert notification details
  $notificationQuery = "INSERT INTO notifications (ticket_id, category, body, created_at) VALUES ('$ticketId', '$category', 'New ticket created', NOW())";
  if (mysqli_query($conn, $notificationQuery)) {
    // Notification inserted successfully
    // Redirect to the same page to prevent form resubmission
    header('Location: ' . $_SERVER['REQUEST_URI']);
  } else {
    echo "Error: " . $notificationQuery . "<br>" . mysqli_error($conn);
  }
} else {
  echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}}}

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <title> <?php echo $_SESSION['username']?></title>
    <link rel="canonical" href="offcanvas.css">
    <link rel="icon" href="../../Images/log3.png" type="image/x-icon">
    <link href="../../css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../usertickets.css">
    <script src="../../jquery/jquery-3.6.1.min.js"></script>
    <style>
        h3{
            margin: 4px;
        }
        .card{
          width:1100px;
          margin:auto;
        }

        @media(max-width:1100px){
          .card{
            width:auto;
            margin:auto;
            
          }

          .responsive{
            overflow-x: auto;
            display: block;
            white-space: nowrap;
          }
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
            <button class="navbar-toggler  p-0 border-0" type="button" id="navbarSideCollapse" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>  
             
            <div class="navbar-collapse offcanvas-collapse" id="navbarsExampleDefault">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 ">

                </ul>
                <a class="nav-link me-3" href="#table"  id="link"  >View Tickets</a>
                <a class="nav-link me-3  " href="selfhelp.php" id="link">Self Help</a>
                <a class="nav-link me-3" href="../Authentications/logout.php" id="link" onclick="if (!confirm('Are you sure you want to logout?')) { event.preventDefault(); }">Log out</a>
            </div>
        </div>
    </nav>


    <main id="main">
    <div class="card tickets shadow mb-4">
  <div class="card-body">
  <div style="background-image: url('../../images/call cent.jpg'); background-size: cover; height:30vh; background-position: center; padding: 20px; text-align: center;">
  <p style="font-size: 1.4vw; padding-top:25px; margin-bottom: 10px; color:#fff">
    <em>Hello <?php echo $_SESSION["username"]; ?>! Kindly check out <em style="font-size:1.8vw">Self-help</em> before you submit a ticket</em>
  </p>
  <a class="btn btn-primary" href="selfhelp.php" >Self-help</a>
  <div class="btn btn-primary" id="createTicketBtn">Create Ticket</div>
</div>

 
    <div id="createTicketForm">
    <form method="post" id="form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
       
       <div class="row p-3">
          <div class="col-md-8">
        <div class="mb-3">
          <label for="ID" class="form-label">Employee ID:</label>
          <input type="number" name="ID" required value="<?php echo $_SESSION['ID'];?>" class="form-control">
        </div>
        <div class="mb-3">
          <label for="title" class="form-label">Problem Title:</label>
          <input type="text" name="title" required class="form-control" placeholder="e.g Computer crash">
        </div>
        <div class="mb-3">
          <label for="category" class="form-label">Category:</label>
          <select name="category" required class="form-control">
            <option value="">Select Category</option>
            <option value="Hardware">Hardware</option>
            <option value="Software">Software</option>
            <option value="Networks">Networks</option>
          </select>
        </div>
      </div>
      <div class="col-md-4">
        <div class="mb-3">
          <label for="dept" class="form-label">Department:</label>
          <select name="dept" required class="form-control">
            <option value="">Select Department</option>
            <option value="Human Resource">Human Resource</option>
            <option value="Accounting">Accounting</option>
            <option value="Marketing">Marketing</option>
            <option value="Operations">Operations</option>
            <option value="Information Technology">Information Technology</option>
          </select>
        </div>
        <div class="mb-3">
          <label for="description" class="form-label">Details &amp; Description:</label>
          <textarea name="description" required class="form-control"></textarea>
        </div>
        <div class="mb-3">
          <label for="priority" class="form-label">Priority:</label>
          <select name="priority" required class="form-control">
            <option value="">Select Priority Level</option>
            <option value="Low">Doesn't really affect me</option>
            <option value="Medium">It has affected some of my workflow</option>
            <option value="High">It has affected all of my work</option>
          </select>
        </div>
      </div>
       <div class="row">
        <div class="col-md-8 text-center">
       <button type="submit" name="submit" class="btn btn-primary">Submit</button>
        <button type="reset" class="btn btn-danger" id="create">Clear</button>
        </div>
      </div>
    
    </div>
  </div>
</div>
        
        </div>
        </form>
        </div>
<script>
$(document).ready(function() {

     // Hide the create ticket form initially
  $("#createTicketForm").hide("slow");
  // Show the create ticket form when the button is clicked
  $("#createTicketBtn").click(function() {
    $("#createTicketForm").toggle("slow");
    $("#createTicketBtn").toggle("slow");
  });


  $("#create").click(function() {
    $("#createTicketForm").toggle("slow");
    $("#createTicketBtn").toggle("slow");
  });

  $("#link").click(function() {
    $("#createTicketForm").hide("slow");
    $("#createTicketBtn").show("slow");
  });

  
});
</script>

   
            <!--USER TICKETS-->
            <div id="table_container">
                
                <h6 class="border-bottom mt-4 ms-3 ">My Tickets</h6>
                <div class="d-flex justify-content-end">
                   <div>
               <form action="#" class="form d-flex m-2">
              <input style="padding:3px; border-radius:4px; border:1px solid grey; margin-right:-3px;" type="search" name="search" id="searchid" placeholder="Ticket # or 0 for All">
              <input class="btn btn-sm btn-primary" type="submit" value="Search">

                  </form>
                   </div> 
                    </div>
                    <div class="responsive">
                    <table id="table" class="table shadow">
                        <thead id="thead">
                        <th >EmployeeID</th>
                        <th >TicketID</th>
                        <th >Title</th>
                        <th >Category</th>
                        <th >Description</th>
                        <th >Assigned</th>
                        <th >Date</th>
                        <th >Status</th>
                        <th >Action</th>
                        </thead>

                        <tbody>
                           <?php

                           if(isset($_SESSION['ID'])){
                             $sql2 = "SELECT* FROM Tickets WHERE Submitted_By = $_SESSION[ID] ";
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
                               
                            }}
                            
                           }

                           // Check if search query is set
if(isset($_GET['search']) && !empty($_GET['search'])){
    $search_query = $_GET['search'];
    $sql = "SELECT * FROM tickets WHERE ID LIKE '%$search_query%'";
  } else {
    // Prepare SQL statement to select all tickets
    $sql = "SELECT * FROM tickets WHERE Submitted_By = $_SESSION[ID]";
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
      <td>".$row['Date_Created']."</td>
      <td>".$status."</td>
      <td><a class='btn btn-primary' href='viewticket.php?id=".$row['ID']."'>View Ticket</a></td>
      
  </tr>";
    }
  
    
  } else {
    echo "<tr>
    <td>No tickets found.</td>
    </tr>";
  }


                           
                           ?>
                        </tbody>

                    </table>
</div>
            </div>
        


    </main>


    <script src="../../js/bootstrap.bundle.min.js "></script>

    <script src="../admin/offcanvas.js "></script>
    <script>
// Get the form element and add an event listener for submission
const form = document.querySelector('form');
form.addEventListener('submit', (event) => {
// Prevent the default form submission behavior

// Submit the form data using AJAX or fetch API

// Redirect to the same page after submission
window.location.href = window.location.href;

// Display an alert message to the user
alert('A new ticket has been created!');

});

</script>

   
</body>

</html>