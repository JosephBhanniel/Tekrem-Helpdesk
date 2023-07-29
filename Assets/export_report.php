<?php
session_start();
if (!isset($_SESSION['ID'])) {
  header('HTTP/1.0 403 Forbidden');
  exit;
}

$conn = mysqli_connect('localhost', 'root', '', 'tek_helpdesk');
if (!$conn) {
  die('Connection failed: ' . mysqli_connect_error());
}

$sql = "SELECT * FROM Reports WHERE TechnicianID = " . $_SESSION['ID'];
$result = mysqli_query($conn, $sql);

$data = array();
while ($row = mysqli_fetch_assoc($result)) {
  $data[] = $row;
}

mysqli_close($conn);

header('Content-Type: application/json');
echo json_encode($data);
?>
