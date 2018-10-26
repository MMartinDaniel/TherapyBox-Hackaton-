<?php
	/**
	 * Task Controller
	 */
	class TaskController extends MainController{
		
		function __construct(){
			parent::__construct();
		}

		public function index(){
			$mdb = Connector::DBConnection();
			$task = new Task($mdb); 
			$this->view("task",array("task"=>$task));
		}
	}
?>
