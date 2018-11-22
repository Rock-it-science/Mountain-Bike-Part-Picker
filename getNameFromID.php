<?php
//Use id passed from call to get frome name
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
$info = '';
if($row = $result2->fetch_assoc()){
  $info = $row["brand"] . " ". $row["model"];
}
echo $info;
 ?>
