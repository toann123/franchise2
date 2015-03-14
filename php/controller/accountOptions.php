<?php
	session_start();		
	require_once('../model/definition.php');
	require_once("../model/UserOption.php");
	if(isset($_SESSION['userid']))
	{
		$currentUserid = $_SESSION['userid'];
		$userop = UserOption::withUserID($currentUserid);
					
		if(isset($_POST['email']))
			$email = $_POST['email'];
		else
			$email = "";
			
		if(isset($_POST['tel']))
			$tel = $_POST['tel'];
		else
			$tel = "";

		$result = $userop->setAccountOptions($email,$tel);
		if($result != "")
			echo $result;
	}
	else {
		echo "<script type='text/javascript' language='JavaScript'>
					window.location = '".LOGIN_PAGE."';
			  </script>";
	}
?>
