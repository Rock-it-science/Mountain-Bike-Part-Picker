<?php
//Use id passed from call to get information from the frames table about that partid
$partType = $_REQUEST["pt"];
$id = $_REQUEST["id"];

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mtbpp";

$conn = new mysqli($servername, $username, $password, $dbname);

if($conn->connect_error){
  die("Connection failed: ". $conn->connect_error);
}
//Setting up variables
$partTypeIdString = $partType . "Id";
$partTypeOptionsString = $partType . "Options";
$tableString = $partType . "Build";
$partTypeS = $partType . "s";

//Getting name from part table
$result2 = $conn->query("SELECT brand, model FROM $partTypeS WHERE id=$id;");
$frameInfo = '';
if($row = $result2->fetch_assoc()){
  $frameInfo = $row["brand"] . " ". $row["model"];
}
echo $frameInfo . " " . $options;
 ?>
