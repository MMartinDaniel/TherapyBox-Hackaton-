<?php
//check loggin
session_start(); 

if(!$_SESSION['loggedin']){header('Location:index.php');};
$gallery->setID($_SESSION['memberID']);
//check if there is any image that needs to be upload.
if(isset($_FILES["image"]) && $_FILES['image']['name'][0] != "") {
    if(is_array($_FILES)) {
    	$gallery->uploadPicture();
        header('Location: '.$_SERVER['REQUEST_URI']);
    }
}
//check if post data have been sent to delete a picture.
if(isset($_POST['delete'])){
	$gallery->deletePicture($_POST['delete'][0]);
}
	$gallery->getGallery();
	?>
<body>


<div class='container'>
  <div class='row'>
	<div style='color:white; ' class='col-md-12'>
		<div class='head'><a href='index.php?'><img src='images/left-arrow.png'></a><H1>Photos</H1></div>
	</div>

  </div>

  <form method="post" enctype="multipart/form-data">
	  <div class="row">
				<?php
					$gallery->printGallery();
				?>
	  </div>
	</form>

</div>

</body>
<script>
	function submitForm(){
	    $('form').submit();
	}
</script>
</html>