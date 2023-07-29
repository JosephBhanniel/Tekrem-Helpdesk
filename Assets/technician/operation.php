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
	<title>Ticket Resolution</title>
	
	<!-- Include Bootstrap CSS -->
	
    <link href="../../css/bootstrap.min.css" rel="stylesheet">
    <link rel="canonical" href="../admin/offcanvas.css">
    <link href="../admin/dashboard.css" rel="stylesheet">
    <link href="../usertickets.css" rel="stylesheet">
	<style>
		.container{
			font-size: 14px;
		}
        body{
        background-color:#f8f9fa;
       }

		th{
			font-size:12px;
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
                <a href="logout.php" class="btn btn-outline-light" onclick="if (!confirm('Are you sure you want to logout?')) { event.preventDefault(); }">Log out</a>
            </div>
        </div> 
       
     </div>




	<div class="container shadow" style="margin-top:60px; font-size:12px;">
		<h2>Ticket Resolution</h2>
		<?php
			// Check if form was submitted
			if($_SERVER["REQUEST_METHOD"] == "POST"){
				// Retrieve form data
				$ticket_id = $_POST["ticket_id"];
				$resolution = $_POST["resolution"];
				$status = $_POST["status"];

				include '../../php/connect.php';

				// Check connection
				// Check connection
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                // Prepare the SQL statement with placeholders
                $sql = "UPDATE tickets SET Resolution = ?, Status = ? WHERE ID = ?";
                $stmt = $conn->prepare($sql);

                // Bind the values to the placeholders
                $stmt->bind_param("ssi", $resolution, $status, $ticket_id);

                $resolution = $resolution; // Set the value of $resolution
                $status = $status; // Set the value of $status
                $ticket_id = $ticket_id; // Set the value of $ticket_id

                // Execute the statement
                if ($stmt->execute()) {
                    echo '<div class="alert alert-success">Ticket successfully resolved!</div>';
                } else {
                    echo "Error: " . $stmt->error;
                }

                // Close the statement and connection
                $stmt->close();
                $conn->close();


			}
			else{
				// Display form to provide resolution
				echo '<form method="post" class=" p-3">
						<div class="form-group p-1">
							<label for="ticket_id">Ticket ID:</label>
							<input type="text" class="form-control" id="ticket_id" name="ticket_id" value ="'.$_GET['id'].'" required readonly>
						</div>
						<div class="form-group p-1">
							<label for="resolution">Resolution:</label>
							<textarea class="form-control" id="resolution" name="resolution" required></textarea>
						</div>
						<div class="form-group p-1">
						<label for="status">Status:</label>
						<input type="text" class="form-control" id="status" name="status" required>
					</div>
						<button type="submit" class="btn btn-primary" >Submit</button>
					</form>';
			}
		?>
	</div>


    <div class="container ">
    <?php
  
// Include database connection
include '../../php/connect.php';

// Get employee ID
$employee_id = $_SESSION['ID']; // Replace with actual employee ID

// Retrieve tickets assigned to employee
$sql="SELECT* from tickets where Assigned_To = $employee_id";


$result = $conn->query($sql);

// Check if tickets were found
if ($result->num_rows > 0) {
    // Display tickets in a table
    echo '<table class="table table-striped mt-5 responsive shadow">
            <thead class="bg-dark text-light" ">
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Dept</th>
                    <th>Category</th>
                    <th>Priority</th>
                    <th>Date Created</th>
                    <th>Last Updated</th>
                    <th>Creator</th>
                    <th>Assigned To</th>
					<th>Resolution</th>
                    <th>Status</th>
                    <th>User Feedback</th>
                </tr>
            </thead>
            <tbody>';
    while($row = $result->fetch_assoc()) {
        echo '<tr>
                <td>'.$row['ID'].'</td>
                <td>'.$row['Title'].'</td>
                <td>'.$row['Description'].'</td>
                <td>'.$row['Department'].'</td>
                <td>'.$row['Category'].'</td>
                <td>'.$row['Priority'].'</td>
                <td>'.$row['Date_Created'].'</td>
                <td>'.$row['Date_Updated'].'</td>
                <td>'.$row['Submitted_By'].'</td>
                <td>'.$row['Assigned_To'].'</td>
				<td>'.$row['Resolution'].'</td>
                <td>'.$row['Status'].'</td>
                <td>'.$row['Feedback'].'</td>
            </tr>';
    }
    echo '</tbody></table>';
} else {
    // No tickets were found
    echo '<div class="alert alert-info mt-5 shadow">No tickets found.</div>';
}

// Close database connection
$conn->close();
?>

    </div>
	<script src="../../js/bootstrap.bundle.min.js"></script>

<script src="../admin/offcanvas.js"></script>
</body>
</html>
