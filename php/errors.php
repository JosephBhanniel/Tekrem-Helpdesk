<?php
include '../php/connect.php';
session_start();

// Check if the login form is submitted
if (isset($_POST['submit'])) {
 

    // Get the username and password from the form
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Validate input fields
    if (empty($username) || empty($password)) {
        $_SESSION['login_error'] = "Please enter both username and password.";
        header("Location: ../Assets/login.php");
        exit();
    }

    // Prepare SQL statement to select user from database
    $sql = "SELECT * FROM Users WHERE Username='$username'";
    $result = mysqli_query($conn, $sql);
    $resultCheck = mysqli_num_rows($result);

    // Check if the user exists in the database
    if ($resultCheck < 1) {
        $_SESSION['login_error'] = "Username or password is incorrect.";
        header("Location: ../Assets/login.php");
        exit();
    } else {
        // Get the user data from the database
        if ($row = mysqli_fetch_assoc($result)) {
            // Verify the password
            $hashedPwdCheck = password_verify($password, $row['Password']);
            if ($hashedPwdCheck == false) {
                $_SESSION['login_error'] = "Username or password is incorrect.";
                header("Location: ../Assets/login.php");
                exit();
            } elseif ($hashedPwdCheck == true) {
                // Log in the user
                $_SESSION['user_id'] = $row['ID'];
                $_SESSION['username'] = $row['Username'];
                $_SESSION['role'] = $row['Role'];

                // Redirect the user to the appropriate page based on their role
                if ($row['Role'] == 'Admin') {
                    header("Location: ../Assets/dashboard.php");
                    exit();
                } elseif ($row['Role'] == 'Technician') {
                    header("Location: ../Assets/itagent.php");
                    exit();
                } elseif ($row['Role'] == 'user') {
                    header("Location:../Assets/enduser.php");
                    exit();
                }
            }
        }
    }

    // Close database connection
    mysqli_close($conn);
} else {
    header("Location: ../Assets/login.php");
    exit();
}
?>