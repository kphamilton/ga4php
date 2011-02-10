<?php

// the global lib sets alot of global variables, its fairly unexciting
$BASE_DIR = realpath(dirname(__FILE__)."/../../");
global $BASE_DIR;

// the tcp port number we use for comms
$TCP_PORT_NUMBER = 21335;
global $TCP_PORT_NUMBER;




// the messages structure, used to extend gaas if needed
define("MSG_STATUS", 18);
define("MSG_INIT_SERVER", 19);
define("MSG_SET_AD_LOGIN", 20);

// the gaasd call's $MESSAGE[<MSG>]_server() for the server side
// and $MESSAGE[<msg>]_client() for the client side 
$MESSAGES[MSG_STATUS] = "gaasStatus";
$MESSAGES[MSG_INIT_SERVER] = "gaasInitServer";
$MESSAGES[MSG_SET_AD_LOGIN] = "gaasSetADLogin";
global $MESSAGES;







function adTestLogin($domain, $user, $password)
{
	$servers = dns_get_record("_gc._tcp.$domain");
	if(count($servers)<1) {
		echo "AD servers cant be found for $domain, fail!\n";
	}
	
	echo count($servers)." AD servers returned, using ".$servers[0]["target"]."\n";
	
	// we should check all servers, but lets just go with 0 for now
	$cnt = ldap_connect($servers[0]["target"], $servers[0]["port"]);
	echo "Connected\n";
	$bind = ldap_bind($cnt, "$user@$domain", "$password");
	if($bind) {
		echo "login has succeeded\n";
		return true;
	} else {
		echo "login has failed\n";
		return false;
	}	
}

function getADGroups($domain, $user, $password)
{
	
}

function generateRandomString($len)
{
	$str = "";
	$strpos = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
	
	for($i=0; $i<$len; $i++) {
		$str .= $strpos[rand(0, strlen($strpos)-1)];
	}
	
	return $str;
}

function generateHexString($len)
{
	$str = "";
	$strpos = "0123456789ABCDEF";
	
	for($i=0; $i<$len; $i++) {
		$str .= $strpos[rand(0, strlen($strpos)-1)];
	}
	
	return $str;
}


?>