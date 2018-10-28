<?php
/*
- This script moves id of frame and frame options to frameBuild
*/

echo("addToBuild started");

//TODO update when userId system is implemented
$userId = 0;

//TODO make a function that does all these automatically
$frameId = $_REQUEST["frameId"];
$price = $_REQUEST["price"];
$size = $_REQUEST["size"];
$material = $_REQUEST["material"];
$wheelsize = $_REQUEST["wheelsize"];

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mtbpp";

$conn = new mysqli($servername, $username, $password, $dbname);

if($conn->connect_error){
  die("Connection failed: " . $conn->connect_error);
}
//Frame options string
$options = $size . " " . $material . " " . $wheelsize;

//Adding part to frameBuild table
//If there is already a row for this userId, append to it rather than trying to add a new line
$checkRow = $conn->query("SELECT * FROM frameBuild WHERE userId=0;");

//Adding to frameBuild table, TODO make this dependant on userId
$result = $conn->query("UPDATE frameBuild SET frameId=$frameId, frameOptions='$options', framePrice=$price WHERE userId=0;");

//Worry about userId stuff later
/*if($checkRow->fetch_assoc()){
  $result = $conn->query("UPDATE frameBuild SET frameId=$frameId, frameOptions='$options' WHERE userId=0;");
}
else{
  $result = $conn->query("INSERT INTO frameBuild VALUES ($userId, $frameId, '$options');");
}
*/
echo($result);

$conn->close();

//frameBuild columns: userId, frameId, frameOptions, framePrice
//frames columns: id, brand, model;
?>
