
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <link href="../../css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" href="../../Images/log3.png" type="image/x-icon">
  <title>Registration Form</title>
  <style>
    .container{
      width:500px;
      margin:auto;
      display:grid;
      justify-content:space-around;
      padding:15px;
      font-size:14px;
      background-color:aliceblue;
      border-radius:30px;
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
td{
  padding: 3px;
}

@media(max-width:768px){
  .container{
    width:400px;
    margin:auto;
    font-size: 13px;
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

// Define variables and initialize with empty values
$firstname = $lastname = $job_title = $email = $department = $username = $password = $confirm_password = $id = "";
$firstname_err = $lastname_err = $job_title_err = $email_err = $department_err = $id_err = $username_err = $password_err = $confirm_password_err = "";

// Define variable for reset token
$reset_token = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validate ID
    if (empty(trim($_POST["ID"]))) {
        $id_err = "Please enter your employee ID.";
    } elseif (!is_numeric($_POST["ID"]) || strlen($_POST["ID"]) <= 2) {
        $id_err  = "Enter a valid Employee ID format";
    } elseif (strlen(trim($_POST["ID"])) > 10) {
        $id_err = "Employee ID must not exceed 10 characters.";
    }else {
        // Prepare a select statement
        $sql = "SELECT id FROM user WHERE id = ?";

        if ($stmt = mysqli_prepare($conn, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "i", $param_username);

            // Set parameters
            $param_username = trim($_POST["ID"]);

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                /* store result */
                mysqli_stmt_store_result($stmt);

                if (mysqli_stmt_num_rows($stmt) == 1) {
                    $id_err = "This ID already exist.";
                } else {
                    $id = trim($_POST["ID"]);
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    } 




    // Validate firstname
    if (empty(trim($_POST["first_name"]))) {
        $firstname_err = "Please enter your first name.";
    } elseif (strlen(trim($_POST["first_name"])) > 50) {
        $firstname_err = "First name must not exceed 50 characters.";
    } else {
        $firstname = trim($_POST["first_name"]);
    }

    // Validate lastname
    if (empty(trim($_POST["last_name"]))) {
        $lastname_err = "Please enter your last name.";
    } elseif (strlen(trim($_POST["last_name"])) > 50) {
        $lastname_err = "Last name must not exceed 50 characters.";
    } else {
        $lastname = trim($_POST["last_name"]);
    }

    // Validate job title
    if (empty(trim($_POST["job_title"]))) {
        $job_title_err = "Please enter your job title.";
    } elseif (strlen(trim($_POST["job_title"])) > 100) {
        $job_title_err = "Job title must not exceed 100 characters.";
    } else {
        $job_title = trim($_POST["job_title"]);
    }

    // Validate email
    if (empty(trim($_POST["email"]))) {
        $email_err = "Please enter your email address.";
    } elseif (strlen(trim($_POST["email"])) > 100) {
        $email_err = "Email address must not exceed 100 characters.";
    } else {
        // Prepare a select statement
        $sql = "SELECT ID FROM user WHERE email = ?";

        if ($stmt = mysqli_prepare($conn, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_email);

            // Set parameters
            $param_email = trim($_POST["email"]);

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                /* store result */
                mysqli_stmt_store_result($stmt);

                if (mysqli_stmt_num_rows($stmt) == 1) {
                    $email_err = "This email address is already registered.";
                } else {
                    $email = trim($_POST["email"]);
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }

    // Validate department
    if (empty(trim($_POST["department"]))) {
        $department_err = "Please enter your department.";
    } elseif (strlen(trim($_POST["department"])) > 100) {
        $department_err = "Department must not exceed 100 characters.";
    } else {
        $department = trim($_POST["department"]);
    }

    // Validate username
    if (empty(trim($_POST["username"]))) {
        $username_err = "Please enter a username.";
    } elseif (strlen(trim($_POST["username"])) > 50) {
        $username_err = "Username must not exceed 50 characters.";
    } else {
        // Prepare a select statement
        $sql = "SELECT id FROM user WHERE username = ?";

        if ($stmt = mysqli_prepare($conn, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);

            // Set parameters
            $param_username = trim($_POST["username"]);

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                /* store result */
                mysqli_stmt_store_result($stmt);

                if (mysqli_stmt_num_rows($stmt) == 1) {
                    $username_err = "This username is already taken.";
                } else {
                    $username = trim($_POST["username"]);
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }

    // Validate password
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter a password.";
    } elseif (strlen(trim($_POST["password"])) < 8) {
        $password_err = "Password must have at least 8 characters.";
    } else {
        $password = trim($_POST["password"]);
    }

    // Validate confirm password
    if (empty(trim($_POST["confirm_password"]))) {
        $confirm_password_err = "Please confirm password.";
    } else {
        $confirm_password = trim($_POST["confirm_password"]);
        if (empty($password_err) && ($password != $confirm_password)) {
            $confirm_password_err = "Password did not match.";
        }
    }

    // Check input errors before inserting in database
    if (empty($id_err) && empty($firstname_err) && empty($lastname_err) && empty($job_title_err) && empty($email_err) && empty($department_err) && empty($username_err) && empty($password_err) && empty($confirm_password_err)) {
        // Generate reset token
        $reset_token = rand(100000, 999999);

        // Prepare an insert statement
        $sql = "INSERT INTO user (ID, Firstname, Lastname, Job_title, email, Dept, Username, password, reset_token) VALUES (?,?, ?, ?, ?, ?, ?, ?, ?)";

        if ($stmt = mysqli_prepare($conn, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sssssssss", $param_id, $param_firstname, $param_lastname, $param_job_title, $param_email, $param_department, $param_username, $param_password, $param_reset_token);

            // Set parameters
            $param_id = $id;
            $param_firstname = $firstname;
            $param_firstname = $firstname;
            $param_lastname = $lastname;
            $param_job_title = $job_title;
            $param_email = $email;
            $param_department = $department;
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            $param_reset_token = $reset_token;

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // // Redirect to login page
                // header("location: login.php");

                // // Display reset token on the page
                // echo "Your reset token is: " . $reset_token;
                echo '<div class="container bg-transparent">
                    <div class="card shadow">
                    <div class="card-body">
                        <h4 class="card-title text-center">Successfully Registered!</h4>
                        <p class="card-text text-center">
                        Here is your reset token in case you forget your pin code. Please keep it safe and secure:
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
                exit();
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }

    // // Close connection
    // mysqli_close($conn);
}
?>


<!-- REGISTRATION FORM -->
<div class="container">
    <h2 class="text-center p-2">Register</h2>
    <form class="form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <table>
            <tr>
                <td><label>Employee ID</label></td>
                <td>
                    <div class="form-group">
                        <input type="text" name="ID" class="form-control col-md-3" rows="1" placeholder="e.g 100214" value="<?php echo isset($_POST['ID']) ? $_POST['ID'] : ''; ?>" required>
                        <span class="text-danger"><?php echo isset($id_err) ? $id_err : ''; ?></span>
                    </div>
                </td>
            </tr>
            <tr>
                <td><label>First Name</label></td>
                <td>
                    <div class="form-group">
                        <input type="text" name="first_name" class="form-control col-md-3" rows="1" placeholder="e.g James" value="<?php echo isset($_POST['first_name']) ? $_POST['first_name'] : ''; ?>" required>
                        <span class="text-danger"><?php echo isset($first_name_err) ? $first_name_err : ''; ?></span>
                    </div>
                </td>
            </tr>
            <tr>
                <td><label>Last Name</label></td>
                <td>
                    <div class="form-group">
                        <input type="text" name="last_name" class="form-control col-md-3" rows="1" placeholder="e.g Muyelu" value="<?php echo isset($_POST['last_name']) ? $_POST['last_name'] : ''; ?>" required>
                        <span class="text-danger"><?php echo isset($last_name_err) ? $last_name_err : ''; ?></span>
                    </div>
                </td>
            </tr>
            <tr>
                <td><label>Job Title</label></td>
                <td>
                    <div class="form-group">
                        <input type="text" name="job_title" class="form-control col-md-3" rows="1" placeholder="e.g Supervisor" value="<?php echo isset($_POST['job_title']) ? $_POST['job_title'] : ''; ?>" required>
                        <span class="text-danger"><?php echo isset($job_title_err) ? $job_title_err : ''; ?></span>
                    </div>
                </td>
            </tr>
            <tr>
                <td><label>Email</label></td>
                <td>
                    <div class="form-group">
                        <input type="email" name="email" class="form-control col-md-3" rows="1" placeholder="e.g james@tekrem.com" value="<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?>" required>
                        <span class="text-danger"><?php echo isset($email_err) ? $email_err : ''; ?></span>
                    </div>
                </td>
            </tr>
            <tr>
                <td><label>Department</label></td>
                <td>
                    <div class="form-group">
                        <select type="text" name="department" class="form-control col-md-3" rows="1" value="<?php echo isset($_POST['department']) ? $_POST['department'] : ''; ?>" required>
                            <option value="">Select department</option>
                            <option value="Accounting">Accounting</option>
                            <option value="Human Resource">Human Resource</option>
                            <option value="Marketing">Marketing</option>
                            <option value="Operations">Operations</option>
                            <option value="Information Technology">Information Technology</option>
                        </select>
                        <span class="text-danger"><?php echo isset($department_err) ? $department_err : ''; ?></span>
                    </div>
                </td>
            </tr>
            <tr>
                <td><label>Username</label></td>
                <td>
                    <div class="form-group">
                        <input type="text" name="username" class="form-control col-md-3" rows="1" placeholder="e.g Jmuyelu" value="<?php echo isset($_POST['username']) ? $_POST['username'] : ''; ?>" required>
                        <span class="text-danger"><?php echo isset($username_err) ? $username_err : ''; ?></span>
                    </div>
                </td>
            </tr>
            <tr>
                <td><label>Password</label></td>
                <td>
                    <div class="form-group">
                        <input type="password" name="password" class="form-control col-md-3" rows="1" required>
                        <span class="text-danger"><?php echo isset($password_err) ? $password_err : ''; ?></span>
                    </div>
                </td>
            </tr>
            <tr>
                <td><label>Confirm Password</label></td>
                <td>
                    <div class="form-group">
                        <input type="password" class="form-control col-md-3" rows="1" name="confirm_password" required>
                        <span class="text-danger"><?php echo isset($confirm_password_err) ? $confirm_password_err : ''; ?></span>
                    </div>
                </td>
            </tr>
        </table>
        <div class="form-group text-center">
            <input class="btn btn-dark mt-1 me-2" type="submit" value="Submit">
        </div>
    </form>

    <div class="text-center">
        <p class="mt-2">
            Already have an account? <a class="m-2" href="login.php">Login</a>
        </p>
    </div>
</div>

</body>
</html>



 
