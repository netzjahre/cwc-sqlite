<?php
ini_set("error_reporting", 32767);
include "./config.inc.php";
//include "functions.inc.php";
//get site id for <TITLE> & dump page, preventing injection
/*if ($_GET['action']=="import" && is_numeric($_GET['sid'])){
	$siteid=$_GET['sid'];
	$siteid=htmlentities($siteid,ENT_QUOTES);
	}else{
	$siteid=0;
	}*/
	//$siteid=$_GET['sid'];
	//$siteid=htmlentities($siteid,ENT_QUOTES);
?>
<html>
	<head>
		<title>Cookieless Web Counter - URI all<?=$sitename[$siteid] ?>
		</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes"/>
		<meta name="robots" content="noindex"/>
		<link rel="stylesheet" type="text/css" href="style.css"/>
	</head>
	<body>
		<h1>Cookieless Web Counter <span style="font-size: 15px; font-style: italic"></span></h1>
		Original (v. 20150324) by <a href = "https://github.com/luciomarinelli/cwc"> Lucio Marinelli</a>, modified by JF to meet own requirements
			<h2>Import from temporary file to database <span style="font-size: 15px; font-style: italic"></span></h2>
		<br />&nbsp;
		<br />&nbsp;

<?php
//get site id for <TITLE> & imprt page, preventing injection
/*if ($_GET['action']=="import" && is_numeric($_GET['sid']))
	{
	$siteid=$_GET['sid'];
	$siteid=htmlentities($siteid,ENT_QUOTES);
	}else{
	$siteid=0;
	}*/

	//dump last visits////////////////////
	//if ($_GET[action]=="import" && $_GET[id]<$number_of_sites) {
  
			  
  
	
	
	//show last 50-100-200-all(n) records for the selected site
	
	//echo "<form action = 'delete_check_lite.php' method = 'POST'>";
	
					  
	//get number of visits preventing injection
	//if (is_numeric($_GET[n])) $n_vis=$_GET[n]+1;
	//else die ("$attack");

include "./language.inc.php";
		$db = new PDO("sqlite:$dbname");
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$db->exec("PRAGMA journal_mode = TRUNCATE;");
		
//$stmt = $db->query ("CREATE TABLE IF NOT EXISTS $tablename[$sid](http_host,request_uri)");
//$stmt->execute();

$numrows = 0;
//wiki.hennweb.de/doku.php?id=programmieren:sqlite3:allgemein#csv_import
//$stmt = $db -> prepare("INSERT INTO $tablename[$sid](http_host,request_uri) VALUES(?,?)");
$stmt = $db -> prepare("INSERT OR REPLACE INTO $tablename[$sid](id,timestamp,php_self,remote_addr,http_host,request_uri,http_referer,http_user_agent,remote_host) VALUES(?,?,?,?,?,?,?,?,?)");
    $handle = fopen("imp_temp.csv", "r");
							
        while (($data = fgetcsv($handle, ",")) !== FALSE) {
			// Skip empty rows
			if (empty(array_filter($data))) {
				continue;
			}
            $numrows += 1;
            $stmt->execute([
                $data[0], $data[1], $data[2], $data[3],
                $data[4], $data[5], $data[6], $data[7], $data[8] 
				]);
				echo $numrows."-".$data[0]."-".$data[1]."-".$data[2]."-".$data[3]."-".$data[4]."-".$data[5]."-".$data[6]."-".$data[7]."-".$data[8]."<br>";
				}
	fclose ($handle);
	//$handle = fopen("imp_temp.csv", "w");
	//fclose ($handle);
	echo "<div class='flex-container'>";
	echo "<div>";
	echo "re-import to actual database successfull";
	echo "</div>";
	$db=null;
	echo "</div>";
	// end if ($_GET[action]=="dump"///////////////////////////////////////////////////////////////
	//else{ //show the main page///////////////////////////////////////////////////////////////////

			echo "<div class='flex-container'>";
			echo "<div><a href='cwclite.php'>$back</a></div>";
			echo "</div>";
			echo "<div class='flex-container'>";
			echo "<div>.</div>";
			echo "</div>";
			echo "<div class='flex-container'>";
			echo "<div>.</div>";
			echo "</div>";			
?>
</body>
</html>

