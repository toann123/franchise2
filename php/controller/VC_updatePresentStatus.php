<?php
	session_start();
	require("../model/VC.php");
	if(isset($_SESSION['vc']) && isset($_POST['vcid']) && isset($_POST['userid']) && isset($_POST['link']) && isset($_POST['present']))
	{
		$vc= new VC();
		
		$vcid= $_POST['vcid'];
		$userid= $_POST['userid'];			
		$link= $_POST['link'];
		$present= $_POST['present'];			
		
		//update present
		$vc->updatePresentStatus($vcid, $userid, $link, $present);
	}		
	else {
		echo "<script type='text/javascript' language='JavaScript'>
					window.location = '../login.php';
			  </script>";
	}
?>