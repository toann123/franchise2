<?php

abstract class Email {

	private $from;
	private $from_name;
	private $to;
	private $to_name;
	private $subject;
	private $link;
	private $topic;
	private $duration;
	private $date;
	private $template;
	private $emailList;
	
	abstract function getTemplate($portalAddress);	

	public function __construct($emailList, $_from, $_from_name, $_to, $_to_name, $_subject, $_link, $_topic, $dur, $_date) {
		$this -> from = $_from;
		$this -> from_name = $_from_name;
		$this -> to = $_to;
		$this -> to_name = $_to_name;
		$this -> subject = $_subject;
		$this -> link = $_link;
		$this -> topic = $_topic;
		$this -> duration = $dur;
		$this -> date = $_date;
		$this -> emailList = $emailList;
	}

	public function getfrom(){
		return $this->from;
	}
	public function getfromname(){
		return $this->from_name;
	}
	public function getto(){
		return $this->to;
	}
	public function gettoname(){
		return $this->to_name;
	}
	public function getsubject(){
		return $this->subject;
	}
	public function getlink(){
		return $this->link;
	}
	public function gettopic(){
		return $this->topic;
	}
	public function getduration(){
		return $this->duration;
	}
	public function getActivityDate(){
		return $this->date;
	}
	public function getEmailList(){			
		return $this->emailList;
	}
}
