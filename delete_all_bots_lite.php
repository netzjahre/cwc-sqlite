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

<?php
error_reporting(E_ALL);
require "config.inc.php";
require "language.inc.php";

//delete entries		
		if(isset ($_POST["botrubber"]))
			{
			echo "<br/>".$tablename[$sid]."<br/>";
			$com = "com";
			$com = "%$com%";
			$claude = "ClaudeBot";
			$claude = "%$claude%";
			$crawl = "crawl";
			$crawl = "%$crawl%";
			}
			
try {
    $db = new PDO("sqlite:$dbname");
	$db->exec("PRAGMA synchronous = NORMAL;");
    $db->exec("PRAGMA journal_mode = TRUNCATE;");
	$stmt = $db->prepare("DELETE FROM $tablename[$sid] WHERE http_user_agent LIKE :com OR http_user_agent LIKE :claude OR http_user_agent LIKE :crawl");
	$stmt->bindParam(':com', $com, PDO::PARAM_STR);
    $stmt->bindParam(':claude', $claude, PDO::PARAM_STR);
    $stmt->bindParam(':crawl', $crawl, PDO::PARAM_STR);
	$stmt->execute();
	$rows_del = $stmt->rowCount();
	}
catch (PDOException $e) {
    print 'Exception : '.$e->getMessage();
    }
finally {
    $db = NULL;
	}
echo "<p>{$rows_del}  rows deleted</p>";
echo "<div><a href='cwclite.php'>Back zu main page</a></div>";
/*				try
					{
					$db = new PDO("sqlite:$dbname");
					$db->exec("PRAGMA journal_mode = TRUNCATE;");
					$stmt = $db->query("DELETE FROM $tablename[$sid] WHERE http_user_agent LIKE '$com' OR http_user_agent LIKE '$claude'");
					$rows_del = $stmt->rowCount();
					$db = NULL;
					}
				catch(PDOException $e)
					{
					print 'Exception : '.$e->getMessage();
					}
			}
			echo "<p>{$rows_del}  rows deleted</p>";
echo "<div><a href='cwclite.php'>Back zu main page</a></div>";
*/
?>

<div style="font-family: sans serif; font-size: 15px; margin-top: 5em; text-align: left">v. 20150324 , modified by JF</div>
</body>
</html>

