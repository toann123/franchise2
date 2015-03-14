<?php
session_start();
require("../model/Activity.php");

if (isset($_SESSION['userid']) && isset($_SESSION["activity_id"])) 
{
	if($_SESSION["activity_id"] != ""){
		
		$Activity = new Activity();
		$activity_id = $_SESSION['activity_id'];
		$current_userid = $_SESSION['userid'];
		$html_return = $Activity->viewActivityDetails($current_userid,$activity_id);
		
		if($html_return != "")
		{
			echo $html_return;
		}
		
		//delete unused sesssion variable
		//unset($_SESSION["activity_id"]);
	}
} 
else {
	echo "<script type='text/javascript' language='JavaScript'>
					window.location = '../../login.php';
			  </script>";
}
?>
