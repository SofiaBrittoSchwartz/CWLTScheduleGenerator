<?php
	
	load();

	function load()
	{
		$fileName = "../DataFiles/adminFormData.json";
		$file = fopen($fileName, "r");
		$data = fread($file, filesize($fileName));

		echo "<script> console.log(".$data.");</script>";
	}
?>