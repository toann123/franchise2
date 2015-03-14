<?php

session_start();

if (isset($_POST["link"])) {
	
	require_once ("../model/VC.php");
	require_once ("../model/User.php");
	require_once ("../model/Channel.php");
	$link = $_POST["link"];

	//instantiate VC class
	$vc = new VC();
	
	$_SESSION["vc"] = $link;

	//get vcid
	$vcid = $vc -> get_vcid($link);

	//get moderator
	$vc -> get_moderator($vcid);

	//get participants
	$return_html = $vc -> getParticipants();

	$user = new User();
	$userid = $user -> getGuestUserIDBylink($link);

	//get moderator id
	$moderator_id = $vc -> get_moderatorIDFrom($link);

	$channel = new Channel();
	$channel_id = $channel -> getChannelIDByUserID($moderator_id);

	$present = $vc -> getPresent();

	//store javascript function call to create channel for new guest user
	$createChannel = "LogonAndBroadcast('$channel_id','$channel_id','uid:$present','$userid');";
	
	//get participant session variable
	$participant_list = "";
	if(isset($_SESSION["participants"])){
		$participant_list = $_SESSION["participants"];
	}

	$channel_html = "<input type='hidden' id='channel_id' value='$channel_id'/>";
	$present_html = "<input type='hidden' id='present' value='$present'/>";
	$userid_html = "<input type='hidden' id='userid' value='$userid'/>";
	$participant_html = "<input type='hidden' id='participant_list' value='$participant_list'/>";

	$return_html .= $channel_html . $present_html . $userid_html;
	if($return_html != ""){
		echo $return_html;
	} 
}
?>
