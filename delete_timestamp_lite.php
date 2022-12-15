<html>
<head>
<title>Cookieless Web Counter - </title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes"/>
<style>
</style>
</head>

<body>
	<h1>Cookieless Web Counter <span style="font-size: 15px; font-style: italic"></span></h1>
	Original (v. 20150324) by <a href = "https://github.com/luciomarinelli/cwc"> Lucio Marinelli</a>, modified by JF to meet own requirements



<?php
error_reporting(E_ALL);
require "config.inc.php";
require "language.inc.php";

//connect to MySQL
//$mysqli = new mysqli($dbhost[$siteid],$dbuser[$siteid],$dbpass[$siteid],$dbname[$siteid]) or die ("$db_connection_error1");
	
//delete entries
		
		if(isset ($_POST[timestamp]))
			{
			$timestamp = htmlentities(stripslashes($_POST[timestamp]));
			$timestamp = "%$timestamp%";
			echo "<br/>".$tablename[$sid]."<br/>";
					$db = new PDO("sqlite:$dbname");
					$db->exec("PRAGMA journal_mode = WAL;");
					$stmt = $db->query("DELETE FROM $tablename[$sid] WHERE timestamp LIKE '$timestamp'");
					$rows_del = $stmt->rowCount();
					$db = NULL;
			}				
echo "<p>{$rows_del}  rows deleted</p>";			
echo "<div><a href='cwclite.php'>Back zu main page</a></div>";
?>

<div style="font-family: sans serif; font-size: 15px; margin-top: 5em; text-align: left">v. 20150324 (L.Marinelli) , modified by JF</div>

</body>
</html>

