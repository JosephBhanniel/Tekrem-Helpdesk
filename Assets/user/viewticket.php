<?php
session_start();
if(!isset($_SESSION["ID"])){
    header("Location:../Authentications/login.php");
  }
  elseif($_SESSION["Role"]=="Administrator" || $_SESSION["Role"]=="Technician")
  {
    header("Location:../Authentications/login.php");
  }

?>

<!DOCTYPE html>
<html>
<head>
	<title>View Ticket</title>
	<link rel="canonical" href="offcanvas.css">
    <link rel="icon" href="../../Images/log3.png" type="image/x-icon">
    <link href="../../css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../usertickets.css">
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
            <a class="navbar-brand" href="enduser.php"><img src="../../Images/log3.png" alt="logo" width="90" height="70" id="logo"></a>
            <div class=" me-2 text-light d-flex " >
                 <?php echo '<h3>'.$_SESSION['username'].'</h3> '?>
                 
                 </div>
            <button class="navbar-toggler  p-0 border-0" type="button" id="navbarSideCollapse" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>  
             
            <div class="navbar-collapse offcanvas-collapse" id="navbarsExampleDefault">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 ">
                   
                <li class="nav-item">
                        <a class="nav-link " href="enduser.php" id="link">Create & View Tickets</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " href="selfhelp.php" id="link">Self Help</a>
                    </li>


                </ul>
                <a href="../Authentications/logout.php" class="btn btn-outline-light">Log out</a>
            </div>
        </div>
    </nav>


<body>
<div class="container">
    <div class="card shadow">
        <h2 class="card-header bg-dark text-light p-2">Ticket Review</h2>
        <div class="card-body">
            <?php
                // Get ticket ID from URL parameter
                $id = $_GET["id"];
                // Connect to the database
                include '../../php/connect.php';

                // Select ticket from the database
                $sql = "SELECT * FROM tickets WHERE ID = $id";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $title = $row["Title"];
                    $description = $row["Description"];
                    $status = $row["Status"];
                    $resolution = $row["Resolution"];
                    $date_created = $row["Date_Created"];
                    $feedback = $row["Feedback"];

                    // Display ticket details
                    echo '<h3 class="card-title text-capitalize">Title: ' . $title . '</h3>';
                    echo '<p class="card-text p-2"><strong>Submitted on:</strong> ' . date("F j, Y, g:i a", strtotime($date_created)) . '</p>';
                    echo '<p class="card-text p-2"><strong>Issue:</strong> ' . $description . '</p>';
                    echo '<p class="card-text p-2"><strong>Status:</strong> ' . $status . '</p>';
                    echo '<p class="card-text p-2"><strong>Resolution:</strong> ' . $resolution . '</p>';
                    echo '<p class="card-text p-2"><strong>Your Feedback:</strong> ' . $feedback . '</p>';

                    // Check if form was submitted
                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                        // Retrieve form data
                        $feedback = $_POST["feedback"];

                        // Update ticket in the database with feedback
                        $sql = "UPDATE tickets SET Feedback='$feedback' WHERE ID = $id";

                        if ($conn->query($sql) === TRUE) {
                            echo '<div class="alert alert-success">Feedback submitted successfully!</div>';
                            // header('Location: ' . $_SERVER['REQUEST_URI']);
                            exit();
                        } else {
                            echo "Error updating ticket: " . $conn->error;
                        }
                    }

                    // Display form to submit feedback
                    echo '<form method="post" id="form">
                            <div class="form-group m-2">
                                <label for="feedback">Feedback:</label>
                                <textarea class="form-control" id="feedback" name="feedback" required></textarea>
                            </div>
                            <input class="btn btn-primary" type="submit" value="Submit Feedback">
                        </form>';
                } else {
                    echo '<div class="alert alert-danger">Ticket not found!</div>';
                }
            ?>
        </div>
    </div>
</div>



<script src="../../js/bootstrap.bundle.min.js "></script>

    <script src="../admin/offcanvas.js "></script>
	
</body>
</html>