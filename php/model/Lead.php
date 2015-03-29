<?php
if (!class_exists("DBConnect")) {
	require_once ("DBConnect.php");
}
class Lead {

	public function __construct() {

	}

	public function updateUserOnlineStatus($currentUser_id, $status) {
		$db = new DBConnect();
		$html_return = "";

		if ($db -> getDBConnect()) {
			$currentUser_id = $db -> getDBConnect() -> real_escape_string($currentUser_id);
			$status = $db -> getDBConnect() -> real_escape_string($status);

			$sql = "update socket_user set status='$status' where user_id ='$currentUser_id'";

			if ($db -> getDBConnect() -> query($sql)) {
				$html_return = "success";
			}
		}
		$db -> close();

		return $html_return;
	}

	public function getGuestUserIDBylink($link) {
		$db = new DBConnect();
		$id = "";
		$link = $db -> getDBConnect() -> real_escape_string($link);
		$sql = "select userid
					 from r2_participants
					 where link = '$link';";

		$query = $db -> getDBConnect() -> query($sql);

		if ($query) {
			$info = "";
			while ($result = $query -> fetch_object()) {
				$id = $result -> userid;
			}

			return $id;
		}
		$db -> close();
	}

	public function getUser($pCurrent_userid) {
		$db = new DBConnect();

		$current_userid = $db -> getDBConnect() -> real_escape_string($pCurrent_userid);

		$sql = "select * from socket_user where user_id <> $current_userid";
		//var_dump($sql);
		if ($query = $db -> getDBConnect() -> query($sql)) {
			$user_array = array();
			$user_object = "";
			//var_dump($result);
			while ($result = $query -> fetch_object()) {
				$user_array[$result -> user_id] = $result -> username;
			}

			$user_object = json_encode($user_array);

			$db -> close();
			return $user_object;
		} else
			return "";
		$db -> close();
	}

	public function validate_Mac_address($userid, $mac_address) {
		$db = new DBConnect();

		$userid = $db -> getDBConnect() -> real_escape_string($userid);
		$mac_address = $db -> getDBConnect() -> real_escape_string($mac_address);

		if ($mac_address != "undefined") {

			//validate duplicate
			$sql22 = "select * from user_device where userid = '$userid' and mac_address='$mac_address'";
			//var_dump($sql22);
			$query22 = $db -> getDBConnect() -> query($sql22);

			if ($query22 -> num_rows > 0) {//found
				//set curent active device
				$sql_update = "update user_device set active = '0' where userid = '$userid'";
				$db -> getDBConnect() -> query($sql_update);

				$sql_update2 = "update user_device set active = '1' where userid = '$userid' and mac_address = '$mac_address'";
				$db -> getDBConnect() -> query($sql_update2);

				return "1";
			} else {
				return "0";
			}
		}
	}

	/*
	 * 16-7-2013
	 * update user feedback form
	 */
	public function createLead($creatorid, $fname, $lname, $company_name, $phone, $email, $address, $suburb, $postcode, $state, $city, $service_code, $price, $note) {
		$db = new DBConnect();

		$fname = $db -> getDBConnect() -> real_escape_string($fname);
		$lname = $db -> getDBConnect() -> real_escape_string($lname);
		$company_name = $db -> getDBConnect() -> real_escape_string($company_name);
		$phone = $db -> getDBConnect() -> real_escape_string($phone);
		$mobile = $db -> getDBConnect() -> real_escape_string($mobile);
		$email = $db -> getDBConnect() -> real_escape_string($email);
		$address = $db -> getDBConnect() -> real_escape_string($address);
		$suburb = $db -> getDBConnect() -> real_escape_string($suburb);
		$postcode = $db -> getDBConnect() -> real_escape_string($postcode);
		$state = $db -> getDBConnect() -> real_escape_string($state);
		$city = $db -> getDBConnect() -> real_escape_string($city);
		$service_code = $db -> getDBConnect() -> real_escape_string($service_code);
		$price = $db -> getDBConnect() -> real_escape_string($price);
		$note = $db -> getDBConnect() -> real_escape_string($note);

		$sql22 = "select * from customer where mobile ='$mobile'";

		$query22 = $db -> getDBConnect() -> query($sql22);
		$customerid = "";
		if ($query22 -> num_rows > 0) {//found matching item
			while ($result = $query -> fetch_object()) {
				$customerid = $result -> a_id;
			}
		} else {
			//insert new customer info
			$insert_customer_sql = "insert into customer values('$firstname','$lastname','$creatorid','','$phone','$mobile','$email','$address','$suburb','$postcode','$state','$city','$creatorid',null,null,1)";
			$db -> getDBConnect() -> query($insert_customer_sql);

			$sql_get_customerid = "select * from customer where mobile ='$mobile'";

			$query_get_customerid = $db -> getDBConnect() -> query($sql_get_customerid);
			if ($query_get_customerid -> num_rows > 0) {//found matching item
				while ($result = $query_get_customerid -> fetch_object()) {
					$customerid = $result -> a_id;
				}
			}
		}

		if ($customerid != "") {
			$sql = "insert into lead values(null, '1', '$state', '$customerid', '$creatorid', null, null, '$service_code', '$note')";
			//var_dump($sql);
			if ($db -> query($sql)) {
				$db -> close();
				return "1";
			} else
				return "0";
		} else {
			return "0";
		}
	}

}

}
?>
