<?php
	session_start();
	//check if logged, then set Juventus as a default team
	if(!$_SESSION['loggedin']){header('Location:index.php');};
	if(!isset($_SESSION['current_team'])){$_SESSION['current_team'] = 'Juventus';};
	if(isset($_POST['team'])){$_SESSION['current_team'] = $_POST['team'];}
	//retrieve data according to the predefined team
	$data = $team->getWonAgaisnt($_SESSION['current_team']);

?>

<body >


	<div class='container'>
		<div class='row '>
			<div style='color:white; ' class='col-md-12'>
				<div class='head'>
					<a href='index.php?'><img src='images/left-arrow.png'></a>
					<H1>Champion's League Challenge</H1>
				</div>
			</div>
		</div>
		<div class='row'>
			<div class='col-md-12 inp-team'>
				<form id='teamform' method='post'>
					<div class='cent'>
						<input type='text' name='team' class='form-control loginp' placeholder="Input Winning Team" >
					</div>
				</form>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12 col-md-12">
				<!-- Loop and show the teams that you won agaisnt -->
				<ul class='teamlist'>
					<li><h4><?php echo $_SESSION['current_team'] ?> - Teams you won Against  </h4></li>
					<?php 
						foreach ($data as $key => $value) {
							echo "<li>" . $value . "</li>";
						}
					?>
				</ul>
			</div>
		</div>  

	</div>

</body>
</html>