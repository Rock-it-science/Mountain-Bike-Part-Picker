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
$tableString = $partType . "Build";
$partTypeS = $partType . "s";

$result1 = $conn->query("SELECT $partTypeIdString, $partTypeOptionsString FROM $tableString WHERE userId=0;");
if($row = $result1->fetch_assoc()){
  $id = $row["$partTypeIdString"];
  $options = $row["$partTypeOptionsString"];
}

$result2 = $conn->query("SELECT brand, model FROM $partTypeS WHERE id=$id;");
$frameInfo = '';
if($row = $result2->fetch_assoc()){
  $frameInfo = $row["brand"] . " ". $row["model"];
}
echo $frameInfo . " " . $options;
 ?>
