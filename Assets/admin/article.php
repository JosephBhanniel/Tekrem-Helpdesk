
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../bootstrap-icons-1.9.1/bootstrap-icons.css">
    <link href="../../css/bootstrap.min.css" rel="stylesheet">
    <title>Edit Article</title>
    <style>

        .container{
            margin-top: 60px;
            padding: 20px;
        }
     @media(max-width:767px){
        .container{
            font-size:10px;
            margin-right: 40px;
        }


     }
    </style>
</head>
<body>

 <div class="navbar bg-dark p-2">
    <a href="dashboard.php?id=a" class="ms-2 p-2 text-light text-decoration-none a-hover">
        <i class="bi bi-speedometer"></i>
        Dashboard
    </a>
 </div>
    

  <div class="container" >
    
<?php
include '../../php/connect.php';
// Check if the form has been submitted for updating or deleting a record
if (isset($_POST['submit'])) {
  // Connect to the database
 

  
  // Get the ID of the record to update or delete
  $id = $_GET['id'];

  if ($_POST['submit'] == 'Update') {
    // Get the new values for the record
    $title = $_POST['title'];
    $description = $_POST['description'];

    // Update the record in the database
    $sql = "UPDATE knowledge_base SET Title='$title', Description='$description' WHERE ID=$id";

    if (mysqli_query($conn, $sql)) {
      echo "<div class='alert alert-success'>Record updated successfully</div>";
    } else {
      echo "<div class='alert alert-danger'>Error updating record: " . mysqli_error($conn) . "</div>";
    }
  } elseif ($_POST['submit'] == 'Delete') {
    // Delete the record from the database
    $sql = "DELETE FROM knowledge_base WHERE ID=$id";

    if (mysqli_query($conn, $sql)) {
      echo "<div class='alert alert-success'>Record deleted successfully</div>";
    } else {
      echo "<div class='alert alert-danger'>Error deleting record: " . mysqli_error($conn) . "</div>";
    }
  }

}


$sql = "SELECT * FROM knowledge_base";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
  echo "<table class='table table-hover shadow' >";
  echo "<thead class = 'bg-dark text-light'>";
  echo "<tr>";
  echo "<th>ID</th>";
  echo "<th>Title</th>";
  echo "<th>Description</th>";
  echo "<th>Date_Created</th>";
  echo "<th>Date_Updated</th>";
  echo "<th>Creator</th>";
  echo "<th>Actions</th>";
  echo "<th></th>";
  echo "</tr>";
  echo "</thead>";
  echo "<tbody>";

  while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>";
    echo "<td>" . $row['ID'] . "</td>";
    echo "<td>" . $row['Title'] . "</td>";
    echo "<td>" . $row['Description'] . "</td>";
    echo "<td>" . $row['Date_Created'] . "</td>";
    echo "<td>" . $row['Date_Updated'] . "</td>";
    echo "<td>" . $row['Created_By'] . "</td>";
    echo "<td>";
    echo "<button type='button' class='btn btn-primary p-2 mt-1 me-1' data-bs-toggle='modal' data-bs-target='#editModal" . $row['ID'] . "'>Edit</button>";
   
    echo "</td>";
    echo "<td>";
   
    echo "<button type='button' class='btn btn-danger p-2  mt-1' data-bs-toggle='modal' data-bs-target='#deleteModal" . $row['ID'] . "'>Delete</button>";
    echo "</td>";
    echo "</tr>";

    // Edit Modal
    echo "<div class='modal fade' id='editModal" . $row['ID'] . "' tabindex='-1' role='dialog' aria-labelledby='editModalLabel' aria-hidden
    : 'true'>";
    echo "<div class='modal-dialog' role='document'>";
    echo "<div class='modal-content'>";
    echo "<div class='modal-header'>";
    echo "<h5 class='modal-title' id='editModalLabel'>Edit Record</h5>";
    echo "<button type='button' class='close text-danger' data-bs-dismiss='modal' aria-label='Close'>";
    echo "<span aria-hidden='true'>×</span>";
    echo "</button>";
    echo "</div>";
    echo "<div class='modal-body'>";
    echo "<form method='POST' action=''>";
    echo "<div class='form-group'>";
    echo "<label for='title'>Title</label>";
    echo "<input type='text' class='form-control' name='title' value='" . $row['Title'] . "'>";
    echo "</div>";
    echo "<div class='form-group'>";
    echo "<label for='description'>Description</label>";
    echo "<textarea class='form-control' name='description'>" . $row['Description'] . "</textarea>";
    echo "</div>";
    echo "<input type='hidden' name='id' value='" . $row['ID'] . "'>";
    echo "<input type='submit' class='btn btn-primary mt-2' name='submit' value='Update'>";
    echo "</form>";
    echo "</div>";
    echo "</div>";
    echo "</div>";
    echo "</div>";
    // Delete Modal
echo "<div class='modal fade' id='deleteModal" . $row['ID'] . "' tabindex='-1' role='dialog' aria-labelledby='deleteModalLabel' aria-hidden='true'>";
echo "<div class='modal-dialog' role='document'>";
echo "<div class='modal-content'>";
echo "<div class='modal-header'>";
echo "<h5 class='modal-title' id='deleteModalLabel'>Delete Record</h5>";
echo "<button type='button' class='close text-danger' data-bs-dismiss='modal' aria-label='Close'>";
echo "<span aria-hidden='true'>&times;</span>";
echo "</button>";
echo "</div>";
echo "<div class='modal-body'>";
echo "<p>Are you sure you want to delete this record?</p>";
echo "</div>";
echo "<div class='modal-footer'>";
echo "<form method='POST' action=''>";
echo "<input type='hidden' name='id' value='" . $row['ID'] . "'>";
echo "<button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cancel</button>";
echo "<input type='submit' class='btn btn-danger' name='submit' value='Delete'>";
echo "</form>";
echo "</div>";
echo "</div>";
echo "</div>";
echo "</div>";
}

echo "</tbody>";
echo "</table>";
} else {
echo "<div class='alert alert-info'>No records found</div>";
}

// Close the database connection
mysqli_close($conn);
?>
  </div>
 <script src="../../js/bootstrap.bundle.min.js"></script>
</body>
</html>