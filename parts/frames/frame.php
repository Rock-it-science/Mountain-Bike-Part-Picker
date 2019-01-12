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
<p id="frameID" style="display: none;">
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
  <h1><a id="frame name" href="
 <?php //Getting manuLink from frames table using id
  $result = $conn->query("SELECT * FROM frames WHERE id=" . $id . ";");
  $row = $result->fetch_assoc();
  $manuf = $row["manufLink"];
  echo $manuf;
 ?>
    ">
    <?php   //Getting frame brand and model name from frames table using id
    $result = $conn->query("SELECT * FROM frames WHERE id=" . $id . ";");
    $row = $result->fetch_assoc();
    $brand = $row["brand"];
    $model = $row["model"];
    echo $brand . " " . $model;
     ?>
  </a></h1>
  <img src="
<?php  //Getting imgLink from frames table using id
  $result = $conn->query("SELECT * FROM frames WHERE id=" . $id . ";");
  $row = $result->fetch_assoc();
  $img = $row["imgLink"];
  echo $img;
 ?>
  " width="500"/>
</div>

<div align="center">
  Frame size:
  <div class="dropdown">
  <button onclick="frameDrop()" class="dropbtn"><a id="f_dropdown-text">Select Frame Size  &#9660;</a></button>
    <div id="f_Dropdown" class="dropdown-content">
      <?php //Get frame sizes from frames table
        $result = $conn->query("SELECT * FROM frames WHERE id=" . $id . ";");
        $row = $result->fetch_assoc();
        $sizesString = $row["frameSizes"];
        $sizes = explode(" ", $sizesString); //Explode sizesString into an array of available sizes)
        for($i=0; $i<sizeof($sizes); $i++){//For every item in sizes, add an opiton in the drop-down for it
          echo "<a onclick=\"frameSize(&quot;" . $sizes[$i] . "&quot;)\">" . $sizes[$i] . "</a>";
        }
       ?>
    </div>
  </div>

  <div class="dropdown">
  <button onclick="wheelDrop()" class="dropbtn"><a id="s_dropdown-text">Select Wheel Size  &#9660;</a></button>
    <div id="s_Dropdown" class="dropdown-content">
      <?php //Get compatible wheel sizes from frames table
        $result = $conn->query("SELECT * FROM frames WHERE id=" . $id . ";");
        $row = $result->fetch_assoc();
        $wsizesString = $row["wheelSizes"];
        $wsizes = explode(" ", $wsizesString); //Explode sizesString into an array of available sizes)
        for($i=0; $i<sizeof($wsizes); $i++){//For every item in sizes, add an opiton in the drop-down for it
          echo "<a onclick=\"wheelSize(" . $wsizes[$i] . ")\"> " . $wsizes[$i] . "</a>";
        }
      ?>
    </div>
  </div>

  <div class="dropdown">
  <button onclick="materialDrop()" class="dropbtn"><a id="m_dropdown-text">Select Material  &#9660;</a></button>
    <div id="m_Dropdown" class="dropdown-content">
      <a onclick="aluminum()">Aluminum</a>
      <a onclick="carbon()">Carbon</a>
    </div>
  </div>

  <p id="price" style="display: none;">Price: $3000</p>
  <div>
    <button id="addButton" onclick="add()" style="display: none;">Add to list</button>
  </div>
</div>

<!-- <script type="text/javascript" src="../../compatibility.js"></script> -->

<script>

//configurable variables
var frameName = document.getElementById("frame name").innerHTML;
var aPrice = 2500;
var cPrice = 3500;
var price = 0;

//TODO Add more dropdowns for colour, etc
//TODO Add pictures for items
//TODO Add price management from different websites

  //Back button
  function back(){
    window.location.href="../../index.html";
  }

  //frame size dropdown
  function frameDrop() {
      document.getElementById("f_Dropdown").classList.toggle("show");
  }
  function wheelDrop(){
      document.getElementById("s_Dropdown").classList.toggle("show");
  }
  function materialDrop(){
      document.getElementById("m_Dropdown").classList.toggle("show");
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

    //if all selections are made, show add to list button
    if((frameSizeSelection != null) && (wheelSizeSelection != null) && (materialSelection != null)){
      document.getElementById("addButton").style.display = "block";
  }
}

//dropdown selection functions
var frameSizeSelection, wheelSizeSelection, materialSelection;
function frameSize(size){
  document.getElementById("f_dropdown-text").innerHTML = size;
  frameSizeSelection = size;
}

function wheelSize(size){
  document.getElementById("s_dropdown-text").innerHTML = String(size);
  wheelSizeSelection = String(size);
}

function material(m){
  if(m == "A"){aluminum();}
  else if(m == "C"){carbon();}
  else if(m == "S"){steel();}
}
function aluminum(){
  document.getElementById("m_dropdown-text").innerHTML = "Aluminum";
  materialSelection = "aluminum";
  //set and show price
  price = aPrice;
  document.getElementById("price").innerHTML = "Price: $"+price;
  document.getElementById("price").style.display = "block";
}
function carbon(){
  document.getElementById("m_dropdown-text").innerHTML = "Carbon";
  materialSelection = "carbon";
  //set and show price
  price = cPrice
  document.getElementById("price").innerHTML = "Price: $"+price;
  document.getElementById("price").style.display = "block";
}
function steel(){
  document.getElementById("m_dropdown-text").innerHTML = "Steel";
  materialSelection = "steel";
  //set and show price
  price = cPrice; //TODO update this after implemeting pricing
  document.getElementById("price").innerHTML = "Price: $"+price;
  document.getElementById("price").style.display = "block";
}

function add(){
  isFrame(function(b){//Callback function to be executed after isframe
    var isf = b;
    if(!isf){ //if there is no frame in currentBuild, then add this one
      console.log("adding frame");
      addRequest = new XMLHttpRequest();
      addRequest.onreadystatechange = function() {
         if (addRequest.status == 200) {
           console.log(addRequest.responseText);
           //addRequest.abort();
           window.location.href="../../index.html";
         }
       };
       addRequest.open("GET","addFrameToBuild.php?frameId="+document.getElementById("frameID").innerHTML+"&size="+frameSizeSelection+"&material="+materialSelection+"&wheelsize="+wheelSizeSelection+"&price="+price,true);
       addRequest.send();
    }
    //if there is a frame selected
    else{
      window.alert("You already have a frame selected!");
    }
  });
}

//Check if frame is in currentBuild
async function isFrame(callback){
  var isframeRequest = new XMLHttpRequest();
  let framePromise = new Promise((resolve, reject) => {
    isframeRequest.onreadystatechange = function check(){
      //console.log("isframeRequest status = " + isframeRequest.status);
      if(isframeRequest.readyState == 4 && isframeRequest.status == 200){
        if(isframeRequest.responseText != ""){
          //Frame is selected
          console.log(isframeRequest.responseText);
          resolve(true);
        }
        else{
          //Frame not selected
          console.log("no frame selected");
          resolve(false);
        }
      }
    };
  });
  isframeRequest.open("GET", "../../php/isPart.php?pt=frame", true);
  isframeRequest.send();
  let b = await framePromise;
  console.log(b);
  callback(b);
}

</script>

</body>
</html>
