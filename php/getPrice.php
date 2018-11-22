<?php

//Echo price from currentBuild
$partType = $_REQUEST["pt"];
$partTypePriceString = $partType . "Price";
$tableString = $partType . "Build";

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mtbpp";

$conn = new mysqli($servername, $username, $password, $dbname);

if($conn->connect_error){
  die("Connection failed: ". $conn->connect_error);
}

$price = $conn->query("SELECT $partTypePriceString FROM $tableString WHERE userId=0;");
if($row = $price->fetch_assoc()){
  echo $row["$partTypePriceString"];
}
 ?>
