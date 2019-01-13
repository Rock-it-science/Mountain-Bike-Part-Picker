<?php
//Add part to database from given data and create a new page for it

//Getting variables from URL
$brand = $_REQUEST["brand"];
$model = $_REQUEST["model"];
$year = $_REQUEST["year"];
$material = $_REQUEST["material"];
$frameSize = $_REQUEST["frameSize"];
$wheelSize = $_REQUEST["wheelSize"];
$sus = $_REQUEST["sus"];
$manufLink = $_REQUEST["manuf"];
$imgLink = $_REQUEST["img"];

//SQL setup
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mtbpp";
$conn = new mysqli($servername, $username, $password, $dbname);
if($conn->connect_error){
  die("Connection failed: ". $conn->connect_error);
}

//Get highest id from frames table (highest id equals number of rows)
$result1 = $conn->query("SELECT id FROM frames;");
$id = mysqli_num_rows($result1)+1;//Add one since id of new part will be the largest id already in table + 1
echo $id;
//Converting arrays to strings (keeping specific format for sql table)
$materialString = "";
for($i=0; $i<sizeof($material); $i++){
  $materialString .= $material[$i];
}

$frameSizeString = $frameSize[0];
for($i=1; $i<sizeof($frameSize); $i++){
  $frameSizeString .= " " . $frameSize[$i];
}

$wheelSizeString = $wheelSize[0];
for($i=1; $i<sizeof($wheelSize); $i++){
  $wheelSizeString .= " " . $wheelSize[$i];
}

//Put new frame into SQL table
$result2 = $conn->query("INSERT INTO frames VALUES (" . $id . ", \"" . $brand . "\", \"" . $model . "\", " . $year . ", \"" . $materialString . "\", \"" . $frameSizeString . "\", \"" . $wheelSizeString . "\", \"" . $manufLink . "\", \"" . $imgLink . "\", " . $sus . ");");
if(!$result2){failure();}
else{success();}

function success(){
  header('Location: /submit_success.html');
}

function failure(){
  echo "Something went wrong";
}
 ?>
