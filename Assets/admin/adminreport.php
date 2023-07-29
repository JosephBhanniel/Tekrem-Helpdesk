<?php
session_start();
if(!isset($_SESSION['ID']) || $_SESSION["Role"]=="Technician" || $_SESSION["Role"]=="End User"){
  header("location: ../index.php");
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Report Details</title>
	<!-- Include Bootstrap CSS -->
    <link href="../../css/bootstrap.min.css" rel="stylesheet">
    <link rel="canonical" href="offcanvas.css">
    <link href="dashboard.css" rel="stylesheet">
	<link rel="stylesheet" href="../../bootstrap-icons-1.9.1/bootstrap-icons.css">
    <link href="../usertickets.css" rel="stylesheet">
	<style>
		#container{
			font-size: 14px;
			margin-top: 80px;
		}

		
		
	</style>
</head>
<body>
<div class="container">
     <nav class="navbar navbar-expand-lg fixed-top navbar-dark bg-dark" aria-label="Main navigation">
        <div class="container-fluid">
            <a class="navbar-brand" href="#"><img src="../../Images/log3.png" alt="logo" width="90" height="70" id="logo"></a>
            
            <button class="navbar-toggler p-0 border-0" type="button" id="navbarSideCollapse" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    

            <div class="navbar-collapse offcanvas-collapse" id="navbarsExampleDefault">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 ">  
                    
                    
                    <li class="nav-item">
                        <a class="nav-link " href="dashboard.php?id=dashboard&&id7=Dashboard" id="link"> <i class="bi bi-speedometer"></i> Dashboard</a>
                    </li>
					
					
					
                   
                    
                   


                </ul>
                <a href="../Authentications/logout.php" class="me-3" id="link">Log out</a>
            </div>
        </div> 
       
     </div>

    




	 <div class="container " id="container">
	 <div class="jumbotron text-center">
    <h1 class="display-4">Welcome to the Helpdesk Report Center</h1>
    <p class="lead">Here you can find detailed reports about the helpdesk activities. Explore the report details below to gain insights into ticket resolutions, technician performance, and user feedback.</p>
  </div>
  <div class="row">
    <?php
    // Retrieve report details from the database
    // Replace DB_HOST, DB_USER, DB_PASS, and DB_NAME with your database details
    include '../../php/connect.php';

    if (!$conn) {
      die("Connection failed: " . mysqli_connect_error());
    }

    $sql = "SELECT reports.ID, reports.TicketID, reports.TechnicianID, reports.ProblemDescription, reports.Resolution, reports.Recommendations, reports.Outcome, reports.ReportDate, tickets.Feedback
            FROM reports
            INNER JOIN tickets ON tickets.ID = reports.TicketID";

    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
      while ($row = mysqli_fetch_assoc($result)) {
        ?>
        <div class="col-md-6 col-lg-6">
          <div class="card mb-3 shadow">
            <div class="card-body">
              <h5 class="card-title">Report ID: <?php echo $row['ID']; ?></h5>
              <p class="card-text"><strong>Ticket ID:</strong> <?php echo $row['TicketID']; ?></p>
              <p class="card-text"><strong>Technician ID:</strong> <?php echo $row['TechnicianID']; ?></p>
              <p class="card-text"><strong>Issue:</strong> <?php echo $row['ProblemDescription']; ?></p>
              <p class="card-text"><strong>Resolution:</strong> <?php echo $row['Resolution']; ?></p>
              <p class="card-text"><strong>Recommendations:</strong> <?php echo $row['Recommendations']; ?></p>
              <p class="card-text"><strong>Report Date:</strong> <?php echo $row['ReportDate']; ?></p>
              <p class="card-text"><strong>Outcome:</strong> <?php echo $row['Outcome']; ?></p>
              <p class="card-text"><strong>User Feedback:</strong> <?php echo $row['Feedback']; ?></p>
            </div>
          </div>
        </div>
        <?php
      }
    } else {
      echo "<p>No reports found.</p>";
    }

    mysqli_close($conn);
    ?>
  </div>
  <button class="btn btn-primary shadow" id="exportBtn">Export Reports</button>
</div>


	</div>
	<script>
		document.getElementById('exportBtn').addEventListener('click', function() {
  // Send an AJAX request to the server to retrieve the report data
  var xhr = new XMLHttpRequest();
  xhr.open('GET', '../export_report.php');
  xhr.onload = function() {
    if (xhr.status === 200) {
      // Convert the response to a CSV file and download it
      var data = JSON.parse(xhr.responseText);
      var csv = 'ID,Ticket ID,Technician ID,Report Text,Report Date\n';
      data.forEach(function(row) {
        csv += row.ID + ',' + row.TicketID + ',' + row.TechnicianID + ',' +
          '"' + row.ReportText.replace(/"/g, '""') + '",' + row.ReportDate + '\n';
      });
      var blob = new Blob([csv], {type: 'text/csv'});
      var link = document.createElement('a');
      link.href = window.URL.createObjectURL(blob);
      link.download = 'report.csv';
      link.click();
    }
  };
  xhr.send();
  alert("Successfully exported.Check your downloads");
});
    
	</script>
	<script src="../js/bootstrap.bundle.min.js"></script>

<script src="offcanvas.js"></script>
</body>
</html>

