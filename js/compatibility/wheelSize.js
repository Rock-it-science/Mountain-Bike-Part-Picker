async function wheelSizeCompat(){

  //Gets wheelsize selections for frame and fork from server using async
  // AJAX calls, then calls back to check if they are compatible or not.

  var frameWS;
  var forkWS;

  getFrameOptions(function(a){
    console.log(a);
    frameWS = a;
  }).then(getForkOptions(function(b){
    console.log(b);
    forkWS = b;
    console.log("later "+ frameWS);
    if(frameWS == forkWS){
      console.log("compatible");
      document.getElementById("frameCompat").innerHTML = "Compatible with fork";
      document.getElementById("forkCompat").innerHTML = "Compatible with frame";
    }
    else{
      console.log("not compatible");
      document.getElementById("frameCompat").innerHTML = "NOT compatible with fork";
      document.getElementById("forkCompat").innerHTML = "NOT compatible with frame";
    }
  }));

  //Get wheelsize from frame and fork options
  async function getFrameOptions(callback){
    var frameRequest = new XMLHttpRequest();
    let framePromise = new Promise((resolve, reject) => {
      frameRequest.onreadystatechange = function check(){
        //console.log("frameRequest status = " + isframeRequest.status);
        if(frameRequest.readyState == 4 && frameRequest.status == 200){
          var ws = frameRequest.responseText.split(" ")[2];
          //console.log(ws);
          resolve(ws)
        }
      };
    });
    frameRequest.open("GET", "php/getOptionsFromPT.php?pt=frame", true);
    frameRequest.send();
    let ws = await framePromise;
    callback(ws);
  }

  async function getForkOptions(callback){
    var forkRequest = new XMLHttpRequest();
    let forkPromise = new Promise((resolve, reject) => {
      forkRequest.onreadystatechange = function check(){
        //console.log("forkRequest status = " + isforkRequest.status);
        if(forkRequest.readyState == 4 && forkRequest.status == 200){
          var ws = forkRequest.responseText.replace(' ','');
          //console.log(ws);
          resolve(ws);
        }
      };
    });
    forkRequest.open("GET", "php/getOptionsFromPT.php?pt=fork", true);
    forkRequest.send();
    let ws = await forkPromise;
    callback(ws);
  }
}
