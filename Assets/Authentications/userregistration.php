<?php

if(isset($_POST['submit'])){
  // Sanitize input data
  $employeeID = filter_input(INPUT_POST, 'employeeID', FILTER_SANITIZE_STRING);
  $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
  $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
  $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
  $firstname = filter_input(INPUT_POST, 'firstname', FILTER_SANITIZE_STRING);
  $lastname = filter_input(INPUT_POST, 'lastname', FILTER_SANITIZE_STRING);
  $jobtitle = filter_input(INPUT_POST, 'jobtitle', FILTER_SANITIZE_STRING);
  $department = filter_input(INPUT_POST, 'Department', FILTER_SANITIZE_STRING);
  $question1 = filter_input(INPUT_POST, 'question1', FILTER_SANITIZE_STRING);
  $answer1 = filter_input(INPUT_POST, 'answer1', FILTER_SANITIZE_STRING);
  $question2 = filter_input(INPUT_POST, 'question2', FILTER_SANITIZE_STRING);
  $answer2 = filter_input(INPUT_POST, 'answer2', FILTER_SANITIZE_STRING);

  // Validate input data
  if (empty($employeeID) || empty($username) || empty($password) || empty($email) || empty($firstname) || empty($lastname) || empty($question1) || empty($answer1) || empty($question2) || empty($answer2) || empty($department) || empty($jobtitle) ) {
    die("All fields are required.");
  }

  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die("Invalid email format.");
  }

  if (!preg_match('/^[a-zA-Z0-9]+$/', $username)) {
    die("Username can only contain letters and numbers.");
  }

  if (strlen($password) < 8) {
    die("Password must be at least 8 characters long.");
  }

  // Hash password
  $hashed_password = password_hash($password, PASSWORD_DEFAULT);

  // Insert user into database
  try {
    $conn = new PDO("mysql:host=localhost;dbname=tek_helpdesk", "root", "");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $conn->prepare("INSERT INTO users (ID, Username, Password, Email, FirstName, LastName, Job_Title, Security_Question1, Security_Answer1, Security_Question2, Security_Answer2, Dept) VALUES (:employeeID, :username, :password, :email, :firstname, :lastname, :jobtitle,:question1, :answer1, :question2, :answer2, :Department)");
    $stmt->bindParam(':employeeID', $employeeID);
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':password', $hashed_password);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':firstname', $firstname);
    $stmt->bindParam(':jobtitle', $jobtitle);
    $stmt->bindParam(':lastname', $lastname);
    $stmt->bindParam(':question1', $question1);
    $stmt->bindParam(':answer1', $answer1);
    $stmt->bindParam(':question2', $question2);
    $stmt->bindParam(':answer2', $answer2);
    $stmt->bindParam(':Department', $department);
    $stmt->execute();

    header('Location: login.php');
   
  } catch(PDOException $e) {
    echo "Registration failed: " . $e->getMessage();
  }

  $conn = null;
}
?>

<!DOCTYPE html>
<html>
<head>
  <link rel="icon" href="../Images/log3.png" type="image/x-icon">
  <link href="../css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="register.css" type="text/css">
  <title>Registration</title>
  <style>
    .container{
        width: 500px;
        margin: auto;
        padding: 5px;
        margin-bottom:300px;
        margin-top:-35px;

        background-color: aliceblue;
        border-radius: 30px;
        font-size:1.05vw;
    }


    form{
        padding:30px;
    }
    h2{
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
    padding-bottom: 40px;
}
@media(max-width:768px){
    .container{
        width: 400px;
        margin:auto;
        font-size: 12px;
    }
    form{
        padding:10px;
    }
}

  </style>

</head>
<body>
  
     <div class="container">
     <form method="post" id="form" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" class="register-form ">
    <h2>Registration Form</h2>
    <table>
      <tr>
        <td> <label for="employeeID">Employee ID</label></td>
        <td><input type="text" name="employeeID" id="employeeID" class="form-control" required></td>
      </tr>
      <tr>
        <td><label for="username">Username</label></td>
        <td><input type="text" name="username" id="username" class="form-control" required></td>
      </tr>

      <tr>
        <td><label for="password">Password</label></td>
        <td><input type="password" name="password" id="password" class="form-control" required></td>
      </tr>

      <tr>
        <td><label for="email">Email</label></td>
        <td><input type="email" name="email" id="email" class="form-control" required></td>
      </tr>
      <tr>
        <td><label for="firstname">First Name</label></td>
        <td><input type="text" name="firstname" id="firstname" class="form-control" required></td>
      </tr>
      <tr>
        <td><label for="lastname">Last Name</label></td>
        <td><input type="text" name="lastname" id="lastname" class="form-control" required></td>
      </tr>
      <tr>
        <td><label for="jobtitle">Job Title</label></td>
        <td><input type="text" name="jobtitle" id="jobtitle" class="form-control" required></td>
      </tr>
      <tr>
        <td><label for="Department">Department</label></td>
        <td><select name="Department" id="Department" class="form-control" required>
    <option value="">Select department</option>
    <option value="Accounts">Accounts</option>
    <option value="Human Resource">Human Resource</option>
    <option value="Marketing">Marketing</option>
    <option value="Adminstration">Adminstration</option>
    <option value="Operations">Operations</option>
    <option value="Infomation Technology">Information Technology</option>
  </select></td>
      </tr>
       
      <tr>
        <td><label for="question1">Security Question 1</label></td>
        <td> <select name="question1" id="question1" class="form-control" required>
    <option value="">Select a security question</option>
    <option value="What is your mother's maiden name?">What is your favorite book?</option>
    <option value="What was the name of your first pet?">What was the name of your first pet?</option>
    <option value="What is your favorite movie?">What is your favorite movie?</option>
  </select></td>
      </tr>
      <tr>
        <td><label for="answer1">Answer 1</label></td>
        <td><input type="text" name="answer1" id="answer1" class="form-control" required></td>
      </tr>
      
      <tr>
        <td><label for="question2">Security Question 2</label></td>
        <td><select name="question2" id="question2" class="form-control" required>
    <option value="">Choose a security question</option>
    <option value="What is your mother's maiden name?">What is your mother's maiden name?</option>
    <option value="What was the name of your first pet?">What was the name of your first pet?</option>
    <option value="What is your favorite movie?">What is your favorite movie?</option>
  </select></td>
      </tr>
      <tr>
        <td><label for="answer2">Answer 2</label></td>
        <td><input type="text" name="answer2" id="answer2" class="form-control" required></td>
      </tr>
      <tr>
        <td></td>
        <td><button type="submit" name="submit" class="btn btn-primary mt-2 me-2">Register</button> OR
        <a href="login.php" class=" fs-5 mt-2 ms-2 p-2">Login Here</a></td>
      </tr>
     

    </table>
</form>
     </div>
</body>

<script>
// Get the form element and add an event listener for submission
const form = document.querySelector('form');
form.addEventListener('submit', (event) => {
// Prevent the default form submission behavior

// Submit the form data using AJAX or fetch API

// Redirect to the same page after submission
window.location.href = window.location.href;

// Display an alert message to the user
alert('Successfully registered!');

});

</script>
</html>