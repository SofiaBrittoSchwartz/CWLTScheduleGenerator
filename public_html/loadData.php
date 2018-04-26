<?php
	
	load();

	function load()
	{
		$fileName = "../DataFiles/adminSchedule.json";
		$file = fopen($fileName, "r");
		$data = fread($file, filesize($fileName));

		echo "<script> console.log(".$data.");</script>";
	}
?>