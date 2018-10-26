<?php 
	/**
	 * Team class, Retrieve user data from the database
	 */
	class Team{

		private $name;

		function __construct(){
		}
		//reads the document and parse it, finally return the list of team that $name won agaisnt
		public function getWonAgaisnt($name){
			$csvFile = file('csv/sport-result.csv');
			//$data = file_get_contents('http://www.football-data.co.uk/mmz4281/1718/I1.csv');
			//$csvFile = explode("\n",$data);
			$data = [];
			foreach ($csvFile as $line) {
				$row = str_getcsv($line);
				if($row[2] == $name && $row[6] == 'H' ){
					if(!in_array($row[3], $data)){
					$data[] = $row[3];
					}
				}
				if($row[3] == $name && $row[6] =='A' ){
					if(!in_array($row[2], $data)){
						$data[] = $row[2];
					}
				}
			}
			return $data;
		}

	}
