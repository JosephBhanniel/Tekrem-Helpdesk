
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <link href="../../css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" href="../../Images/log3.png" type="image/x-icon">
  <title>Reset Password</title>
  <style>
    .container{
      width: 500px;
      margin: auto;
      margin-top: 50px;
      background-color:aliceblue;
      padding: 20px;
      border-radius: 20px;
    }
  
    body {
    background-image: url("../../Images/call\ cent.jpg");
    background-repeat: no-repeat;
    background-size: cover;
    height: 100vh;
    display: flex;
    align-items: center;
    padding-top: 40px;
    padding-bottom: 40px;
}
span{
  color:red;
}

@media(max-width:768px){
  .container{
    width:400px;
    margin:auto;
    font-size: 14px;
  }
}

  </style>
</head>
<body>
<?php
// Start the session
session_start();

// Include database configuration file
include '../../php/connect.php';

$id = "";
// Define variables and initialize with empty values
$reset_token = $new_password = $confirm_password = "";
$new_password_err = $confirm_password_err = $id_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $id = $_POST["id"];
  if (empty(trim($_POST["id"]))) {
    $id_err = "Please enter your id.";
  }

  // Validate reset token
  if (empty(trim($_POST["reset_token"]))) {
    $reset_token_err = "Please enter a reset token.";
  } else {
    // Prepare a select statement to determine the table
    $sql = "SELECT ID, reset_token, 'technician' AS table_name FROM technician WHERE ID = ? AND reset_token = ?
            UNION ALL
            SELECT ID, reset_token, 'admin' AS table_name FROM admin WHERE ID = ? AND reset_token = ?
            UNION ALL
            SELECT ID, reset_token, 'user' AS table_name FROM user WHERE ID = ? AND reset_token = ?";

    if ($stmt = mysqli_prepare($conn, $sql)) {
      // Bind variables to the prepared statement as parameters
      mysqli_stmt_bind_param($stmt, "isisis", $param_id1, $param_reset_token1, $param_id2, $param_reset_token2, $param_id3, $param_reset_token3);

      // Set parameters
      $param_id1 = $param_id2 = $param_id3 = intval(trim($_POST["id"]));
      $param_reset_token1 = $param_reset_token2 = $param_reset_token3 = trim($_POST["reset_token"]);

      // Attempt to execute the prepared statement
      if (mysqli_stmt_execute($stmt)) {
        /* store result */
        mysqli_stmt_store_result($stmt);

        if (mysqli_stmt_num_rows($stmt) == 0) {
          $reset_token_err = "Invalid reset token.";
        } else {
          mysqli_stmt_bind_result($stmt, $id_db, $reset_token_db, $table_name);
          mysqli_stmt_fetch($stmt);

          $reset_token = trim($_POST["reset_token"]);
        }
      } else {
        echo "Oops! Something went wrong. Please try again later.";
      }

      // Close statement
      mysqli_stmt_close($stmt);
    }
  }

  // Validate new password
  if (empty(trim($_POST["new_password"]))) {
    $new_password_err = "Please enter a new password.";
  } elseif (strlen(trim($_POST["new_password"])) < 6) {
    $new_password_err = "Password must have at least 6 characters.";
  } else {
    $new_password = trim($_POST["new_password"]);
  }

  // Validate confirm password
  if (empty(trim($_POST["confirm_password"]))) {
    $confirm_password_err = "Please confirm password.";
  } else {
    $confirm_password = trim($_POST["confirm_password"]);
    if (empty($new_password_err) && ($new_password != $confirm_password)) {
      $confirm_password_err = "Password did not match.";
    }
  }

  // Check input errors before updating the password
  if (empty($reset_token_err) && empty($new_password_err) && empty($confirm_password_err)) {

    // Determine the table based on the provided id and reset token
    switch ($table_name) {
      case 'technician':
        $table = 'technician';
        break;
      case 'admin':
        $table = 'admin';
        break;
      case 'user':
        $table = 'user';
        break;
      default:
        echo "Invalid ID or reset token.";
        exit();
    }

    // Prepare an update statement
    $sql = "UPDATE $table SET password = ?, reset_token = '' WHERE id = ?";

    if ($stmt = mysqli_prepare($conn, $sql)) {
      // Bind variables to the prepared statement as parameters
      mysqli_stmt_bind_param($stmt, "si", $param_password, $param_id);

      // Set parameters
      $param_password = password_hash($new_password, PASSWORD_DEFAULT); // Creates a password hash
      $param_id = intval(trim($_POST["id"]));

      // Attempt to execute the prepared statement
      if (mysqli_stmt_execute($stmt)) {
        $reset_token2 = rand(100000, 999999);
        // Display success message on the page
        echo '<div class="container bg-transparent">
                    <div class="card shadow">
                    <div class="card-body">
                        <h4 class="card-title text-center">Password Successfully Reset!</h4>
                        <p class="card-text text-center">
                        Here is your new reset token. Please keep it safe and secure:
                        </p>
                        <p class="alert alert-info p-2 text-center">
                        ' . $reset_token . '
                        </p>
                        <p class="card-text text-center">
                        <a class="btn btn-dark" href="login.php">Login</a>.
                        </p>
                    </div>
                    </div>
                    </div>
                    ';
       
        // Prepare an update statement
        $sql = "UPDATE $table SET reset_token = '$reset_token2' WHERE id = '$id'";
        $result = mysqli_query($conn, $sql);
        exit();
      } else {
        echo "Oops! Something went wrong. Please try again later.";
      }

      // Close statement
      mysqli_stmt_close($stmt);
    }
  }

  // Close connection
  mysqli_close($conn);
}
?>

      <div class="container">
        <fieldset>
          <legend><h2 class="text-center">Reset Password</h2></legend>
          

  <form action="forgpass.php" method="post">
  
      <table>
        <tr>
          <td><label>Employee ID:</label></td>
          <td><input type="text"  class="form-control m-1"  name="id" value="" required>
          <?php if (!empty($id_err)) echo "<span>" . $id_err . "</span>"; ?>
        </td>
          
        </tr>
        <tr>
          <td><label>Reset Token:</label></td>
          <td><input type="text" class="form-control m-1"  name="reset_token" value="" required>
          <?php if (!empty($reset_token_err)) echo "<span>" . $reset_token_err . "</span>"; ?>
        </td>
          
        </tr>

        <tr>
          <td><label>New Password:</label></td>
          <td><input type="password" class="form-control m-1" name="new_password" value="" required>
          <?php if (!empty($new_password_err)) echo "<span>" . $new_password_err . "</span>"; ?></td>
         
        </tr>
        <tr>
          <td><label>Confirm Password:</label></td>
          <td><input type="password" class="form-control m-1"  name="confirm_password" value="" required>
          <?php if (!empty($confirm_password_err)) echo "<span>" . $confirm_password_err . "</span>"; ?>
        </td>
         
        </tr>
      </table>

    <div class="text-center m-2">
      <input class="btn btn-dark text-light mb-2" type="submit" value="Reset Password"> <br> or  <a href="login.php" class="mt-4"> Login </a>
    </div>

  </form>
        </fieldset>
      </div>

</body>
</html>
