<?php
	/**
	 * Main Controller.
	 */
	class MainController{
		
		//Include all models
		function __construct(){
			foreach ( glob("model/*.php") as $file) {
				require_once $file;
			}
		}

		public function view($view,$data){
			foreach ($data as $id_assoc => $value) {
				${$id_assoc} = $value;
			}

			require_once 'core/ViewHelper.php';
			$helper = new ViewHelper();
			require_once('view/'.$view.'View.php');
		}

		public function redirect($controller=DEFAULT_CONTROLLER,$action=DEFAULT_ACTION){
        header("Location:index.php?controller=".$controlador."&action=".$accion);
    }
     

	}

?>