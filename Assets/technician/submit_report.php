
<?php
session_start();
if(!isset($_SESSION["ID"])){
    header("Location:../Authentications/login.php");
  }
  elseif($_SESSION["Role"]=="Administrator" || $_SESSION["Role"]=="End User")
  {
    header("Location:../Authentications/login.php");
  }
// // Check if the form is submitted
// if ($_SERVER["REQUEST_METHOD"] == "POST") {
//     // Connect to the database
//     $conn = mysqli_connect("localhost", "root", "", "it_ticketing_system");
//     if (!$conn) {
//         die("Connection failed: " . mysqli_connect_error());
//     }

//     // Get the form data
//     $ticketID = $_POST["ticketID"];
//     $technicianID = $_POST["technicianID"];
//     $problemDescription = $_POST["problemDescription"];
//     $reportDate = date("Y-m-d H:i:s"); // Current date and time
//     $_SESSION["TechID"] = $technicianID;

//     // Prepare SQL statement to insert report
//     $sql = "INSERT INTO Reports (TicketID, TechnicianID, problemDescription, ReportDate)
//             VALUES ('$ticketID', '$technicianID', '$problemDescription', '$reportDate')";

//     // Check if the report is successfully inserted
//     if (mysqli_query($conn, $sql)) {
//         // Redirect to the same page to prevent form resubmission
//         header("Location: " . $_SERVER["PHP_SELF"] . "?success=1");
//         exit();
//     } else {
//         echo "Error: " . $sql . "<br>" . mysqli_error($conn);
//     }

//     // Close the database connection
//     mysqli_close($conn);
// }
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Connect to the database using PDO
    $dsn = "mysql:host=localhost;dbname=tek_helpdesk;charset=utf8mb4";
    $username = "root";
    $password = "";
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ];
    try {
        $pdo = new PDO($dsn, $username, $password, $options);
    } catch (\PDOException $e) {
        throw new \PDOException($e->getMessage(), (int) $e->getCode());
    }

    // Sanitize and validate the form data
    
    $ticketID = filter_input(INPUT_POST, 'ticketID', FILTER_VALIDATE_INT);
    $resolution = filter_input(INPUT_POST, 'resolution', FILTER_SANITIZE_STRING);
    $recommendations = filter_input(INPUT_POST, 'recommendations', FILTER_SANITIZE_STRING);
    $outcome = filter_input(INPUT_POST, 'outcome', FILTER_SANITIZE_STRING);
    $technicianID = filter_input(INPUT_POST, 'technicianID', FILTER_VALIDATE_INT);
    $problemDescription = filter_input(INPUT_POST, 'problemDescription', FILTER_SANITIZE_STRING);
    if (!$ticketID || !$technicianID || !$problemDescription) {
        die("<h4 class='alert alert-success'>Invalid Details Provided!</h4>");
    }

    // Check if the ticket ID and technician ID exist in the database
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM tickets WHERE ID = ? AND Assigned_To = ?");
    $stmt->execute([$ticketID, $technicianID]);
    $count = $stmt->fetchColumn();
    if ($count == 0) {
        die("Invalid ticket ID or technician ID.");
    }

    // Insert the report into the database
    $reportDate = date("Y-m-d H:i:s"); // Current date and time
    $stmt = $pdo->prepare("INSERT INTO reports (TicketID, TechnicianID, ProblemDescription, Resolution, Recommendations, Outcome, ReportDate) VALUES (?, ?, ?, ?, ?, ?, ?)");
    try {
        $stmt->execute([$ticketID, $technicianID, $problemDescription, $resolution, $recommendations, $outcome, $reportDate]);
        // Redirect to the same page to prevent form resubmission
        header("Location: " . $_SERVER["PHP_SELF"] . "");
        // exit();
    } catch (\PDOException $e) {
        die("Error: " . $e->getMessage());
    }
}


?>


<!DOCTYPE html>
<html>
<head>
	<title>Report Details</title>
	<!-- Include Bootstrap CSS -->
    <link href="../../css/bootstrap.min.css" rel="stylesheet">
    <link rel="canonical" href="../admin/offcanvas.css">
    <link href="../admin/dashboard.css" rel="stylesheet">
    <link href="../usertickets.css" rel="stylesheet">
	<style>
		#container{
			font-size: 14px;
			margin-top: 80px;
		}

		table{
            font-size: 1.2vw;
        }
		
	</style>
</head>
<body>
<div class="container">
     <nav class="navbar navbar-expand-lg fixed-top navbar-dark bg-dark" aria-label="Main navigation">
        <div class="container-fluid">
            <a class="navbar-brand" href="#"><img src="../../Images/log3.png" alt="logo" width="90" height="70" id="logo"></a>
            <div class=" me-2 text-light d-flex " >
                 <?php echo '<h3>'.$_SESSION['firstname'].'</h3> '?>
                 <?php echo '<h3>'.$_SESSION['lastname'].'</h3>'?>  
                 
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

    





	<div class="container" id="container">
		<h1>Report Details</h1>
        <div class="table table-responsive">
		<table class="table table-bordered">
			<thead class="bg-dark text-light">
				<tr>
					<th>ID</th>
					<th>Ticket ID</th>
					<th>Technician ID</th>
					<th>Problem</th>
                    <th>Resolution</th>
                    <th>Recommendations</th>
					<th>Report Date</th>
                    <th>Outcome</th>
				</tr>
			</thead>
			<tbody>
				<?php
				if(isset($_SESSION["ID"])){
                    // Retrieve report details from database and display them in the table
				// Replace DB_HOST, DB_USER, DB_PASS, and DB_NAME with your database details
				include '../../php/connect.php';
				if (!$conn) {
					die("Connection failed: " . mysqli_connect_error());
				}
				$sql = "SELECT * FROM reports WHERE TechnicianID = ".$_SESSION['ID']."";
				$result = mysqli_query($conn, $sql);
				if (mysqli_num_rows($result) > 0) {
					while($row = mysqli_fetch_assoc($result)) {
						echo "<tr>";
						echo "<td>".$row['ID']."</td>";
						echo "<td>".$row['TicketID']."</td>";
						echo "<td>".$row['TechnicianID']."</td>";
						echo "<td>".$row['ProblemDescription']."</td>";
                        echo "<td>".$row['Resolution']."</td>";
                        echo "<td>".$row['Recommendations']."</td>";
						echo "<td>".$row['ReportDate']."</td>";
                        echo "<td>".$row['Outcome']."</td>";
						echo "</tr>";
					}
				} else {
					echo "<tr><td colspan='5'>No report found.</td></tr>";
				}
				mysqli_close($conn);
                }
				?>
			</tbody>
		</table>
		<button class="btn btn-primary" id="exportBtn">Export Report</button>

	</div>
    </div>
	<script>
		document.getElementById('exportBtn').addEventListener('click', function() {
  // Send an AJAX request to the server to retrieve the report data
  var xhr = new XMLHttpRequest();
  xhr.open('GET', 'export_report.php');
  xhr.onload = function() {
    if (xhr.status === 200) {
      // Convert the response to a CSV file and download it
      var data = JSON.parse(xhr.responseText);
      var csv = 'ID,Ticket ID,Technician ID,Report Text,Report Date\n';
      data.forEach(function(row) {
        csv += row.ID + ',' + row.TicketID + ',' + row.TechnicianID + ',' +
          '"' + row.problemDescription.replace(/"/g, '""') + '",' + row.ReportDate + '\n';
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
	<script src="../../js/bootstrap.bundle.min.js"></script>

<script src="../admin/offcanvas.js"></script>
</body>
</html>

