<?php
session_start();

require_once '../model/VC.php';

if(isset($_POST["vcid"]) && isset($_POST["moderator_id"]) && isset($_POST["current_userid"])){
	$vcid = $_POST["vcid"];
	$moderator_id = $_POST["moderator_id"];
	$current_userid = $_POST["current_userid"];
	
	$vc = new VC();
	$html_return = $vc->checkLockVCRoom($vcid, $moderator_id, $current_userid);
	if($html_return != ""){
		echo $html_return;
	}
	
}else{
	echo "<script type='text/javascript' language='JavaScript'>
					window.location = '".LOGIN_PAGE."';
			  </script>";
}

?>
