<!DOCTYPE html>
<html>
<head>
  <title>Forgot Password</title>
  <link rel="icon" href="../Images/log3.png" type="image/x-icon">
  <link href="../css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="register.css" type="text/css">
  <style>
    .container{
        width: 800px;
        margin: auto;
        padding: 10px;

        background-color: aliceblue;
        border-radius: 30px;
    }
    fieldset{
        padding:20px;
    }
    input{
        border-radius:5px;
        border:1px solid #000;
    }
    td{
        padding: 8px;
    }
    legend{
        text-align:center;
    }
    body {
    background-image: url("../Images/call\ cent.jpg");
    background-repeat: no-repeat;
    background-size: cover;
    height: 100vh;
    display: grid;
    align-items: center;
    padding-top: 40px;
    padding-bottom: 40px;}

    @media(max-width:768px){
    .container{
        width: 400px;
        margin:auto;
        font-size: 12px;
    }
    
}


  </style>
</head>
<body>
  

  <?php
    include '../php/connect.php';
// check if form is submitted
if(isset($_POST['reset'])) {
  // retrieve form data
  // retrieve form data and sanitize input
$id = mysqli_real_escape_string($conn, $_POST['id']);
$security_question_1 = mysqli_real_escape_string($conn, $_POST['security_question_1']);
$security_answer_1 = mysqli_real_escape_string($conn, $_POST['security_answer_1']);
$security_question_2 = mysqli_real_escape_string($conn, $_POST['security_question_2']);
$security_answer_2 = mysqli_real_escape_string($conn, $_POST['security_answer_2']);
$password = mysqli_real_escape_string($conn, $_POST['password']);
$confirm_password = mysqli_real_escape_string($conn, $_POST['confirm_password']);

  // check if passwords match
  if($password != $confirm_password) {
      
      echo "<h4 class='alert text-center bg-light text-danger m-5'>Passwords do not match.<a href='Reset_questions.php'>Try Again</a></h4> ";
      exit();
  }

  // // check if user exists and security questions are correct
  $sql = "SELECT * FROM users WHERE ID='$id' and  Security_Question1 = '$security_question1'";

  $result = mysqli_query($conn, $sql);
  $row = mysqli_fetch_assoc($result);
  if(mysqli_num_rows($result) != 1) {
    echo "<h4 class='alert text-center bg-light text-danger m-5'>Wrong Details Provided.<a href='Reset_questions.php'>Try Again</a></h4> ";
     
      exit();
  }

  // update password
  $hashed_password = password_hash($password, PASSWORD_DEFAULT);
  $sql = "UPDATE users SET Password='$hashed_password' WHERE ID='$id'";
  if(mysqli_query($conn, $sql)) {
      echo "<h4 class='alert text-center bg-light m-5'>Password Reset Successful!<a href='login.php'>Login</a></h4>
       
      ";
      exit();
  } else {
      echo "Error updating password: " . mysqli_error($conn);
  }

  // close connection
  mysqli_close($conn);
}
?>

   
      

      <div class="container">
      <fieldset>
                    <legend><h1>Reset Password</h1></legend>
        
      <form method="post" id="form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                        
                
      <table>
                       <tr>
                        <td><label for="id">Employee ID:</label></td>
                        <td> <input type="text" id="id" name="id" required></td>
                       </tr>
                       <tr>
                        <td><label for="security_question_1">Security Question 1:</label></td>
                        <td><select id="security_question_1" name="security_question_1" required>
                <option value="">Select a security question</option>
                <option value="What is your mother's maiden name?">What is your favorite book?</option>
                <option value="What was the name of your first pet?">What was the name of your first pet?</option>
                <option value="What is your favorite movie?">What is your favorite movie?</option>
                </select></td>
                       </tr>
                       <tr>
                        <td><label for="security_answer_1">Security Answer 1:</label></td>
                        <td><input type="text" id="security_answer_1" name="security_answer_1" required></td>
                       </tr>
                       <tr>
                        <td><label for="security_question_2">Security Question 2:</label></td>
                        <td><select id="security_question_2" name="security_question_2" required>
                <option value="">Select a security question</option>
                <option value="What is your mother's maiden name?">What is your favorite book?</option>
                <option value="What was the name of your first pet?">What was the name of your first pet?</option>
                <option value="What is your favorite movie?">What is your favorite movie?</option>
                </select></td>
                       </tr>
                       <tr>
                        <td><label for="security_answer_2">Security Answer 2:</label></td>
                        <td><input type="text" id="security_answer_2" name="security_answer_2" required></td>
                       </tr>
                       <tr>
                        <td><label for="password">New Password:</label></td>
                        <td><input type="password" id="password" name="password" required></td>
                       </tr>
                       <tr>
                        <td><label for="confirm_password">Confirm New Password:</label></td>
                        <td><input type="password" id="confirm_password" name="confirm_password" required></td>
                       </tr>
                       <tr>
                        <td></td>
                        <td><input  class="btn btn-primary" type="submit" name="reset" value="Reset Password">
                         or <a href="login.php">Login</a></td>
                       </tr>

                    </table>
                </form>
                </fieldset>
      </div>


</body>



</html>