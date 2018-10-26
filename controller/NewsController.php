<?php
	/**
	 * News Controller
	 */
	class NewsController extends MainController{
		
		function __construct(){
			parent::__construct();
		}

		public function index(){
			$news = new News(); 
			$this->view("news",array("news"=>$news));
		}
	}
?>
