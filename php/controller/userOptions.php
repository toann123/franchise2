<?php
	session_start();		
	require_once('../model/definition.php');
	require_once("../model/UserOption.php");
	if(isset($_SESSION['userid']))
	{
		$currentUserid = $_SESSION['userid'];
		$userop = UserOption::withUserID($currentUserid);
					
		if(isset($_POST['position']))
			$position = $_POST['position'];
		else
			$position = "";
			
		if(isset($_POST['name']))
			$name = $_POST['name'];
		else
			$name = "";
		
		if(isset($_POST['org']))
			$org = $_POST['org'];
		else
			$org = "";

		$result = $userop->setUserOptions($position,$name,$org);
		if($result != "")
			echo $result;
	}
	else {
		echo "<script type='text/javascript' language='JavaScript'>
					window.location = '".LOGIN_PAGE."';
			  </script>";
	}
?>
