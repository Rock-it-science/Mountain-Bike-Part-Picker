<?php
//Use partType variable passed from call to get the id of that item from currentBuild,
// and then get information from the frames table about that partid
$partType = $_REQUEST["pt"];

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mtbpp";

$conn = new mysqli($servername, $username, $password, $dbname);

if($conn->connect_error){
  die("Connection failed: ". $conn->connect_error);
}
$partTypeIdString = $partType . "Id";
$partTypeOptionsString = $partType . "Options";
$result1 = $conn->query("SELECT $partTypeIdString, $partTypeOptionsString FROM currentBuild WHERE userId=0;");
if($result1->num_rows > 0){
  $id = $row["$partTypeIdString"];
  $options = $row["$partTypeOptionsString"];
}

$result2 = $conn->query("SELECT brand, model FROM frames WHERE id=$id;");
$frameInfo = '';
if($row = $result2->fetch_assoc()){
  $frameInfo = $row["brand"] . " ". $row["model"];
}
echo $frameInfo . " " . $options;
 ?>
