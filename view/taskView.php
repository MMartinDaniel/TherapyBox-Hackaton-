<?php
//check loggin status
	session_start();
	if(!$_SESSION['loggedin']){header('Location:index.php');};
	//set user ID to the tasks.
	$task->setUser($_SESSION['memberID']);
	if(isset($_POST['modified'])){
		$task->update();
		 header('Location: '.$_SERVER['REQUEST_URI']);
	}
	//check if there was a new task to be created.
	if(isset($_POST['addnew'])){
		$task->createTask($_SESSION['memberID']);
	}
	//get the task list.
	$tasks_list = $task->getTaskList();

?>

<body >
	<div class="container">
		<div class="row nmargin">
		  <div class="col-md-12">
			<div id="todo-list">
				<div class='head'><a href='index.php?'><img src='images/left-arrow.png'></a><h1>To-Do List </h1>	</div>
				<form  id='tasks'  method='post' >	
					<input type='hidden' id='mod' value='' name='modified'>		
					<input type='hidden' id='data' value='' name='data'>	
					<input type='hidden' id='kind' value='' name='kind'>	
					<ul id="tasklist">
						<?php
						// loop and print it.
						if(!empty($tasks_list)){
						 foreach ($tasks_list as $key => $value) {
							echo "<li><span></span>
							<input class='taskForm' type='text' id='".$value['task_id']."' onchange='". 'submitForm(this)'. "' value='". $value['title']."'></input>
							<div class='round'>
								<input type='checkbox' onchange='". 'submitForm(this)'. "' name='checkbox-" .$value['task_id']. "' id='checkbox-" . $value['task_id'] . "' " . (($value['status'] == 1) ? 'checked' : '') . " />
									<label for=checkbox-". $value['task_id']. "></label>
							</div></li>";
							};
						};
						?>
						
					</ul>
				</form>
			</div>
		  </div>
		</div>
	 	<div class='row nmargin'>
		  	<div class='col-md-12'>
		  	<form method='post'>	
		  		<div style='text-align: center;'><button id='addt' type='submit' class='addTask'><img src='images/Plus_button_small.png'></button>
		  		<input type="hidden" name="addnew" value='true'></div>

		  	</form>

		  	</div>
		</div>
	</div>

</body>


<script type="text/javascript">

//to avoid updating more than one row in the database, it only gets 1 ID, send it to a input
// and finally send it using post.
function submitForm(ele){
		document.getElementById("mod").value = ele.id;
		if(ele.type == "checkbox"){
			if(ele.checked == true){
				document.getElementById("data").value = 1;}
			else{ document.getElementById("data").value = 0;
			}
		}else{
			document.getElementById("data").value = ele.value;
		}
			document.getElementById('kind').value = ele.type;
		    $('#tasks').submit();

	}


</script>
</html>