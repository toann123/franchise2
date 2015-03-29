<?php
require_once ("Email.php");

require_once '../../extlib/phpmailer/class.phpmailer.php';

class UpdateEmail extends Email {

	public function getTemplate($portalAddress) {
		$fromname = parent::getreplyname();
		$date = parent::getActivityDate();
		$topic = parent::gettopic();
		$duration = parent::getduration();
		$link = parent::getlink();
		$time = parent::getStartTime();
		$hostlink = $portalAddress;		
		$emailList = parent::getEmailList();
        $vcId = parent::getVcId();
		$vc_description = parent::getVCDescription();
		
		$html_participant = "<ol>";
		foreach($emailList as $email){
			$html_participant .= "<li class='details-font'>$email</li>";
		}
		$html_participant .= "</ol>";

		$html_email = "<html>
						<body style='margin-top: 30px;'>
							<div class='container'>
								<div class='row'>
									<div class='offset2 span8 well well-small'>
										<h1>A video conference has been <span style='color: #1AADF5;' >updated</span></h1><span style='text-decoration: underline;'>By " . $fromname . "</span>
                                        <h2>Video Conference Reference: #" . $vcId . "</h2>
									</div>
								</div>
								<div class='row'>
									<div class='offset2 span8 well well-small'>
										<h3 class=''><strong>Description</strong></h3>
										<p>$vc_description</p>
										<br/>
										<h3 class=''><strong>Details</strong> <small style='font-size: 85%;;'>The new details are listed below</small></h3>
										<hr>
										<p>					
											<ul class=''>
												<li style='font-size: 1.5em;padding: 5px 0px;'>
													<strong>Date:</strong> " . $date . "
												</li>
												<li style='font-size: 1.5em;padding: 5px 0px;'>
													<strong>Time:</strong> " . $time . "
												</li>
												<li style='font-size: 1.5em;padding: 5px 0px;'>
													<strong>Duration:</strong> " . $duration . " minutes
												</li>
											</ul>
										</p>
									</div>
								</div>
								<div class='row'>
									<div class='offset2 span8 well well-small'>
										<h3>Joining:<small style='font-size: 75%;'> when the time comes, just click the link below.</small></h3>
											<a style='font-size 1.3em;' href='".$hostlink."?link=".$link."' class='btn btn-large btn-block btn-primary '>Join</a>
										</p>
									</div>
								</div>
								<div class='row'>
									<div class='offset2 span8'>
										<p><small style='font-size:75%;'><strong style='color: #b94a48;'>*</strong>This message is a notification from the CCN network. If you wish to reply to the <strong> sender </strong> simply use the 'Reply' or 'Reply to all' feature in your email client.</small></p>
									</div>
								</div>
							</div>
							
						</body>
						</html>
				  ";
		return $html_email;
	}

	public function send_email($portalAddress) {
		$this -> template = $this -> getTemplate($portalAddress);
		$mail = new PHPMailer(true);
		//defaults to using php "mail()"; the true param means it will throw exceptions on errors, which we need to catch
		try {
			$mail -> AddAddress(parent::getto(), parent::gettoname());
			$mail -> AddReplyTo(parent::getreply(), parent::getreplyname());
			$mail -> SetFrom(parent::getfrom(), parent::getfromname());
			$mail -> Subject = parent::gettopic();
			$mail -> AltBody = 'To view the message, please use an HTML compatible email viewer!';
			// optional - MsgHTML will create an alternate automatically
			$mail -> IsHTML(true);
			//$mail->MsgHTML(file_get_contents('../class/contents.html'));
			$mail -> Body = $this -> template;

			//process attachments
			//if($attachfiles != null || $attachfiles != "")
			// {
			// 	  foreach ($attachfiles as $link)
			//	  {
			//		$mail->AddAttachment($this->strip_attachfiles_url($link));      // attachment
			//	  }
			//  }
			$mail -> Send();
			// echo "Message Sent OK</p>\n";
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