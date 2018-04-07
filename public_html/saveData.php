<?php 

	// $schedule = json_decode($_GET['sched']);
	$data = $_GET['data'];

	echo save($data);

	function save($data)
	{
		// echo $schedule;
		echo " hello ";
		echo $data;
		
		$file = fopen("DataFiles/adminFormData1.json", "w"); 
		$text = '{ "schedule": [[-1, -1, -1, 0, 0, 0, 0, 0, -1, -1, -1, -1], [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],  [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],  [0, 0, 0, -1, 0, 0, 0, -1, 0, 0, 0, 0], [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0], [0, 0, 0, 0, 0, 0, 0, 0, -1, -1, -1, -1]]}';
		
		fwrite($file, $schedule); 
		// fwrite($file, 'This is it!'); 
		fwrite($file, $text); 
		fclose($file);
	}
	
?>