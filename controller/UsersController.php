<?php
	/**
	 * User Controller
	 */
	class UsersController extends MainController{
		
		function __construct(){
			parent::__construct();
		}

		public function index(){
			$mdb = Connector::DBConnection();
			$userController = new User($mdb);	
			$this->view("index",array('userController'=>$userController));
		}
	}
?>
