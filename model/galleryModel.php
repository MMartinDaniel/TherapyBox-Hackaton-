<?php 
	/**
	 * Gallery class, Retrieve user data from the database
	 */
	class Gallery{

		private $user_id;
		private $pictures;
		private $db;
		function __construct($mdb=NULL){
			
			if($mdb == NULL)
				throw new Exception("User: Database obj invalid ", 1);
			$this->db = &$mdb;	
		}

		public function setID($id){
			$this->user_id = $id;
		}
		//Get the Gallery from the database using and ID;
		public function getGallery(){
			$query = $this->db->prepare( 'SELECT * FROM `gallery` WHERE user_id = ?');
			if ($query->execute(array($this->user_id))) {
				while ($row = $query->fetch()) {
					$this->pictures[] = $row;
				}
			}
			
			return $this->pictures;
		}
		//print the user gallery;
		public function printGallery(){
			$cont = 0;
			if(isset($this->pictures)){
			foreach ($this->pictures as $picture => $value) {
				$cont++;
				echo " <div class='col-xs-12 col-md-4'><div id='" .$value[0] . "' class='picture-card'>
				<div class='picture-grid'>
				<label class=' hidden-tag'>
				<img class='item-pic' src='images/uploads/". $value[1] . "'>
					<input type='submit' style='display:none;' name='delete[]' value='".$value[0]."' />
				</label></div></div>
				</div>";
			}}
			//only 6 pictures allowed, if the user has not 6 pictures, then it shows default picture.
			if($cont < 6){
				for ($i=$cont; $i < 6 ; $i++) { 
				 	 echo "	<div class='col-xs-12 col-md-4'>
				 	 		<div id='pic1' class='picture-card'>
							<div class='picture-grid'>
							<label class='btn-upload'>
								<input type='file' name='image[]' onchange='". 'submitForm()'. "'/>";
					if($i == $cont)	{
							echo"<img class='plus-pic' src='images/Plus_button.png'>";};
						echo "</label></div></div></div>";
				}
			}
		}
		// Print smaller Versions of the gallery
		public function printGalleryThumb(){
				$cont = 0;
				if(isset($this->pictures)){
					foreach ($this->pictures as $picture => $value) {
						if($cont %2 == 0){echo "<div class='row'>";};
						$cont++;
						echo "<a href='index.php?&controller=gallery'> <div id='" .$value[0] . "' class='picture-card-small'>
						<div class='picture-grid'><img class='item-pic-tmb' src='images/uploads/". $value[1] . "'></div></div></a>";
						if($cont %2 == 0){echo "</div>";};
						if($cont == 4){break;};
					}
				}
				if($cont < 4){
					for ($i=$cont; $i < 4 ; $i++) { 
					  if($cont %2 == 0){echo "<div class='row'>";};
					  $cont++;
					  echo "<a href='index.php?&controller=gallery'><div id='pic1' class='picture-card-small'>
							<div class='picture-grid'></div></div></a>";
					if($cont %2 == 0){echo "</div>";};
					}
				}
			}
			//Upload the picture, resizing it
		public function uploadPicture(){
			$cont = 0;
			foreach ($_FILES['image'] as $key => $value) {
				if($value != ""){
					$index = $cont;
					break;
				}
				$cont++;
			}

			$file = $_FILES['image']['tmp_name'][$index]; 
	        $sourceProperties = getimagesize($file);
	        $fileNewName = time() . $_FILES['image']['name'][$index] ;
	        $folderPath = "images/uploads/";
	        $ext = pathinfo($_FILES['image']['name'][$index], PATHINFO_EXTENSION);
	        $imageType = $sourceProperties[2];

	        switch ($imageType) {

	            case IMAGETYPE_PNG:
	                $imageResourceId = imagecreatefrompng($file); 
	                $targetLayer = $this->imageResize($imageResourceId,$sourceProperties[0],$sourceProperties[1]);
	                imagepng($targetLayer,$folderPath.  $fileNewName);
	                break;


	            case IMAGETYPE_GIF:
	                $imageResourceId = imagecreatefromgif($file); 
	                $targetLayer = $this->imageResize($imageResourceId,$sourceProperties[0],$sourceProperties[1]);
	                imagegif($targetLayer,$folderPath. $fileNewName);
	                break;


	            case IMAGETYPE_JPEG:
	                $imageResourceId = imagecreatefromjpeg($file); 
	                $targetLayer = $this->imageResize($imageResourceId,$sourceProperties[0],$sourceProperties[1]);
	                imagejpeg($targetLayer,$folderPath. $fileNewName);
	                break;


	            default:
	                echo "Invalid Image type.";
	                exit;
	                break;
	        }
	        //finally add it to the database.
			$query = $this->db->prepare("INSERT INTO `gallery` (`idpic`, `url`, `user_id`) VALUES (NULL, ?, ?)");
			$query->bindParam(1, $fileNewName);
			$query->bindParam(2, $this->user_id);
			$query->execute();
		}
			//get URL, from the picture, then delete the row, finally remove the file from the server.
		public function deletePicture($id){

			$query = $this->db->prepare( 'SELECT url FROM `gallery` WHERE idpic = ?');
			$query->bindParam(1,$id);
			$query->execute();
			$file = $query->fetch();

			$query = $this->db->prepare("DELETE FROM `gallery` WHERE idpic = ?");
			$query->bindParam(1, $id);
			$query->execute();

			if (file_exists("images/uploads/". $file[0])) {
				unlink("images/uploads/". $file[0]);
				//echo "images/uploads/". $file[0];
			}

		}
		//function to resize the picture to 280x280
		public function imageResize($imageResourceId,$width,$height) {
			
			$targetWidth =280;
			$targetHeight =280;
			$targetLayer=imagecreatetruecolor($targetWidth,$targetHeight);
			imagecopyresampled($targetLayer,$imageResourceId,0,0,0,0,$targetWidth,$targetHeight, $width,$height);

			return $targetLayer;
		}


	}
