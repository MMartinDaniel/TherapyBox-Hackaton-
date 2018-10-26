<?php 
	/**
	 * User class, Retrieve user data from the database
	 */
	class User{

		private $username;
		private $password;
		private $email;
		private $user_data;
		private $db;
		private $logged;
	

		function __construct($mdb=NULL){
			if($mdb == NULL)
				throw new Exception("User: Database obj invalid ", 1);
			$this->db = &$mdb;
		}
		public function getName(){
			return $this->username;
		}

		public function logout(){
			session_destroy();
		}

		public function register(){
			//check if password matchs
			if($_POST['password'] != $_POST['validation-password']){
				$error = "Passwords do not match";
				return $error;
			}
			//check if username already exist
			$query = $this->db->prepare('SELECT username FROM users WHERE username = :username');
			$query->execute(array(':username' => $_POST['username']));
			$row = $query->fetch(PDO::FETCH_ASSOC);

			if(!empty($row['username'])){
					$error = "username already in use";
					return $error;
			}

			//hash the password
			$hashedpassword = password_hash($_POST['password'], PASSWORD_BCRYPT);
			$this->password = $hashedpassword;
			//resize picture
			$profilepic = $this->processPicture();
			//insert final values
			$query = $this->db->prepare('INSERT INTO `users` (`id`,`username`,`password`,`email`, `profile_pic`) VALUES (NULL, ?, ?, ?,?)');
			$query->bindParam(1, $_POST['username']);
			$query->bindParam(2, $hashedpassword);
			$query->bindParam(3,  $_POST['email']);
			$query->bindParam(4,  $profilepic);
			$query->execute();

		}

		//login an set the session data.
		public function login(){

			$query = $this->db->prepare( 'SELECT * FROM users WHERE username = ? LIMIT 1' );
			$query->bindParam(1,$_POST['username']);
			$query->execute();
			$row = $query->fetch();
			if($query->rowCount() == 0){$error = "User does not exist "; return $error;};
			if( password_verify($_POST['password'], $row['password']) == 1){

				$_SESSION['loggedin'] = true;
				$_SESSION['username'] = $row['username'];
				$_SESSION['memberID'] = $row['id'];
				$_SESSION['picture']  = $row['profile_pic'];


				$error = "";}else{
				$error = "Incorrect Password";
			}



 			return $error;
		}


		public function processPicture(){
			
			$cont = 0;
			$file = $_FILES['profile-pic']['tmp_name']; 
	        $sourceProperties = getimagesize($file);
	        $fileNewName = time() . $_FILES['profile-pic']['name'];
	        $folderPath = "images/uploads/";
	        $ext = pathinfo($_FILES['profile-pic']['name'], PATHINFO_EXTENSION);
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
	          return $fileNewName;
		}

		public function imageResize($imageResourceId,$width,$height) {
		
			$targetWidth =280;
			$targetHeight =280;
			$targetLayer=imagecreatetruecolor($targetWidth,$targetHeight);
			imagecopyresampled($targetLayer,$imageResourceId,0,0,0,0,$targetWidth,$targetHeight, $width,$height);
			return $targetLayer;
		}

	}
