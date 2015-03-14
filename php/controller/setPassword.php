<?php
	session_start();		
	require_once('../model/definition.php');
	require_once("../model/UserOption.php");
	if(isset($_SESSION['userid']))
	{
		$currentUserid = $_SESSION['userid'];
		$userop = UserOption::withUserID($currentUserid);
					
		if(isset($_POST['pw']))
			$pw = $_POST['pw'];
		else
			$pw = "";
			
		$result = $userop->setPassword($pw);
		if($result != "")
			echo $result;
	}
	else {
		echo "<script type='text/javascript' language='JavaScript'>
					window.location = '".LOGIN_PAGE."';
			  </script>";
	}
?>
