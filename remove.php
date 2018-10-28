<?php
$partType = $_REQUEST["pt"];

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mtbpp";

$conn = new mysqli($servername, $username, $password, $dbname);

if($conn->connect_error){
  die("Connection failed: ". $conn->connect_error);
}

//Strings
$partTypeIdString = $partType . "Id";
$partTypeOptionsString = $partType . "Options";
$partTypePriceString = $partType . "Price";
$tableString = $partType . "Build";

//Checking if frame partType exists in buildFrame table
$result = $conn->query("UPDATE $tableString SET $partTypeIdString='', $partTypeOptionsString='', $partTypePriceString='' WHERE userId = 0;");
echo $result;
 ?>
