<?php
	/**
	 * User Controller
	 */
	class TeamController extends MainController{
		
		function __construct(){
			parent::__construct();
		}

		public function index(){
			$team = new Team(); 
			$this->view("team",array("team"=>$team));
		}
	}
?>
