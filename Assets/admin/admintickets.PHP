<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Dashboard</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">

                        <div class="dropdown me-2">
                            <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="dropdown">Filter</button>
                            <ul class="dropdown-menu">
                                <li class="dropdown-item"><a href="#">Open Tickets</a></li>
                                <li class="dropdown-item"><a href="#">Open Tickets</a></li>
                            </ul>
                        </div>
                        <div>
                            <form action="#" class="form d-flex">
                                <input style="padding:3px; border-radius:4px; border:1px solid grey; margin-right:-3px;" type="search" name="search" id="searchid" placeholder="Ticket # or Dept">
                                <input class="btn btn-sm btn-primary" type="submit" value="Search">

                            </form>
                        </div>
                    </div>
                </div>


                <h2>Tickets</h2>
                <div class="table-responsive">
                    <table class="table table-striped table-sm">
                        <thead class="bg-dark text-light">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Title</th>
                                <th scope="col">Dept</th>
                                <th scope="col">Category</th>
                                <th scope="col">Description</th>
                                <th scope="col">Priority</th>
                                <th scope="col">Creator ID</th>
                                <th scope="col">Assigned To</th>
                                <th scope="col">Status</th>
                                <th scope="col">Date created</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
// Establish database connection
include '../php/connect.php';
// Check if search query is set
if(isset($_GET['search']) && !empty($_GET['search'])){
  $search_query = $_GET['search'];
  $sql = "SELECT * FROM Tickets WHERE ID LIKE '%$search_query%' OR Dept LIKE '%$search_query%'";
} else {
  // Prepare SQL statement to select all tickets
  $sql = "SELECT * FROM Tickets";
}

// Check if filter dates are set
if(isset($_GET['start_date']) && !empty($_GET['start_date']) && isset($_GET['end_date']) && !empty($_GET['end_date'])){
  $start_date = date('Y-m-d', strtotime($_GET['start_date']));
  $end_date = date('Y-m-d', strtotime($_GET['end_date']));
  $sql .= " WHERE DateCreated BETWEEN '$start_date' AND '$end_date'";
}

// Execute SQL statement and fetch results
$result = mysqli_query($conn, $sql);

// Check if there are any results
if (mysqli_num_rows($result) > 0) {

  // Display table rows
  while($row = mysqli_fetch_assoc($result)) {
    if($row['Status']== NULL){
        $status = "Open";
    }else{
        $status = $row['Status'];
    }
   
    echo "<tr>
            <td>".$row['ID']."</td>
            <td>".$row['Title']."</td>
            <td>".$row['Dept']."</td>
            <td>".$row['Category']."</td>
            <td>".$row['Description']."</td>
            <td>".$row['Priority']."</td>
            <td>".$row['CreatorID']."</td>
            <td>".$row['AssignedToID']."</td>
            <td>".$status."</td>
            <td>".$row['DateCreated']."</td>
          </tr>";
  }

  // Close table
  echo "</table>";
} else {
  echo "No tickets found.";
}

// Close database connection
mysqli_close($conn);
?>




                        </tbody>
                    </table>
                </div>
            </main>
