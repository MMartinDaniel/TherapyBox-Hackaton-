<?php
	function loadController($controller){
		//check the controller
		$controller = ucwords($controller).'Controller';
		$strFController = 'controller/'. $controller . '.php';
		//if file doesn't exist, is that the url is not correct.
		// stablish it to the default controller.
		if(!is_file($strFController)){
			$controller =  ucwords(DEFAULT_CONTROLLER). 'Controller';
			$strFController = 'controller/'. $controller . '.php';
		}
		//use it
		require_once $strFController;
		$controllerOBJ = new $controller();
		return $controllerOBJ;
	}
	//load the action, default_action is the function index() of the  corresponding Controller.
	function loadAction($controllerOBJ,$action){
		$action = $action;
		$controllerOBJ->$action();
	}

	function execAction($controllerOBJ){
		if(isset($_GET['action']) && method_exists($controllerOBJ, $_GET['action'])){
			loadAction($controllerOBJ,$_GET['action']);
		}else{
			loadAction($controllerOBJ,DEFAULT_ACTION);
		}
	}
	
?>