 <?php
//Cookieless Web Counter by Lucio Marinelli, modified by JF to meet own requirements
//Please see attached GNU GENERAL PUBLIC LICENSE version 3

error_reporting(E_ALL);
require "config.inc.php";

//Function to detect bots
function is_bot($text) {
	$botkey=array("bot","bots","BUbiNG","spider","slurp","search","crawl","favicon","qwant");
	foreach ($botkey as $letter) {
		if (stripos($text,$letter) !== false) {
			return true;
		}
	}
	return false;
}

/*get site id for <TITLE> & dump page, preventing injection
if ($_GET['action']=="dump" && is_numeric($_GET['sid']))
	{
	$siteid=$_GET['sid'];
	$siteid=htmlentities($siteid,ENT_QUOTES);
	}else{
	$siteid=0;
	}*/
?>	  
<html>
<head>
<title>Cookieless Web Counter - </title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes"/>
<!--meta name="viewport" content="width=device-width, initial-scale=1.0/-->
<meta name="robots" content="noindex"/>
<link rel="stylesheet" type="text/css" href="style.css"/>
</head>

<body>
	<h1>Cookieless Web Counter <span style="font-size: 15px; font-style: italic"></span></h1>
	Original (v. 20150324) by <a href = "https://github.com/luciomarinelli/cwc"> Lucio Marinelli</a>, modified by JF to meet own requirements
<br/>&nbsp;

<?php
$id="text";
require "language.inc.php";

//delete entries
		if(isset ($_POST[cbox]) && is_array($_POST[cbox]))
			{
			$cbox = $_POST[cbox];
			foreach($cbox as $key => $value)
				{
					$db = new PDO("sqlite:$dbname");
					$db->exec("PRAGMA journal_mode = WAL;");
					$stmt = $db->query("DELETE FROM $tablename[$sid] WHERE id = '$key'");

					$rows_del = $stmt->num_rows;
					$db = NULL;
				}
				$count = count($_POST[cbox]);
				echo "<p>{$count} rows deleted</p>";
			}		
echo "<div><a href='cwclite.php'>Back zu main page</a></div>";
?>
</body>
</html>

