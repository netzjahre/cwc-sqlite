 <?php
//Cookieless Web Counter - tracker code starts here
//Include this tracked in each page you want to count.
//CONFIGURATION-LITE
//Table name (default is "contatore")
$tablename="cwcsqlite";
date_default_timezone_set('X/Y');
//ini_set('date.timezone', 'X/Y');
//date_default_timezone_get();
//-------CONFIGURATION ENDS HERE-----
//
define('LOG_FILE', __DIR__ . '/statelog.txt');
//include "phpself-scriptname.inc.php";
include "functions.inc.php";
$myfile = basename($_SERVER["SCRIPT_NAME"]);
$php_self=$myfile;
$remote_addr=$_SERVER['REMOTE_ADDR'];
$http_host=$_SERVER['HTTP_HOST'];
$request_uri=$_SERVER['REQUEST_URI'];
$http_referer=$_SERVER['HTTP_REFERER'];
$http_user_agent=$_SERVER['HTTP_USER_AGENT'];
//
//SQLite
$db = new SQLite3("/your_server_path/your_username/cwc-lite/cwcsqlite.db");
$db->exec("PRAGMA journal_mode = TRUNCATE;");
if (!$db) {
	die("Database connection failed: " . $db->lastErrorMsg());
	}
//$id = htmlentities($id,ENT_QUOTES);
//$timestamp = htmlentities($timestamp,ENT_QUOTES);
$remote_addr = htmlentities($remote_addr,ENT_QUOTES);
$country = get_country_from_ip($remote_addr);
if (!preg_match('/^[A-Z]{2}$/', $country)) {
    $country = '.'; // standard value
}
if ($country === "Ukn") {
	error_log("Country for $remote_addr not found.\n", 3, LOG_FILE);
} elseif ($country === "Private/Reserved IP") {
	error_log("Private oder reserved IP-address: $remote_addr\n", 3, LOG_FILE);
}
$remote_host = gethostbyaddr($_SERVER['REMOTE_ADDR']) ?: 'Unknown';
$php_self = htmlentities($php_self,ENT_QUOTES);
$http_host = htmlentities($http_host,ENT_QUOTES);
$request_uri = htmlentities($request_uri,ENT_QUOTES);
$http_referer = htmlentities($http_referer,ENT_QUOTES);
$http_user_agent = htmlentities($http_user_agent,ENT_QUOTES);
//
// Check if $http_referer is empty
if(empty($http_referer)) {
    $http_referer = '.'; // Replace with a dot if empty
	}

//prepareinsert
$insert = $db -> prepare("INSERT INTO cwcsqlite 
         ('php_self','remote_addr','http_host','request_uri','http_referer','http_user_agent','remote_host', 'country')
		 VALUES (:php_self,:remote_addr,:http_host,:request_uri,:http_referer,:http_user_agent,:remote_host,:country)") or die("end");

 //bindValue()
 $insert->bindValue(':php_self', $php_self);
 $insert->bindValue(':remote_addr', $remote_addr);
 $insert->bindValue(':http_host', $http_host);
 $insert->bindValue(':request_uri', $request_uri);
 $insert->bindValue(':http_referer', $http_referer);
 $insert->bindValue(':http_user_agent', $http_user_agent);
 $insert->bindValue(':remote_host', $remote_host);
 $insert->bindValue(':country', $country);
 $insert->execute();

$db->close();

?>