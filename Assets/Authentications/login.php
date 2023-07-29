<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/bootstrap.min.css">
    <link rel="icon" href="../../Images/log3.png" type="image/x-icon">
    <link rel="stylesheet" href="login.css">
    <script src="../../jquery/jquery-3.6.1.min.js"></script>
    <style>
      h4{
        width: 1200px;
        margin: auto;
        margin-top: -150px;
       
      }
    </style>
    <title>Login</title>
</head>

<body>
  


<?php

include '../../php/connect.php';
session_start();

$idError = "";
$passwordError = "";
$Error = "";

if (isset($_POST['submit'])) {
  // Get form inputs
  $employeeid = mysqli_real_escape_string($conn, $_POST["ID"]);
  $password = mysqli_real_escape_string($conn, $_POST["password"]);

  // Validate inputs
  if (empty($employeeid)) {
    $idError = "<span class='text-danger'>Please enter the employee ID.</span>";
  } else if (!is_numeric($employeeid) || strlen($employeeid) <= 2) {
    $idError = "<span class='text-danger'>Invalid employee ID format.";
  }

  if (empty($password)) {
    $passwordError = "<span class='text-danger'>Please enter the password.</span>";
  } else if (strlen($password) < 8) {
    $passwordError = "<span class='text-danger'>Invalid Password.</span>";
  }

  if (empty($idError) && empty($passwordError)) {
    // Query database for user
    $userQuery = "SELECT * FROM user WHERE ID = '$employeeid'";
    $userResult = mysqli_query($conn, $userQuery);

    // Query database for admin
    $adminQuery = "SELECT * FROM admin WHERE ID = '$employeeid'";
    $adminResult = mysqli_query($conn, $adminQuery);

    // Query database for technician
    $technicianQuery = "SELECT * FROM technician WHERE ID = '$employeeid'";
    $technicianResult = mysqli_query($conn, $technicianQuery);

    if (mysqli_num_rows($userResult) == 1) {
      $row = mysqli_fetch_assoc($userResult);
      $hash = $row['Password'];

      if (password_verify($password, $hash)) {
        if ($row["user_status"] == "Active") {
          $_SESSION["ID"] = $employeeid;
          $_SESSION["Role"] = "End User";
          $_SESSION["firstname"] = $row['Firstname'];
          $_SESSION["username"] = $row['Username'];
          $_SESSION["lastname"] = $row['Lastname'];
          header("Location: ../user/enduser.php");
          exit;
        }
      }
    } elseif (mysqli_num_rows($adminResult) == 1) {
      $row = mysqli_fetch_assoc($adminResult);
      $hash = $row['Password'];

      if (password_verify($password, $hash)) {
        $_SESSION["ID"] = $employeeid;
        $_SESSION["username"] = $row['Username'];
        $_SESSION["Role"] = "Administrator";
        header("Location: ../admin/dashboard.php?id=dashboard&&id7=Dashboard");
        exit;
      }
    } elseif (mysqli_num_rows($technicianResult) == 1) {
      $row = mysqli_fetch_assoc($technicianResult);
      $hash = $row['Password'];

      if (password_verify($password, $hash)) {
        if ($row["user_status"] == "Active") {
          $_SESSION["ID"] = $employeeid;
          $_SESSION["firstname"] = $row['Firstname'];
          $_SESSION["lastname"] = $row['Lastname'];
          $_SESSION["username"] = $row['Username'];
          $_SESSION["service_type"] = $row['service_type'];
          $_SESSION["Role"] = "Technician";
          header("Location: ../technician/itagent.php?id=dash");
          exit;
        }
      }
    }

    // Invalid employee ID or password
    $Error = "<span class='text-danger'>Invalid employee ID or password.</span>";
  }

  // Redirect after form submission
  header("Location: ".$_SERVER['PHP_SELF']."?er=".urlencode($Error)."&er1=".urlencode($idError)."&er2=".urlencode($passwordError));

  exit;
}
?>

    <div class="container shadow">
      
        <main class="form-signin w-100 m-auto">
         
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                <fieldset>
                   
                    <a href="../index.php"><img class="mb-4" src="../../Images/log3.png" alt="" width="72" height="57" id="logo"></a>
                    
                    <h1 class="h3 mb-3 fw-normal">Login </h1>
                    <?php if(isset($_GET['er'])){
                      echo $_GET['er'];
                    }?>

                    <div class="form-floating ">
                        <input type="text" name="ID" class="form-control" id="floatingInput" placeholder="Username">
                        <label for="floatingInput"  style="text-align: left;">Employee ID</label>
                        <?php if(isset($_GET['er1'])){
                      echo $_GET['er1'];
                    }?>
                    </div>
                    <div class="form-floating ">
                        <input type="password"  name="password" class="form-control" id="floatingPassword" placeholder="Password">
                        <label for="floatingPassword"  style="text-align: left;">Password</label>
                        <?php if(isset($_GET['er2'])){
                      echo $_GET['er2'];
                    }?>
                    </div>


                    <button class="w-100 btn btn-lg btn-dark" type="submit" name="submit">Submit</button> <br> <br>
                    <p>
                        <a href="forgpass.php" class="text-warning text-bold fs-6">Forgot Password </a>
                        <p> Do not have an account?
                        <a href="registration.php" class="text-dark fs-6 m-2">Sign up</a> or go back <a class=" fs-6 m-2" href="../index.php">Home</a></p>
                    </p>
                    


                </fieldset>
            </form>
        </main>
    </div>




    <script src="../js/bootstrap.bundle.js"></script>
</body>

</html>