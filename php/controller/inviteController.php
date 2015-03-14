<?php
require_once '../model/Email.php';
require_once '../model/VC_Link.php';
require_once '../model/Activity.php';

class inviteController {

	// private $emailAddresses;
	// private $startTime;
	// private $duration;
	// private $from;
	// private $from_name;
	// private $subject;
	// private $link;
	// private $topic;
	// private $to;
	// private $to_name;

	// /**
	// * Constructs the inviteController object
	// * Creates the Array of Email Addresses
	// * Creates Subject based upon the user's name.
	// */
	// public function __constructor($emails,$startHour,$startMinute,$dur, $_from, $_from_name, $_link)
	// {
	// $this->emailAddresses = $this->getAllEmails($emails,",");
	// $this->startTime = $startHour . ":" . $startMinute;
	// $this->duration = $dur;
	// $this->from = $_from;
	// $this->from_name = $_from_name;
	// $this->subject = "Join a video conference with ".$from_name;
	// $this->link = $_link;
	// }
	//
	/**
	 * This method tasks a string and splits it by the delimiter and returns an Array.
	 * In this case it is used in order to split the list of Emails and return them as a
	 * Array for later processing.
	 * $emailAddresses: A String of emails seperated by the delimiter.
	 * $delimiter: the character seperating each email.
	 * Return: Array
	 */
	private function getAllEmails($emailAddresses, $delimiter) {
		$emails = "";
		if(!is_array($emailAddresses)){
			if(strstr($emailAddresses, ",")){
				$emailAddresses = str_replace(" ", '', $emailAddresses);
				$emails = explode($delimiter, $emailAddresses);
			}else{
				$emails = $emailAddresses;
			}
		}else{
			$emails = $emailAddresses;
		}
		
		
		return $emails;
	}

	/**
	 * This method taekes information relevant to the inivtation email and creates the email object and sends it.
	 * emails:		 a string of emails seperated by commas.
	 * startHour: 	the starting hour of the video conference.
	 * startMinute: the starting minute of the video conference
	 * dur: 		the duration of the video conference
	 * _from: 		the email of the inviter (person sending the invitations)
	 * _from_name: 	the name of the inviter (person sending the invitations)
	 * subject: 	the subject of the email.
	 * to_name: 	the name of the person receiving the email address.
	 * topic:		The topic of the video conference.
	 */
	public function sendAllMail($moderator_id, $emailList, $duration, $startHour, $startMinute, $start_date, $from, $from_name, $AMPM) {
		require_once ("../model/InviteEmail.php");

		date_default_timezone_set('Australia/Melbourne');
		$startTime = $startHour . ":" . $startMinute;
		$tmpTime = $this -> convertTime($startTime, $AMPM);
		$tmpStartTime = date('Y-m-d H:i:s', strtotime($this -> changeDate($start_date) . " " . $startTime . " " . $AMPM));

		$subject = "Join a video conference with $from_name at " . $startTime . " " . $AMPM . " on " . $start_date;

		$topic = $subject;

		$status = "new";
		$vcid = "";
		$VCObj = new VC_Link();
		$tmpTime = $this -> convertTime($startTime, $AMPM);
		$dbCreatedDate = date('Y-m-d H:i:s', time());

		$room_id = $VCObj -> getModerator_roomid($moderator_id);

		//insert new activity into database if status is new
		if ($status == "new") {
			$topic = "Join a video conference with " . $from_name . " at " . $startTime . " " . $AMPM . " on " . $start_date;
			$activityObj = new Activity();
			//insert activity into database
			$activityObj -> insertActivity($moderator_id, $topic, "VC", $emailList, $tmpStartTime, $duration, "new");

			//call function below to create new Video Conference entry and get "vcid" return
			$vcid = $VCObj -> create_VC($moderator_id, $room_id, $duration, $tmpStartTime, $dbCreatedDate, "", $topic);
		} 

		$emailList = $this -> getAllEmails($emailList, ",");

		for ($i = 0; $i < count($emailList); $i++) {
			$link = "";
			//echo $emailList[$i];

			//get participant userid (insert new user if email hasn't existed)
			$participant_userid = $VCObj -> getParticipant_Userid($emailList[$i]);

			//send all invitees an email based on activity updating status
			if ($status == "new") {
				//generate 'ripemd160' hash comprised of "vcid" and "userid"
				$link = $VCObj -> createVCAndLink($vcid, $participant_userid);
				$emailObj = new InviteEmail($emailList, $from, $from_name, $emailList[$i], $emailList[$i], $subject, $link, $topic, $duration, $start_date);
				$emailObj -> send_email(VC_PAGE);

				//insert participant into Video Conference entry
				$VCObj -> insert1Participant_toVC($vcid, $participant_userid, "", $link, "");
			} 

		}
	}

	//21-1-2013
	/*
	 * get removed participants from updated activity
	 */
	private function getRemovedParticipants($currList, $newList) {
		$removedParticipants = array();
		if (count($newList) > 0 && count($currList))
			$removedParticipants = array_diff($currList, $newList);

		return $removedParticipants;
	}

	/*
	 * get added participants from updated activity
	 */
	private function getAddedParticipants($currList, $newList) {
		$removedParticipants = array();
		if (count($newList) > 0 && count($currList))
			$removedParticipants = array_diff($newList, $currList);
		return $removedParticipants;
	}
	
	//4-2-2013
	public function getNewParticipantList($currentList, $addedList){
		if(!is_array($currentList)){
			if(strstr($currentList, ","))
				$currentList = explode(",", $currentList);
		}
		if(!is_array($addedList)){
			if(strstr($addedList, ","))
				$addedList = explode(",", $addedList);
		}
		$NewParticipantList = array();
		if (count($addedList) > 0 && count($currentList))
			$NewParticipantList = array_diff($currentList, $addedList);

		return $NewParticipantList;
	}

	public function UpdateAndSendAllMail($created_date, $vcid, $currentParticipantList, $moderator_id, $emailList, $duration, $startHour, $startMinute, $start_date, $from, $from_name, $AMPM, $activity_id, $status) {	date_default_timezone_set('Australia/Melbourne');
		//echo "VCID $vcid";
		$startTime = $startHour . ":" . $startMinute;
		$tmpTime = $this -> convertTime($startTime, $AMPM);
		$tmpStartTime = date('Y-m-d H:i:s', strtotime($this -> changeDate($start_date) . " " . $startTime . " " . $AMPM));

		//process for added Participant List
		$currentParticipantList1 = explode(",", $currentParticipantList);
		array_pop($currentParticipantList1);
		// echo "current Participants: ";
		// var_dump($currentParticipantList);
		//remove sender from participant email list

		$entire_email = explode(",", $emailList);
		$emailArrayList = explode(",", $emailList);
		array_pop($emailArrayList);
		// echo "emailLIst: ";
		 var_dump($entire_email);

		$addedParticipantList = $this -> getAddedParticipants($currentParticipantList1, $emailArrayList);
		// echo "addedParticipantList: ";
		 var_dump($addedParticipantList);
		if (count($addedParticipantList) > 0) {
			//call function to insert new entry for this activity and send email to this list
			$this -> loopThroughAddedEmailsAndSend($emailList, $vcid, $moderator_id, $startTime, $AMPM, $addedParticipantList, $from, $from_name, $duration, $start_date, "new", $activity_id);
		}

		//process for removed Participant
		$removedParticipantList = $this -> getRemovedParticipants($currentParticipantList1, $emailArrayList);
		// echo "removedParticipantList: ";
		 var_dump($removedParticipantList);
		if (count($removedParticipantList) > 0) {
			//call function to update entry of participants of this activity and send email to this list
			$this -> loopThroughRemovedEmailsAndSend($emailList, $vcid, $moderator_id, $startTime, $AMPM, $removedParticipantList, $from, $from_name, $duration, $start_date, "remove", $activity_id);
		}
		
		$oldParticipantList = $this->getNewParticipantList($currentParticipantList,$addedParticipantList);
		if(count($oldParticipantList) == 0){//in case old list is the same
			$oldParticipantList = $entire_email;
		}
		 echo "New list:   ";
		 var_dump($oldParticipantList);
		if ($status == "new") {
			require_once ("../model/InviteEmail.php");

			$subject = "Join a video conference with $from_name at " . $startTime . " " . $AMPM . " on " . $start_date;

			$topic = $subject;

			// insert VC and participants, send emails with hash link
			$this -> loopThroughCurrentEmailAndSend($entire_email, $created_date, $vcid, $tmpStartTime, $moderator_id, $startTime, $AMPM, $oldParticipantList, $from, $from_name, $subject, $topic, $duration, $start_date, $status);

			//send email and process for added participants

			//send email and process for removed participants

			$activityObj = new Activity();
			//insert activity into database
			$html_return = $activityObj -> updateActivity($moderator_id, $topic, "VC", $emailList, $tmpStartTime, $duration, $status, $activity_id);
			return $html_return;
		} elseif ($status == "active" || $status == "update") {
			require_once ("../model/UpdateEmail.php");

			$subject = $from_name . " has changed Conference session at " . $startTime . " " . $AMPM . " on " . $start_date;
			$topic = $subject;

			$this -> loopThroughCurrentEmailAndSend($entire_email, $created_date, $vcid, $tmpStartTime, $moderator_id, $startTime, $AMPM, $oldParticipantList, $from, $from_name, $subject, $topic, $duration, $start_date, "active");

			$activityObj = new Activity();
			//var_dump($emailList);
			//insert activity into database
			$html_return = $activityObj -> updateActivity($moderator_id, $topic, "VC", $emailList, $tmpStartTime, $duration, "active", $activity_id);

			return $html_return;
		} elseif ($status == "cancel") {
			require_once ("../model/CancelEmail.php");
			$subject = $from_name . " has Canceled Conference session at " . $startTime . " " . $AMPM . " on " . $start_date;
			$topic = $subject;

			$this -> loopThroughCurrentEmailAndSend($entire_email, $created_date, $vcid, $tmpStartTime, $moderator_id, $startTime, $AMPM, $oldParticipantList, $from, $from_name, $subject, $topic, $duration, $start_date, $status);

			$activityObj = new Activity();
			//insert activity into database
			$html_return = $activityObj -> updateActivity($moderator_id, $topic, "VC", $emailList, $tmpStartTime, $duration, $status, $activity_id);
			return $html_return;
		}
	}

	private function loopThroughCurrentEmailAndSend($entire_emailList, $created_date, $vcid, $tmpStartTime, $moderator_id, $startTime, $AMPM, $emailList, $from, $from_name, $subject, $topic, $duration, $start_date, $status) {

		$VCObj = new VC_Link();
		$tmpTime = $this -> convertTime($startTime, $AMPM);
		$dbCreatedDate = date('Y-m-d H:i:s', time());

		$room_id = $VCObj -> getModerator_roomid($moderator_id);

		//insert new activity into database if status is new
		if ($status != "new") {
			//call function to update r2_vcs
			$VCObj -> updateVCID($vcid, $duration, $tmpStartTime, $created_date, '1');
		}
		
		if(!is_array($emailList))
			$emailList = $this -> getAllEmails($emailList, ",");

		for ($i = 0; $i < count($emailList); $i++) {
			$link = "";
			//echo $emailList[$i];

			//get participant userid (insert new user if email hasn't existed)
			$participant_userid = $VCObj -> getParticipant_Userid($emailList[$i]);

			if ($status == "active") {

				//get previous Video conference link
				$link = $VCObj -> getVCLink($participant_userid, $vcid);
				//var_dump($link);
				$emailObj = new UpdateEmail($entire_emailList, $from, $from_name, $emailList[$i], $emailList[$i], $subject, $link, $topic, $duration, $start_date);
				$emailObj -> send_email(VC_PAGE);

				//var_dump($emailObj);
			} elseif ($status == "cancel") {
				$emailObj = new CancelEmail($entire_emailList, $from, $from_name, $emailList[$i], $emailList[$i], $subject, $link, $topic, $duration, $start_date);
				$emailObj -> send_email(VC_PAGE);
				//var_dump($emailObj);
			}

		}
	}

	//21-1-2013
	/*
	 * Append new participant entry for this activity and send new invite email to added participants
	 *
	 */
	private function loopThroughAddedEmailsAndSend($emailList, $vcid, $moderator_id, $startTime, $AMPM, $addedEmailList, $from, $from_name, $duration, $start_date, $status, $activity_id) {
		require_once ("../model/InviteEmail.php");
		$VCObj = new VC_Link();
		$tmpTime = $this -> convertTime($startTime, $AMPM);
		$dbCreatedDate = date('Y-m-d H:i:s', time());
		$tmpStartTime = date('Y-m-d H:i:s', strtotime($this -> changeDate($start_date) . " " . $startTime . " " . $AMPM));
		
		$emailList = $this -> getAllEmails($emailList, ",");
		
		$room_id = $VCObj -> getModerator_roomid($moderator_id);
		//var_dump($addedEmailList);
		foreach ($addedEmailList as $addedEmail) {
			$link = "";
			var_dump($addedEmailList);
			//get participant userid (insert new user if email hasn't existed)
			$participant_userid = $VCObj -> getParticipant_Userid($addedEmail);
			echo "added part: $participant_userid";
			//insert new activity into database if status is new
			if ($status == "new") {
				$topic = "Join a video conference with " . $from_name . " at " . $startTime . " " . $AMPM . " on " . $start_date;
				// $activityObj = new Activity();
				// //insert activity into database
				// $activityObj -> appendParticipantToActivity($participant_userid, $activity_id);

				//generate 'ripemd160' hash comprised of "vcid" and "userid"
				$link = $VCObj -> createVCAndLink($vcid, $participant_userid);
				$emailObj = new InviteEmail($emailList, $from, $from_name, $addedEmail, $addedEmail, $topic, $link, $topic, $duration, $start_date);
				$emailObj -> send_email(VC_PAGE);

				//insert participant into Video Conference entry
				$VCObj -> insert1Participant_toVC($vcid, $participant_userid, "", $link, "");
			}
		}
	}

	/*
	 * Update removed participants from this activity, mark inactive and send removed email template
	 */
	private function loopThroughRemovedEmailsAndSend($emaillist, $vcid, $moderator_id, $startTime, $AMPM, $removedParticipantList, $from, $from_name, $duration, $start_date, $status, $activity_id) {
		require_once ("../model/RemoveEmail.php");
		$VCObj = new VC_Link();
		$tmpTime = $this -> convertTime($startTime, $AMPM);
		$dbCreatedDate = date('Y-m-d H:i:s', time());
		
		$emailList = $this -> getAllEmails($emaillist, ",");

		$room_id = $VCObj -> getModerator_roomid($moderator_id);
		echo "removed email list";
		var_dump($removedParticipantList);
		if (count($removedParticipantList) > 0) {
			foreach ($removedParticipantList as $removedEmail) {
				$link = "";
				//echo $emailList[$i];

				//get participant userid (insert new user if email hasn't existed)
				$participant_userid = $VCObj -> getParticipant_Userid($removedEmail);
				echo $participant_userid;
				//update participant infor based on activity id
				if ($status == "remove") {
					$topic = $from_name . " has removed Video conference with you at " . $startTime . " " . $AMPM . " on " . $start_date;
					// $activityObj = new Activity();
					// //remove activity into database
					// $activityObj -> removedParticipantFromActivity($moderator_id, $activity_id);

					//remove participant from VC
					$VCObj -> remove1Participant_fromVC($vcid, $participant_userid);

					//call function to deactivate VC from db
					$VCObj -> deactiveParticipantVC($vcid, $removedEmail);

					$emailObj = new RemoveEmail($emailList, $from, $from_name, $removedEmail, $removedEmail, $topic, $link, $topic, $duration, $start_date);
					$emailObj -> send_email(VC_PAGE);
					//var_dump($emailObj);
				}
			}
		}

	}

	private function convertTime($startTime, $AMPM) {
		$temp = strtotime($startTime . " " . $AMPM);
		//echo "		TMP		" . $temp;
		return $temp;
	}

	private function changeDate($date) {
		$dateArray = explode("/", $date);
		if (count($dateArray) == 3) {
			$tmpDate = $dateArray[2] . "-" . $dateArray[1] . "-" . $dateArray[0];
			//yyyy-mm-dd;
			return $tmpDate;
		} else {
			return false;
		}
	}

}
?>
