 <?php
//Cookieless Web Counter - tracker code starts here
//Include this tracked in each page you want to count.
//CONFIGURATION-LITE
//Table name (default is "contatore")
$tablename="cwcsqlite";
date_default_timezone_set('Europe/Berlin');
//date_default_timezone_get();
//-------CONFIGURATION ENDS HERE-----
//
$php_self=0;
$remote_host=0;
$remote_addr=0;
$http_host=0;
$request_uri=0;
$http_referer=0;
$http_user_agent=0;
//
$php_self=$_SERVER['PHP_SELF'];
$remote_addr=$_SERVER['REMOTE_ADDR'];
$http_host=$_SERVER['HTTP_HOST'];
$request_uri=$_SERVER['REQUEST_URI'];
$http_referer=$_SERVER['HTTP_REFERER'];
$http_user_agent=$_SERVER['HTTP_USER_AGENT'];
//
//SQLite
$db = new SQLite3("/usr/www/users/netzjap/cwc-lite/cwcsqlite.db");
$db->exec("PRAGMA journal_mode = TRUNCATE;");
//$id = htmlentities($id,ENT_QUOTES);
//$timestamp = htmlentities($timestamp,ENT_QUOTES);
$remote_addr = htmlentities($remote_addr,ENT_QUOTES);
$remote_host = gethostbyaddr($remote_addr);
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
//prepare()
$insert = $db -> prepare("INSERT INTO cwcsqlite 
         ('php_self','remote_addr','http_host','request_uri','http_referer','http_user_agent','remote_host')
		 VALUES (:php_self,:remote_addr,:http_host,:request_uri,:http_referer,:http_user_agent,:remote_host)") or die("aus");

 //bindValue()
 $insert->bindValue(':php_self', $php_self);
 $insert->bindValue(':remote_addr', $remote_addr);
 $insert->bindValue(':http_host', $http_host);
 $insert->bindValue(':request_uri', $request_uri);
 $insert->bindValue(':http_referer', $http_referer);
 $insert->bindValue(':http_user_agent', $http_user_agent);
 $insert->bindValue(':remote_host', $remote_host);
 $insert->execute();

$db->close();
?>