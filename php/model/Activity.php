<?php
if (!class_exists("DBConnect")) {
   require_once ("DBConnect.php");
}
require_once ("User.php");
require_once ("Channel.php");
//require_once ("definition.php");

class Activity
{
    private $activity_id;
    private $topic;
    private $type;
    private $created_date;
    private $start;
    private $starttime;
    private $duration;
    private $included_user_id;
    private $sender_channel_id;
    private $status;
    private $FILE;
    private $return_html;
    private $attachment_list;

    public function __construct()
    {
        $activity_id = "";
        $topic = "";
        $type = "";
        $created_date = "";
        $start = "";
        $duration = "";
        $included_user_id = "";
        $sender_channel_id = "";
        $status = "";
        $return_html = "";
        $attachment_list = array();
    }

    /*
     * 21-1-2013
     * Add more participant entries based on activity id
     */
    public function appendParticipantToActivity($current_userid, $activity_id) // use for "sendInvitation.php"
    {
        $db = new DBConnect();

        $html_return = "";

        if ($db->getDBConnect()) {
            $receiverid = "";
            $currentuserid = $db->getDBConnect()->real_escape_string($current_userid);

            //********** scan through $invitation_to array to insert invitation to the entire user in this variable
            $action = "send";
            $sql2 = "INSERT INTO socket_user_activity(user_activity_id,user_id,activity_id, ACTION, is_new_activity, status)
									VALUES(NULL, '$current_userid', '$activity_id','$action', '1', 'active');";
            //note: update TeleConnect API 22-10-2012. Insert extra column "is_new_activity" for counting number of new activities
            //		that user hasn't viewed yet
            var_dump($sql2);
            $db->getDBConnect()->query($sql2);

        }

        $db->close();

        return $html_return;
    }

    /*
     * 21-1-2013
     * update participant entries to set status to deactive based on activity id
     */
    public function removedParticipantFromActivity($current_userid, $activity_id) // use for "sendInvitation.php"
    {
        $db = new DBConnect();

        $html_return = "";

        if ($db->getDBConnect()) {
            $receiverid = "";
            $currentuserid = $db->getDBConnect()->real_escape_string($current_userid);

            //********** scan through $invitation_to array to insert invitation to the entire user in this variable
            $action = "send";
            $sql2 = "UPDATE socket_user_activity SET status = 'remove'
					 WHERE activity_id = '$activity_id'
					 AND user_id = '$current_userid';";
            //note: update TeleConnect API 22-10-2012. Insert extra column "is_new_activity" for counting number of new activities
            //		that user hasn't viewed yet
            var_dump($sql2);
            $db->getDBConnect()->query($sql2);

        }

        $db->close();

        return $html_return;
    }

    /**
     * MAKE SURE TO ADD EXTRA COLUMN TO socket_activity TABLE
     * @param $current_userid
     * @param $aTopic
     * @param $aType
     * @param $aIncluded_user_id
     * @param $aStart
     * @param $aDuration
     * @param $aStatus
     * @param $senderId
     * @return string
     */
    public function insertActivity($current_userid, $aTopic, $aType, $aIncluded_user_id, $aStart, $aDuration, $aStatus) // use for "sendInvitation.php"
    {
        $db = new DBConnect();

        $html_return = "";

        if ($db->getDBConnect()) {
            $receiverid = "";
            $currentuserid = $db->getDBConnect()->real_escape_string($current_userid);
            date_default_timezone_set('Australia/Melbourne');
            $topic = $db->getDBConnect()->real_escape_string($aTopic);
            $type = $db->getDBConnect()->real_escape_string($aType);
            $created_date = date('Y-m-d H:i:s', time());

            $act_option = $db->getDBConnect()->real_escape_string($aIncluded_user_id);
            $invitation_to = explode(",", $act_option);

            //Apr 24 2012 13:55:32
            //var_dump($aDuration);
            //echo $aDuration;
            $start = $db->getDBConnect()->real_escape_string($aStart);

            $duration = $db->getDBConnect()->real_escape_string($aDuration);

            // $sender_channel_id= $db->getDBConnect()->real_escape_string($sender_channel_id);
            $status = $db->getDBConnect()->real_escape_string($aStatus);

            //24-1-2013
            //add extra one column name "status" into database

            $sql = "INSERT INTO socket_activity(activity_id,topic,TYPE,created_date,start,duration,act_option,sender_channel_id,status,sender_id )
							VALUES(NULL,'$topic','$type','$created_date','$start','$duration','$act_option','104','$status', '$current_userid');";
            if (!$db->getDBConnect()->query($sql)) {
                printf("Errormessage: %s\n", $db->getDBConnect()->error);
            }

            //********** assign activity to user ************
            $sql22 = "SELECT activity_id AS activity_id FROM socket_activity
					  WHERE created_date = '$created_date'
					  AND act_option = '$act_option'
					  AND start = '$start'
					  AND duration = '$duration'";
            var_dump($sql22);
            $activityid = "";
            $query22 = $db->getDBConnect()->query($sql22);
            if ($query22->num_rows > 0) {
                while ($result22 = $query22->fetch_object()) {
                    $activityid = intval($result22->activity_id);
                }
            }

            //********** scan through $invitation_to array to insert invitation to the entire user in this variable
            $action = "send";
            $sql2 = "INSERT INTO socket_user_activity(user_activity_id,user_id,activity_id, ACTION, is_new_activity, status)
									VALUES(NULL, '$current_userid', '$activityid','$action', '1', 'active');";
            if (!$db->getDBConnect()->query($sql2)) {
                printf("Errormessage: %s\n", $db->getDBConnect()->error);
            }

            for ($i = 0; $i < count($invitation_to); $i++) {
                if (is_numeric($invitation_to[$i])) {
                    $action = "pending";
                    $sql2 = "INSERT INTO socket_user_activity(user_activity_id,user_id,activity_id, ACTION, is_new_activity, status)
										VALUES(NULL, '$current_userid', '$invitation_to[$i]','$action', '1', 'active');";
                    $db->getDBConnect()->query($sql2);
                }
            }
            //note: update TeleConnect API 22-10-2012. Insert extra column "is_new_activity" for counting number of new activities
            //		that user hasn't viewed yet
            var_dump($sql2);

        }

        $db->close();

        return $html_return;
    }

    //16-1-2013
    public function updateActivity($current_userid, $aTopic, $aType, $aIncluded_user_id, $aStart, $aDuration, $aStatus, $activity_id) // use for "sendInvitation.php"
    {
        $db = new DBConnect();

        $html_return = "";

        if ($db->getDBConnect()) {
            $receiverid = "";
            $currentuserid = $db->getDBConnect()->real_escape_string($current_userid);
            date_default_timezone_set('Australia/Melbourne');
            $topic = $db->getDBConnect()->real_escape_string($aTopic);
            $type = $db->getDBConnect()->real_escape_string($aType);
            $created_date = date('Y-m-d H:i:s', time());

            $activity_id = $db->getDBConnect()->real_escape_string($activity_id);

            $act_option = $db->getDBConnect()->real_escape_string($aIncluded_user_id);
            //$invitation_to = explode(",", $act_option);

            //Apr 24 2012 13:55:32
            //var_dump($aDuration);
            //echo $aDuration;
            $start = $db->getDBConnect()->real_escape_string($aStart);

            $duration = $db->getDBConnect()->real_escape_string($aDuration);

            // $sender_channel_id= $db->getDBConnect()->real_escape_string($sender_channel_id);
            $status = $db->getDBConnect()->real_escape_string($aStatus);

            $sql = "UPDATE socket_activity SET topic = '$topic', TYPE='$type', created_date='$created_date', start='$start', duration='$duration', act_option='$act_option',sender_channel_id='104',status='$status'
					WHERE activity_id='$activity_id'";

            if ($db->getDBConnect()->query($sql)) {
                $html_return = "done";
            }

            // //********** assign activity to user ************
            // $sql22 = "select activity_id as activity_id from socket_activity
            // where created_date = '$created_date'
            // and act_option = '$act_option'
            // and start = '$start'
            // and duration = '$duration'";
            // var_dump($sql22);
            // $activityid = "";
            // $query22 = $db -> getDBConnect() -> query($sql22);
            // if ($query22 -> num_rows > 0) {
            // while ($result22 = $query22 -> fetch_object()) {
            // $activityid = intval($result22 -> activity_id);
            // }
            // }
            //
            // //********** scan through $invitation_to array to insert invitation to the entire user in this variable
            // $action = "send";
            // $sql2 = "insert into socket_user_activity(user_activity_id,user_id,activity_id, action, is_new_activity)
            // values(NULL, '$current_userid', '$activityid','$action', '1');";
            // //note: update TeleConnect API 22-10-2012. Insert extra column "is_new_activity" for counting number of new activities
            // //		that user hasn't viewed yet
            // var_dump($sql2);
            // $db -> getDBConnect() -> query($sql2);

        }

        $db->close();

        return $html_return;
    }

    public function loadActivity($current_userid)
    {
        $db = new DBConnect();
        $divCount = 0;
        $_SESSION['divCount'] = $divCount;

        $html_return = array();

        if (!$db->getDBConnect()) {
            echo 'ERROR: Could not connect to the database.';
        } else {
            $userid = $current_userid;
            $activity_id = "";

            //get current date time
            date_default_timezone_set('Australia/Melbourne');
            $currentDateTime = time();

            $sql = "SELECT u1.username AS sendername, a.status, a.topic, a.type, a.created_date, a.start, a.duration, a.act_option, u1.username AS sender, ua.is_new_activity, a.activity_id
					FROM socket_user u1, socket_user_activity ua, socket_activity a
					WHERE u1.user_id = '$userid'
					AND a.activity_id = ua.activity_id
					AND u1.user_id = ua.user_id
					ORDER BY a.created_date DESC,a.status DESC, a.start ASC;";
            //var_dump($sql);
            $query = $db->getDBConnect()->query($sql);
            $countNewActivity = 0;
            if ($query && $query->num_rows > 0) {

                while ($result = $query->fetch_object()) {

                    ////***********************************
                    //get max activity ID to assign the name of the upload folder for new activity
                    //$_SESSION['max_activityid'] = intval($result -> max_activityid) + 1;

                    $activity_id = $result->activity_id;

                    //11-1-2013
                    $view_btn = "<a href=\"#\" id=\"$activity_id\" title=\"View Detail Activity\" place-holder=\"View Detail Activity\" onclick=\"setDetailActivity('$activity_id-view');\"><i class=\"icon-folder-open icon-large\" style=\"color: #339966\"></i></a>";
                    $edit_btn = "<a href=\"#\" id=\"$activity_id\" title=\"Edit Activity\" place-holder=\"Edit Activity\" onclick=\"setDetailActivity('$activity_id-edit');\"><i class=\"icon-edit icon-large\" style=\"color: #CC0000\"></i></a>";
                    $manage_btn = $view_btn . " &nbsp; " . $edit_btn;

                    $topic = $result->topic;
                    $type = $result->type;

                    $created_date = $result->created_date;
                    $created_date = strtotime($created_date);
                    $created_date = date('d/m/Y H:i:s', $created_date);

                    $start1 = $result->start;
                    $start1 = strtotime($start1);

                    //calculate number of minutes left before change format
                    $secondLeft = round((($start1 - $currentDateTime) / 60 * 60), 0);

                    $start = date('d/m/Y H:i:s', $start1);
                    //echo $start;
                    $duration = $result->duration;

                    $countdownTime = "";
                    $countdownDiv = "";

                    //11-12-2012
                    //get participants list
                    $inviteeList = "";

                    //calculate number of seconds that coference commencing
                    $conferenceCommencing = intval($secondLeft) + intval($duration) * 60;

                    //echo $conferenceCommencing."  ".intval($secondLeft)." ala ";

                    $ongoing = "";
                    if (intval($secondLeft) > 0 || $conferenceCommencing >= 0) {
                        $tempt1 = "";
                        $tempt2 = "";
                        $tempt3 = "";

                        if ($conferenceCommencing > 0 && intval($secondLeft) <= 0) {
                            //calculate commencing time to set for javascript timer
                            $start2 = $result->start;
                            $start2 = strtotime($start2);
                            $start2 = $start2 + ($conferenceCommencing);
                            //adding end time for the commencing conference
                            $start2 = date('d/m/Y H:i:s', $start2);
                            $ongoing = '<span class="label label-info">Commencing</span>';

                            //echo $conferenceCommencing."     ".$start;
                            //seperate start date component.
                            $tempt1 = explode(" ", $start2);
                        } else {
                            //echo $conferenceCommencing."     ".$start;
                            //seperate start date component.
                            $tempt1 = explode(" ", $start);
                        }

                        // get two components (d/m/y ; H:i:s)
                        $tempt2 = explode("/", $tempt1[0]);
                        //process first component 	"d/m/y"
                        $tempt3 = explode(":", $tempt1[1]);
                        //process second component 	"H:i:s"

                        $day = $tempt2[0];
                        $month = $tempt2[1];
                        $year = $tempt2[2];

                        $hour = $tempt3[0];
                        $minute = $tempt3[1];
                        $second = $tempt3[2];

                        $countdownDiv = '<div class="row-fluid">
											<div class="span12 postResponse" id="countdown_conference' . $divCount . '"></div>
												</div>';

                        $executeCountDown = "<script type=\"text/javascript\">
													countdown('countdown_conference" . $divCount . "',$day,$month,$year,$hour,$minute,$second, 1, $duration);
												  </script>";
                        // run script to count down the time until the conference occurs
                        //$html_return .= $executeCountDown;

                        //count the number of new activity to set the notification icon label on the top left of top nav bar
                        if ($result->is_new_activity == "1")
                            $countNewActivity++;
                        //echo $countNewActivity;
                    }

                    $sendername = $result->sendername;
                    $status = $result->status;

					$duration = $result -> duration;
					$act_option = $result -> act_option;
					$act_option = explode(",", $act_option);
					$inviteeList = "";
					for ($i = 0; $i < count($act_option); $i++) {
						if (!is_numeric($act_option[$i])) {
							//session variable "username" is created in LoginController.php page
							if ($act_option[$i] != $_SESSION["username"]) {//exclude current user id from inviteelist
								$inviteeList .= '<li><span class="text-info">' . $act_option[$i] . '</span></li>';
							}
						}

                    }

                    //var_dump($inviteeList);

                    //**************************************************************************************
                    //--------------------------in case the current activity is read from sender------------

                    $sqll = "SELECT u.username AS receivername, ua.action, u.user_id
									 FROM socket_user u, socket_user_activity ua
									 WHERE u.user_id = ua.user_id
									 AND ua.activity_id = '$activity_id'";
                    //var_dump($sqll);
                    $queryl = $db->getDBConnect()->query($sqll) or die($mysqli->connect_error);

                    //prepare data format to display on client Feed table
                    //convert date and time format
                    $startdate = date('d/m/Y', $start1);
                    $starttime = "";
                    $start1 = date('d/m/Y h:i A', $start1);
                    $tempt = split(" ", $start1);

                    if (count($tempt) == 3)
                        $starttime = $tempt[1] . " " . $tempt[2];
                    if ($queryl && $queryl->num_rows > 0) {
                        //var_dump($inviteeList);
                        while ($result = $queryl->fetch_object()) {
                            $receivername = "";
                            //var_dump($expression)
                            if ($current_userid != $result->user_id) {
                                $receivername = '<li><span class="text-info">' . $result->receivername . '</span></li>';

                            }

                            $action = $result->action;
                            $invitelistTag = '<div><ul>		' . $receivername . $inviteeList . '
											 </ul></div>';
                            if ($status == "expired") {
                                //display a feed row
                                $activiti_seq = $divCount + 1;
                                //var_dump($inviteeList);

                                $html_return[] = array("$topic,$invitelistTag ,$startdate,$starttime,$duration,$manage_btn");
                                // $html_return[] = array("$activiti_seq,$topic,$invitelistTag ,$startdate,$starttime,$duration, <span class=\"label\">Expired</span>");
                            } elseif ($status == "new" || $status == "active") {
                                //display a feed row
                                $activiti_seq = $divCount + 1;

                                $html_return[] = array("$topic,$invitelistTag,$startdate,$starttime,$duration,$manage_btn");
                                // $html_return[] = array("$activiti_seq,$topic,$invitelistTag,$startdate,$starttime,$duration, <span class=\"label label-important\">New</span>");
                            } else {
                                //display a feed row
                                $activiti_seq = $divCount + 1;

                                $html_return[] = array("$topic,$invitelistTag,$startdate,$starttime,$duration,$manage_btn");
                                // $html_return[] = array("$activiti_seq,$topic,$invitelistTag,$startdate,$starttime,$duration, <span class=\"label label-important\">New</span>");
                            }
                        }

                    }

                    //var_dump($inviteeList);
                    //increment divcount to generate unique id for div container to be able to processed individually later on.
                    $divCount++;
                }

                //echo $countNewActivity;
                //assign a number of new activities to session variable so that it can be retrieve in different pages
                $_SESSION['countNewActivity'] = $countNewActivity;

            } else {
                $html_return = null;
            }
        }

        $html_return1 = json_encode($html_return);

        $_SESSION['divCount'] = $divCount;

        $db->close();

        return $html_return1;
    }

    /*
     * 14-2-2013
     * Display detail activity
     *
     */

    public function viewActivityDetails($current_userid, $activity_id)
    {
        $db = new DBConnect();

        $html_return = "";

        if (!$db->getDBConnect()) {
            echo 'ERROR: Could not connect to the database.';
        } else {
            $userid = $current_userid;
            $sendername = "";
            $current_useremail = "";
            $current_participantList = "";
			$activity_status = "";

            //22-1-2013
            $vcid = "";
            $created_date1 = "";

            //get current date time
            date_default_timezone_set('Australia/Melbourne');
            $currentDateTime = time();

            $sql = "SELECT u1.username AS sendername, a.status, a.topic, a.type, a.created_date, a.start, a.duration, a.act_option, ua.is_new_activity, a.activity_id
					FROM socket_user u1, socket_user_activity ua, socket_activity a
					WHERE u1.user_id = '$userid'
					AND a.activity_id = ua.activity_id
					AND u1.user_id = ua.user_id
					AND a.activity_id = '$activity_id'
					ORDER BY a.created_date DESC,a.status DESC, a.start ASC;";
            //var_dump($sql);
            $query = $db->getDBConnect()->query($sql);
            $countNewActivity = 0;
            if ($query && $query->num_rows > 0) {

                while ($result = $query->fetch_object()) {

                    $topic = $result->topic;
                    $type = $result->type;

                    $created_date = $result->created_date;
                    $created_date = strtotime($created_date);
                    $created_date = date('d/m/Y H:i A', $created_date);

                    //22-1-2013
                    $created_date1 = $result->created_date;

                    $created_date_str = split(" ", $created_date);
                    $created_date = $created_date_str[0];
                    $created_time = $created_date_str[1] . " " . $created_date_str[2];

                    $start1 = $result->start;
                    $start1 = strtotime($start1);

                    //calculate number of minutes left before change format
                    $secondLeft = round((($start1 - $currentDateTime) / 60 * 60), 0);

                    $start = date('d/m/Y H:i:s', $start1);
                    //echo $start;
                    $duration = $result->duration;

                    $countdownTime = "";
                    $countdownDiv = "";

                    //11-12-2012
                    //get participants list
                    $inviteeList = "";

                    //calculate number of seconds that coference commencing
                    $conferenceCommencing = intval($secondLeft) + intval($duration) * 60;

                    //echo $conferenceCommencing."  ".intval($secondLeft)." ala ";

                    $ongoing = "";
                    if (intval($secondLeft) > 0 || $conferenceCommencing >= 0) {
                        $tempt1 = "";
                        $tempt2 = "";
                        $tempt3 = "";

                        if ($conferenceCommencing > 0 && intval($secondLeft) <= 0) {
                            //calculate commencing time to set for javascript timer
                            $start2 = $result->start;
                            $start2 = strtotime($start2);
                            $start2 = $start2 + ($conferenceCommencing);
                            //adding end time for the commencing conference
                            $start2 = date('d/m/Y H:i:s', $start2);
                            $ongoing = '<span class="label label-info">Commencing</span>';

                            //echo $conferenceCommencing."     ".$start;
                            //seperate start date component.
                            $tempt1 = explode(" ", $start2);
                        } else {
                            //echo $conferenceCommencing."     ".$start;
                            //seperate start date component.
                            $tempt1 = explode(" ", $start);
                        }

                        // get two components (d/m/y ; H:i:s)
                        $tempt2 = explode("/", $tempt1[0]);
                        //process first component 	"d/m/y"
                        $tempt3 = explode(":", $tempt1[1]);
                        //process second component 	"H:i:s"

                        $day = $tempt2[0];
                        $month = $tempt2[1];
                        $year = $tempt2[2];

                        $hour = $tempt3[0];
                        $minute = $tempt3[1];
                        $second = $tempt3[2];

                    }else{
                    	$activity_status = "expired";
                    }

                    $sendername = $result->sendername;
                    $status = $result->status;

                    $status_html = "<select disabled='disabled' id='status_edit' onmouseover='displayConfirmChangingStatus();' onmouseout='hideConfirmChangingStatus();'>";
                    if ($status == "new" || $status == "active") {
                        $status_html .= "<option value='update' selected> Active </option>";
                        $status_html .= "<option value='cancel'> Cancel </option>";
                    } elseif ($status == "expired") {
                        $status_html .= "<option value='$status' selected> $status </option>";
                    } elseif ($status == "cancel") {
                        $status_html .= "<option value='active'> Active </option>";
                        $status_html .= "<option value='cancel' selected> Cancel </option>";
                    }

                    $status_html .= "</select>";

                    $duration = $result->duration;
                    $act_option = $result->act_option;

                    //21-1-2013
                    $current_participantList = $act_option;

					$act_option = explode(",", $act_option);
					$inviteeList = "";
					$numOfParticipants = count($act_option) - 1;
					
					//25-1-2013
					$limit_participant = 4;
					
					for ($i = 0; $i < count($act_option); $i++) {
						if (!is_numeric($act_option[$i])) {
							if ($act_option[$i] != $sendername) {//exclude current user id from inviteelist
								$index = $i + 1;
								$inviteeList .= "<div id='participant_div$index'>
													<span class='span6'><input id='chk$index' style='visibility: hidden' type='checkbox' place-holder='Select to remove'> &nbsp;
													    <i class='icon-user icon-4x' style='color: #75D1FF'></i>
														<span id='user$index'><a> $act_option[$i] </a></span>
														<input onfocus='validateEmailOnFocus(this.value,this.id);' id='edit_email$index' value='$act_option[$i]' type='text' style='visibility:hidden' rel='tooltip' data-placement='right' data-trigger data-original-title='Email is invalid'>
													</span>
												</div>";
                            }
                        }

                    }

                    //22-1-2013
                    //query to get vcid from r2_vcs
                    $sqlvc = "SELECT id FROM r2_vcs
						  WHERE moderator='$current_userid'
						  AND duration='$duration'
						  AND start='$result->start'
						 ;";
                    //var_dump($sqlvc);
                    $queryvc = $db->getDBConnect()->query($sqlvc);
                    if ($queryvc && $queryvc->num_rows > 0) {
                        //var_dump($inviteeList);
                        while ($result = $queryvc->fetch_object()) {
                            $vcid = $result->id;
                        }
                    }

                    //**************************************************************************************
                    //--------------------------in case the current activity is read from sender------------

                    $sqll = "SELECT u.username AS receivername, ua.action, u.user_id
									 FROM socket_user u, socket_user_activity ua
									 WHERE u.user_id = ua.user_id
									 AND ua.activity_id = '$activity_id'";
                    //var_dump($sqll);
                    $queryl = $db->getDBConnect()->query($sqll) or die($mysqli->connect_error);

                    //prepare data format to display on client Feed table
                    //convert date and time format
                    $startdate = date('d/m/Y', $start1);
                    $starttime = "";
                    $start1 = date('d/m/Y h:i A', $start1);
                    $tempt = split(" ", $start1);

                    $hour = "<div class='input-append inlineDiv'>
									<select class='span8 clearMe' name='startingHour' id='startingHour_edit' disabled='true'>
										<option value=''>  </option>";
                    $min = "<div class='input-append inlineDiv'>
									<select class='span9 clearMe' placeholder='minute' name='startingMinute' id='startingMinute_edit' disabled='true'>
										<option value=''>  </option>";
                    $AMPM = "<div class='input-append inlineDiv'>
									<select class='span12 offset1 clearMe' name='AMPM' id='AMPM_edit' disabled='true'>";

                    if (count($tempt) == 3) {
                        $t = split(":", $tempt[1]);
                        $hour_tempt = $t[0];
                        $min_tempt = $t[1];
                        $AMPM_tempt = $tempt[2];

                        //generate hour combobox
                        for ($i = 1; $i <= 12; $i++) {
                            if ($hour_tempt == $i) {
                                if ($i < 10) {
                                    $hour .= "<option value='$i' selected> 0$i </option>";
                                } else {
                                    $hour .= "<option value='$i' selected> $i </option>";
                                }
                            } else {
                                if ($i < 10) {
                                    $hour .= "<option value='$i'> 0$i </option>";
                                } else {
                                    $hour .= "<option value='$i'> $i </option>";
                                }

                            }
                        }
                        //generate minute combobox
                        for ($j = 0; $j <= 59; $j += 5) {
                            if ($j == $min_tempt) {
                                if ($j < 10)
                                    $min .= "<option value='$j' selected> 0$j </option>";
                                else
                                    $min .= "<option value='$j' selected> $j </option>";
                            } else {
                                if ($j < 10)
                                    $min .= "<option value='$j'> 0$j </option>";
                                else
                                    $min .= "<option value='$j'> $j </option>";
                            }
                        }
                        //generate AMPM combobox
                        if ($AMPM_tempt == "AM") {
                            $AMPM .= "<option value='AM' selected> AM </option>";
                            $AMPM .= "<option value='PM'> PM </option>";
                        } else {
                            $AMPM .= "<option value='AM'> AM </option>";
                            $AMPM .= "<option value='PM' selected> PM </option>";
                        }
                    }
                    $hour .= "</select><span class='add-on' rel='tooltip' data-placement='bottom' data-trigger='manual' id='startingHour_editSpan' data-original-title='Select Starting Hour'>Hour</span>
											</div>";
                    $min .= "</select><span class='add-on' rel='tooltip' data-placement='bottom' data-trigger='manual' id='startingMinute_editSpan' data-original-title='Select Starting Minute'>Min</span>
											</div>";
                    $AMPM .= "</select>	</div>";

                    //generate duration combobox
                    $duration_html = "<select disabled='disabled' class='clearMe' name='dur' rel='tooltip' title='Select Duration' data-placement='right' data-trigger='manual' id='duration_edit'>
													<option value='' selected='selected'>  </option>";
                    for ($i = 10; $i <= 200; $i += 5) {
                        if ($i == $duration) {
                            $duration_html .= "<option value='$i' selected> $i </option>";
                        } else {
                            $duration_html .= "<option value='$i'> $i </option>";
                        }

                    }
                    $duration_html .= "</select><span class='add-on' rel='tooltip' title='Select Duration' data-placement='right' data-trigger='manual' id='durSpan'>Minutes</span>";

                    $num = 1;
                    $participants = "";

                    $edit_button = "";

                    if ($queryl && $queryl->num_rows > 0) {
                        //var_dump($inviteeList);
                        while ($result = $queryl->fetch_object()) {
                            $receivername = "";

                            if ($current_userid != $result->user_id) {
                                $receivername = '<li><span class="text-info">' . $result->receivername . '</span></li>';
                            } else {
                                $edit_button = "<a onclick='enableEditing();' class='btn btn-warning pull-right'><i class='icon-pencil'> Edit</i></a>";
                            }

                            $action = $result->action;
                            $invitelistTag = '<div><ul>		' . $receivername . $inviteeList . '
											 </ul></div>';
                            if ($status == "expired") {
                                $edit_button = '<span class="label label-important pull-right">Expired</span>';
                                //disable editing when activity expired
                                // $html_return[] = array("$activiti_seq,$topic,$invitelistTag ,$startdate,$starttime,$duration, <span class=\"label\">Expired</span>");
                            } elseif ($status == "new") {

                                // $html_return[] = array("$topic,$invitelistTag,$startdate,$starttime,$duration,$manage_btn");
                                // $html_return[] = array("$activiti_seq,$topic,$invitelistTag,$startdate,$starttime,$duration, <span class=\"label label-important\">New</span>");
                            } else {

                                // $html_return[] = array("$topic,$invitelistTag,$startdate,$starttime,$duration,$manage_btn");
                                // $html_return[] = array("$activiti_seq,$topic,$invitelistTag,$startdate,$starttime,$duration, <span class=\"label label-important\">New</span>");
                            }

                            //display participants
                            // if ($action == "pending") {
                            // $participants .= "<tr>
                            // <td> $num </td>
                            // <td> <a><img src='img/user.ico' style='width: 50px; height: 50px;'/> $receivername </a> </td>
                            // <td> <span class='label label-warning'>$action</span> </td>
                            // </tr>";
                            // } elseif ($action == "accepted") {
                            // $participants .= "<tr>
                            // <td> $num </td>
                            // <td> <a><img src='img/user.ico' style='width: 50px; height: 50px;'/> $receivername </a> </td>
                            // <td> <span class='label label-success'>$action</span> </td>
                            // </tr>";
                            // }
                            //$participants .= "<span class='span4'><img src='img/user.ico' style='width: 50px; height: 50px;'/><a id='user$num'> $receivername </a></span>";
                            $num++;
                        }

                    }

					if($activity_status == "expired"){
						$edit_button = "<span class='label label-important pull-right'>Expired</span>";
					}

                }

                $html_return .= "
						<fieldset>
							
					<div class='span2'>
					
								<!-- 		left space			 -->
							</div>
							<div class='row-fluid well span8'  style='background-color:white;'>
								<div>
									<h2 align='center' class='text-info'>Activity Details <a id='updateActivityHelp_button' class='link pull-right' onclick='showAllActivity_help();' title='Update Activity Help'><i class='icon-question-sign'></i></a></h2>
								</div>
								<!-- 		center form			 -->
								<div>
									$edit_button
								</div>
								<br />
								<div class='page-header'>
									<h4>Title: <small id='title_show'> $topic </small> <textarea  class='span6' id='edit_topic' style='display: none;resize:none'>$topic</textarea></h4>
									<a id='titleHelp' style='display: none' onclick='toggleHelp(\"titleHelp\");' rel='popover' data-placement='right' data-content='Title of the activity that will appear in the suject of email.' data-original-title='Title'><i class='icon-question-sign icon-large icon'></i></a>
								</div>
								
								<div class='control-group' onclick=''>
									<div class='span3'>
										<label>Activity Status:</label>
									</div>
									<div>
										<div id='div_status' class='input-append date'  rel='tooltip' data-placement='top' title='Changing this status to Cancel will deacticate this activity!''>
											$status_html											
										</div>
										<a id='statusHelp' style='display: none' onclick='toggleHelp(\"statusHelp\");' rel='popover' data-placement='top' data-content='This selected field allow canceling or re-activating this activity.' data-original-title='Activity Status'><i class='icon-question-sign icon-large icon'></i></a>
									</div>
								</div>
								
								<div class='control-group'>
									<div class='span3'>
										<label>Start Date:</label>
									</div>
									<div>
										<div class='input-append date'>
											<input id='startdate_edit' type='text' class='span7' value='$startdate' disabled='disabled'>
											<span class='add-on'><i class='icon-calendar'></i></span>
										</div>
										<a id='dateHelp' style='display: none' onclick='toggleHelp(\"dateHelp\");' rel='popover' data-placement='top' data-content='Entry of the date that Video Conference will commence.' data-original-title='Starting Date'><i class='icon-question-sign icon-large icon'></i></a>
									</div>
								</div>
								
								<div class='control-group'>
									<div class='span3'>
										<label>Start Time:</label>
									</div>
									<div class='controls-row'>
										$hour
										$min
										$AMPM
										<div class='inlineDiv'><a id='timeHelp' style='display: none' onclick='toggleHelp(\"timeHelp\");' rel='popover' data-placement='right' data-content='Entry of the time that Video Conference will commence.' data-original-title='Starting Time'><i class='icon-question-sign icon-large icon'></i></a></div>
									</div>								
								</div>
								
								<div class='control-group'>
									<div class='span3'>
										<label>Modified Date:</label>
									</div>
									<div>
										<input type='text' class='span2' disabled='disabled' value='$created_date'>
										&nbsp;
										<input type='text' class='span2' disabled='disabled' value='$created_time'>
										<a id='modifiedDateHelp' style='display: none' onclick='toggleHelp(\"modifiedDateHelp\");' rel='popover' data-placement='left' data-content='This field shows the last updated date of this activity.' data-original-title='Modified Date'><i class='icon-question-sign icon-large icon'></i></a>
									</div>
								</div>
							
								<div class='control-group'>
									<div class='span3'>
										<label>Duration:</label>
									</div>
									<div>
										<div class='input-append date'>
											$duration_html
										</div>
										<a id='durationHelp' style='display: none' onclick='toggleHelp(\"durationHelp\");' rel='popover' data-placement='bottom' data-content='Period of time that Video Conference will spend.' data-original-title='Duration'><i class='icon-question-sign icon-large icon'></i></a>
									</div>									
								</div>
							
								<div class='control-group'>
									<div>
										<label>Participants: <a id='participantnHelp' style='display: none' onclick='toggleHelp(\"participantnHelp\");' rel='popover' data-placement='right' data-content='A list of participants who are invited to this activity.' data-original-title='Participant List'><i class='icon-question-sign icon-large icon'></i></a></label>
									</div>
									<br />
									<div id='participant_div'>
										$inviteeList
									</div>
									
								</div>
								<div id='addDelParticipant_div' style='visibility:hidden;'>
									<span id='addParticipant_div' rel='tooltip' data-placement='left' data-trigger='' data-original-title='You have reached the limited number of participant!'>
										<a class='btn' onclick='append_new_participant_entry()'><i class='icon-plus-sign-alt icon-2x' style='color:#49afcd'></i>Add Participant</a>
										<a id='addParticipantHelp' style='display: none' onclick='toggleHelp(\"addParticipantHelp\");' rel='popover' data-placement='top' data-content='This button allow adding more participants to this activity. Note: the number of participants is limited by current user licence.' data-original-title='Adding More Participant'><i class='icon-question-sign icon-large icon'></i></a>
									</span>
									<span id='delParticipant_div' rel='tooltip' data-placement='right' data-trigger='' data-original-title='Participant list can not be empty!'>
										<a class='btn' onclick='remove_participant_entry()'><i class='icon-remove icon-2x' style='color:#bd362f'></i>Remove Participant</a>
										<a id='removeParticipantHelp' style='display: none' onclick='toggleHelp(\"removeParticipantHelp\");' rel='popover' data-placement='right' data-content='This button allow removing selected participants emails by ticking into the check box locating next to each participant's icon and clicking into this button.' data-original-title='Remove Selected Participant'><i class='icon-question-sign icon-large icon'></i></a>
									</span>
								</div>
								
								<br />
								<br />
								<hr id='seperate' style='visibility: hidden'/>
								<div id='update_msg_div' style='display: none'>
									<div class='alert alert-success confirmMess'>
									<strong>Activity is upaded successfully</strong>
									<br />
									A new email will be re-sent to all of participants. Page is loading . . .
									</div>
								</div>
								<div id='submit_buttons' style='visibility: hidden'>
									<span class='pull-left'><a class='btn btn-warning' onclick='cancelEdit(\"" . ACTIVITY_PAGE . "\");'><i class='icon-reply'></i> Cancel</a>
										<a id='btnCancelHelp' style='display: none' onclick='toggleHelp(\"btnCancelHelp\");' rel='popover' data-placement='right' data-content='This button switch current updating activity status to viewing status.' data-original-title='Cancel Editing'><i class='icon-question-sign icon-large icon'></i></a>
									</span>
									<span class='pull-right'>
										<a id='btnUpdateHelp' style='display: none' onclick='toggleHelp(\"btnUpdateHelp\");' rel='popover' data-placement='bottom' data-content='This buttion submits new change of current activity and re-send email to entire participants within the list and sender.' data-original-title='Update Editing'><i class='icon-question-sign icon-large icon'></i></a>
										<a id='btnUpdate' class='btn btn-success' onclick='validateAndSend(\"\", \"startingHour_edit\", \"startingMinute_edit\", \"AMPM_edit\", \"duration_edit\", \"startdate_edit\", \"$sendername\", \"$sendername\", \"$current_userid\")'><i id='icon_processing' class='icon-ok' title='ok'></i>&nbsp;Update</a>
									</span>
								</div>
							</div>
							<div class='span2'>
								<input type='hidden' id='act' value='$activity_id'>
								<input type='hidden' id='numOfParticipants' value='$numOfParticipants'>
								<input type='hidden' id='currentParticipantsList' value='$current_participantList'>
								<input type='hidden' id='vcid' value='$vcid'/>
								<input type='hidden' id='created_date' value='$created_date1'/>
								<input type='hidden' id='limit_participant' value='$limit_participant'/>
							</div>
							<div class='span2'>
								<!-- 		right space			 -->
							</div>
							<div class='span3'></div>
							
							</fieldset>
					";

            }
        }

        $db->close();

        return $html_return;
    }

    /**
     * This function gets and returns a 2D array of the users activities. The first dimension is simply a number (0, 1, 2)
     * where as the second dimension is the activity itself. Additionally, the act_option key contains an array of email addresses.
     * In order to access these items, this notation can be used
     * $array[0]["title"] OR $array[0]["act_option"][0]
     * @param $userEmail  users email
     * @return array|bool array of activities, if failed a false boolean.
     */
    public function getSentActivitiesByEmail($userEmail ,$startlimit, $endlimit)
    {
        $db = new DBConnect();
        $sql = "SELECT * FROM socket_activity WHERE act_option LIKE '%$userEmail%' LIMIT $startlimit , $endlimit;";
        if ($db->getDBConnect()) {
            $result = $db->getDBConnect()->query($sql);
            if ($result->num_rows > 0) {
                $activities = array();
                while ($object = $result->fetch_object()) {
                    $activitiesSubarray = array(
                        'activity_id' => $object->activity_id,
                        'title' => $object->topic,
                        'start' => $object->start,
                        'duration' => $object->duration,
                        'act_option' => explode(",", $object->act_option),
                        'senderId' => $object->sender_id
                    );
                    $activities[] = $activitiesSubarray;
                }
                return $activities;
            } else {
                return false;
            }
            $db->getDBConnect()->close();
        }
        return false;
    }

}
?>
