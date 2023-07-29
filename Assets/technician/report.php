<?php
session_start();
if(!isset($_SESSION["ID"])){
    header("Location:../Authentications/login.php");
  }
  elseif($_SESSION["Role"]=="Administrator" || $_SESSION["Role"]=="End User")
  {
    header("Location:../Authentications/login.php");
  }

?>


<!DOCTYPE html>
<html>
  <head>
    <title>Submit Report</title>
    <!-- Include Bootstrap CSS -->
    <link href="../../css/bootstrap.min.css" rel="stylesheet">
    <link rel="canonical" href="../admin/offcanvas.css">
    <link href="../admin/dashboard.css" rel="stylesheet">
    <link href="../usertickets.css" rel="stylesheet">
    <style>
       td{
        
        padding: 8px;
       }

       fieldset{
        border:none;
        padding: 10px;
        margin: 80px 30px 0 0;
       }
       body{
        background-color:#f8f9fa;
       }

       textarea{
        width: 400px;
        height:100px;
       }

       @media(max-width:768px){
			textarea{
				width:200px;
			}
		}
    </style>
  </head>
  <body>
  <div class="container">
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
                    
                    
                    <li class="nav-item">
                        <a class="nav-link " href="itagent.php?id=dash" id="link">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " href="viewreports.php" id="link">View Reports</a>
                    </li>
                    
                   


                </ul>
                <a href="logout.php" id="log_out">Log out</a>
            </div>
        </div> 
       
     </div>
         
<div>



    
    <div class="container mt-4 p-5 justify-content-center">
    
    <div class="card shadow ">
  <div class="card-body">
    <h5 class="card-title text-center">Create Report</h5>
    <form method="post" action="submit_report.php">
    <div class="row p-5">
     <div class="col-md-4">
     <div class="mb-3">
        <label for="ticketID" class="form-label">Ticket ID:</label>
        <input type="number" name="ticketID" required class="form-control">
      </div>
      <div class="mb-3">
        <label for="technicianID" class="form-label">Technician ID:</label>
        <input type="number" name="technicianID" required class="form-control" value="<?php echo $_SESSION['ID'];?>" readonly>
      </div>
      <div class="mb-3">
        <label for="problemDescription" class="form-label">Problem Description:</label>
        <textarea name="problemDescription" required class="form-control"></textarea>
      </div>
  </div>
      <div class="col-md-4">
   
      <div class="mb-3">
        <label for="resolution" class="form-label">Resolution:</label>
        <input type="text" name="resolution" class="form-control">
      </div>
      <div class="mb-3">
        <label for="recommendations" class="form-label">Recommendations:</label>
        <textarea name="recommendations" class="form-control"></textarea>
      </div>
      <div class="mb-3">
        <label for="outcome" class="form-label">Outcome:</label>
        <select name="outcome" class="form-control">
          <option value="Resolved">Resolved</option>
          <option value="Pending">Pending</option>
          <option value="Unresolved">Unresolved</option>
        </select>
        </div>
      </div>
      <div>
      <button type="submit" class="btn btn-primary">Submit</button>
      </div>  
    </form>
  </div>
</div>

       


    
  </body>
  <script src="../../js/bootstrap.bundle.min.js"></script>

<script src="../admin/offcanvas.js"></script>
</html>
