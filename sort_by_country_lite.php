 <?php
//Cookieless Web Counter by Lucio Marinelli, modified by JF to meet own requirements
//Please see attached GNU GENERAL PUBLIC LICENSE version 3x

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
if ($_GET[action]=="dump" && is_numeric($_GET['sid']))
	{
	$siteid=$_GET['sid'];
	$siteid=htmlentities($siteid,ENT_QUOTES);
	}else{
	$siteid=0;
	}*/
?>

<html>
<head>
<title>Cookieless Web Counter - <?=$sitename[$sid] ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes"/>
<meta name="robots" content="noindex"/>
<link rel="stylesheet" type="text/css" href="style.css"/>
</head>
<body>
<h1>Cookieless Web Counter <span style="font-size: 15px; font-style: italic"></span></h1>
Original (v. 20150324) by <a href = "https://github.com/luciomarinelli/cwc"> Lucio Marinelli</a>, modified by JF to meet own requirements
<br/>&nbsp;
<br/>&nbsp;

<?php
echo "<h3>$sitename[$sid]</h3>";										
require "language.inc.php";

//count the number of sites
$number_of_sites=count($sitename)+1;
$ipcount=1;

//dump last visits///////////////////////////////////////////////////////////////////////
if ($_GET['action']=="dump" && $_GET['id']<$number_of_sites) {
	
	
	//show last 50-100-200-all(n) records for the selected site

	echo "<form action = 'delete_check_lite.php' method = 'POST'>";

	//get number of visits preventing injection
	if (is_numeric($_GET[n])) $n_vis=$_GET[n]+1;
	else die ("$attack");
	
	echo "<h2>$sitename[$sid]</h2>";
	echo "<h3>$last_visits ($_GET[n])</h3><table border='0px' style='font-size: 12px' width='100%'>";
	#echo "<h3>$last_visits ($_GET[n])</h3><table border='0px' style='font-size: 12px'>";	

	echo "<div class='flex-container'>";
	echo "<div class='within-flex'><a href='cwclite.php'>$back</a></div>";
	echo "<div class='within-flex'><a href='sort_by_uri_lite.php'>Sort list by URL</a></div>";
	echo "</div>";
	echo'<div id = "wrapper">';	
	echo "<table style='border-spacing:5px;'>";
	echo "<tr style='background-color:#a2a5a7;text-align: left;'>
		<th>Id</th>
		<th>$timestamp_label</th>
		<th style='width:20%'>$remote_host_label</th>
		<th>$remote_addr_label</th>
		<th>SORT BY $country_label</th>
		<!--th style='width:3%'>.</th-->
		<th style='width:10%'>$http_host_label</th>
		<th style='width:17%'>$request_uri_label</th>
		<th style='width:20%'>$http_referer_label</th>
		<th style='width:20%'>$http_user_agent_label</th>
		<th>Select to delete</th>
		<th>Daily Count</th>
		</tr>";	

		//open the database					 
		$db = new PDO("sqlite:$dbname");
		$db->exec("PRAGMA journal_mode = TRUNCATE;");
		$db->exec("CREATE INDEX IF NOT EXISTS idx_country ON $tablename[$sid] (date_txt, country, remote_addr, request_uri)");
		$result = $db->query("SELECT * FROM $tablename[$sid] INDEXED BY idx_country ORDER BY date_txt, country, remote_addr, request_uri");

		$i=1;
		$countt=0;
		$iminus=0;
		foreach($result as $row)
		{
			if ($i == $n_vis){break;}
			//$timestamp = htmlspecialchars($row['timestamp'] ,ENT_QUOTES);						   												   
			//$atime = intval(substr($timestamp,8,2));
			$atime = htmlspecialchars($row[date_txt] ,ENT_QUOTES);
			/*
			if ($bremote==$remote_addr && $remote_addr<>"")
			   {$ipcount = $ipcount+1;}
		    */
			if ( $atime <> $btime && $i>1)
			   {
				$iminus=$i-1;
				$line = "<hr style='height:3px;background-color:#000000;'/>";
				echo "<tr><td>$line</td><td>"."count = ".htmlspecialchars($countt, ENT_QUOTES)."</td><td>$line</td><td>$line</td><td>$line</td><td>$line</td><td>$line</td><td>$line</td><td>$line</td><td>$line</td><td>$line</tr>";
			   }
			if (((($i)%2)==0)) {$stile="style= 'background-color: #cecece;'";} //Change background
			if (((($i)%2)==0) && is_bot($row[7])) {$stile="style= 'background-color: #cecece;color: white'";} //Change background and text
			if (((($i)%2)>0)) {$stile="style= 'background-color: #779BAB;'";} //Change background
			if (((($i)%2)>0) && is_bot($row[7])) {$stile="style= 'background-color: #779BAB; color: white'";} //Change background and text
			/*
			if ($bremote<>$remote_addr && $bremote<>"" && $remote_addr<>"")
				{
				$ipcount=1;
				echo "<tr>";
				for($spalte=0; $spalte < 10; $spalte++) {echo "<td>.</td>";}
				echo "</tr>";
				}
			*/
			echo "<tr $stile>";
			echo "<td>".htmlspecialchars($row['id'], ENT_QUOTES)."</td>
			<td>".htmlspecialchars($row['datime_txt'], ENT_QUOTES)."</td>
			<td style='word-break: break-all; word-wrap: break-word;'>".htmlspecialchars($row['remote_host'], ENT_QUOTES)."</td>";
			echo "<td><a href='https://get.geojs.io/v1/ip/geo/".htmlspecialchars($row['remote_addr']).".json' target='_blank'>".htmlspecialchars($row['remote_addr'])."</a></td>";
			echo"
			<td style='word-break: break-all; word-wrap: normal;'>".htmlspecialchars($row['country'], ENT_QUOTES)."</td>
			<td style='word-break: break-all; word-wrap: normal;'>".htmlspecialchars($row['http_host'], ENT_QUOTES)."</td>
			<td style='word-break: break-all; word-wrap: normal;'>".htmlspecialchars($row['request_uri'], ENT_QUOTES)."</td>
			<td style='word-break: break-all; word-wrap: break-word;'>".htmlspecialchars($row['referer'], ENT_QUOTES)."</td>
			<td style='word-break: break-all; word-wrap: break-word;'>".htmlspecialchars($row['http_user_agent'], ENT_QUOTES)."</td>";
			$id = htmlspecialchars($row['id'], ENT_QUOTES);//von chatGPT empfohlen
			echo "<td><input style='transform: scale(2); margin-left:15px;' type='checkbox' name=\"cbox[$id]\" /></td>";//von chatGPT empfohlen

			//echo "<td>".$i."</td>";
			$countt= $i - $iminus;
			echo "<td>".htmlspecialchars($countt, ENT_QUOTES)."</td></tr>";
			//echo "<td>".$ipcount."</td></tr>";
			$i=$i+1;
			//$Datumm = substr($timestamp,0,10);
			//$bremote = $remote_addr;
			//$btime = intval(substr($timestamp,8,2));
			$btime = htmlspecialchars($row[date_txt] ,ENT_QUOTES);
		} // end foreach($result as $row)
		$db = NULL;// close the database connection
	echo "</table>";///////////////////////////////////////////////////////////////////////////////

	include "footer.inc.php";
    } // end if ($_GET[action]=="dump"...	
	
	else{ //show the main page/////////////////////////////////////////////////////////////////
		include "toyester.inc.php";
    } // end else show the mainpage ///////////////////////////////////////////////////////
?>
</body>
</html>