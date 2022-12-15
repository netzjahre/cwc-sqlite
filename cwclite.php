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

//get site id for <TITLE> & dump page, preventing injection
if ($_GET['action']=="dump" && is_numeric($_GET['sid']))
	{
	$siteid=$_GET['sid'];
	$siteid=htmlentities($siteid,ENT_QUOTES);
	}else{
	$siteid=0;
	}
?>

<html>
<head>
<title>Cookieless Web Counter - <?=$sitename[$siteid] ?></title>
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
echo "<h3>$sitename[$sid]</h3>";
require "language.inc.php";

//count the number of sites
$number_of_sites=count($sitename)+1;
$ipcount=1;		   

//dump last visits
if ($_GET['action']=="dump" && $_GET['id']<$number_of_sites) {
	
	//show last 50-100-200-all(n) records for the selected site

	echo "<form action = 'delete_check_lite.php' method = 'POST'>";

	//get number of visits preventing injection
	if (is_numeric($_GET['n'])) $n_vis=$_GET['n']+1;
	else die ("$attack");
	
	echo "<h2>$sitename[$siteid]</h2>";
	//echo "<h3>$last_visits ($_GET['n'])</h3><table border='0px' style='font-size: 12px' width='100%'>";
	//echo "<h3>$last_visits ($_GET['n'])</h3><table border='0px' style='font-size: 12px'>";	

	echo "<div class='flex-container'>";
	echo "<div><a href='$_SERVER[PHP_SELF]'>$back</a></div>";
	echo "<div><a href='sort_by_ip_lite.php'>Sort list by IP</a></div>";
	echo "<div><a href='sort_by_uri_lite.php'>Sort list by URL</a></div>";
	echo "</div>";
	echo'<div id = "wrapper">';	
	echo "<table style='border-spacing:5px;'>";
	echo "<tr style='background-color:#a2a5a7;text-align: left;'>
		<th>Id</th>
		<th>SORT BY<br />$timestamp_label</th>
		<th style='width:20%'>$remote_host_label</th>
		<th>$remote_addr_label</th>
		<th style='width:10%'>$http_host_label</th>
		<th style='width:20%'>$request_uri_label</th>
		<th style='width:20%'>$http_referer_label</th>
		<th style='width:20%'>$http_user_agent_label</th>
		<th>Select to delete</th>
		<th>Daily Count</th>
		</tr>";	

		//open the database
		$db = new PDO("sqlite:$dbname");
		$db->exec("PRAGMA journal_mode = WAL;");
		$result = $db->query("SELECT * FROM $tablename[$sid] INDEXED BY idx_timestamp ORDER BY timestamp ASC");
		//$result = $db->query("SELECT * FROM $tablename[$sid] ORDER BY timestamp DESC");
		$i=1;
		$countt=0;
		$iminus=0;
		foreach($result as $row)
		{

			if ($i == $n_vis){break;}
			$timestamp = $row[1];
			$a = intval(substr($timestamp,8,2));
			
			$remote_addr = htmlentities($row[3],ENT_QUOTES);
			$remote_host = gethostbyaddr($remote_addr);
			$id = $row[0];
			$id = htmlentities($id,ENT_QUOTES);
			$timestamp = $row[1];
			$timestamp = htmlentities($timestamp,ENT_QUOTES);
			$php_self = $row[2];
			$php_self = htmlentities($php_self,ENT_QUOTES);
			$remote_addr = $row[3];
			$remote_addr = htmlentities($remote_addr,ENT_QUOTES);
			$http_host = $row[4];
			$http_host = htmlentities($http_host,ENT_QUOTES);
			$request_uri = $row[5];
			$request_uri = htmlentities($request_uri,ENT_QUOTES);
			$http_referer = $row[6];
			$http_referer = htmlentities($http_referer,ENT_QUOTES);
			$http_user_agent = $row[7];
			$http_user_agent = htmlentities($http_user_agent,ENT_QUOTES);
			
			if ( $a <> $b && $i>1)
			{
				$iminus=$i-1;
				$line = "<hr style='height:3px;background-color:#000000;'/>";
				echo "<tr><td>$line</td><td>"."count = ".$countt."</td><td>$line</td><td>$line</td><td>$line</td><td>$line</td><td>$line</td><td>$line</td><td>$line</td><td>$line</tr>";
			}
			if (((($i)%2)==0)) {$stile="style= 'background-color: #cecece;'";} //Change background
			if (((($i)%2)==0) && is_bot($http_user_agent)) {$stile="style= 'background-color: #cecece;color: white'";} //Change background and text
			if (((($i)%2)>0)) {$stile="style= 'background-color: #779BAB;'";} //Change background
			if (((($i)%2)>0) && is_bot($http_user_agent)) {$stile="style= 'background-color: #779BAB; color: white'";} //Change background and text
#htmlentities weiter oben		
			echo "<tr $stile>";
			echo "<td>$id</td>
			<td>$timestamp</td>
			<td style='word-break: break-all; word-wrap: break-word;'>$remote_host</td>";
			//$muster = "/^(\w{4}:{1}){7}(^\w{4})$/";
			echo "<td><a href='https://www.whois.com/whois/$remote_addr' target='_blank'>$remote_addr</a></td>";
			echo"
			<td style='word-break: break-all; word-wrap: normal;'>$http_host</td>
			<td style='word-break: break-all; word-wrap: normal;'>$request_uri</td>
			<td style='word-break: break-all; word-wrap: break-word;'>$http_referer</td>
			<td style='word-break: break-all; word-wrap: break-word;'>$http_user_agent</td>";
			echo "<td><input type='checkbox' name='cbox[$id]'/></td>";
			//echo "<td>".$i."</td>";
			$countt= $i - $iminus;
			echo "<td>".$countt."</td></tr>";
			$i=$i+1;
			$b = intval(substr($timestamp,8,2));
			
			
			
		} // end foreach($result as $row)
		// close the database connection
		$db = NULL;
//////////////
	echo "</table>";
///////////////////////////////////////////////////////////////////////////////	
	echo "<div class='flex-container'>";
	echo "<div><a href='cwclite.php'>$back</a></div>";
	echo "<div><a href='sort_by_ip_lite.php'>Sort list by IP</a></div>";
	echo "<div><a href='sort_by_uri_lite.php'>Sort list by URL</a></div>";
	echo "</div>";
	echo "<div>";
	echo "<p align='center'><input type='submit' name='rubber' value='Delete checked rows'/></p>";
	echo "</form>";	
	echo "<p align='center'>Inserted or pasted text must be left-aligned.</p>";
	echo "<form action = 'delete_timestamp_lite.php' method = 'POST'>";
	echo "<p align='center'>or insert a part of   <input type='text' name='timestamp' value='Timestamp' maxlength='18' size='18'>";
	echo " and <input type='submit' name='timerubber' value='delete rows'></p>";
	echo "</form>";
	echo "<form action = 'delete_ip_lite.php' method = 'POST'>";
	echo "<p align='center'>or insert a part of   <input type='text' name='ip' value='IP' maxlength='15' size='15'>";
	echo " and <input type='submit' name='iprubber' value='delete rows'></p>";
	echo "</form>";
	echo "<form action = 'delete_useragent_lite.php' method = 'POST'>";
	echo "<p align='center'>or insert a part of   <input type='text' name='useragent' value='User Agent' maxlength='15' size='15'>";
	echo " and <input type='submit' name='agentrubber' value='delete rows'></p>";
	echo "</form>";
	echo "<form action = 'delete_url_lite.php' method = 'POST'>";
	echo "<p align='center'>or insert a part of   <input type='text' name='url' value='URL, part next domain/' maxlength='15' size='15'>";
	echo " and <input type='submit' name='urlrubber' value='delete rows'></p>";
	echo "</form>";
	echo "<form action = 'delete_me_lite.php' method = 'POST'>";
	echo "<p align='center'><input type='submit' name='selfrubber' value='Delete own visits'></p>";
	echo "</form>";
	echo "<form action = 'delete_all_bots_lite.php' method = 'POST'>";
	echo "<p align='center'><input type='hidden' name='useragent' value='.com'>";
	echo "<input type='submit' name='botrubber' value='Delete most bots'></p>";
	echo "</form>";
	echo "</div>";
	echo "</div>";//Ende wrapper
	
    } // end if ($_GET['action']=="dump"...	
	
	else{ //show the main page/////////////////////////////////////////////////////////////////
	//
	//
	//
	echo "<table cellpadding='10' style='border-spacing:5px;'>";
	echo "<tr style='text-align: left; background-color: #a2a5a7'><th>$site_label</th><th>$today_visits</th><th>$today_visitors</th><th>$yesterday_visits</th><th>$yesterday_visitors</th><th>$last_visits</th></tr>";

	///////////////////////////////////////////////////////////////////////////
	for ($siteid=1; $siteid<$number_of_sites; $siteid++)
	{
 
	  //count today's visits/////////////////////
	  $today = date("Y-m-d");
	  $yesterday = date("Y-m-d",strtotime("-1 days"));
	  $visite_odierne = 0;

		$db = new PDO("sqlite:$dbname");
		//$db->exec("PRAGMA journal_mode = WAL;");
		$stmt = $db->prepare("SELECT timestamp FROM $tablename[$sid] WHERE timestamp LIKE ?");
		$stmt->bindValue(1,$today.'%',SQLITE3_TEXT);
		$stmt->execute();

		if ($data = $stmt->fetch()) {
			do 
				{$visite_odierne += 1;}
			while ($data = $stmt->fetch());
		} else {
        echo '-';
		}
	  $db = NULL;


	  //count today's visitors/////////////////////
	  $today = date("Y-m-d");
	  $visitatori_odierni = 0;

		$db = new PDO("sqlite:$dbname");
		//$db->exec("PRAGMA journal_mode = WAL;");
		$stmt = $db->prepare("SELECT remote_addr FROM $tablename[$siteid] WHERE timestamp LIKE ? GROUP BY remote_addr");
		$stmt->bindValue(1,$today.'%',SQLITE3_TEXT);
		$stmt->execute();
		if ($data = $stmt->fetch()) {
			do 
				{$visitatori_odierni += 1;}
			while ($data = $stmt->fetch());
		} else {
        echo '-';
		}
		
	  $db = NULL;

	  //count yesterday's visits/////////////////////
	  $today = date("Y-m-d");
	  $yesterday = date("Y-m-d",strtotime("-1 days"));
	  $visite_ieri = 0;

		$db = new PDO("sqlite:$dbname");
		//$db->exec("PRAGMA journal_mode = WAL;");
		$stmt = $db->prepare("SELECT timestamp FROM $tablename[$sid] WHERE timestamp LIKE ?");
		$stmt->bindValue(1,$yesterday.'%',SQLITE3_TEXT);
		$stmt->execute();

		if ($data = $stmt->fetch()) {
			do 
				{$visite_ieri += 1;}
			while ($data = $stmt->fetch());
		} else {
        echo '-';
		}
	  $db = NULL;
	  
	  //count yesterday's visitors/////////////////////

	  $today = date("Y-m-d");
	  $yesterday = date("Y-m-d",strtotime("-1 days"));
	  $visitatori_ieri = 0;

		$db = new PDO("sqlite:$dbname");
		//$db->exec("PRAGMA journal_mode = WAL;");
		$stmt = $db->prepare("SELECT remote_addr FROM $tablename[$siteid] WHERE timestamp LIKE ? GROUP BY remote_addr");
		$stmt->bindValue(1,$yesterday.'%',SQLITE3_TEXT);
		$stmt->execute();
		if ($data = $stmt->fetch()) {
			do 
				{$visitatori_ieri += 1;}
				while ($data = $stmt->fetch());
		} else {
        echo '-';
		}
	  $db = NULL; 
//////////////////////////////////////////////////////////////////////////
	  $result = 0;
	  $numrows = 0;
		$db = new PDO("sqlite:$dbname");
		//$db->exec("PRAGMA journal_mode = WAL;");
		$result = $db->query("SELECT * FROM $tablename[$sid]");
		if ($data = $result->fetch()) {
			do 
				{$numrows += 1;}
			while ($data = $result->fetch());
		} else {
        echo '-';
		}
		
	  $db = NULL;

		echo "<tr style='background-color:#cecece;'>
			<td>$sitename[$siteid]</td>
			<td>$visite_odierne</td>
			<td>$visitatori_odierni</td>
			<td>$visite_ieri</td>
			<td>$visitatori_ieri</td>
			<td><a href='$_SERVER[PHP_SELF]?id=$siteid&amp;action=dump&amp;n=50'>50</a>&nbsp;&nbsp;
				<a href='$_SERVER[PHP_SELF]?id=$siteid&amp;action=dump&amp;n=100'>100</a>&nbsp;&nbsp;
				<a href='$_SERVER[PHP_SELF]?id=$siteid&amp;action=dump&amp;n=200'>200</a>&nbsp;&nbsp;
				<a href='$_SERVER[PHP_SELF]?id=$siteid&amp;action=dump&amp;n=$numrows'>all</a></td></tr>";
	} // end for ($siteid=1; $siteid<$number_of_sites; $siteid++)/////////
	echo "</table>";  
  } // end else show the mainpage ////////////////////////////////////////////////////////
?>

</body>
</html>

