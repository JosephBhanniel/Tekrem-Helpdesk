
<?php
    // Initialize variables
    $error_message = "";
    $success_message = "";

    // Check if user is already logged in, redirect to home page
    if(isset($_SESSION['username'])){
      header("Location: login.php");
      exit;
    }

    // Check if form is submitted
 

      // Sanitize input data
      $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_STRING);
      $security_question_1 = filter_input(INPUT_POST, 'security_question_1', FILTER_SANITIZE_STRING);
      $security_answer_1 = filter_input(INPUT_POST, 'security_answer_1', FILTER_SANITIZE_STRING);
      $security_question_2 = filter_input(INPUT_POST, 'security_question_2', FILTER_SANITIZE_STRING);
      $security_answer_2 = filter_input(INPUT_POST, 'security_answer_2', FILTER_SANITIZE_STRING);
      $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
      $confirm_password = filter_input(INPUT_POST, 'confirm_password', FILTER_SANITIZE_STRING);

      // Validate input data
      if(empty($id) || empty($security_question_1) || empty($security_answer_1) || empty($security_question_2) || empty($security_answer_2) || empty($password) || empty($confirm_password)){
        $error_message = "All fields are required.";
      } else if($password !== $confirm_password){
        $error_message = "Password and confirm password do not match.";
      } else {
        // Check if security questions and answers are correct
        try {
          $conn = new PDO("mysql:host=localhost;dbname=it_ticketing_system", "root", "");
          $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

          $stmt = $conn->prepare("SELECT * FROM users WHERE ID=:id AND security_question_1=:security_question_1 AND security_answer_1=:security_answer_1 AND security_question_2=:security_question_2 AND security_answer_2=:security_answer_2");
          $stmt->bindParam(':id', $id);
          $stmt->bindParam(':security_question_1', $security_question_1);
          $stmt->bindParam(':security_answer_1', $security_answer_1);
          $stmt->bindParam(':security_question_2', $security_question_2);
          $stmt->bindParam(':security_answer_2', $security_answer_2);
          $stmt->execute();

          $user = $stmt->fetch(PDO::FETCH_ASSOC);

          if(!$user){
            $error_message = "Invalid security questions or answers.";
          } else {
            // Hash password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Update user's password
            $stmt = $conn->prepare("UPDATE users SET password=:password WHERE ID=:id");
            $stmt->bindParam(':password', $hashed_password);
            $stmt->bindParam(':id', $id);
            $stmt->execute();

            $success_message = "Password updated successfully. You can now <a href='login.php'>login</a> with your new password.";
          }
        } catch(PDOException $e) {
          $error_message = "Error: " . $e->getMessage();
        }

        $conn = null;
      }
    
?>