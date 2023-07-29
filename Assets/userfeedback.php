<?php
session_start();
if(!isset($_SESSION["ID"])){
    header("Location:login.php");
  }
  elseif($_SESSION["Role"]=="End User" || $_SESSION["Role"]=="Administrator")
  {
    header("Location:login.php");
  }

?>

<!DOCTYPE html>
<html>
<head>
	<title>View Ticket</title>
	<link rel="canonical" href="offcanvas.css">
    <link rel="icon" href="../Images/log3.png" type="image/x-icon">
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="usertickets.css">
    <style>
        h3{
            margin: 4px;
        }
        .container{
            margin-top:60px;
            padding:20px;
        }
    </style>
</head>
<nav class="navbar navbar-expand-lg fixed-top navbar-dark bg-dark" aria-label="Main navigation">
        <div class="container-fluid">
            <a class="navbar-brand" href="#"><img src="../Images/log3.png" alt="logo" width="90" height="70" id="logo"></a>
            <div class=" me-2 text-light d-flex " >
                 <?php echo '<h3>'.$_SESSION['firstname'].'</h3> '?>
                 <?php echo '<h3>'.$_SESSION['lastname'].'</h3>'?>
                 </div>
            <button class="navbar-toggler  p-0 border-0" type="button" id="navbarSideCollapse" aria-label="Toggle navigation">
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
                <a href="logout.php" id="log_out">Log out</a>
            </div>
    </nav>


<body>
	<div class="container">
		<h2 class="bg-dark text-light p-2">Tiket Review</h2>
		<?php
			// Get ticket ID from URL parameter
			$id = $_GET["id"];
            		// Connect to database
		include '../php/connect.php';

		// Select ticket from database
		$sql = "SELECT t.ID AS Ticket_ID, t.Title, t.Description, t.Priority, t.Status, t.Resolution, t.Date_Created, t.Date_Updated, t.Department, t.Category,
		f.ID AS Feedback_ID, f.Rating, f.Comments, f.Submitted_By AS Feedback_Submitted_By, f.Date_Submitted, f.Assigned_To AS Feedback_Assigned_To, f.Response, f.Date_Responded, f.Response_Status
		FROM tickets t
		LEFT JOIN feedback f ON t.ID = f.Ticket_ID
		WHERE t.ID = $id";
		$result = $conn->query($sql);

		if ($result->num_rows > 0) {
			$row = $result->fetch_assoc();
			$title = $row["Title"];
			$description = $row["Description"];
			$status = $row["Status"];
			$resolution = $row["Resolution"];
			$date_created = $row["Date_Created"];
			$feedbck = $row["Comments"];
			$response = $row["Response"];

			// Display ticket details
			echo ' <h3 class="text-capitalize"> Title: ' . $title . '</h3>';
			echo '<p class="p-2">Submitted on: ' . date("F j, Y, g:i a", strtotime($date_created)) . '</p>';
			echo '<p class="p-2">Issue: ' . $description . '</p>';
			echo '<p class="p-2">Status: ' . $status . '</p>';
			echo '<p class="p-2">Resolution: ' . $resolution . '</p>';
			echo '<p class="p-2">Your Feedback: ' . $feedbck . '</p>';
			echo '<p class="p-2">Technician Feedback: ' . $response . '</p>';

			// Check if form was submitted
			if ($_SERVER["REQUEST_METHOD"] === "POST") {
				// Check if the form was submitted
				if (isset($_POST["submit_feedback"])) {
					// Retrieve form data
					$response = $_POST["feedback"];
					
			
					$sql = "UPDATE feedback 
		SET Response = '$response',
			Date_Responded = CURRENT_TIMESTAMP,
			Response_Status = 'Resolved'
		WHERE Ticket_ID = $id";

			
					if ($conn->query($sql) === TRUE) {
						echo '<div class="alert alert-success">Feedback submitted successfully!</div>';
					} else {
						echo "Error inserting feedback: " . $conn->error;
					}
				}
			}
			
			// Display form to submit feedback
			echo '<form method="post" id="form">
					
					<div class="form-group m-2">
						<label for="feedback">Feedback:</label>
						<textarea class="form-control" id="feedback" name="feedback" required></textarea>
					</div>
					
					<input type="submit" name="submit_feedback" class="btn btn-primary" value="Submit Feedback">
				</form>';
			
		} else {
			echo '<div class="alert alert-danger">Ticket not found!</div>';
		}
	?>
</div>


<script src="../js/bootstrap.bundle.min.js "></script>

    <script src="offcanvas.js "></script>
	
</body>
</html>