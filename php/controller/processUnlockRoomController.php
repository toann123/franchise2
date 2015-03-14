<?php
session_start();

require_once '../model/VC.php';

if(isset($_POST["vcid"]) && isset($_POST["moderator_id"])){
	$vcid = $_POST["vcid"];
	$moderator_id = $_POST["moderator_id"];
	
	$vc = new VC();
	$html_return = $vc->processUnlockVCRoom($vcid, $moderator_id);
	if($html_return != ""){
		echo $html_return;
	}
	
}else{
	echo "<script type='text/javascript' language='JavaScript'>
					window.location = '".LOGIN_PAGE."';
			  </script>";
}

?>
