<?php
session_start();
if(!isset($_SESSION['ID'])){
    header("Location: ../Authentications/login.php");
}

?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.101.0">
    <link rel="icon" href="../../Images/log3.png" type="image/x-icon">
    <title>Self Help</title>
    <link href="../../css/bootstrap.min.css" rel="stylesheet">
    <link href="../../bootstrap-icons-1.9.1/bootstrap-icons.css" rel="stylesheet">
    <link href="../usertickets.css" rel="stylesheet">
    <script src="../../jquery/jquery-3.6.1.min.js"></script>

</head>

<style>
    #center {
        width: 1200px;
        margin: auto;
        margin-top: 30px;
        color: #fff;
        font-size:1.3vw;
        display: flex;
    }
    .row{
        margin-left:20px;
    }
    .card{
        margin-top: 8px;
    }
    
     body{
        background: linear-gradient(to top, #ffffff -70%, #ccccff 100%);
     }


     .jumbutron{
      background-image: url("../../images/helper.jpg");
      background-size:cover;
      height: 50vh;
      margin-top:-20px;
      padding:20px 10px 10px 10px;
     

     }

     #wilks_images{
       width:40px;
       height:auto;
     }

    
    
   

    @media(max-width:1300px){
        #center {
        width: 450px;
        margin: auto;
        margin-top: 10px;
        color: #fff;
        font-size:1.3vw;
        display: grid;
    }
    }

    @media(max-width:768px){
        .row {
        margin-left:0;
    }
    }


    nav{
        display:flex;
        justify-content:space-between;
        margin:30px;
        background:black;
        margin:0;
        margin-top:-70px;
        padding: 20px;
    }
    .lnks{
        margin-right:10px;
        color:#fff;
        text-decoration:none;
    }

    .lnks:hover{
        background-color:white;
        color:#000;
        border-radius: 8px;
        padding:5px;
        transition: 0.33s;
    }
    .link_holder{
        margin-top: 15px;
    }


    .floating-text {
            position: absolute;
            top: -30px;
            left: -70px;
            font-size: 14px;
            color: #fff;
            background-color: #007bff;
            padding: 6px 12px;
            border-radius: 4px;
            animation: floatAnimation 2s infinite;
            margin-bottom: 30px;
        }
        
        @keyframes floatAnimation {
            0% {
                transform: translateX(0);
            }
            50% {
                transform: translateX(-10px);
            }
            100% {
                transform: translateX(0);
            }
        }
        
        .chatbot-icon {
            position: fixed;
            bottom: 20px;
            right: 20px;
            width: 60px;
            height: 60px;
            background-color: #407DC0;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 24px;
            cursor: pointer;
            z-index: 9999;
        }
        
        .chatbot-container {
            position: fixed;
            bottom: 100px;
            right: 20px;
            width: 400px;
            background-color: #f8f9fa;
            border-radius: 4px;
            border: 1px solid #ccc;
            z-index: 9999;
        }
        
        .chatbot-header {
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            border-bottom: 1px solid #ccc;
        }
        
        .chatbot-body {
            padding: 10px;
            height: 300px;
            overflow-y: auto;
        }
        
        .chatbot-footer {
            padding: 10px;
            border-top: 1px solid #ccc;
        }
        
        .chatbot-input {
            width: 100%;
            padding: 6px 12px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        
        .chatbot-message {
            margin-bottom: 10px;
        }
        
        .chatbot-bot {
            background-color: #fff;
            padding: 8px 12px;
            border-radius: 4px;
            border: 1px solid #ccc;
        }
        
        .chatbot-user {
            text-align: right;
        }

        #ikonic{
          border-radius: 100%;
        }
</style>

<body>
    <nav>
        <div>
            <a href="enduser.php">
                <img src="../../images/log3.png" alt="logo" width="70" height="auto" id="logo">
            </a>
        </div>
        <div class="link_holder">
            <a href="enduser.php " class="lnks">Home</a>
            <a href="../Authentications/Logout.php " class="lnks" onclick="if (!confirm('Are you sure you want to logout?')) { event.preventDefault(); }">Logout</a>
        </div>
    </nav>

   <div class="jumbutron">
   <h3 class="text-center m-4 text-light mt-5">Welcome To Self-Help <?php echo $_SESSION['username'];?> !</h3>
        <h5 class="text-center m-4 text-light">This section enables you to overcome Basic problems without the aid of our technical team</h5>
         <h6 class="text-center m-4 text-light fw-1"><em >Through:</em></h6>
        <div class=" d-flex justify-content-center">
            
          <div class="img m-2 d-grid text-center bg-light p-2 my-2 rounded shadow">Guidelines<a href="#troubleshootingAccordion"><img class="ms-3" src="../../images/tutor.png"  id="wilks_images" alt=""></a></div>
          <div class="img m-2 d-grid text-center bg-light p-2 my-2 rounded shadow">Videos <a href="#video"><img src="../../images/vid.jpg" id="wilks_images" alt=""></a></div>
          <div class="img m-2 d-grid text-center bg-light p-2 my-2 rounded shadow">It Help Bot <a href="#video"><img class="ms-3"  id="wilks_images" src="../../images/bot.jpg" alt=""></a></div>
        </div>
      </div>
         
    <?php

// session_destroy();

// Connect to database
include '../../php/connect.php';

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get search keywords
    $keywords = $_POST["keywords"];
    
    // Prepare SQL statement
    $sql = "SELECT * FROM knowledge_base WHERE Title LIKE '%" . $keywords . "%' OR Description LIKE '%" . $keywords . "%'";
    $result = $conn->query($sql);
    
    // Display search results
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo '
            <div class="alert alert-light alert-dismissible fade show shadow d-flex justify-content-between m-5" role="alert" >
            
            <div class="card mt-4 " style="display: none; border:none;">
             
            <div class="card-body bg-transparent">
                  <h5 class="card-title">' . $row["Title"] . ' Solution</h5>
                  <p class="card-text">' . $row["Description"] . '</p>
                          
            </div>
            </div>
            <div class="p-2">
             <button type="button" class="close text-danger" " data-bs-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
             </button>
             </div>
                 
            </div>';

            // Trigger the slide animation using jQuery
            echo '<script>
                      $(document).ready(function() {
                          $(".card").slideDown(500);
                      });
                  </script>';
            
            // exit();
        }
    } else {

        echo '
            <div class="alert alert-danger alert-dismissible fade show shadow d-flex justify-content-between " role="alert" style="width:400px; margin:auto;">
            <div class="card mt-2 bg-transparent" style="border:none;"
            <div class="card-body ">
                  <h5 class="card-title"> No results were found!</h5>             
            </div>
            <div class="p-2">
             <button type="button" class="close text-danger" " data-bs-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
             </button>
             </div>
            
            </div>
                 
            </div>';
        // echo ("<SCRIPT LANGUAGE='JavaScript'>
        //         window.alert('No Results Found');
        //         window.location.href='javascript:history.go(1)';
        //         </SCRIPT>");
    }
}

// Close database connection
$conn->close();





?>         
      
      <div class="container">
    <div class="chatbot-icon" id="chatbotIcon">
        <div class="floating-text">Hello <?php echo $_SESSION['username'];?>, talk to me <img src="../../images/chat-icon1.png" width="20" height="auto" alt="log"> </div>
        <img src="../../images/chat2.png" id="ikonic" class="shadow  me-5 mb-5" width="120" height="auto" alt="">
        <span id="span" style="display:none">&times;</span>
    </div>

    <div class="chatbot-container" id="chatbotContainer">
        <div class="chatbot-header d-flex justify-content-between">
            IT Help Chatbot
            
        </div>
        <div class="chatbot-body" id="chatbotBody">
            <div class="chatbot-message chatbot-bot">
                Hi <?php echo $_SESSION['username'];?>! How can I assist you today?
            </div>
        </div>
        <div class="chatbot-footer d-flex">
            <input type="text" class="chatbot-input" id="chatbotInput" placeholder="Type your message here...">
            <button id="sendButton" class="btn btn-primary ms-1"><i class="bi bi-send-fill"></i></button> <!-- Added send button -->
        </div>
    </div>
</div>
  
   <!-- Video tutorial section -->
<div class="mt-4">
  
  <div class="container mt-5">
  <h4 class="text-center" id="video">Video Tutorials</h4>
    <div class="row ">
      <div class="col-lg-4">
        <div class="card shadow">
          <div class="card-body">
            <h5 class="card-title">How to clean a computer</h5>
            <p class="card-text">This video will show you how to safely and effectively clean your computer</p>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#video-modal-1">
              Watch
            </button>
          </div>
        </div>
      </div>
      <div class="col-lg-4">
        <div class="card shadow">
          <div class="card-body">
            <h5 class="card-title">How to restart a computer</h5>
            <p class="card-text">Learn in simple steps how to restart your computer to enhance performance in a safe way</p>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#video-modal-2">
              Watch
            </button>
          </div>
        </div>
      </div>
      <div class="col-lg-4">
        <div class="card shadow">
          <div class="card-body">
            <h5 class="card-title">Keyboard not responding</h5>
            <p class="card-text">Having troubles with your keyboard? don't worry we've got you covered</p>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#video-modal-3">
              Watch
            </button>
          </div>
        </div>
      </div>
         </div>

    <div id="center" >

       
       
        
         <div class="container mt-2 me-4 bg-secondary p-5 rounded shadow">
            <div class="accordion shadow" id="troubleshootingAccordion">
                <!-- Basic Hardware troubleshooting section -->
                <div class="accordion-item">
                    <h2 class="accordion-header" id="hardwareHeader">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#hardwareCollapse" aria-expanded="false" aria-controls="hardwareCollapse">
                       <h5> Basic Hardware troubleshooting</h5>
                    </button>
                    </h2>
                    <div id="hardwareCollapse" class="accordion-collapse collapse" aria-labelledby="hardwareHeader" data-bs-parent="#troubleshootingAccordion">
                        <div class="accordion-body">
                            <!-- Hardware solutions -->
        <p><strong>Problem:</strong> I am unable to turn on my computer.</p>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#hardware-modal">
          View Solution
        </button>
                        </div>
                    </div>
                </div>

                <!-- Basic Software troubleshooting section -->
                <div class="accordion-item">
                    <h2 class="accordion-header" id="softwareHeader">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#softwareCollapse" aria-expanded="false" aria-controls="softwareCollapse">
                            <h5>Basic Software troubleshooting</h5>
                    </button>
                    </h2>
                    <div id="softwareCollapse" class="accordion-collapse collapse" aria-labelledby="softwareHeader" data-bs-parent="#troubleshootingAccordion">
                        <div class="accordion-body">
                        <p><strong>Problem:</strong> My computer is running slow.</p>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#software-modal">
          View Solution
        </button>
                        </div>
                    </div>
                </div>
                <!-- Basic Network troubleshooting section -->
                <div class="accordion-item">
                    <h2 class="accordion-header" id="networkHeader">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#networkCollapse" aria-expanded="false" aria-controls="networkCollapse">
                            <h5>Basic Network troubleshooting</h5>
      </button>
                    </h2>
                    <div id="networkCollapse" class="accordion-collapse collapse shadow" aria-labelledby="networkHeader" data-bs-parent="#troubleshootingAccordion">
                        <div class="accordion-body">
                        <p><strong>Problem:</strong> I can't connect to the internet.</p>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#networks-modal">
          View Solution
        </button>
                        </div>
                    </div>
                </div>
            </div>
    </div>
     
    <div class="container bg-light text-dark rounded fs-6 mt-2 me-5 shadow" >
		<h4 class=" p-2 rounded fs-5">Not found what you are looking for? Try searching for a solution to your Problem</h4>
		<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
			<div class="form-group">
				<label for="keywords">Search Keywords:</label>
				<input type="text" class="form-control" id="keywords" name="keywords" placeholder="Enter keywords">
			</div>
			<button type="submit" class="btn btn-primary m-2">Search</button>
		</form>
        <p class="m-2 p-1 fs-5 fw-4">
            Still having a challenge? <a href="enduser.php">Login a ticket</a>
        </p>
	</div>
     



         </div>
    </div>


     <!-- Modal for solutions -->
     <div class="modal fade" id="hardware-modal" tabindex="-1" role="dialog" aria-labelledby="hardware-modal-label" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="hardware-modal-label">Hardware Solution</h5>
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <!-- Hardware solution content -->
            <p>Here is the solution for hardware-related issues.</p>
          </div>
        </div>
      </div>
    </div>
  
    <div class="modal fade" id="software-modal" tabindex="-1" role="dialog" aria-labelledby="software-modal-label" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="software-modal-label">Software Solution</h5>
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <!-- Software solution content -->
            <p>Here is the solution for software-related issues.</p>
          </div>
        </div>
      </div>
    </div>
  
    <div class="modal fade" id="networks-modal" tabindex="-1" role="dialog" aria-labelledby="networks-modal-label" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="networks-modal-label">Networks Solution</h5>
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <!-- Networks solution content -->
            <p>Here is the solution for network-related issues.</p>
          </div>
        </div>
      </div>
    </div>
  
    
 
    </div>
  </div>
</div>

      
<!-- Modals for videos -->
<div class="modal fade" id="video-modal-1" tabindex="-1" role="dialog" aria-labelledby="video-modal-label-1" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="video-modal-label-1">How To Clean Your Computer</h5>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="embed-responsive embed-responsive-16by9">
          <video class="embed-responsive-item" width="300" height="auto" src="../../images/clean.mp4"  controls></video>
          <!-- <iframe class="embed-responsive-item" src="../../images/clean.mp4" autoplay="false"></iframe> -->
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="video-modal-2" tabindex="-1" role="dialog" aria-labelledby="video-modal-label-2" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="video-modal-label-2">How to restart a computer</h5>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="embed-responsive embed-responsive-16by9">
        <video class="embed-responsive-item" width="300" height="auto" src="../../images/restart.mp4"  controls></video>
          <!-- <iframe class="embed-responsive-item" src="../../images/restart.mp4" autoplay="false"></iframe> -->
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="video-modal-3" tabindex="-1" role="dialog" aria-labelledby="video-modal-label-3" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="video-modal-label-3">Keyboard not responding</h5>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="embed-responsive embed-responsive-16by9">
        <video class="embed-responsive-item" width="300" height="auto" src="../../images/keyboard.mp4"  controls></video>
          <!-- <iframe class="embed-responsive-item" src="../../images/keyboard.mp4" autoplay="false"></iframe> -->
        </div>
      </div>
    </div>
  </div>
</div>


 
    <script src="../../js/bootstrap.bundle.min.js "></script>
    <script src="chatbot-messages.js"></script>
    <script src="quer.js"></script>

</body>

</html>

