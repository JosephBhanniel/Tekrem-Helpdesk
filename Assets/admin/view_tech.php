

<div class="container">
    <a href="register2.php" class="btn btn-primary">Add a technician</a>
    <table class="table mt-5 overflow-x-auto" id="table">
        <thead class="bg-dark text-light">
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Email</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Role</th>
                <th>Service</th>
                <th>Department</th>
                <th>Operations</th>
            </tr>
        </thead>
   
    <tbody>

        <?php
       
       include "../../php/connect.php";
       $sql = "SELECT* FROM technician  where user_status = 'Active'";
       $result = mysqli_query($conn,$sql);
       $result = mysqli_query($conn, $sql);
     if (mysqli_num_rows($result) > 0) {
         while ($row = mysqli_fetch_assoc($result)) {
         
             $id=$row['ID'];
             $name=$row['Username'];
             $email=$row['Email'];
             $firstname=$row['Firstname'];
             $lastname=$row['Lastname'];
             $role=$row['user_type'];
             $service=$row['service_type'];
             $dept=$row['Dept'];
             
     
             echo '
             <tr>
           <td>'.$id.'</td>
           <td>'.$name.'</td>
           <td>'.$email.'</td>
           <td>'.$firstname.'</td>
           <td>'.$lastname.'</td>
           <td>'.$role.'</td>
           <td>'.$service.'</td>
           <td>'.$dept.'</td>
           <td>
           <button class = "btn btn-primary m-1"><a href="edit_tech.php?updateid='.$id.'" class="text-light" style="text-decoration:none;">Update</a></button>
           <button  onclick="return confirm(\'Are you sure?\')"  class = "btn btn-danger m-1"><a href="delete.php?delete='.$id.'" class="text-light" style="text-decoration:none;">Delete</a></button>
          </td>
           </tr> ';

         }
     } else {
         echo "No user found.";
     }


        ?>


        
    </tbody>
  </table>
</div>