<?php
if (!class_exists("DBConnect")) {
   require_once ("../model/DBConnect.php");
}
//require_once 'PasswordUtility.php';

class loginController
{
    private $userName;
    private $uid;
    private $name;
    private $db;

    function __construct($username)
    {
        $this->userName = $username;
        $this->db = new DBConnect();
    }

    public function logUserIn($pass)
    {
        $userCheck = $this->checkUserName();
        $passCheck = $this->checkPassword($pass);

        if ($userCheck == true) {
            if ($passCheck == true) {
                $this->setLoginSession($this->userName, $this->uid, $this->name);
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }

    }

    public function logUserInPassTest($pass)
    {
        $userCheck = $this->checkUserName();
        $passCheck = $this->checkPassword($pass);
        if ($userCheck == true) {
            if ($passCheck == true) {
                $this->setLoginSession($this->userName, $this->uid, $this->name);
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * Sets the autoLogin cookie that allows the user to by pass login
     */
    public function setAutoLogin()
    {
        $DAY = 86400;
        setcookie("autoLogin", $this->userName, time() + $DAY);
    }

    /**
     * @return cookie   returns the value of the autoLogin cookie that is set.
     * @return bool     returns false is the cookie is not set.
     */
    public function getAutoLogin()
    {
        if (isset($_COOKIE["autoLogin"])) {
            return $_COOKIE["autoLogin"];
        } else {
            return false;
        }
    }

    /**
     * Checks and matches the users provided username (email address) against the database.
     * @return bool returns false is the email does not exist, returns true if it does.
     */
    private function checkUserName()
    {
        $query = "SELECT * FROM users WHERE email = '$this->userName';";
        $results = $this->getQuery($query);
        if ($results->num_rows > 0) {
            while ($row = $results->fetch_object()) {
                if ($row->email == $this->userName) {
                    $this->uid = $row->id;
                    $this->name = $row->name;
                    return true;
                } else {
                    return false;
                }
            }

        } else {
            return false;
        }
        return false;
    }

    /**
     * @param $pass The users password in hashed format.
     * @return bool Returns false if the user's given password (after being hashed) does not match the database
     */
    public function checkPassword($pass)
    {
    	$pass = $this->db->getDBConnect()->real_escape_string($pass);
        $dbPass = $this->getPasswordFromDB();
		if ($dbPass) { 
			$pwhash = hash(HASH_ALG,$pass);
	        if ($dbPass == $pwhash) {
	            return true;
	        }
		}
		return false;
    }

    public function getPasswordFromDB()
    {
        $query = "SELECT * FROM users WHERE email = '$this->userName';";
        $results = $this->getQuery($query);
        if ($results->num_rows > 0) {
            while ($row = $results->fetch_object()) {
                if ($row->email == $this->userName) {
                    return $row->password;
                } else {
                    return 0;
                }
            }
        } else {
            return false;
        }
        return false;

    }

    /**
     * @param $query    The query being sent to the database through the global DBconnect object.
     * @return mixed    Returns the results from the database.
     */
    private function getQuery($query)
    {
        $results = $this->db->getDBConnect()->query($query);
        return $results;
    }

    /**
     * @param $userName the users email (username)
     * @param $uID      the users user ID
     * @param $name     the users real name
     */
    private function setLoginSession($userName, $uID, $name)
    {
        $_SESSION["username"] = $userName;
        $_SESSION["userid"] = $uID;
        $_SESSION["name"] = $name;
    }

}

?>
