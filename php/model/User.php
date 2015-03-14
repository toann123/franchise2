<?php
class User
{
    private $user_id;
    private $pass;
    private $username;
    private $token;
    private $status;
    private $channel;
    private $friendlist;
    private $activities;
    private $return_html;

    public function __construct()
    {
        $user_id = "";
        $username = "";
        $token = "";
        $status = "";
        $channel = null;
        $friendlist = null;
        $activities = null;
        $return_html = "";
    }

    public function setUserID($uID)
    {
        $this->user_id = $uID;
    }

    public function getUserID()
    {
        return $this->user_id;
    }

    public function updateUserOnlineStatus($currentUser_id, $status)
    {
        $db = new DBConnect();
        $html_return = "";

        if ($db->getDBConnect()) {
            $currentUser_id = $db->getDBConnect()->real_escape_string($currentUser_id);
            $status = $db->getDBConnect()->real_escape_string($status);

            $sql = "update socket_user set status='$status' where user_id ='$currentUser_id'";

            if ($db->getDBConnect()->query($sql)) {
                $html_return = "success";
            }
        }
        $db->close();

        return $html_return;
    }

    public function getGuestUserIDBylink($link)
    {
        $db = new DBConnect();
        $id = "";
        $link = $db->getDBConnect()->real_escape_string($link);
        $sql = "select userid
					 from r2_participants
					 where link = '$link';";

        $query = $db->getDBConnect()->query($sql);

        if ($query) {
            $info = "";
            while ($result = $query->fetch_object()) {
                $id = $result->userid;
            }

            return $id;
        }
        $db->close();
    }

    public function createChannel()
    {

    }

    public function getChannelInfo()
    {

    }


    public function getUser($pCurrent_userid)
    {
        $db = new DBConnect();

        $current_userid = $db->getDBConnect()->real_escape_string($pCurrent_userid);

        $sql = "select * from socket_user where user_id <> $current_userid";
        //var_dump($sql);
        if ($query = $db->getDBConnect()->query($sql)) {
            $user_array = array();
            $user_object = "";
            //var_dump($result);
            while ($result = $query->fetch_object()) {
                $user_array[$result->user_id] = $result->username;
            }

            $user_object = json_encode($user_array);

            $db->close();
            return $user_object;
        } else
            return "";
        $db->close();
    }

    public function getUserByName($currentUser, $searchForName, $current_user_channel)
    {
        $db = new DBConnect();
        $currentUser = $db->getDBConnect()->real_escape_string($currentUser);
        $searchForName = $db->getDBConnect()->real_escape_string($searchForName);
        $current_user_channel = $db->getDBConnect()->real_escape_string($current_user_channel);

        $sql = "select u1.user_id, u1.username, u1.status from socket_user u1
				where u1.user_id <> '$currentUser'
				and u1.username like '%$searchForName%'
				UNION
				select  u2.user_id, u2.username, u2.status from socket_user u2
				where u2.user_id = '$currentUser'";

        $query = $db->getDBConnect()->query($sql);

        if ($query) {
            $html_return = "";
            $sender_name = "";
            $firstname = "";
            $lastname = "";
            $status = "";
            $statusDescription = "";
            $friendName = "";
            $html_return = "";
            while ($result = $query->fetch_object()) {

                if ($result->user_id == $currentUser) {
                    $sender_name = $result->username;
                }

                if ($result->username == $searchForName) {

                    if (strpos($result->username, " ")) {
                        $name = explode(" ", $result->username);
                        $firstname = $name[0];
                        $lastname = $name[1];
                    } else {
                        $firstname = $result->username;
                    }

                    //****************************************
                    //get user friendship status

                    $sqlstatus = "select f1.friendship_id, f1.user_id,f1.status from socket_friendlist f1
							 where f1.user_id = '$currentUser'
							 and f1.friendship_id = (select f2.friendship_id 
							 					  from socket_friendlist f2 
							 					  where f2.user_id = '$result->user_id');";

                    if ($queryCheck = $db->getDBConnect()->query($sqlstatus)) {
                        if ($queryCheck->num_rows > 0) //indicates that the relationship has been set
                        {
                            while ($resultCheck = $queryCheck->fetch_object()) {
                                if ($resultCheck->status == "friend") {
                                    $statusDescription = "friend";
                                    $status = "<span class='label label-success'>Online</span>";
                                    //indicates that the relationship has already connected
                                }
                                if ($resultCheck->status == "send") {
                                    $statusDescription = "send";
                                    $status = "<span class='label label-warning'>Sent</span>";
                                    //indicates that the friend request already sent
                                }

                                if ($resultCheck->status == "pending") {
                                    $statusDescription = "pending";
                                    $status = "<span class='label label-warning'>Pending</span>";
                                    //indicates that friend request is waiting for response
                                }
                            }
                        }
                    }

                    //****************************************

                    $friendName = $result->username;
                }

            }

            if ($statusDescription == "" && $firstname != "" && $lastname != "") // there is no relationship
            {
                $html_return .= "<tr>
								<td>$firstname</td>
								<td>$lastname</td>
								<td>None</td>
								<td>
									<span class='actionButton'>
										<a onclick=\"sendFriendRequest('$friendName','$current_user_channel','$sender_name');\" class='btn icon-plus-sign' alt='Add to your circle' title='Add to your circle'></a>
									</span>
								</td>
							</tr>";
            } elseif ($statusDescription != "" && $firstname != "" && $lastname != "") {
                $html_return .= "<tr>
								<td>$firstname</td>
								<td>$lastname</td>
								<td>$status</td>
								<td>										
								</td>
							</tr>";
            }

            $db->close();
            return $html_return;
        }
        $db->close();
    }

    public function getUserChannelByActivityID($activity_id)
    {
        $db = new DBConnect();
        $activity_id = $db->getDBConnect()->real_escape_string($activity_id);
        $sql = "select c.channel_id,c.channel_name,c.access_key,c.access_secret from socket_channels c,socket_activity a
						 where a.activity_id='$activity_id'
						 and   a.sender_channel_id = c.channel_id";

        $query = $db->getDBConnect()->query($sql);

        if ($query) {
            $info = "";
            while ($result = $query->fetch_object()) {
                $info = $result->channel_id . ',' . $result->channel_name . ',' . $result->access_key . ',' . $result->access_secret;
            }
            $db->close();
            return $info;
        }
        $db->close();
    }

    public function getUserChannelByFriendID($frienduserid)
    {
        $db = new DBConnect();
        $frienduserid = $db->getDBConnect()->real_escape_string($frienduserid);
        $sql = "select c.channel_id,c.channel_name,c.access_key,c.access_secret from socket_channels c,socket_user u, socket_user_channels uc
						 where u.user_id = '$frienduserid'
						 and   uc.user_id = u.user_id
						 and   c.channel_id = uc.channel_id;";

        $query = $db->getDBConnect()->query($sql);

        if ($query) {
            $info = "";
            while ($result = $query->fetch_object()) {
                $info = $result->channel_id . ',' . $result->channel_name . ',' . $result->access_key . ',' . $result->access_secret;
            }

            return $info;
        }
        $db->close();
    }

    public function getUserInfo($current_userid, $friend_channel_id)
    {
        $db = new DBConnect();
        $current_userid = $db->getDBConnect()->real_escape_string($current_userid);
        $friend_channel_id = $db->getDBConnect()->real_escape_string($friend_channel_id);

        $sql = "select u.user_id, u.username, c.channel_name from socket_user u, socket_user_channels uc, socket_channels c
						 where u.user_id = uc.user_id
						 and c.channel_id = uc.channel_id
						 and uc.channel_id = '$friend_channel_id'";

        $query = $db->getDBConnect()->query($sql);

        if ($query) {
            $candidateName = "";
            while ($result = $query->fetch_object()) {
                //*********************important***************************8
                // we will change it in future to store the entire current login user friend list in local javascript variable rather check at server which cost bandwidth
                ///check if user login user is friend
                $sqlcheck = "SELECT f.user_id, u.username, f.status
					FROM socket_friendlist f, socket_user u
					where f.friendship_id IN (select f2.friendship_id 
											  from socket_friendlist f2 
											  where f2.user_id = '$current_userid') 
				    AND f.user_id != '$current_userid' 
				    AND f.status <> 'pending' 
				    AND u.user_id = f.user_id;";
                $queryCheck = $db->getDBConnect()->query($sqlcheck);

                if ($queryCheck->num_rows > 0) {
                    $isFriend = false;
                    while ($resultCheck = $queryCheck->fetch_object()) {
                        if ($resultCheck->user_id == $result->user_id) //display if other recent online user is in a friend
                        {
                            if ($resultCheck->status == "friend") //display if status if friend
                                return $result->user_id . "," . $result->username . "," . $result->channel_name;
                        }
                    }
                }
            }

        }
        $db->close();
    }

    public function insertUser($current_userid, $aUsername, $token)
    {
        $db = new DBConnect();
        $userid = $db->getDBConnect()->real_escape_string($current_userid);
        $username = $db->real_escape_string($aUsername);
        $token = $db->real_escape_string($token);

        $sql = "insert into socket_user(user_id,username,token)
					values(NULL,'$username','$token');";

        $query = $db->query($sql);

        umask(0007);
        $dirName = $userid;
        $pathname = UPLOAD_URL . $dirName;

        if (!is_dir($pathname))
            mkdir($pathname, 0777);

        $db->close();
    }

    public function loadCircle($current_userid, $current_user_channel_id)
    {
        $db = new DBConnect();

        $current_userid = $current_userid;
        $current_user_channel_id = $current_user_channel_id;

        $html_return = "";

        $sql = "SELECT f.user_id, u.username, f.status
						FROM socket_friendlist f, socket_user u
						where f.friendship_id IN (select f2.friendship_id 
												  from socket_friendlist f2 
												  where f2.user_id = '$current_userid') 
					    AND u.user_id = f.user_id
					    AND f.user_id <> '$current_userid';";

        $query = $db->getDBConnect()->query($sql);

        if ($query->num_rows > 0) {
            $html_return = "";

            $html_return .= '<table id="tbFriendlist" class=" table table-striped">
							<thead>
								<tr>
									<th> First Name </th>
									<th> Last Name </th>
									<th> Status </th>
									<th> &nbsp; </th>
								</tr>
							</thead>
							<tbody id="friendlist">';

            $divCount = 0;
            while ($result = $query->fetch_object()) {
                $frienduserid = $result->user_id;
                $firstname = "";
                $lastname = "";
                $divid = "div$frienduserid";
                $ButtonsTag = "";
                $lblnewid = "lblNew-$frienduserid";
                $acceptbtnid = "acbtn-$frienduserid";
                $declinebtnid = "dcbtn-$frienduserid";

                if ($result->status == "friend") {
                    if (strpos($result->username, " ")) {
                        $name = explode(" ", $result->username);
                        $firstname = $name[0];
                        $lastname = $name[1];
                    } else {
                        $firstname = $result->username;
                    }

                    $html_return .= "<tr id='$divid'>
								<td>$firstname</td>
								<td>$lastname</td>
								<td><span id='lblStatus_$frienduserid' class='label label-success'>Online</span></td>
								<td><span class='label label-success hidden'>Online</span></td>
						   </tr>";
                }
                if ($result->status == "send") {
                    if (strpos($result->username, " ")) {
                        $name = explode(" ", $result->username);
                        $firstname = $name[0];
                        $lastname = $name[1];
                    } else {
                        $firstname = $result->username;
                    }

                    $ButtonsTag = '<span class="acceptDeclineButtons">
															<a id="' . $acceptbtnid . '" class="btn btn-mini btn-success" onclick="friendAcceptEvent(this,\'' . $lblnewid . '\',\'' . $current_user_channel_id . '\')">Accept</a></span>
														   <span class="acceptDeclineButtons">
														    <a id="' . $declinebtnid . '" class="btn btn-mini btn-danger" onclick="friendDeclineEvent(this,\'' . $lblnewid . '\',\'' . $current_user_channel_id . '\')">Decline</a></span>';

                    $html_return .= "<tr id='$divid'>
														<td>$firstname</td>
														<td>$lastname</td>
														<td>$ButtonsTag</td>
														<td><span id='$lblnewid' class='label label-important'>New</span></td>
												   </tr>";
                }
                if ($result->status == "pending") {
                    if (strpos($result->username, " ")) {
                        $name = explode(" ", $result->username);
                        $firstname = $name[0];
                        $lastname = $name[1];
                    } else {
                        $firstname = $result->username;
                    }

                    if ($current_userid == $result->user_id) //display for current login user
                    {
                        $ButtonsTag = '<span class="acceptDeclineButtons">
															<a id="' . $acceptbtnid . '" class="btn btn-mini btn-success" onclick="friendAcceptEvent(this,\'' . $lblid . '\',\'' . $frienduserid . '\')">Accept</a></span>
														   <span class="acceptDeclineButtons">
														    <a id="' . $declinebtnid . '" class="btn btn-mini btn-danger" onclick="friendDeclineEvent(this,\'' . $lblid . '\',\'' . $frienduserid . '\')">Decline</a></span>';
                    } else {
                        $ButtonsTag = "<span id='lblStatus-$frienduserid' class='label label-warning'>pending</span>";
                    }

                    $html_return .= "<tr id='$divid'>
								<td>$firstname</td>
								<td>$lastname</td>
								<td>$ButtonsTag</td>
								<td><span id='$lblnewid' class='label label-important'>New</span></td>
						   </tr>";

                    $divCount++;
                }
            }
            $html_return .= '</tbody>
				</table>';
        }

        $db->close();
        return $html_return;
    }

    public function insertGuestUser($userid, $aUsername, $token)
    {
        $db = new DBConnect();
        $userid = $db->getDBConnect()->real_escape_string($userid);
        $username = $db->getDBConnect()->real_escape_string($aUsername);
        $token = $db->getDBConnect()->real_escape_string($token);

        $sql = "insert into socket_user(user_id,username,token, status, vidyo_id, vidyo_link)
     values($userid,'$username','$token', '','0',NULL);";

        $query = $db->query($sql);

        $db->close();
    }

    public function loadFriendList($current_user_id)
    {
        $db = new DBConnect();

        $userid = $current_user_id;

        $sql = "SELECT f.user_id, u.username
				FROM socket_friendlist f, socket_user u
				where f.friendship_id IN (select f2.friendship_id 
										  from socket_friendlist f2 
										  where f2.user_id = '$userid') 
			    AND f.user_id != '$userid' 
			    AND f.status <> 'pending' 
			    AND u.user_id = f.user_id;";

        $friendlist = array();
        //declare an empty array

        $query = $db->getDBConnect()->query($sql);

        $htmlout = "<option value='Invite'>Invite...</option>";
        if ($query) {
            while ($result = $query->fetch_object()) {
                // modified 27/11/2012
                $friendid = $result->user_id;
                $friendname = $result->username;
                $htmlout .= "<option value='$friendid'>" . $friendname . "</option>";
            }
        }

        $_SESSION['friendlist'] = $friendlist;

        $db->close();

        return $htmlout;
    }

    public function sendFriendRequest($current_userid, $friend_username, $sender_name)
    {
        $db = new DBConnect();
        $html_return = "";

        if ($db->getDBConnect()) {
            $userid = $current_userid;
            $friend_username = $db->getDBConnect()->real_escape_string($friend_username);
            $sender_name = $db->getDBConnect()->real_escape_string($sender_name);

            $sql = "SELECT user_id from socket_user where username = '$friend_username';";
            //echo 	$sql;
            if ($query = $db->getDBConnect()->query($sql)) {
                if ($result = $query->fetch_object()) {
                    $friend_id = $result->user_id;

                    //**************************************************************

                    $sqlCheck = "select f1.friendship_id, f1.user_id,f1.status from socket_friendlist f1
								 where f1.user_id = '$userid'
								 and f1.friendship_id = (select f2.friendship_id 
								 					  from socket_friendlist f2 
								 					  where f2.user_id = '$friend_id');";

                    if ($queryCheck = $db->getDBConnect()->query($sqlCheck)) {
                        if ($queryCheck->num_rows > 0) //indicates that the relationship has been set
                        {
                            while ($result = $queryCheck->fetch_object()) {
                                if ($result->status == "decline") {
                                    $friendship_id = $result->friendship_id;
                                    $sqla = "update socket_friendlist set status = 'pending'
											where friendship_id = $friendship_id
											and user_id = $friend_id;";
                                    $sqlb = "update socket_friendlist set status = 'send'
											where friendship_id = $friendship_id
											and user_id = $userid;";
                                    if ($db->getDBConnect()->query($sqla) && $db->getDBConnect()->query($sqlb)) {
                                        $sql5 = "SELECT c.channel_id,c.access_key,c.access_secret,u.user_id as friend_id,u.username as receiverName from socket_channels c, socket_user_channels uc, socket_user u
											 where u.user_id = '$friend_id'
											 and u.user_id = uc.user_id
											 and c.channel_id = uc.channel_id;";

                                        $query5 = $db->getDBConnect()->query($sql5);

                                        while ($result4 = $query5->fetch_object()) {
                                            //	echo $sql5;
                                            $friend_id = "";

                                            $friend_id = $result4->friend_id;

                                            $info = $result4->channel_id . ',' . $result4->access_key . ',' . $result4->access_secret . ',' . $userid . ',' . $friend_id . ',' . $sender_name . ',' . $result4->receiverName;

                                            $html_return .= $info;

                                        }

                                    }
                                    break;
                                }
                                if ($result->status == "friend") {
                                    $html_return .= "0";
                                    //indicates that the relationship has already connected
                                    break;
                                }
                                if ($result->status == "send") {
                                    $html_return .= "1";
                                    //indicates that the friend request already sent
                                    break;
                                }

                                if ($result->status == "pending") {
                                    $html_return .= "2";
                                    //indicates that friend request is waiting for response
                                    break;
                                }

                            }
                        } else //create relationship entries in database
                        {

                            $max_friend_id = "";
                            $sql2 = "SELECT MAX(friendship_id) as max_friend FROM socket_friendlist";

                            if ($query2 = $db->getDBConnect()->query($sql2)) {
                                if ($result2 = $query2->fetch_object()) {
                                    $max_friend_id = $result2->max_friend;

                                    $sql3 = "INSERT INTO socket_friendlist(friendship_id,user_id,status) VALUES( $max_friend_id + 1, '$userid' , 'send'),
															 ($max_friend_id + 1, $friend_id, 'pending');";
                                    if ($db->getDBConnect()->query($sql3)) {
                                        $sql4 = "SELECT c.channel_id,c.access_key,c.access_secret,u.user_id as friend_id,u.username as receiverName from socket_channels c, socket_user_channels uc, socket_user u
											 where u.user_id = $friend_id
											 and u.user_id = uc.user_id
											 and c.channel_id = uc.channel_id;";

                                        if ($query4 = $db->getDBConnect()->query($sql4)) {
                                            if ($result4 = $query4->fetch_object()) {
                                                $friend_id = "";

                                                $friend_id = $result4->friend_id;

                                                $info = $result4->channel_id . ',' . $result4->access_key . ',' . $result4->access_secret . ',' . $userid . ',' . $friend_id . ',' . $sender_name . ',' . $result4->receiverName;

                                                $html_return .= $info;

                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        $db->close();

        return $html_return;
    }

    public function responseFriendRequest($pCurrent_userid, $pFriend_userid, $pCommand)
    {
        $db = new DBConnect();

        $current_userid = $db->getDBConnect()->real_escape_string($pCurrent_userid);
        $friend_userid = $db->getDBConnect()->real_escape_string($pFriend_userid);
        $command = $db->getDBConnect()->real_escape_string($pCommand);

        $sqlCheck = "select f1.friendship_id, f1.user_id,f1.status from socket_friendlist f1
								 where f1.user_id = '$current_userid'
								 and f1.friendship_id = (select f2.friendship_id 
								 					  from socket_friendlist f2 
								 					  where f2.user_id = '$friend_userid');";

        if ($queryCheck = $db->getDBConnect()->query($sqlCheck)) {
            if ($queryCheck->num_rows > 0) //indicates that the relationship has been set
            {
                while ($result = $queryCheck->fetch_object()) {
                    $friendship_id = $result->friendship_id;
                    if ($result->status == "pending") //indicates that friend request is waiting for response
                    {
                        $sql = "";
                        if ($command == "accept") {
                            $sql = "update socket_friendlist set status = 'friend'
									where friendship_id = '$friendship_id';";
                        }
                        if ($command == "decline") {
                            $sql = "update socket_friendlist set status = 'decline'
									where friendship_id = '$friendship_id';";
                        }

                        //write query to update this friend status

                        echo $sql;
                        $db->getDBConnect()->query($sql);
                    }
                }
            }
            $db->close();
            return true;
        }
    }

    public function removeFriendFromList($friend_user_id)
    {

    }

    public function accepActivities($activ_id, $pcommand)
    {
        $db = new DBConnect();

        $activity_id = $db->getDBConnect()->real_escape_string($activ_id);
        $command = $db->getDBConnect()->real_escape_string($pcommand);

        //update action query
        $sql = "update socket_user_activity set action = '$command' where activity_id = '$activity_id' and action <> 'send';";
        //update new activity status query
        $sql2 = "update socket_user_activity set is_new_activity = '0' where activity_id = '$activity_id';";

        if ($db->query($sql) && $db->query($sql2)) {
            $db->close();
            return true;
        } else
            return false;
    }

}
?>
