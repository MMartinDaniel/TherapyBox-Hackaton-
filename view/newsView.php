
<?php
	session_start();if(!$_SESSION['loggedin']){header('Location:index.php');};
?>

<body >


	<div class='container'>
		<div class='row'>
			<div style='color:white; ' class='col-md-12'>
				<div class='head'><a href='index.php?'>
					<img src='images/left-arrow.png'></a><H1>News</H1>
				</div>
			</div>
		</div>
		<div class='row'>
			<div class='col-md-12'>
				<div class='cent'><img id='news' src=''>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-12 col-md-12">
				<h2 style='color:white;' id='news-title'></h2>
				<p style='color:white;' id='news-descrip'></p>
			</div>
		</div>  

	</div>

</body>

<!-- Read the BBC feeds, parse it and append them to their respective divs -->
<script type="text/javascript">
	$( document ).ready(function() {

	  var feed = "json/bbcfeed.xml";
	  
	  $.ajax(feed, {
	    accepts:{
	      xml:"application/rss+xml"
	    },
	    dataType:"xml",
	    success:function(data) {
	      document.getElementById("news").src = $(data).find("item").find("media\\:thumbnail").first().attr("url");
	      document.getElementById("news-title").innerHTML = $(data).find("item").find("title").first().text();
	      document.getElementById("news-descrip").innerHTML = $(data).find("item").find("description").first().text();
	    } 
	  });

	});
</script>
</html>