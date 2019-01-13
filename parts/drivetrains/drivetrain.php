<!DOCTYPE html>
<meta charset="utf-8"/>
<html>
<style>
/* Dropdown Button */
.dropbtn {
    border: none;
    padding: 4px;
    cursor: pointer;
}

/* Dropdown button on hover & focus */
.dropbtn:hover, .dropbtn:focus {
  cursor: pointer;
}

/* The container <div> - needed to position the dropdown content */
.dropdown {
    position: relative;
    display: inline-block;
}

/* Dropdown Content (Hidden by Default) */
.dropdown-content {
    display: none;
    position: absolute;
    background-color: white;
    min-width: 160px;
    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
    z-index: 1;
}

/* Links inside the dropdown */
.dropdown-content a {
    display: block;
}

/* Change color of dropdown links on hover */
.dropdown-content a:hover {background-color: #eaeaea}

/* Show the dropdown menu (use JS to add this class to the .dropdown-content container when the user clicks on the dropdown button) */
.show {display:block;}
</style>
<body>

<!--Extra invisible p to pass id to js through DOM, also set up SQL connection stuff here too-->
<p id="drivetrainID" style="display: none;">
 <?php
  //Connection stuff
  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "mtbpp";
  $conn = new mysqli($servername, $username, $password, $dbname);
  if($conn->connect_error){
    die("Connection failed: ". $conn->connect_error);
  }

  //Get ID then echo it
  $id = $_REQUEST["id"];
  echo $id;
 ?>
</p>

<div align="right">
  <button id="back" onclick="back()">Back to build</button>
</div>

<div align="center">
  <h1><a id="drivetrain name" href="
 <?php //Getting manuLink from drivetrains table using id
  $result = $conn->query("SELECT * FROM drivetrains WHERE id=" . $id . ";");
  $row = $result->fetch_assoc();
  $manuf = $row["manufLink"];
  echo $manuf;
 ?>
    ">
    <?php   //Getting drivetrain brand and model name from drivetrains table using id
    $brand = $row["brand"];
    $model = $row["model"];
    echo $brand . " " . $model;
     ?>
  </a></h1>
  <img src="
<?php  //Getting imgLink from drivetrains table using id
  $img = $row["imgLink"];
  echo $img;
 ?>
  " width="500"/>
</div>

<div align="center">
  <p id="price"></p>
  <div>
    <button id="addButton" onclick="add()">Add to list</button>
  </div>
</div>


<script>
var price = 545;
setPrice();

//configurable variables
var drivetrainName = document.getElementById("drivetrain name").innerHTML;

//Show price
function setPrice(){
  document.getElementById("price").innerHTML = "Price: " + price;
}

  //Back button
  function back(){
    window.location.href="../../index.html";
  }

  window.onclick = function(event) {
    // Close the dropdown if the user clicks outside of it
    if (!event.target.matches('.dropbtn')) {
      var dropdowns = document.getElementsByClassName("dropdown-content");
      var i;
      for (i = 0; i < dropdowns.length; i++) {
        var openDropdown = dropdowns[i];
        if (openDropdown.classList.contains('show')) {
          openDropdown.classList.remove('show');
        }
      }
    }
}

function add(){
  isDrivetrain(function(b){//Callback function to be executed after isdrivetrain
    var isf = b;
    if(!isf){ //if there is no drivetrain in currentBuild, then add this one
      console.log("adding drivetrain");
      addRequest = new XMLHttpRequest();
      addRequest.onreadystatechange = function() {
         if (addRequest.status == 200) {
           console.log(addRequest.responseText);
           //addRequest.abort();
           window.location.href="../../index.html";
         }
       };
       addRequest.open("GET","addDrivetrainToBuild.php?drivetrainId="+document.getElementById("drivetrainID").innerHTML+"&price="+price,true);
       addRequest.send();
    }
    //if there is a drivetrain selected
    else{
      window.alert("You already have a drivetrain selected!");
    }
  });
}

//Check if drivetrain is in currentBuild
async function isDrivetrain(callback){
  var isdrivetrainRequest = new XMLHttpRequest();
  let drivetrainPromise = new Promise((resolve, reject) => {
    isdrivetrainRequest.onreadystatechange = function check(){
      //console.log("isdrivetrainRequest status = " + isdrivetrainRequest.status);
      if(isdrivetrainRequest.readyState == 4 && isdrivetrainRequest.status == 200){
        if(isdrivetrainRequest.responseText != ""){
          //Drivetrain is selected
          console.log(isdrivetrainRequest.responseText);
          resolve(true);
        }
        else{
          //Drivetrain not selected
          console.log("no drivetrain selected");
          resolve(false);
        }
      }
    };
  });
  isdrivetrainRequest.open("GET", "../../php/isPart.php?pt=drivetrain", true);
  isdrivetrainRequest.send();
  let b = await drivetrainPromise;
  console.log(b);
  callback(b);
}

</script>

</body>
</html>
