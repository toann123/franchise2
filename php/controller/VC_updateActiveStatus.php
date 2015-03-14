<?php
	session_start();
	require("../model/VC.php");
	if(isset($_SESSION['vc']) && isset($_POST['vcid']) && isset($_POST['moderator_id']) && isset($_POST['active']))
	{
		$vc= new VC();
		
		$vcid= $_POST['vcid'];
		$moderator_id= $_POST['moderator_id'];			
		$active= $_POST['active'];		
		
		//update present
		$vc->updateActiveStatus($vcid, $moderator_id, $active);
	}		
	else {
		echo "<script type='text/javascript' language='JavaScript'>
					window.location = '../login.php';
			  </script>";
	}
?>