<?php
session_start();
if(!isset($_SESSION["ID"])){
    header("Location:../Authentications/login.php");
  }
  elseif($_SESSION["Role"]=="Administrators" || $_SESSION["Role"]=="End User")
  {
    header("Location:../Authentications/login.php");
  }

?>

<!DOCTYPE html>
<html>
<head>
	<title>View and Edit Reports</title>
	<!-- Include Bootstrap CSS -->
	
    <link href="../../css/bootstrap.min.css" rel="stylesheet">
    <link rel="canonical" href="../admin/offcanvas.css">
    <link href="../admin/dashboard.css" rel="stylesheet">
    <link href="../usertickets.css" rel="stylesheet">
    <style>
        .container{
			font-size: 12px;
			margin-top: 80px;
		}
        body{
        background-color:#f8f9fa;
       }

        @media(max-width:768px){
            .container{
                font-size: 9px;
            }
            th{
                font-size:8px;
            }
        }
    </style>
</head>
<body>
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
                    <li class="nav-item">
                        <a class="nav-link " href="itagent.php?id=dash" id="link">Home</a>
                    </li>
                    </li>
                   


                </ul>
                <a href="../Authentications/logout.php" class="nav-link me-3" id="link" onclick="if (!confirm('Are you sure you want to logout?')) { event.preventDefault(); }">Log out</a>
            </div>
        </div> 
       
    </nav>


    <div class="container">
  <div class="jumbotron text-center">
    <h1 class="display-4 ">Welcome, <?php echo $_SESSION['username']; ?> !</h1>
    <p class="lead">Here you can view and edit your reports. Explore the details below to review the reported issues, resolutions, and recommendations.</p>
  </div>

  <h3 class="p-3 mb-3">View and Edit Reports</h3>
  <div class="row">
    <?php
    // Connect to database
    include '../../php/connect.php';

    // Select reports from database
    $sql = "SELECT r.ID, t.Title, u.Username as TechnicianID, r.ReportDate, t.Description, t.Resolution, r.ProblemDescription, r.Recommendations
            FROM reports r 
            JOIN tickets t ON r.TicketID = t.ID 
            JOIN technician u ON r.TechnicianID = u.ID";
    $result = $conn->query($sql);

    // Display reports as cards
    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        ?>
        <div class="col-md-6 col-lg-6">
          <div class="card mb-3 shadow">
            <div class="card-body">
              <h5 class="card-title">Report ID: <?php echo $row["ID"]; ?></h5>
              <p class="card-text"><strong>Reported By:</strong> <?php echo $row["TechnicianID"]; ?></p>
              <p class="card-text"><strong>Date Created:</strong> <?php echo $row["ReportDate"]; ?></p>
              <p class="card-text"><strong>Description:</strong> <?php echo $row["ProblemDescription"]; ?></p>
              <p class="card-text"><strong>Resolution:</strong> <?php echo $row["Resolution"]; ?></p>
              <p class="card-text"><strong>Recommendations:</strong> <?php echo $row["Recommendations"]; ?></p>
              <a href="edit_report.php?id=<?php echo $row["ID"]; ?>" class="btn btn-primary">Edit</a>
            </div>
          </div>
        </div>
        <?php
      }
    } else {
      echo "<p>No reports found.</p>";
    }

    // Close database connection
    $conn->close();
    ?>
  </div>
</div>

    <script src="../../js/bootstrap.bundle.min.js"></script>

<script src="../offcanvas.js"></script>
</body>
</html>
