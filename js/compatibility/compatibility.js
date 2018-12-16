import * as module from './wheelsize.js';

export async function compat(){
  
  //If a frame and a fork are currently selected, then run wheelSizeCompat
  var isFrame;
  var isFork;

  //Pipelining tasks: check for frame, then check for fork, then check if they both returned true
  checkFrame();

  async function checkFrame(){
    isPart("frame", function(a){
      console.log(a);
      isFrame = a;
      checkFork();
    });
  }

  async function checkFork(){
    isPart("fork", function(b){
      console.log(b);
      isFork = b;
      isBoth();
    });
  }

  async function isBoth(){
    //console.log(isFrame + " - " + isFork);
    if(isFrame && isFork){
      console.log("running wheelSizeCompat");
      module.wheelSizeCompat();
    }
  }


  async function isPart(pt, callback){
    var ispartRequest = new XMLHttpRequest();
    let partPromise = new Promise((resolve, reject) => {
      ispartRequest.onreadystatechange = function check(){
        //console.log("ispartRequest status = " + ispartRequest.status);
        if(ispartRequest.readyState == 4 && ispartRequest.status == 200){
          if(ispartRequest.responseText != ""){
            //Part is selected
            //console.log(ispartRequest.responseText);
            resolve(true);
          }
          else{
            //Part not selected
            //console.log("no part selected");
            resolve(false);
          }
        }
      };
    });
    ispartRequest.open("GET", "php/isPart.php?pt="+pt, true);
    ispartRequest.send();
    let returnStatement = await partPromise;
    //console.log(b);
    callback(returnStatement);
  }
}
