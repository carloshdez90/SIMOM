<?php

	$max=$_REQUEST['max'];
	include('sensor.php');
	$valores = new temperatura();
	$valores->lectura($max);
	
?>
