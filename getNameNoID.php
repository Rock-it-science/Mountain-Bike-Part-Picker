<?php
//Get id and options from current build, then use id to get name from part table
$partType = $_REQUEST["pt"];

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

//Get id and options from current build
$result1 = $conn->query("SELECT $partTypeIdString, $partTypeOptionsString FROM $tableString WHERE userId=0;");
$id = 0;
$options = '';
if($row = $result1->fetch_assoc()){
  $id = $row["$partTypeIdString"];
  $options = $row["$partTypeOptionsString"];
}
//Getting name from part table
$result2 = $conn->query("SELECT brand, model FROM $partTypeS WHERE id=$id;");
$info = '';
if($row = $result2->fetch_assoc()){
  $info = $row["brand"] . " ". $row["model"];
}
echo $info . " " . $options;
 ?>
