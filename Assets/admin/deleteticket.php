<?php
if(isset($_POST['delete'])) {
    // connect to the database
    $db = new mysqli('localhost', 'root', '', 'tek_helpdesk');
    
    // prepare the SQL query to delete from tickets table
    $delete_tickets_query = "DELETE FROM tickets WHERE ID='$id'";
    // execute the query
    $delete_tickets_result = $db->query($delete_tickets_query);
    
    // prepare the SQL query to delete from reports table
    $delete_reports_query = "DELETE FROM reports WHERE TicketID='$id'";
    // execute the query
    $delete_reports_result = $db->query($delete_reports_query);
    
    // check if both queries were successful
    if ($delete_tickets_result && $delete_reports_result) {
    // echo "Ticket deleted successfully";
    header("Location: dashboard.php?id=b");
    } else {
    echo "Error deleting ticket: " . $db->error;
    }
    
    // close the database connection
    $db->close();
}    



?>