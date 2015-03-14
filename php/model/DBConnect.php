<?php
include("definition.php");
class DBConnect
{
	private $host;
	private $user;
	private $pw;
	private $dbname;
	private $db;
	
	public function __construct()
	{
		$this->host = SERVERHOST;
		$this->user = HOSTUSER;
		$this->pw = HOSTPW;
		$this->dbname = DBNAME;
		$this->db = mysqli_connect($this->host, $this->user, $this->pw, $this->dbname);
	}
	
	public function connect()
	{
		$this->db = mysqli_connect($this->host, $this->user, $this->pw, $this->dbname);
	}
	
	public function query($sql)
	{
		$res = $this->db->query($sql);	
		if ($res)
		{
			if (strpos($sql,'SELECT') === false)
			{
			  return true;
			}
		}
		else
		{
			if (strpos($sql,'SELECT') === false)
			{
			  return false;
			}
			else
			{
			  return null;
			}
		}
		$results = array();
		while ($row = mysql_fetch_array($res))
		{
			$result = new DALQueryResult();
			foreach ($row as $k=>$v)
			{
			  $result->$k = $v;
			}
			$results[] = $result;
		}
		return $results;
	}
	
	public function close()
	{
		$this->db->close();
	}
	
	public function getDBConnect()
	{
		return $this->db;
	}
}
?>
