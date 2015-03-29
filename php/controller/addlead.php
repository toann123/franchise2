<?php
	session_start();
	require("../model/Lead.php");
	if (isset($_SESSION['userid']) && isset($_SESSION['roleid']) && isset($_POST['fname'])
			&& isset($_POST['lname'])&& isset($_POST['company_name'])&& isset($_POST['phone'])&& isset($_POST['mobile'])&& isset($_POST['email'])&& isset($_POST['address'])
			&& isset($_POST['suburb'])&& isset($_POST['postcode'])&& isset($_POST['state'])&& isset($_POST['city'])&& isset($_POST['service_code'])
			&& isset($_POST['price'])&& isset($_POST['note']))
	{
		$lead= new Lead();
		
		$creatorid = $_SESSION['userid'];
		$role = $_SESSION['roleid'];
		
		//user info
		$fname = $_POST['fname'];
		$lname = $_POST['lname'];
		$company_name = $_POST['company_name'];
		$phone = $_POST['phone'];
		$mobile = $_POST['mobile'];
		$email = $_POST['email'];
		$address = $_POST['address'];
		$suburb = $_POST['suburb'];
		$postcode = $_POST['postcode'];
		$state = $_POST['state'];
		$city = $_POST['city'];
		
		//task info
		$service_code = $_POST['service_code'];
		$price = $_POST['price'];
		$note = $_POST['note'];
		
		//update present
		$return = $lead->createLead($creatorid, $fname, $lname, $company_name, $phone, $mobile, $email, $address, $suburb, $postcode, $state, $city, $service_code, $price, $note);
		
		if($return != ""){
			echo $return;
		}
	}		
	else {
		echo "<script type='text/javascript' language='JavaScript'>
					window.location = '../login.php';
			  </script>";
	}
?>