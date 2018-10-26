<?php
	/**
	 * Gallery Controller
	 */
	class GalleryController extends MainController{
		
		function __construct(){
			parent::__construct();
		}

		public function index(){
			$mdb = Connector::DBConnection();
			$gallery = new Gallery($mdb); 
			$this->view("gallery",array("gallery"=>$gallery));
		}
	}
?>
