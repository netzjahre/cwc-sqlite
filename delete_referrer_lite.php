 <html>
<head>
<title>Cookieless Web Counter - </title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes"/>
<meta name="robots" content="noindex"/>												   
<style>
</style>
</head>

<body>
<h1>Cookieless Web Counter <span style="font-size: 15px; font-style: italic"></span></h1>
Original (v. 20150324) by <a href = "https://github.com/luciomarinelli/cwc"> Lucio Marinelli</a>, modified by JF to meet own requirements
br/>&nbsp;

<?php
error_reporting(E_ALL);
require "config.inc.php";
require "language.inc.php";

//delete entries


		
		if(isset ($_POST[referrer]))
			{
			$referrer = htmlentities(stripslashes($_POST[referrer]));
			$reference = "%$referrer%";
				try
					{
					$db = new PDO("sqlite:$dbname");

					$db->exec("PRAGMA synchronous = NORMAL;");
					$db->exec("PRAGMA journal_mode = TRUNCATE;");
					$stmt = $db->query("DELETE FROM $tablename[$sid] WHERE http_referer LIKE '$reference'");
					$rows_del = $stmt->rowCount();
					$db = NULL;
					}	// end try //////////////////////////////
				catch(PDOException $e)
					{
					print 'Exception : '.$e->getMessage();
					}
			}				
echo "<p>{$rows_del}  rows deleted</p>";			
echo "<div><a href='cwclite.php'>Back zu main page</a></div>";
?>

</body>
</html>

