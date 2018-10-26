<?php
	/**
	 * Dashboard Controller
	 */
	class DashboardController extends MainController{
		
		function __construct(){
			parent::__construct();
		}
		//dashboard uses another clases for the view
		public function index(){
			$mdb = Connector::DBConnection();
			$dashboard = new Dashboard();
			$galleryC = new Gallery($mdb);
			$tasksC = new Task($mdb);

			$this->view("dashboard",
				array("dashboardC"=>$dashboard,
						"galleryC" => $galleryC,
						"taskC" => $tasksC));
		}
	}
?>
