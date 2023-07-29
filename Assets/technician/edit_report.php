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
	<title>Edit Report</title>
    <link href="../../css/bootstrap.min.css" rel="stylesheet">
    <link rel="canonical" href="../admin/offcanvas.css">
    <link href="../admin/dashboard.css" rel="stylesheet">
    <link href="../usertickets.css" rel="stylesheet">
    
	 
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
                        <a class="nav-link " href="itagent.php" id="link">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " href="viewreports.php" id="link">View Reports</a>
                    </li>
                    
                   


                </ul>
                <a href="../Authentications/logout.php" id="log_out">Log out</a>
            </div>
        </div> 
       
     </div>
     




	<div class="container mt-5 p-3 shadow" >
		<h2>Edit Report</h2>
		<?php
			// Get report ID from URL parameter
			$id = $_GET["id"];

			// Connect to database
			include '../../php/connect.php';

			// Select report and ticket from database
			$sql = "SELECT r.ID, r.TicketID, r.TechnicianID, r.Recommendations, r.ProblemDescription, r.ReportDate, t.ID, t.Title, t.Department, t.Category, t.Description, t.Priority, t.Submitted_by, t.Assigned_To, t.Resolution, t.Status, t.Date_Created 
			        FROM reports r
			        JOIN tickets t ON r.TicketID = t.ID
			        WHERE r.ID = $id";
			$result = $conn->query($sql);

			if ($result->num_rows > 0) {
				$row = $result->fetch_assoc();
				$reporter_id = $row["TechnicianID"];
				$title = $row["Title"];
				$description = $row["ProblemDescription"];
				$status = $row["Status"];
				$resolution = $row["Resolution"];
				$recommendations = $row["Recommendations"];

				// Check if form was submitted
				if($_SERVER["REQUEST_METHOD"] == "POST"){
					// Retrieve form data
					$title = $_POST["title"];
					$description = $_POST["description"];
					$status = $_POST["status"];
					$resolution = $_POST["resolution"];
					$recommendations = $_POST["recommendations"];

					// Update report in database
					$sql = "UPDATE reports SET ProblemDescription='$description', Resolution='$resolution', Recommendations='$recommendations' WHERE ID = $id;
					        UPDATE tickets SET Title='$title',Status='$status', Resolution='$resolution' WHERE ID = " . $row["TicketID"];

					if ($conn->multi_query($sql) === TRUE) {
						echo '<div class="alert alert-success">Report updated successfully! <a class="text-decoration-underline" href="viewreports.php">View Report</a></div>';
						
						exit();
					} else {
						echo "Error updating report: " . $conn->error;
					}
				}

				// Display form to edit report
				echo '<form method="post" >
				         <div class="row">
						  <div class="col-md-4">
						<div class="form-group p-2">
							<label for="reporter_id">Reporter ID:</label>
							<input type="text" class="form-control" id="reporter_id" name="reporter_id" value="' . $reporter_id . '" readonly>
						</div>
						<div class="form-group p-2">
							<label for="title">Title:</label>
							<input type="text" class="form-control" id="title" name="title" value="' . $title . '" required>
						</div>
						<div class="form-group p-2">
							<label for="description"> Report Description:</label>
							<textarea class="form-control" id="description" name="description" required>' . $description . '</textarea>
						</div>
						</div>
						<div class="col-md-8">
						<div class="form-group p-2">
							<label for="status">Status:</label>
							<select class="form-control" id="status" name="status">
								<option value="New"' . ($status == "New" ? " selected" : "") . '>New</option>
								<option value="In Progress"' . ($status == "In Progress" ? " selected" : "") .
                                '>In Progress</option>
                                <option value="Resolved"' . ($status == "Resolved" ? " selected" : "") . '>Resolved</option>
                                <option value="Closed"' . ($status == "Closed" ? " selected" : "") . '>Closed</option>
                                </select>
                                </div>
                                <div class="form-group p-2">
                                <label for="resolution">Resolution:</label>
                                <textarea class="form-control" id="resolution" name="resolution">' . $resolution . '</textarea>
                                </div>

								<div class="form-group p-2">
                                <label for="recommendations">Recommendations:</label>
                                <textarea class="form-control" id="recommendations" name="recommendations">' . $recommendations . '</textarea>
                                </div>
								
								<div>
                                <button type="submit" class="btn btn-primary">Update Report</button>
								</div>
                                </form>';
                            } else {
                                echo "Report not found.";
                            }
                    
                            // Close database connection
                            $conn->close();
                        ?>
                    </div>
                    
                    <script src="../js/bootstrap.bundle.min.js"></script>

                    <script src="offcanvas.js"></script>
                    </body>
</html>                    