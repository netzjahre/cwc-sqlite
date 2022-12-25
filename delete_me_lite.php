<html>
<head>
<title>Cookieless Web Counter - </title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes"/>
<style>
</style>
</head>

<body>
<h1>Cookieless Web Counter <span style="font-size: 20px; font-style: italic"><a href="http://www.luciomarinelli.com" target="_external" style="text-decoration: none; color: black">by Lucio Marinelli</a></span></h1>
Modified by JF



<?php
error_reporting(E_ALL);
require "config.inc.php";
require "language.inc.php";
	
// Get the client ip address
$ipaddress = $_SERVER['REMOTE_ADDR'];
$ipaddress = stripslashes($_SERVER['REMOTE_ADDR']);
#$addr = inet_pton($ipaddress);
#$address = inet_ntop($addr);
#$ippaddress = $address;
$ippaddress = $ipaddress;
	
//delete entries
		
		if(isset ($_POST["selfrubber"]))
			{
			$ipnumber = "%$ippaddress%";
				try
					{
					$db = new PDO("sqlite:$dbname");
					$db->exec("PRAGMA journal_mode = WAL;");
					$stmt = $db->query("DELETE FROM $tablename[$sid] WHERE remote_addr LIKE '$ipnumber'");
					$rows_del = $stmt->rowCount();
					$db = NULL;
					}	// end try //////////////////////////////
				catch(PDOException $e)
					{
					print 'Exception : '.$e->getMessage();
					}
			}				
echo "<p>{$ippaddress} ---> {$rows_del}  rows deleted</p>";
echo "<div><a href='cwclite.php'>Back zu main page</a></div>";
?>

<div style="font-family: sans serif; font-size: 15px; margin-top: 5em; text-align: left">v. 20150324 , modified by JF</div>

</body>
</html>

