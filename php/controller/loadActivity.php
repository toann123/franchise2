<?php
//require_once '../model/definition.php';
session_start();
require("../model/Activity.php");
if (isset($_SESSION['userid']) && $_POST['user_id']) 
{
	$Activity = new Activity();
	$userid = $_SESSION['userid'];
	$html_return = $Activity->loadActivity($userid);
	
	if($html_return != null || $html_return != "")
	{
		echo $html_return;
	}
} 
else {
	echo "<script type='text/javascript' language='JavaScript'>
					window.location = '".LOGIN_PAGE."';
			  </script>";
}
?>
