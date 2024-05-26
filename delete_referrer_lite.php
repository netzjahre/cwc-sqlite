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


		
		if(isset ($_POST[http_referer]))
			{
			$httpreferer = htmlentities($http_referer,ENT_QUOTES);
			$httpreferer = "%$http_referer%";
				try
					{
					$db = new PDO("sqlite:$dbname");
		$db = new PDO("sqlite:$dbname");
		$db->exec("PRAGMA synchronous = NORMAL;");
		$db->exec("PRAGMA journal_mode = TRUNCATE;");
		$db->exec("CREATE INDEX IF NOT EXISTS idx_referer_host_uri_date ON $tablename[$sid] (date(timestamp, http_referer, http_host, request_uri))");
		$result = $db->query("SELECT * FROM $tablename[$sid] ORDER BY date(timestamp), http_referer, http_host, request_uri");

		$i=1;
		$countt=0;
		$iminus=0;
		foreach($result as $row)
		{
					$db->exec("PRAGMA synchronous = NORMAL;");
					$db->exec("PRAGMA journal_mode = TRUNCATE;");
					$stmt = $db->query("DELETE FROM $tablename[$sid] WHERE http_referer = '$httpreferer'");
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

