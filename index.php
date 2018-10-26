
<?php
header('Access-Control-Allow-Origin: *'); 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'config/global.php';
require_once 'core/connector/connection.php';
require_once 'core/MainController.php';
require_once 'core/controllerLoader.php';
require_once 'core/header.php';

	//delegates the control to the controller, use action depending of controlller
	if(isset($_GET['controller'])){
		$controllerOBJ= loadController($_GET['controller']);
		execAction($controllerOBJ);
	}else{
		$controllerOBJ=loadController(DEFAULT_CONTROLLER);
		execAction($controllerOBJ);
	}
?>

 

<?php
	require_once'core/footer.php';
?>

<!-- /.content-wrapper -->
 <?php
 // require_once("core/footer.php");
?>