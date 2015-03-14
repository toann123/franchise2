<?php
	//Host info
	if (!defined('SERVERHOST')) define('SERVERHOST', 'localhost');		
	if (!defined('HOSTUSER')) define('HOSTUSER', 'tc');	 
	if (!defined('HOSTPW')) define('HOSTPW', 'teleconnect1'); 
	if (!defined('DBNAME')) define('DBNAME', 'tc');
	
	//Socket server info	
	if (!defined('SOCKETSERVER_URL')) define('SOCKETSERVER_URL', '');
	if (!defined('SOCKETSERVER_PORT')) define('SOCKETSERVER_PORT', '');	
	if (!defined('SSL_SOCKETSERVER_URL')) define('SSL_SOCKETSERVER_URL', '');	 
	if (!defined('SSL_SOCKETSERVER_PORT')) define('SSL_SOCKETSERVER_PORT', '');	 
	if (!defined('SOCKETUSER')) define('SOCKETUSER', '');	
	if (!defined('SOCKETPW')) define('SOCKETPW', '');
	
	//Javascript process websocket URL	
	if (!defined('SOCKETJAVASCRIPT_URL')) define('SOCKETJAVASCRIPT_URL', 'teleSock/');

    //page Locations and Names 	
	if (!defined('HOST_LINK')) define('HOST_LINK', 'https://ccn.keytrust.com.au/tc/');

	if (!defined('ACTIVITY_PAGE')) define('ACTIVITY_PAGE', HOST_LINK.'activity.php');	
	if (!defined('HOME_PAGE')) define('HOME_PAGE', HOST_LINK.'index.php');	
	if (!defined('FEED_PAGE')) define('FEED_PAGE', HOST_LINK.'feed.php');	
	if (!defined('INVITE_PAGE')) define('INVITE_PAGE', HOST_LINK.'invite.php');	
	if (!defined('LOGIN_PAGE')) define('LOGIN_PAGE', HOST_LINK.'login.php');	
	if (!defined('VC_PAGE')) define('VC_PAGE', HOST_LINK.'vcsession.php');	
	
	if (!defined('HASH_ALG')) define('HASH_ALG', 'sha256');

	if (!defined('HASH_ALG')) define('HASH_ALG', 'sha256');
	if (!defined('COPYRIGHT')) define('COPYRIGHT', '&copy; 2013 KeyTrust');
	if (!defined('SLOGAN')) define('SLOGAN', 'Powered by the Collaborative Care Network');
?>
