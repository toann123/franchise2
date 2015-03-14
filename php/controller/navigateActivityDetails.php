<?php
session_start();
require("../model/Activity.php");

if (isset($_SESSION['userid']) && isset($_POST["activity_id"]) && isset($_POST["action"]) ) 
{
	if($_POST["activity_id"] != "")
	{
		$_SESSION["activity_id"] = $_POST["activity_id"];
		$_SESSION["action"] = $_POST["action"];
		echo "done";
	}
} 
else {
	echo "<script type='text/javascript' language='JavaScript'>
					window.location = '../../login.php';
			  </script>";
}
?>
