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
$database = "cwcsqlite.db";
if (file_exists($database))
	{
	die("Database already exists!");
	}
	
//Connect to database
$db = new PDO("sqlite:".$database);

//Create table 
$db->exec("CREATE TABLE IF NOT EXISTS cwcsqlite(
      id INTEGER PRIMARY KEY,
	  timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
      php_self TEXT,
      remote_addr TEXT,
      http_host TEXT,
      request_uri TEXT,
      http_referer TEXT,
      http_user_agent TEXT,
      remote_host TEXT,
	  country TEXT,
	  datime_txt TEXT,
	  date_txt TEXT)");
#timestamp TIMESTAMP DEFAULT (datetime('now','localtime')) NOT NULL UNIQUE,
$db->close();
echo date_default_timezone_get()."<br />";
echo "Unix ".time()."<br />";
?>
Table0 was created!
<?php
$database = "cwcount.db";
if (file_exists($database))
	{
	die("Database $database already exists!");
	}
	
//Connect to database
$db = new PDO("sqlite:".$database);

//Create table 
$db->exec("CREATE TABLE IF NOT EXISTS cwctimport(
      http_host,
      request_uri)");
$db->close();
echo date_default_timezone_get()."<br />";
echo "Unix ".time()."<br />";
?>
Table1 was created!
</body>
</html>