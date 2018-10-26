<?php 
//check session status, and if logged, then set the controller for the user Data.
// and retrieve all the info, for the gallery, and tasklist.
session_start();
if(!$_SESSION['loggedin']){header('Location:index.php');}; 
  $galleryC->setID($_SESSION['memberID']);
  $taskC->setUser($_SESSION['memberID']);
  $galleryC->getGallery();
  $tlist = $taskC->getTaskList();
  if(empty($tlist)){
    $taskC->createTask($_SESSION['memberID']);
    $taskC->getTaskList();
  }

?>;
<body >


<div  class='container'>
  <div class='row'>
    <div class='col-md-3 col-xs-12'>
      <div class='img-profile'>
        <img id='dash-profile' src='images/uploads/<?php echo $_SESSION['picture'] . "'" ?>>
      </div>
    </div>
    <div class='col-md-9 col-xs-12' ><h1 class='dash-hed' >Good Day <?php echo $_SESSION['username']; ?><h1></div>
  </div>
  <div class="row">
    <div class="col-12 col-md-4">
      <div class='card'>
        <div class='header'>Weather</div>
        <div id='location'><img id='weather' src=''></div> 
        <div id='city'></div></div>
      </div>
    <div class="col-xs-12 col-md-4">
      <div class='card'><div class='header'>News</div>
        <a href='index.php?controller=news'><h3 id='news-title'></h3></a>
        <p id='news-descrip'></p>
      </div>
    </div>
        <div class="col-xs-12 col-md-4">
          <div class='card'>
            <div class='header'>Sport</div>
            <a href='index.php?controller=team'><h3 id='sport-title'></h3></a><p id='sport-descrip'></p>
          </div>
        </div>

  </div>
  <div class="row">
    <div class="col-xs-12 col-md-4">
      <div class='card'>
        <div class='header'>Photos</div> <!-- Print all the thumbails of the gallery -->
        <div class='thumb-pic-l'><?php  $galleryC->printGalleryThumb(); ?></div>
      </div>
    </div>
    <div class="col-xs-12 col-md-4">
      <div class='card'>
        <div class='header'>Tasks</div><!-- Print all the thumbails of the tasks -->
        <div class='thumb-task-l'><?php  $taskC->printTaskListThumb(); ?></div>
      </div>
    </div>
    <div class="col-xs-12 col-md-4">
      <div class='card'>
        <div class='header'>Clothes</div>
        <canvas id="pie-chart" height="50vw" width="80vw"></canvas>
      </div>
  </div>



</div>




</body>
<script type="text/javascript">
/* Read the BBC feeds, parse it and append them to their respective locations */
$( document ).ready(function() {
   showPosition();
      
  var feed = "json/bbcfeed.xml";
  
  $.ajax(feed, {
    accepts:{
      xml:"application/rss+xml"
    },
    dataType:"xml",
    success:function(data) {
      document.getElementById("news-title").innerHTML = $(data).find("item").find("title").first().text();
      document.getElementById("news-descrip").innerHTML = $(data).find("item").find("description").first().text();
    } 
  });

  var feed = "json/bbc-sports.xml";
  
  $.ajax(feed, {
    accepts:{
      xml:"application/rss+xml"
    },
    dataType:"xml",
    success:function(data) {
      document.getElementById("sport-title").innerHTML = $(data).find("item").find("title").first().text();
      document.getElementById("sport-descrip").innerHTML = $(data).find("item").find("description").first().text();
    } 
  });
  //Retrieve data from the json file, parse it and create the chart.
 let xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
      if (this.readyState === 4 && this.status === 200) {
        let response = JSON.parse(this.responseText);
        console.log(response);    
        var obj = {};
        $(response.payload).each(function(index,value){
          if(obj[value.clothe] == null){obj[value.clothe] = 1;}else{ obj[value.clothe]++;}
        });

          Chart.defaults.global.legend.display = false;
           var mychart = new Chart(document.getElementById("pie-chart"), {
              type: 'pie',
              data: {
              labels: [],
              datasets: [{
              backgroundColor: ["#3e95cd", "#8e5ea2","#3cba9f","#e8c3b9","#c45850" ],
              data: []
              }]
            }

         });
           //Loop on the results, then do % of each item.
        Object.keys(obj).forEach(function(key) {
          value = ((obj[key]/1000)*100).toFixed(2);
          addData(mychart,key,value);
        });   
        console.log(obj);
      }
    }
    xhr.open("GET", "json/clothing-api.json");
   //xhr.open("GET", "https://cors-anywhere.herokuapp.com/https://therapy-box.co.uk/hackathon/clothing-api.php?username=swapnil");
	//xhr.open("GET", "https://therapy-box.co.uk/hackathon/clothing-api.php?username=swapnil");
    xhr.setRequestHeader("Accept", 'application/json');
    xhr.send();

});


//Return forecast depending on the geolocalization
function showPosition() {
  
    var lat;
    var lon;

    $.when(

      $.getJSON('http://ip-api.com/json', function(data){
      lat = data.lat;
      lon = data.lon;
    })
      ).then(function(){
   

     console.log(lat + " y " + lon);
	//call using &units=metric to get the temperature in celsius 
    $.getJSON("https://api.openweathermap.org/data/2.5/weather?lat=" + lat + "&lon=" + lon + "&APPID=d0a10211ea3d36b0a6423a104782130e&units=metric",
        function (forecast) {
            $("#location").append(forecast.coord);
            $("#location").append("<h2 id='degrees'>" + forecast.main.temp + " 	&deg " + forecast.weather[0].main + "</h2>");
            $("#city").append( forecast.name);
       		$("#weather").attr("src","images/" + forecast.weather[0].main + "_icon.png");
        }
    );
    });
    
}//function of chartjs, adddata dynamically to the chart. 
function addData(chart, label, data) {
    chart.data.labels.push(label);
    chart.data.datasets.forEach((dataset) => {
        dataset.data.push(data);
    });
    chart.update();
}
   


</script>
</html>