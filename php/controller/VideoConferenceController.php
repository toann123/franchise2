<?php
require_once '../model/VideoConference.php';
require_once '../model/DBConnect.php';
require_once '../model/User.php';

class VideoConferenceController
{
	private $db;
	
	public function __construct()
	{
		$this->db = new DBConnect();
	}
	
	public function insertVC($sT, $dtCreated, $modNote, $modID, $rID, $dur )
	{
		$vc = new VideoConference($sT, $dtCreated, $modNote, $modID, $rID, $dur);
		$this->insertVCToDatabase($vc);
	}
	
	private function insertVCToDatabase($vc)
	{
			//query to insert new Video Conference entry
			$sql_insert = "insert into r2_vcs(id, moderator, roomid, duration, start, created, active, note)
						   values(NULL, '$vc->getModID()', '$vc->getRoomID', '$vc->getDuration()', '$vc->getStartTime()', '$vc->getCreated()', '1', NULL)";
			
			//insert into database		   
			$query = $this->db->getDBConnect() -> query($sql_insert);
			
			//get most recent added video conference id
			$sql_getid = "select id from r2_vcs 
						  where moderator = '$vc.getModID()'
						  and roomid = '$vc.getRoomID'
						  and duration = '$vc.getDuration()'
						  and start = '$vc.getStartTime()'
						  and created = '$vc.getCreated()'
						  and active = '1'";
			$query_getid = $this->db->getDBConnect() -> query($sql_getid);
			while ($result_getid = $query_getid -> fetch_object())
			{
				$return_vcid = $result_getid->id;
			}
		return $return_vcid;
	}
	
}







// if($query_get_info)
				// {
					// //5-12-2012
					// $roomid = $this->getModerator_roomid($db, $currentuserid);
					// //call function below to create new Video Conference entry and get "vcid" return
					// $vcid = $this->create_VC($db, $currentuserid, $roomid, $duration, $start, $created_date, "", $topic);
// 							
					// $info ="";	
					// while ($result = $query_get_info ->fetch_object()) 
					// {
						// $channelid = trim($result->channel_id);		
						// $sender_name = $result->sender;
						// $sender_email = $result->sender_email;		
// 						
						// $info .= $channelid.','.$result->access_key.','.$result->access_secret.','.$result->rev_name.','.$result->sender.','.$activityid.','.$attachFiles_info.";";
// 																		
						// //5-12-2012
						// //get participant userid (insert new user if email hasn't existed)
						// $participant_userid = $this->getParticipant_Userid($db, $currentuserid);
// 						
						// //generate 'ripemd160' hash comprised of "vcid" and "userid"
						// $link = hash('ripemd160', $vcid . $currentuserid);
						// $link = base64_encode($link);
// 						
						// //insert participant into Video Conference entry
						// $this->insert1Participant_toVC($db, $vcid, $currentuserid, "", $link, "");
// 						
						// //3/12/2012	- will be re-enable when real implementing system for sending email to actual member-users
						// //call private function to send email (with attachments) to entire people in list   (***********include this sender as well)										
						// //$this->send_email($result->sender_email, $result->sender, $result->rev_email, $result->rev_name, "subject", "body", "altBody", $attachment_list, $link, $topic);
						// //var_dump($result->sender_email, $result->sender, $result->rev_email, $result->rev_name, "subject", "body", "altBody", $attachment_list);						
					// }
// 					
					// //sending email for non-users
					// for($i = 0; $i < count($invitation_to); $i++)				
					// {
						// if(!is_numeric($invitation_to[$i]))
						// {
							// //5-12-2012
							// //get participant userid (insert new user if email hasn't existed)
							// $participant_userid = $this->getParticipant_Userid($db, $invitation_to[$i]);
// 							
							// //generate 'ripemd160' hash comprised of "vcid" and "userid"
							// $link = hash('ripemd160', $vcid . $participant_userid);
							// $link = base64_encode($link);
// 							
							// //insert participant into Video Conference entry
							// $this->insert1Participant_toVC($db, $vcid, $participant_userid, "", $link, "");
// 							
							// //call private function to send email (with attachments) to entire people in list						
							// $this->send_email($sender_email, $sender_name, $invitation_to[$i], $invitation_to[$i], "subject", "body", "altBody", $attachment_list, $link, $topic);
							// //var_dump($sender_email, $sender_name, $invitation_to[$i], $invitation_to[$i], "subject", "body", "altBody", $attachment_list);				
						// }								
					// }
// 					
					// $html_return .= preg_replace("/[\n\r]/","",$info) . "\n";
// 					
				// } 
			// }
// 
		// }
// 			
		// $db->close();








/*
	 * 	5-12-2012	 
	 *  Start - Support functions for primary function "insertActivity" above
	 */
		
	/*
	 * Get moderator roomid 
	 * @param: $db - database connection object
	 * @param: $moderator_id
	 * @return: $return_roomid - moderator room id
	 */	
	// private function getModerator_roomid($db, $moderator_id)
	// {
		// $return_roomid = "";
		// if (!$db->getDBConnect()) {
			// echo 'ERROR: Could not connect to the database.';
		// } else {
// 						
			// //get room id of moderator
			// $sql_getid = "select vidyo_id from users where id = '$moderator_id';";				
// 			
			// $query_getid = $db->getDBConnect() -> query($sql_getid);
			// while ($result_getid = $query_getid -> fetch_object())
			// {
				// $return_roomid = $result_getid->vidyo_id;
			// }
// 				
		// }
// 		
		// return $return_roomid;
	// }	
	// /*
	 // * Create a new Video Conference schedule with room id, start date and time and insert it into "r2_vcs" tables
	 // * select new recent added id to return
	 // * @param: $db - database connection object
	 // * @param: $moderator_id - id of morderator who owns this room and sends invitation
	 // * @param: $roomid - room id of owner (moderator)
	 // * @param: $duration - duration of Video Conference
	 // * @param: $start - datetime that Video Conference commences
	 // * @param: $created - datetime that this activity is created
	 // * @param: $active - set to 1 (default) for active VC's, 0 for de-activated VC's
	 // * @param: $note - the note entered by the moderator when inviting the participants - in case it would be conference title
	 // * @return: $return_vcid - recent added video conference id
	 // */
	// private function create_VC($db, $moderator_id, $roomid, $duration, $start, $created, $active, $note)
	// {
		// $return_vcid = "";
		// if (!$db->getDBConnect()) {
			// echo 'ERROR: Could not connect to the database.';
		// } else {
			// //query to insert new Video Conference entry
			// $sql_insert = "insert into r2_vcs(id, moderator, roomid, duration, start, created, active, note)
						   // values(NULL, '$moderator_id', '$roomid', '$duration', '$start', '$created', '1', NULL)";
// 			
			// //insert			   
			// $query = $db->getDBConnect() -> query($sql_insert);
// 			
			// //get recent added video conference id
			// $sql_getid = "select id from r2_vcs 
						  // where moderator = '$moderator_id'
						  // and roomid = '$roomid'
						  // and duration = '$duration'
						  // and start = '$start'
						  // and created = '$created'
						  // and active = '1'";
			// $query_getid = $db->getDBConnect() -> query($sql_getid);
			// while ($result_getid = $query_getid -> fetch_object())
			// {
				// $return_vcid = $result_getid->id;
			// }
		// }
		// return $return_vcid;
	// }
// 	
	// /*
	 // * Insert new user as entered guest email for sending invitation into "users" table	 * 
	 // * @param: $db - database connection object
	 // * @param: $email - entered guest email	 * 
	 // * @return: $userid - userid of matching $email address in "users" table
	 // */	
	// private function getParticipant_Userid($db, $email)
	// {
		// $return_id = "";
		// if (!$db->getDBConnect()) {
			// echo 'ERROR: Could not connect to the database.';
		// } else {
			// $email = trim($email);
			// //query to check whether this email has already existed in database or not
			// $sql = "select count(*) from users where email = '$email';";
// 	
			// $query = $db->getDBConnect() -> query($sql);
// 			
			// if ($query && $query -> num_rows < 0) {	//if it does not exist
				// $sql_insert = "insert into users(id, name, org, email, tel, registered, lastaccess, roleid, active, login, available, api_access, api_key, 
							   // recording, vcid, ip, vidyo_id, vidyo_link, vidyo_name, tenantid)
							   // values(NULL, NULL, NULL, '$email', '', NULL, NULL, NULL,  1, 0, 0, NULL, NULL, 0, 0, NULL, 0, NULL, NULL, 0)";
				// //insert			   
				// $db->getDBConnect() -> query($sql_insert);
			// }
// 			
			// //get id of matching email of recent-inserted or inserted user
			// $sql_getid = "select id from users where email = '$email';";
// 				
			// $query_getid = $db->getDBConnect() -> query($sql_getid);
			// while ($result_getid = $query_getid -> fetch_object())
			// {
				// $return_id = $result_getid->id;
			// }
// 				
		// }
// 		
		// return $return_id;
	// }
// 
	// /*
	 // * Insert one participant that will join to passing Video Conference ID parameter
	 // * @param: $vcid - the id number of the VC
	 // * @param: $userid - the id number of the user participating in the VC (includes the moderator!)
	 // * @param: $present - 0=hansn't clicked on link, 1=clicked onlink, 2=talking to assistant, 3=in Vidyo room
	 // * @param: $link - the unique link emailed to the participant (hash of vcid and userid) - hash using 'ripemd160' encoding method
	 // * @param: $active - default 1 means active, 0 means no longer active (invalidates link)
	 // */
	// private function insert1Participant_toVC($db, $vcid, $userid, $present, $link, $active)
	// {		
		// if (!$db->getDBConnect()) {
			// echo 'ERROR: Could not connect to the database.';
		// } else {
			// //query to insert a participant into "r2_participants" table
			// $sql_insert = "insert into r2_participants(vcid, userid, present, link, active)
						   // values('$vcid', '$userid', '0', '$link', '1')";
// 			
			// //insert			   
			// $query = $db->getDBConnect() -> query($sql_insert);
// 			
			// if($query)
				// return true;
			// else 
				// return false;
		// }
		// return false;
	// }
// 		
// 	
	// /*
	 // * 	5-12-2012	 
	 // *  End - Support functions for primary function "insertActivity" above
	 // */
































?>
