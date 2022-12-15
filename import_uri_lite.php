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
		<h1>Import csv archive <span style="font-size: 15px; font-style: italic">
				<a href="https://stackoverflow.com/" style="text-decoration: none; color: black">with help of stackoverflow.com</a>
			</span>
		</h1>
<br/>&nbsp;
<br/>&nbsp;

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
	
	echo "<form action = 'delete_check_lite.php' method = 'POST'>";
	
					  
	//get number of visits preventing injection
	//if (is_numeric($_GET[n])) $n_vis=$_GET[n]+1;
	//else die ("$attack");

include "./language.inc.php";
		$db = new PDO("sqlite:$dbname1");
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$db->exec("PRAGMA journal_mode = WAL;");
		
$stmt = $db->query ("CREATE TABLE IF NOT EXISTS $tablename1[$sid](http_host,request_uri)");
$stmt->execute();

//wiki.hennweb.de/doku.php?id=programmieren:sqlite3:allgemein#csv_import
$stmt = $db -> prepare("INSERT INTO $tablename1[$sid](http_host,request_uri) VALUES(?,?)");
    $handle = fopen("exp.csv", "r");
            while (($data = fgetcsv($handle,","))!== FALSE) {
				$http_host = $data[0];
				$request_uri = $data[1];
				$stmt = $db -> exec("INSERT INTO $tablename1[$sid] VALUES('$data[0]','$data[1]')");
				echo $data[0]$data[1]."<br />";
				}
fclose ($handle);

$db=null;

			echo "<div class='flex-container'>";
			echo "csv import successfull";
			echo "</div>";
	
	
	echo '</div>';//Ende wrapper
	
	
	// end if ($_GET[action]=="dump"///////////////////////////////////////////////////////////////
	//else{ //show the main page///////////////////////////////////////////////////////////////////

			echo "<div class='flex-container'>";
			echo "<div><a href='cwclite.php'>$back</a></div>";
			echo "</div>";
			echo "<div class='flex-container'><a href='count_all_uri_lite.php'>Show archive</a></div>";
//unset all variables/////////////////////////////////////////////////////////////////////////////
$keys = array();
foreach($GLOBALS as $k => $v){
	$keys[] = $k;
}
for($t=1;$keys[$t];$t++){
	unset($$keys[$t]);
}
unset($k); unset($v); unset($t);
?>
</body>
</html>

