<?php
//Cookieless Web Counter by Lucio Marinelli, modified by JF to meet own requirements
//Please see attached GNU GENERAL PUBLIC LICENSE version 3
?>
<html>
<head>
<title>Cookieless Web Counter - <?=$sitename[$siteid] ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes"/>
<meta name="robots" content="noindex"/>
<link rel="stylesheet" type="text/css" href="style.css"/>
</head>
<body>

<?php
/*$database = "your.db";
if (file_exists($database))
	{
	die("Database already exists!");
	}
	
//Connect to database
$db = new PDO("sqlite:".$database);

//Create table 
$db->exec("CREATE TABLE IF NOT EXISTS yourtable(
      id INTEGER PRIMARY KEY,
	  timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL UNIQUE,
	  #timestamp TIMESTAMP DEFAULT (datetime('now','localtime')) NOT NULL UNIQUE,
      php_self TEXT,
      remote_addr TEXT,
      http_host TEXT,
      request_uri TEXT,
      http_referer TEXT,
      http_user_agent TEXT)");

$db->exec("CREATE INDEX IF NOT EXISTS idx_timestamp ON yourtable (timestamp, id)");
$db->exec("CREATE INDEX IF NOT EXISTS idx_date_ip ON yourtable (date(timestamp), remote_addr)");
$db->exec("CREATE INDEX IF NOT EXISTS idx_date_uri ON yourtable (date(timestamp), request_uri)");
$db->exec("CREATE INDEX IF NOT EXISTS idx_remotehost_requesturi ON yourtable (remote_host, request_uri)");
$db->close();
echo date_default_timezone_get()."<br />";
echo "Unix ".time()."<br />";*/
?>
Table0 was created!
<?php
$database = "your1.db";
if (file_exists($database))
	{
	die("Database $database already exists!");
	}
	
//Connect to database
$db = new PDO("sqlite:".$database);

//Create table 
$db->exec("CREATE TABLE IF NOT EXISTS yourtable1(
      http_host,
      request_uri)");
	  
/*$db->exec("CREATE INDEX IF NOT EXISTS idx_timestamp ON yourtable1 (timestamp, id)");
$db->exec("CREATE INDEX IF NOT EXISTS idx_date_ip ON yourtable1 (date(timestamp), remote_addr)");
$db->exec("CREATE INDEX IF NOT EXISTS idx_date_uri ON yourtable1 (date(timestamp), request_uri)");
$db->exec("CREATE INDEX IF NOT EXISTS idx_remotehost_requesturi ON yourtable1 (remote_host, request_uri)");*/
$db->close();
echo date_default_timezone_get()."<br />";
echo "Unix ".time()."<br />";
?>
Table1 was created!
</body>
</html>