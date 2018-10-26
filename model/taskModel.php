<?php 
	/**
	 * task class, Retrieve user data from the database
	 */
	class Task{

		private $title;
		private $done;
		private $db;
		private $task_id;
		private $user_id;
		private $tasks;
		function __construct($mdb = NULL){
			if($mdb == NULL)
				throw new Exception("User: Database obj invalid ", 1);
			$this->db = &$mdb;

		}

		public function setTitle($name){
			$this->title = $name;
		}
		public function setUser($user){
			$this->user_id = $user;
		}
		public function setStatus($done){
			$this->status = $status;
		}
		//update the task, depending if checkbox was modified or the title.
		public function update(){
			if($_POST['kind'] == "text"){
				$query =$this->db->prepare( "UPDATE `tasks` SET title=? WHERE task_id=?");	
				$query->execute([$_POST['data'], $_POST['modified']]);

			}else{
				$id = explode("-", $_POST['modified']); 
				$query =$this->db->prepare( "UPDATE `tasks` SET status=? WHERE task_id=?");
				$query->execute([$_POST['data'], $id[1]]);

			}

		}
		public function createTask($user_id){   
			$query = $this->db->prepare("INSERT INTO `tasks` (`task_id`, `title`, `status`, `user_id`) VALUES (NULL,'Insert New Task...' , 0, ?)");
			$query->bindParam(1, $user_id);
			$query->execute();
		}
		//get task according to an user ID
		public function getTaskList(){
			$query = $this->db->prepare( 'SELECT * FROM tasks WHERE user_id = ?');
			if ($query->execute(array($this->user_id))) {
				while ($row = $query->fetch()) {
					$this->tasks[] = $row;
				}
			}
			
			return $this->tasks;
		}
		//print task list in a smaller version
		public function printTaskListThumb(){
				$cont = 0;
				echo "<ul>";
				foreach ($this->tasks as $key => $value) {
					if($cont < 3){
					echo "<li><a href='index.php?controller=task'><span></span>
							<input class='taskForm task-dash' type='text'  value='". $value['title']."' disabled></input>
							<div class='round round-sm'>
								<input type='checkbox'" . (($value['status'] == 1) ? 'checked' : '') . " />
									<label for=checkbox-". $value['task_id']. "></label>
							</div></a></li>";
							$cont++;
					}else{break;};
				}
				echo "</ul>";


		}

	}
