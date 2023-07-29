
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="../../css/bootstrap.min.css">
    <link rel="stylesheet" href="../../bootstrap-icons-1.9.1/bootstrap-icons.css">
  <title>Update User</title>
  <style>
    .container{
        width: 500px;
        margin: auto;
        
    }
    fieldset{
        border: 1px solid #000;
        margin-top: 50px;
        padding:20px;
        border-radius: 10px;
        background-color: aliceblue;
        font-size: 1.1vw;
    }
    @media(max-width:768px){
        fieldset{
            font-size: 10px;

        }
        .container{
            width: 350px;
            margin:auto;
        }
    }

    legend{
        text-align:center;
    }
    
    td,input{
        padding:5px;
    }
    body {
    background-image: url("../../Images/call\ cent.jpg");
    background-repeat: no-repeat;
    background-size: cover;
    height: 100vh;
    
}
  </style>
</head>
<body>

<?php

// connect to database
include '../../php/connect.php';

// get user ID from URL parameter
$user_id = $_GET['updateid'];

// get current user data from database
$sql = "SELECT * FROM user WHERE ID=$user_id";
$result = mysqli_query($conn, $sql);



if (mysqli_num_rows($result) > 0) {
  // output data of each row
  $row = mysqli_fetch_assoc($result);
  $username = $row['Username'];
  $password = $row['Password'];
  $email = $row['Email'];
  $firstname = $row['Firstname'];
  $lastname = $row['Lastname'];
  $role = $row['user_type'];
  $department = $row['Dept'];
} else {
  echo "User not found.";
  exit;
}

mysqli_close($conn);

?>

 <div class="container">
 <fieldset>
    <legend><h2>Update User</h2></legend>
    <form action="update_user.php?updateid=<?php echo $user_id; ?>" method="post">
     <table>
        <tr>
            <td><label for="username">Username:</label></td>
            <td><input type="text" name="username" id="username" value="<?php echo $username; ?>"></td>
        </tr>
        <tr>
            <td><label for="password">Password:</label></td>
            <td><input type="password" name="password" id="password" value="<?php echo $password; ?>"></td>
        </tr>
        <tr>
            <td><label for="email">Email:</label></td>
            <td><input type="email" name="email" id="email" value="<?php echo $email; ?>"></td>
        </tr>
        <tr>
            <td><label for="firstname">First Name:</label></td>
            <td><input type="text" name="firstname" id="firstname" value="<?php echo $firstname; ?>"></td>
        </tr>
        <tr>
            <td> <label for="lastname">Last Name:</label></td>
            <td><input type="text" name="lastname" id="lastname" value="<?php echo $lastname; ?>"></td>
        </tr>
        <tr>
            <td><label for="role">Role:</label></td>
            <td><select name="role" id="role">
        <option value="<?php echo $role; ?>"><?php echo $role; ?></option>
        <option value="Administrator">Administrator</option>
        <option value="Technician">Technician</option>
        <option value="End User">End User</option>
        
    </select></td>
        </tr>
        <tr>
            <td><label for="department">Department:</label></td>
            <td><select name="department" id="department">
        <option value="<?php echo $department; ?>"> <?php echo $department; ?></option>
        <option value="Accounts">Accounts</option>
        <option value="Human Resource">Human Resource</option>
        <option value="Marketing">Marketing</option>
        <option value="Operations">Operations</option>
        <option value="Information Technology">Information Technology</option>

    </select></td>
        </tr>
        <tr>
            <td></td>
            <td><input class="btn btn-primary m-2" type="submit" value="Update User">
          or <a class="text-decoration-underline text-primary" href="dashboard.php?id=g"><i class="bi bi-house text-primary "></i> Home</a></td>
        </tr>
     </table> 
    
  </form>
 </fieldset>
  
 </div>

</body>
</html>
