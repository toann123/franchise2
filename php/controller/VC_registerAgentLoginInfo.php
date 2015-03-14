<?php
	session_start();
	require("../model/TC_Agent.php");
	if(isset($_POST['userid']) && isset($_POST['email']))
	{
		$tc_agent = new TC_Agent();
		
		$userid= $_POST['userid'];	
		$email= $_POST['email'];		
		$html_return = "";
		
		//call to create TeleConnect Agent login user
		$html_return = $tc_agent->createAccount($userid, $email);
		$html_return = trim($html_return);
		
		if($html_return == "<result>ok</result>" || $html_return == "<error>UserAlreadyExistsException</error>")
		{
			echo $tc_agent->getPassword();
		}	
		
	}		
	else {
		echo "<script type='text/javascript' language='JavaScript'>
					window.location = '../login.php';
			  </script>";
	}
?>