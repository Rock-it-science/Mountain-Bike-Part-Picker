<?php
//Add part to database from given data and create a new page for it

//Getting variables from URL
$brand = $_REQUEST["brand"];
$model = $_REQUEST["model"];
$year = $_REQUEST["year"];

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
$rows = $result1->fetch_assoc();
$id = sizeof($rows)+1;//Add one since id of new part will be the largest id already in table + 1

//Put new frame into SQL table
$result2 = $conn->query("INSERT INTO frames VALUES (" . $id . ", \"" . $brand . "\", \"" . $model . "\", " . $year . ");");
if($result2 != ""){failure();}

//Template for new frame page
$templateText = file_get_contents("../parts/frames/frameTemplate.html");

//Create new page from frame template
$newPage = fopen("../parts/frames/" . $brand . $model . ".html", "w") or die(failure());
fwrite($newPage, $templateText);
fclose($newPage);

success();

function success(){
  header('Location: /submit_success.html');
}

function failure(){
  echo "Something went wrong";
}
 ?>
