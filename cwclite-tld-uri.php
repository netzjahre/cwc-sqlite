 <?php
	//Cookieless Web Counter by Lucio Marinelli, modified by JF to meet own requirements
	//Please see attached GNU GENERAL PUBLIC LICENSE version 3
	//tld. and uri in same column in opposite to cwc.php
	error_reporting(E_ALL);
	require "config.inc.php";
	//Function to detect bots
	function is_bot($text) {
		$botkey=array("bot","bots","BUbiNG","spider","slurp","search","crawl","qwant");
		foreach ($botkey as $letter) {
			if (stripos($text,$letter) !== false) {
				return true;
				}
			}
		return false;
		}
	//get site id for <TITLE> & dump page, preventing injection
	if ($_GET['action']=="dump" && is_numeric($_GET['sid'])) {
		$siteid=$_GET['sid'];
		$siteid=htmlentities($siteid,ENT_QUOTES);
		}
			else{
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
		<br/>&nbsp;		   
		<?php
			echo "<h3>$sitename[$sid]</h3>";
			require "language.inc.php";
			//count the number of sites
			$number_of_sites=count($sitename)+1;
			$ipcount=1;
			//dump last visits/////////////////////////////////////////////////////////////////////
			if ($_GET['action']=="dump" && $_GET['id']<$number_of_sites) {
				//show last 50-100-200-all(n) records for the selected site
				//end of form behind checkboxes (in footer.inc.php)													   
				echo "<form action = 'delete_check_lite.php' method = 'POST'>";
				//get number of visits preventing injection
				if (is_numeric($_GET['n'])) $n_vis=$_GET['n']+1;
					else die ("$attack");
				echo "<h2>$sitename[$siteid]</h2>";
				//echo "<h3>$last_visits ($_GET['n'])</h3><table border='0px' style='font-size: 12px' width='100%'>";
				//echo "<h3>$last_visits ($_GET['n'])</h3><table border='0px' style='font-size: 12px'>";	
				echo "<div class='flex-container'>";
				echo "<div class='within-flex'><a href='$_SERVER[PHP_SELF]'>$back</a></div>";
				echo "<div class='within-flex'><a href='sort_by_ip_lite.php'>Sort list by IP</a></div>";
				echo "<div class='within-flex'><a href='sort_by_uri_lite.php'>Sort list by URL</a></div>";
				echo "<div class='within-flex'><a href='count_all_uri_lite.php'>Archive of exported visit data</a></div>";
				echo "</div>";
				echo'<div id = "wrapper">';	
				echo "<table style='border-spacing:5px;'>";
				echo "<tr style='background-color:#a2a5a7;text-align: left;'>
					  <th>Id</th>
					  <th>SORT BY<br />$timestamp_label</th>
					  <th style='width:20%'>$remote_host_label</th>
					  <th>$remote_addr_label</th>
					  <th style='width:3%'>.</th>
					  <!--th style='width:10%'>$http_host_label</th-->
					  <th style='width:27%'>$request_uri_label</th>
					  <th style='width:20%'>$http_referer_label</th>
					  <th style='width:20%'>$http_user_agent_label</th>
					  <th>Select to delete</th>
					  <th>Daily Count</th>
					  </tr>";
				//open the database
				$db = new PDO("sqlite:$dbname");
				$db->exec("PRAGMA synchronous = NORMAL;");
				$db->exec("PRAGMA journal_mode = TRUNCATE;");
				$db->exec("CREATE INDEX IF NOT EXISTS idx_many ON cwcsqlite (timestamp,remote_host,remote_addr,request_uri,http_user_agent)");
				$db->exec("CREATE INDEX IF NOT EXISTS idx_timestamp ON cwcsqlite (timestamp, id)");
				$db->exec("CREATE INDEX IF NOT EXISTS idx_date_ip ON cwcsqlite (date(timestamp), remote_addr)");
				$db->exec("CREATE INDEX IF NOT EXISTS idx_date_uri ON cwcsqlite (date(timestamp), request_uri)");
				$db->exec("CREATE INDEX IF NOT EXISTS idx_remoteaddr_requesturi ON cwcsqlite (remote_addr, request_uri)");
				$db->exec("CREATE INDEX IF NOT EXISTS idx_remotehost_requesturi ON cwcsqlite (remote_host, request_uri)");
				//$result = $db->query("SELECT * FROM $tablename[$sid] INDEXED BY idx_timestamp ORDER BY timestamp ASC");
				$result = $db->query("SELECT * FROM $tablename[$sid] ORDER BY timestamp ASC");
				$i=1;
				$countt=0;
				$iminus=0;
				foreach($result as $row) {
						if ($i == $n_vis){break;}
						$timestamp = $row[1];
						$a = intval(substr($timestamp,8,2));
						$remote_addr = htmlentities($row[3],ENT_QUOTES);
						$remote_host = $row[8];
						$remote_host = htmlentities($remote_host,ENT_QUOTES);
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
						if ( $a <> $b && $i>1) {
							$iminus=$i-1;
							$line = "<hr style='height:3px;background-color:#000000;'/>";
							echo "<tr><td>$line</td><td>"."count = ".$countt."</td><td>$line</td><td>$line</td><td>$line</td><td>$line</td><td>$line</td><td>$line</td><td>$line</td><td>$line</tr>";
							}
						if (((($i)%2)==0)) {$stile="style= 'background-color: #cecece;'";} //Change background
						if (((($i)%2)==0) && is_bot($http_user_agent)) {$stile="style= 'background-color: #cecece;color: white'";} //Change background and text
						if (((($i)%2)>0)) {$stile="style= 'background-color: #779BAB;'";} //Change background
						if (((($i)%2)>0) && is_bot($http_user_agent)) {$stile="style= 'background-color: #779BAB; color: white'";} //Change background and text
						echo "<tr $stile>";
						echo "<td>$id</td>
						<td>$timestamp</td>
						<td style='word-break: break-all; word-wrap: break-word;'>$remote_host</td>";
						//$muster = "/^(\w{4}:{1}){7}(^\w{4})$/";
						echo "<td><a href='https://www.whois.com/whois/$remote_addr' target='_blank'>$remote_addr</a></td>";
						echo"
							<td style='word-break: break-all; word-wrap: normal;'>.</td>
							<td style='word-break: break-all; word-wrap: normal;'>$http_host$request_uri</td>
							<td style='word-break: break-all; word-wrap: break-word;'>$http_referer</td>
							<td style='word-break: break-all; word-wrap: break-word;'>$http_user_agent</td>";
						echo "<td><input type='checkbox' name='cbox[$id]'/></td>";
						//echo "<td>".$i."</td>";
						$countt= $i - $iminus;
						echo "<td>".$countt."</td></tr>";
						$i=$i+1;
						$b = intval(substr($timestamp,8,2));
					}
				$db = NULL;
				echo "</table>";
				///////////////////////////////////////////////////////////////////////////////
				include "footer.inc.php";
			}
			// end dump last visits/////////////////////////////////////////////////////////////////////

			else{ //show the main page
					include "toyester.inc.php";
			} // end else show the mainpage
		?>
	</body>
</html>