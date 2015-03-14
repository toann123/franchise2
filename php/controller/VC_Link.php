<?php
require_once ("../model/DBConnect.php");
require_once ("../model/Email.php");
require_once ('../model/User.php');
require_once ('../model/Channel.php');

class VC_Link {
	private $room_id;
	private $vcid;
	private $participant_id;
	private $moderator_id;
	private $link;
	private $db;

	public function __construct() {
		$this -> link = "";
		$this -> room_id = "";
		$this -> vcid = "";
		$this -> participant_id = "";
		$this -> moderator_id = "";
		$this -> db = new DBConnect();
	}

	/*
	 * 	5-12-2012
	 *  Start - Support functions for primary function "insertActivity" from Activity class
	 */

	/*
	 * 	12-12-2012
	 *  @param: $db - database connection
	 * @param: $moderator_id - user id of room owner / sender of emails
	 * @param: $rev_email - an array of receiving email addresses (include sender itself)
	 * @param: $attachment_list - list of attachment files from the invitation (not implement now)
	 * @param: $topic - invitation message or title
	 */

	public function createVCAndLink($moderator_id, $emailList, $duration, $startTime, $created_date, $from, $from_name, $AMPM, $status) {
		if ($status == "new") {
			date_default_timezone_set('Australia/Melbourne');
			//echo "	Created Date	";
			$dbCreatedDate = date('Y-m-d H:i:s', time());
			//echo $dbCreatedDate;

			$tmpTime = $this -> convertTime($startTime, $AMPM);
			//echo "		tmptime		";
			//echo $tmpTime;
			$tmpStartTime = date('Y-m-d H:i:s', strtotime($this -> changeDate($created_date) . " " . $startTime . " " . $AMPM));
			//hh:mm
			//dd/mm/yyyy
			//echo "	Start Time	";
			//echo $tmpStartTime;

			$this -> room_id = $this -> getModerator_roomid($this -> db, $moderator_id);
			//echo "Room ID";
			//echo $this -> room_id;
			$subject = $from_name . " has changed Conference session at " . $startTime . " " . $AMPM . " on " . $created_date;
			$topic = $subject;
			//for now
			//call function below to create new Video Conference entry and get "vcid" return
			$this -> vcid = $this -> create_VC($this -> db, $moderator_id, $this -> room_id, $duration, $tmpStartTime, $dbCreatedDate, "", $topic);
			//echo "vcid";
			//echo $this -> vcid;

			for ($i = 0; $i < count($emailList); $i++) {
				//get participant userid (insert new user if email hasn't existed)
				$participant_userid = $this -> getParticipant_Userid($this -> db, $emailList[$i]);

				//generate 'ripemd160' hash comprised of "vcid" and "userid"
				$link = hash('ripemd160', $this -> vcid . $participant_userid);
				$link = base64_encode($link);

				//insert participant into Video Conference entry
				$this -> insert1Participant_toVC($this -> db, $this -> vcid, $participant_userid, "", $link, "");

				//call private function to send email (with attachments) to entire people in list
				//should change to Email constructor call
				//$this->send_email($sender_email, $sender_name, $rev_email[$i], $rev_email[$i], "subject", "body", "altBody", $attachment_list, $link, $topic);

				$emailObj = new Email($from, $from_name, $emailList[$i], $emailList[$i], $subject, $link, $topic, $duration, $created_date);
				//send all invitees an email
				$emailObj -> send_email();
			}
		} elseif ($status == "cancel") {
			date_default_timezone_set('Australia/Melbourne');
			//echo "	Created Date	";
			$dbCreatedDate = date('Y-m-d H:i:s', time());
			//echo $dbCreatedDate;

			$tmpTime = $this -> convertTime($startTime, $AMPM);
			//echo "		tmptime		";
			//echo $tmpTime;
			$tmpStartTime = date('Y-m-d H:i:s', strtotime($this -> changeDate($created_date) . " " . $startTime . " " . $AMPM));
			//hh:mm
			//dd/mm/yyyy
			//echo "	Start Time	";
			//echo $tmpStartTime;

			$this -> room_id = $this -> getModerator_roomid($this -> db, $moderator_id);
			//echo "Room ID";
			//echo $this -> room_id;
			$subject = $from_name . " has <b style='color: #b94a48'>Canceled</b> Conference session at " . $startTime . " " . $AMPM . " on " . $created_date;
			$topic = $subject;
			//for now
			//call function below to create new Video Conference entry and get "vcid" return
			//$this -> vcid = $this -> create_VC($this -> db, $moderator_id, $this -> room_id, $duration, $tmpStartTime, $dbCreatedDate, "", $topic);
			//echo "vcid";
			//echo $this -> vcid;

			for ($i = 0; $i < count($emailList); $i++) {
				//get participant userid (insert new user if email hasn't existed)
				$participant_userid = $this -> getParticipant_Userid($this -> db, $emailList[$i]);

				//generate 'ripemd160' hash comprised of "vcid" and "userid"
				$link = hash('ripemd160', $this -> vcid . $participant_userid);
				$link = base64_encode($link);

				//insert participant into Video Conference entry
				//$this -> insert1Participant_toVC($this -> db, $this -> vcid, $participant_userid, "", $link, "");

				//call private function to send email (with attachments) to entire people in list
				//should change to Email constructor call
				//$this->send_email($sender_email, $sender_name, $rev_email[$i], $rev_email[$i], "subject", "body", "altBody", $attachment_list, $link, $topic);

				$emailObj = new Email($from, $from_name, $emailList[$i], $emailList[$i], $subject, $link, $topic, $duration, $created_date);
				//send all invitees an email
				$emailObj -> send_cancel_email();
			}
		}

		// //generate 'ripemd160' hash comprised of "vcid" and "userid"
		// $link = hash('ripemd160', $this -> vcid . $moderator_id);
		// $link = base64_encode($link);
		// $email = new Email($from, $from_name, $from, $from, $subject, $link, $topic, $duration, $created_date);
		// //send one email to the orginator of the conference

	}

	public function changeDate($date) {
		$dateArray = explode("/", $date);
		if (count($dateArray) == 3) {
			$tmpDate = $dateArray[2] . "-" . $dateArray[1] . "-" . $dateArray[0];
			//yyyy-mm-dd;
			return $tmpDate;
		} else {
			return false;
		}
	}

	private function convertTime($startTime, $AMPM) {
		$temp = strtotime($startTime . " " . $AMPM);
		echo "		TMP		" . $temp;
		return $temp;
	}

	/*
	 * Get moderator roomid
	 * @param: $db - database connection object
	 * @param: $moderator_id
	 * @return: $return_roomid - moderator room id
	 */
	public function getModerator_roomid($db, $moderator_id) {
		$return_roomid = "";
		if (!$db -> getDBConnect()) {
			echo 'ERROR: Could not connect to the database.';
		} else {

			//get room id of moderator
			$sql_getid = "select vidyo_id from users where id = '$moderator_id';";
			echo $sql_getid;

			$query_getid = $db -> getDBConnect() -> query($sql_getid);
			while ($result_getid = $query_getid -> fetch_object()) {
				$return_roomid = $result_getid -> vidyo_id;
			}

		}

		return $return_roomid;
	}

	/*
	 * Create a new Video Conference schedule with room id, start date and time and insert it into "r2_vcs" tables
	 * select new recent added id to return
	 * @param: $db - database connection object
	 * @param: $moderator_id - id of morderator who owns this room and sends invitation
	 * @param: $roomid - room id of owner (moderator)
	 * @param: $duration - duration of Video Conference
	 * @param: $start - datetime that Video Conference commences
	 * @param: $created - datetime that this activity is created
	 * @param: $active - set to 1 (default) for active VC's, 0 for de-activated VC's
	 * @param: $note - the note entered by the moderator when inviting the participants - in case it would be conference title
	 * @return: $return_vcid - recent added video conference id
	 */
	public function create_VC($db, $moderator_id, $roomid, $duration, $start, $created, $active, $note) {
		$return_vcid = "";
		if (!$db -> getDBConnect()) {
			echo 'ERROR: Could not connect to the database.';
		} else {
			//query to insert new Video Conference entry
			$sql_insert = "insert into r2_vcs(id, moderator, roomid, duration, start, created, active, note)
						   values(NULL, '$moderator_id', '$roomid', '$duration', '$start', '$created', '1', NULL)";

			//insert
			$query = $db -> getDBConnect() -> query($sql_insert);

			//get recent added video conference id
			$sql_getid = "select id from r2_vcs 
						  where moderator = '$moderator_id'
						  and roomid = '$roomid'
						  and duration = '$duration'
						  and start = '$start'
						  and created = '$created'
						  and active = '1'";
			$query_getid = $db -> getDBConnect() -> query($sql_getid);
			while ($result_getid = $query_getid -> fetch_object()) {
				$return_vcid = $result_getid -> id;
			}
		}
		return $return_vcid;
	}

	/*
	 * Insert new user as entered guest email for sending invitation into "users" table	 *
	 * @param: $db - database connection object
	 * @param: $email - entered guest email	 *
	 * @return: $userid - userid of matching $email address in "users" table
	 */
	public function getParticipant_Userid($db, $email) {
		$return_id = "";
		if (!$db -> getDBConnect()) {
			echo 'ERROR: Could not connect to the database.';
		} else {
			$email = trim($email);
			//query to check whether this email has already existed in database or not
			$sql = "select count(*) as countUser from users where email = '$email';";

			$query = $db -> getDBConnect() -> query($sql);

			if ($query && $query -> num_rows > 0) {//if it does not exist
				if ($query -> fetch_object() -> countUser == 0) {
					$sql_insert = "insert into users(id, name, org, email, tel, registered, lastaccess, roleid, active, login, available, api_access, api_key, 
							   recording, vcid, ip, vidyo_id, vidyo_link, vidyo_name, tenantid)
							   values(NULL, NULL, NULL, '$email', '', NULL, NULL, NULL,  1, 0, 0, NULL, NULL, 0, 0, NULL, 0, NULL, NULL, 0)";
					//insert
					$db -> getDBConnect() -> query($sql_insert);
				}
			}

			//get id of matching email of recent-inserted or inserted user
			$sql_getid = "select id from users where email = '$email';";

			$query_getid = $db -> getDBConnect() -> query($sql_getid);
			while ($result_getid = $query_getid -> fetch_object()) {
				$return_id = $result_getid -> id;

				//10-12-2012
				//instantiate User object to insert new jWebsocket username for guest user
				$user = new User();
				$user -> insertGuestUser($return_id, $email, "");

				//instantiate Channel object to insert new jWebsocket channel for guest user
				$channel = new Channel();
				$channel -> createChannel($return_id, $return_id, $return_id, $return_id, '1');
			}

		}

		return $return_id;
	}

	/*
	 * Insert one participant that will join to passing Video Conference ID parameter
	 * @param: $vcid - the id number of the VC
	 * @param: $userid - the id number of the user participating in the VC (includes the moderator!)
	 * @param: $present - 0=hansn't clicked on link, 1=clicked onlink, 2=talking to assistant, 3=in Vidyo room
	 * @param: $link - the unique link emailed to the participant (hash of vcid and userid) - hash using 'ripemd160' encoding method
	 * @param: $active - default 1 means active, 0 means no longer active (invalidates link)
	 */
	public function insert1Participant_toVC($db, $vcid, $userid, $present, $link, $active) {
		if (!$db -> getDBConnect()) {
			echo 'ERROR: Could not connect to the database.';
		} else {
			//query to insert a participant into "r2_participants" table
			$sql_insert = "insert into r2_participants(vcid, userid, present, link, active)
						   values('$vcid', '$userid', '0', '$link', '1')";

			//insert
			$query = $db -> getDBConnect() -> query($sql_insert);

			if ($query)
				return true;
			else
				return false;
		}
		return false;
	}

	/*
	 * 	5-12-2012
	 *  End - Support functions for primary function "insertActivity" above
	 */
	//3/12/2012
	private function send_email($from, $from_name, $to, $to_name, $subject, $body, $altBody, $attachfiles, $link, $topic) {
		require_once 'phpmailer/class.phpmailer.php';

		$mail = new PHPMailer(true);
		//defaults to using php "mail()"; the true param means it will throw exceptions on errors, which we need to catch

		try {
			$mail -> AddAddress($to, $to_name);
			$mail -> SetFrom($from, $from_name);
			$mail -> AddReplyTo('mihn.nguyen@keytrust.com.au', 'First Last');
			$mail -> Subject = $topic;
			$mail -> AltBody = 'To view the message, please use an HTML compatible email viewer!';
			// optional - MsgHTML will create an alternate automatically
			$mail -> IsHTML(true);
			//$mail->MsgHTML(file_get_contents('../class/contents.html'));
			$mail -> Body = "
		  
			<div style=\"width: 640px; font-family: Arial, Helvetica, sans-serif; font-size: 11px;\">
			<div align=\"center\"><h1>Video Conference</h1></div><br>
			<br/>
			You are invited to Video Conference
			<br />
			Title: $topic
			<br />
			Here is link to access: <a href='https://ccn.keytrust.com.au/portal/vcsession.php?link=$link'>https://ccn.keytrust.com.au/portal/vcsession.php</a>
			
			
			<p class=MsoNormal style='mso-margin-top-alt:auto;mso-margin-bottom-alt:auto'>
				<b><span style='font-size:24.0pt;font-family:\"Tw Cen MT Condensed Extra Bold\",\"sans-serif\";color:blue;mso-fareast-language:EN-AU'>KeyTrust</span></b>
				<b><span style='mso-fareast-language:EN-AU'><br></span></b>
				<span style='font-size:7.5pt;font-family:\"MS Sans Serif\",\"serif\";mso-fareast-language:EN-AU'>Trusted e-Business Solutions</span>
				<span style='font-size:7.5pt;font-family:\"Microsoft Sans Serif\",\"sans-serif\";mso-fareast-language:EN-AU'><br></span>
				<span style='font-size:7.5pt;font-family:\"MS Sans Serif\",\"serif\";mso-fareast-language:EN-AU'>Melbourne&nbsp; -&nbsp; Sydney&nbsp; -&nbsp; Canberra</span>
				<span style='font-size:7.5pt;font-family:\"Microsoft Sans Serif\",\"sans-serif\";mso-fareast-language:EN-AU'><br></span>
				<span style='font-size:7.5pt;font-family:\"MS Sans Serif\",\"serif\";mso-fareast-language:EN-AU'>E-mail:&nbsp;
					<span style='color:blue'>&nbsp;</span>
						<span style='color:black'>
							<a href=\"blocked::mailto:support@KeyTrust.com.au\">
							<span style='color:blue'>support@KeyTrust.com.au</span>
							</a>
						</span>
				</span>
				<span style='font-size:7.5pt;font-family:\"Microsoft Sans Serif\",\"sans-serif\";mso-fareast-language:EN-AU'><br></span>
				<span style='font-size:7.5pt;font-family:\"MS Sans Serif\",\"serif\";mso-fareast-language:EN-AU'>Web:</span>
				<span style='font-size:7.5pt;font-family:\"Microsoft Sans Serif\",\"sans-serif\";mso-fareast-language:EN-AU'> </span>
				<span style='font-size:7.5pt;font-family:\"MS Sans Serif\",\"serif\";color:blue;mso-fareast-language:EN-AU'>
					<a href=\"blocked::http://www.keytrust.com.au/\">
						<span style='color:blue'>http://www.KeyTrust.com.au</span>
					</a>
				</span>
				<span style='mso-fareast-language:EN-AU'><br></span>
				<span style='font-size:7.5pt;font-family:\"MS Sans Serif\",\"serif\";mso-fareast-language:EN-AU'>---------------------------------------------</span>
				<span style='mso-fareast-language:EN-AU'><o:p></o:p></span>
			</p>
			<p class=MsoNormal><o:p>&nbsp;</o:p></p>
			
			</div> 
				  ";

			//process attachments
			if ($attachfiles != null || $attachfiles != "") {
				foreach ($attachfiles as $link) {
					$mail -> AddAttachment($this -> strip_attachfiles_url($link));
					// attachment
				}
			}

			var_dump($mail);
			$mail -> Send();
			echo "Message Sent OK</p>\n";
		} catch (phpmailerException $e) {
			echo $e -> errorMessage();
			//Pretty error messages from PHPMailer
		} catch (Exception $e) {
			echo $e -> getMessage();
			//Boring error messages from anything else!
		}
	}

}
?>
