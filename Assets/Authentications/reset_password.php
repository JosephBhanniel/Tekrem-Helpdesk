<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="../css/bootstrap.min.css" rel="stylesheet">
  <title>Password Reset</title>
</head>
<body>
<?php
// Start the session
session_start();

// Include database configuration file
include '../../php/connect.php';

$id = $_POST["id"];
// Define variables and initialize with empty values
$reset_token = $new_password = $confirm_password = "";
$new_password_err = $confirm_password_err = $id_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
  if (empty(trim($_POST["id"]))) {
    $id_err = "Please enter your id.";
  }

  // Validate reset token
  if (empty(trim($_POST["reset_token"]))) {
    $reset_token_err = "Please enter a reset token.";
  } else {
    // Prepare a select statement to determine the table
    $sql = "SELECT id FROM technician WHERE id = ? AND reset_token = ?";

    if ($stmt = mysqli_prepare($conn, $sql)) {
      // Bind variables to the prepared statement as parameters
      mysqli_stmt_bind_param($stmt, "is", $param_id, $param_reset_token);

      // Set parameters
      $param_id = intval(trim($_POST["id"]));
      $param_reset_token = trim($_POST["reset_token"]);

      // Attempt to execute the prepared statement
      if (mysqli_stmt_execute($stmt)) {
        /* store result */
        mysqli_stmt_store_result($stmt);

        if (mysqli_stmt_num_rows($stmt) == 0) {
          $reset_token_err = "Invalid reset token.";
        } else {
          $reset_token = trim($_POST["reset_token"]);
        }
      } else {
        echo "Oops! Something went wrong. Please try again later.";
      }

      // Close statement
      mysqli_stmt_close($stmt);
    }

    // If reset token validation fails, check in admin table
    if (empty($reset_token) && $id_err == "") {
      $sql = "SELECT id FROM admin WHERE id = ? AND reset_token = ?";

      if ($stmt = mysqli_prepare($conn, $sql)) {
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "is", $param_id, $param_reset_token);

        // Set parameters
        $param_id = intval(trim($_POST["id"]));
        $param_reset_token = trim($_POST["reset_token"]);

        // Attempt to execute the prepared statement
        if (mysqli_stmt_execute($stmt)) {
          /* store result */
          mysqli_stmt_store_result($stmt);

          if (mysqli_stmt_num_rows($stmt) == 0) {
            $reset_token_err = "Invalid reset token.";
          } else {
            $reset_token = trim($_POST["reset_token"]);
          }
        } else {
          echo "Oops! Something went wrong. Please try again later.";
        }

        // Close statement
        mysqli_stmt_close($stmt);
      }
    }

    // If reset token validation fails, check in users table
    if (empty($reset_token) && $id_err == "") {
      $sql = "SELECT id FROM user WHERE id = ? AND reset_token = ?";

      if ($stmt = mysqli_prepare($conn, $sql)) {
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "is", $param_id, $param_reset_token);

        // Set parameters
        $param_id = intval(trim($_POST["id"]));
        $param_reset_token = trim($_POST["reset_token"]);

        // Attempt to execute the prepared statement
        if (mysqli_stmt_execute($stmt)) {
          /* store result */
          mysqli_stmt_store_result($stmt);

          if (mysqli_stmt_num_rows($stmt) == 0) {
            $reset_token_err = "Invalid reset token.";
          } else {
            $reset_token = trim($_POST["reset_token"]);
          }
        } else {
          echo "Oops! Something went wrong. Please try again later.";
        }

        // Close statement
        mysqli_stmt_close($stmt);
      }
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
    $table_name = "";
    if (!empty($reset_token) && $id_err == "") {
      $table_name = "technician";
    } elseif (!empty($reset_token) && $id_err == "") {
      $table_name = "admin";
    } elseif (!empty($reset_token) && $id_err == "") {
      $table_name = "users";
    }

    if (!empty($table_name)) {
      // Prepare an update statement
      $sql = "UPDATE $table_name SET password = ?, reset_token = '' WHERE id = ?";

      if ($stmt = mysqli_prepare($conn, $sql)) {
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "si", $param_password, $param_id);

        // Set parameters
        $param_password = password_hash($new_password, PASSWORD_DEFAULT); // Creates a password hash
        $param_id = intval(trim($_POST["id"]));

        // Attempt to execute the prepared statement
        if (mysqli_stmt_execute($stmt)) {
          // Display success message on the page
          echo "<div class='card mx-auto' style='width: 500px;'>
                  <div class='card-body'>
                    <h4 class='card-title text-center'>Your password has been reset successfully</h4>
                    <p class='card-text text-center'>Here is your new reset token. Keep it secret and safe!</p>
                    <div class='container text-center'>
                      <h4 class='alert bg-secondary text-light'>$reset_token2</h4>
                      <br>
                      <em><a href='login.php'>You can now login to your account</a></emp>
                    </div>
                  </div>
                </div>";
          $reset_token2 = rand(100000, 999999);
          // Prepare an update statement
          $sql = "UPDATE $table_name SET reset_token = '$reset_token2' WHERE id = '$id'";
          $result = mysqli_query($conn, $sql);
        } else {
          echo "Oops! Something went wrong. Please try again later.";
        }

        // Close statement
        mysqli_stmt_close($stmt);
      }
    } else {
      echo "Invalid ID or reset token.";
    }
  }

  // Close connection
  mysqli_close($conn);
}
?>
  
</body>
</html>
