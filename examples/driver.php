<?php

//Note this is how to upload a song to remixed, unfornately the page would need to be reloaded after the call to get the actual remix
/*$post = array(
     "url"=>"https://musicp-blockwood.c9users.io/CST205project/echo/examples/music/Seven_Nation_Army.mp3",
     "api_key"=>"LA2Y1VTHC4KU8MMPU"
);
$ch = curl_init();
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_URL, "http://developer.echonest.com/api/v4/track/upload");
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $post); 
$response = curl_exec($ch);
var_dump($response);*/
?>
<!DOCTYPE html>
<html lang="en">
<head>
<div class = "container">
    <div class = "row">
        <div class = "col-md-offset-12">  
         <h1>&nbsp &nbsp &nbsp &nbsp</h1>
         <h1 class = "greenBtn">W</h1>
         <h1 class = "tealBtn">e</h1>
         <h1 class = "redBtn">l</h1>
         <h1 class = "blueBtn">c</h1>
         <h1 class = "purpBtn">o</h1>
         <h1 class = "pinkBtn">m</h1>
         <h1 class = "orangeBtn">e</h1>
         <h1>&nbsp</h1>
         <h1 class = "redBtn">t</h1>
         <h1 class = "greenBtn">o</h1>
         <h1>&nbsp</h1>
         <h1 class = "tealBtn">M</h1>
         <h1 class = "redBtn">i</h1>
         <h1 class = "pinkBtn">x</h1>
         <h1 class = "purpBtn">a</h1>
         <h1 class = "blueBtn">l</h1>
         <h1 class = "orangeBtn">a</h1>
         <h1 class = "pinkBtn">t</h1>
         <h1 class = "greenBtn">o</h1>
         <h1 class = "orangeBtn">r</h1>
            
       </div>     
    </div>
</div>

<br>
<br>
<br>
<br>
<br>
<br>



<meta charset=utf-8>

<!-- add in the sounds we are going to use -->
<audio src="audio/SFW_Drop_Loop_27_G_125_BPM.wav" id="cowbell"></audio>
<audio src="audio/JUST_kick_909_thug.wav" id="kickThug"></audio>
<audio src="audio/JUST_kick_short_round.wav" id="kickRound"></audio>
<audio src="audio/Vox 1.wav" id="Vox1"></audio>
<audio src="audio/Vox 12.wav" id="Vox12"></audio>
<audio src="audio/Vox 9.wav" id="Vox9"></audio>
<audio src="audio/BL_FX_vox_shout_oneshot_Police.wav" id="wooop"></audio>

<audio src="audio/14_RA_KIT_06_CHORD_120_Gm.wav" id="raKit"></audio>
<audio src="audio/BL_C_m_120_BVs_loop_GirlGroup_HighHarm.wav" id="bvGirl"></audio>
<audio src="audio/BL_Cm_85_lead_phrase_NeverGonLetYouGo.wav" id="never"></audio>
<audio src="audio/BPM.wav" id="ghostShell"></audio>
<audio src="audio/Loops.wav" id="house"></audio>
<audio src="audio/SFW_Drop_Loop_12_E_125_BPM.wav" id="hiHat"></audio>
<audio src="audio/MdL_94_drum_loop_kittychop.wav" id="kitty"></audio>



</head>

<body>
<link rel = "stylesheet" type = "text/css" href = "CSS/Style.css">
<link href='https://fonts.googleapis.com/css?family=Raleway:400,100,500' rel='stylesheet' type='text/css'>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script type="text/javascript" src='../remix.js'></script>
<script type="text/javascript">

// Hop through the beats of a track using the arrow keys
// You will need to supply your Echo Nest API key, the trackID, and a URL to the track.
// The supplied track can be found in the audio subdirectory.
var apiKey = 'LA2Y1VTHC4KU8MMPU';
var trackID = 'TROFQFX13385238876';
var trackURL = 'music/Back_In_Black.mp3';
var i=0;
var context;
var remixer;
var player;
var player2;
var track;
var remixed;
var remixed2;
var newTrack;
var playbackIndex = -1;
var myjson;
var remixCon;
var directorySong;

//parsin what comes back from getParse
function valueParser(option)
{
    var option=option.split("+");
    return option;
}
//was going to be used for text maybe for future improvement
function parser(artist,songTitle)
{
    //prep artist name and song title for ajax call to get songID
    var count=0;
    var artistString="&artist=";
    var artist=artist.split(" ");
    var songTitle=songTitle.split(" ");
    var titleString="&title=";
    for(count =0;count<artist.length;count++)
    {
        if(count==artist.length-1)
        {
        artistString=artistString+artist[count];
        }else{
         artistString=artistString+artist[count]+"%20";
        }
    }
    for(count=0; count<songTitle.length;count++)
    {
        if(count==songTitle.length-1)
     {
         titleString=titleString+songTitle[count];
     }else{
         titleString=titleString+songTitle[count]+"%20";
     }
    }
    return [artistString,titleString];
}
//for future 
function getSongID(artist,song){
//ajax call to get song ID
    $.ajax({
  url: 'http://developer.echonest.com/api/v4/song/search?api_key='+apiKey+artist+song,
  dataType: 'json',
  async: false,
  success: function(data) {
      
    myjson = data;
    
  }
 
});
console.log(myjson);
 
 
}
//parses the get string callback
function getParse(name){
   if(name=(new RegExp('[?&]'+encodeURIComponent(name)+'=([^&]*)')).exec(location.search))
      return decodeURIComponent(name[1]);
}
//creates the Remix using echonest API
function getRemix(remixer,player,trackID,trackURL,track,context,apiKey,info)
{
     remixer = createJRemixer(context, $, apiKey);
       
        player = remixer.getPlayer();
        
        $(info).text("Loading analysis data...");
        
        remixer.remixTrackById(trackID, trackURL, function(t, percent) {
            track = t;

            $(info).text(percent + "% of the track loaded");
            if (percent == 100) {
                //console.log(percent);
                $(info).text(percent + "% of the track loaded, remixing...");
                $(info).css("color","red");
            }

            if (track.status == 'ok') {
                
                remixed = new Array();
                for (var i=0; i < track.analysis.beats.length; i++) {
                    remixed.push(track.analysis.beats[i])
                }
                $(info).text("Remix complete!");
                for(i=0;i<remixed.length-42;i++)
               {
                makeButtons(i,"button"+i,remixed);
                }
                //makedummyButtons();
            }
        });
    return [remixer,remixed,track,player];
}

function makedummyButtons(){
    //var testB;
    for(var i = 0; i < 656; i++){
        
        //Create an input type dynamically.   
        var testB = document.createElement("input");
        //Assign different attributes to the element. 
        testB.type = "button";
        testB.className = "remixBtn";
        //testB.style.borderColor=white;
        testB.style.backgroundColor=makeColor(); 
        var myButtons= document.getElementById("test");
        myButtons.appendChild(testB);        
   // }

    }
  
}


function makeColor(){

  var hexColor = ['a', 'b', 'c', 'd', 'e', 'f', '0','1', '2', '3', '4', '5', '6', '7', '8', '9'];

  var x = '#';
  for(var i = 1; i <=6; i++){

    var y = Math.floor((Math.random() * 16));
    x += hexColor[y];
    //document.getElementById("demo").innerHTML = x;
  }
  
  return x;

}
function makeButtons( index,name,remixed)
{
    //Create an input type dynamically.   
    var element = document.createElement("input");
    //Assign different attributes to the element. 
    element.type = "button";
    element.value = ""; 
    element.name = name;  
    element.id=name;
    element.className = "remixBtn";
    element.style.backgroundColor=makeColor();
    element.onclick = function() { // Note this is a function
    if(index==0)
    {
        player2.play(0,remixed[index]);
    }
    else{
        player2.play(remixed[index],remixed[index+40]);
    }
    element.style.backgroundColor=makeColor();
    };

    var myButtons= document.getElementById("songParts");
    //Append the element in page (in span).  
    myButtons.appendChild(element);
}

function init() {
    //get submission selection
    if(getParse("artist")!=undefined)
    {
      var something=valueParser(getParse("artist"));
      trackURL=something[0];
      trackID=something[1];
      
    }
    //check the browser supports audio kit
    var contextFunction = window.webkitAudioContext || window.AudioContext;
    if (contextFunction === undefined) {
        $("#info").text("Sorry, this app needs advanced web audio. Your browser doesn't"
            + " support it. Try the latest version of Chrome?");
    } else {
       context = new contextFunction();
    //create the remix and set values
        remixCon= getRemix(remixer,player,trackID,trackURL,track,context,apiKey,"#info");
        remixer = remixCon[0];
        remixed = remixCon[1];
        track  = remixCon[2];
        player = remixCon[3];
       player2 = remixer.getPlayer();
       //for stepping through the song
        var j=0;
    // Set up the keyboard controls
    document.addEventListener('keydown', function(event) {
       //step through the song using r
        if(event.which ==82)//r
        {
            if(j=remixed.length)
            {
                j=0;
            }
            player.play(0,remixed[j]);
            j++
        }
   //given in example echonest
        if (event.which == 39) {  // right arrow
            playbackIndex = playbackIndex + 1;
            if (playbackIndex > remixed.length - 1) {
                playbackIndex = 0;
            }
            player.play(0, remixed[playbackIndex]);
            
        }
       
        if (event.which == 37) {  // left arrow
            playbackIndex = playbackIndex - 1;
            if (playbackIndex < 0) {
                playbackIndex = remixed.length - 1;
            }
            player.play(0, remixed[playbackIndex]);
        }

        if (event.which == 40) {  // down arrow
            playbackIndex = playbackIndex - 4;
            if (playbackIndex < 0) {
                playbackIndex = remixed.length - 1;
            }
            player.play(0, remixed[playbackIndex]);
        }

        if (event.which == 38) {  // up arrow
            playbackIndex = playbackIndex + 4;
            if (playbackIndex > remixed.length - 1) {
                playbackIndex = 0;
            }
      
            player.play(0, remixed[playbackIndex]);
        }
        //end 
        //Lower the volumne by lowering the gain
        if (event.which== 73){//on i
        
          player.fadeOut();
        }
        //Raise the volumne by upping the gain
        if (event.which==65)//on a    fade in
        {
            player.fadeIn();
            
        }
       //play remix make sure player has top
        if(event.which== 9){//tab key replay
        player.stop();
        player.play(0,remixed);
        }
        //stop player
        if(event.which== 83){// s key
         player.stop();
        }
        
    });
    }
}




window.onload = init;
</script>

<div id='info'> </div><br>

<h2>
    Press the <span class ="green"> Right and Left arrow keys </span> to move through the track by beat.
    <br>
    Press the <span class = "teal">Up and Down arrow keys</span>  to move through the track by bar.
    <br>
    Press the <span class = "red">Tab key</span> to replay the song
    <br>
    Press the <span class = "pink"> S </span> to stop the song
    <br>
    Press <span class = "orange"> R </span>  to step throught the song 
    <br>
    Press <span class = "purp"> I </span> to lower the volume 
    <br>
    Press <span class = "blue" > A </span> to raise the volume
    <br>
</h2>


<div id="songParts"></div>
<!--<div id="test"></div>
    <script>
        makedummyButtons();
    </script>
</div>-->

<div class="container">

   

      <div class = "row">

        <div id ="btn-block" class = "col-md-offset-12">
          <button id ="cowbellButton" type = "button" class ="btn greenBtn" value ="audio/name of the sound file "></button>
          <button  id = "aButton" type = "button" class = "btn purpBtn"></button>
          <button  id = "bButton" type = "button" class = "btn pinkBtn"></button>
          <button  id = "cButton" type = "button" class = "btn blueBtn"></button>
          <button  id = "dButton" type = "button" class = "btn tealBtn"></button>
          <button  id = "eButton" type = "button" class = "btn redBtn"></button>
          <button  id = "fButton" type = "button" class = "btn orangeBtn"></button> 
        </div>

        </div>

      <div class = "row">
        <div id= "btn-block" class = "col-md-offset-12">
          <button  id = "gButton" type = "button" class = "btn redBtn"></button>
          <button  id = "hButton" type = "button" class = "btn blueBtn"></button>
          <button  id = "iButton" type = "button" class = "btn orangeBtn"></button>
          <button  id = "jButton" type = "button" class = "btn purpBtn"></button>
          <button  id = "kButton" type = "button" class = "btn greenBtn"></button>
          <button  id = "lButton" type = "button" class = "btn tealBtn"></button>
          <button  id = "mButton" type = "button" class = "btn pinkBtn"></button>
        </div>



      </div>
      
  </div>
  
  <div class = "container"> 
      <div class = "row"> 
          <div class ="col-md-5">
              <form method="get" action="driver.php" >
               <h3>Artist & Song
            <select  name="artist">

                <option value="music/Back_In_Black.mp3 TRPNOLW154AC0A1605">AC\DC-Back In Black </option> 
                <option value="music/Opera_Singer.mp3 TRJGGMD154ABE12801">Cake-Opera Singer</option>
                <option value="music/Cthulhu_Steps.mp3 TRJDOEO154AC0C7C88">Deadmau5-Cthulhu Steps</option>
                <option value="music/City_In_Florida.mp3 TRPNOLW154AC0A1605">Deadmau5-City In Florida</option>
                <option value="music/Hooked_On_A_Feeling.mp3 TRWYVRI154AD838E9F">Blue Swede-Hooked On A Feeling</option>
                <option value="music/Ain't_No_Rest_For_the_Wicked.mp3 TRWBPMG154AD87F492">Cage the Elephant-Ain't No Rest For the Wicked</option>
                <option value="music/Sail.mp3 TROFWQU154AD8E6848">AWOLNATION-Sail</option>
                <option value="music/Walk_This_Way.mp3 TRINMYI154AD9137E1">Aerosmith-Walk This Way</option>
                <option value="music/Seven_Nation_Army.mp3 TRNTNZC154AD93AA81">Seven Nation Army-The White Stripes</option>
              </select>&nbsp
              
    
              <br><br>
              <input type="submit" class = "sub">
                  </form>
              </h3>
          </div>
      </div>
  </div>
  

 <script>
document.getElementById("cowbellButton").addEventListener("click", function() {
    myFunction("cowbell");
});
document.getElementById("aButton").addEventListener("click", function() {
    myFunction("kickThug");
});
document.getElementById("bButton").addEventListener("click", function() {
    myFunction("kickRound");
});
document.getElementById("cButton").addEventListener("click", function() {
    myFunction("wooop");
});
document.getElementById("dButton").addEventListener("click", function() {
    myFunction("Vox12");
});
document.getElementById("eButton").addEventListener("click", function() {
    myFunction("Vox9");
});
document.getElementById("fButton").addEventListener("click", function() {
    myFunction("wooop");
});
document.getElementById("gButton").addEventListener("click", function() {
    myFunction("raKit");
});
document.getElementById("hButton").addEventListener("click", function() {
    myFunction("bvGirl");
});
document.getElementById("iButton").addEventListener("click", function() {
    myFunction("never");
});
document.getElementById("jButton").addEventListener("click", function() {
    myFunction("ghostShell");
});
document.getElementById("kButton").addEventListener("click", function() {
    myFunction("house");
});
document.getElementById("lButton").addEventListener("click", function() {
    myFunction("hiHat");
});
document.getElementById("mButton").addEventListener("click", function() {
    myFunction("kitty");
});

function myFunction(source) {
    var audio = document.getElementById(source);
    if (audio.paused) {
        audio.play();
    }else{
        audio.currentTime = 0
    }
}
  </script>
</body>


</html>
