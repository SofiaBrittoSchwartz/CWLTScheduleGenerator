<?php
	
	load();

	function load()
	{
		$fileName = "../DataFiles/adminFormData1.json";
		$file = fopen($fileName, "r");
		$data = fread($file, filesize($fileName));

		echo "<script> console.log(".$data.");</script>";
	}
?>