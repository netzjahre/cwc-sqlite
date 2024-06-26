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
//get site id for <TITLE> & dump page, preventing injection//////////////////////////////
if ($_GET[action]=="dump" && is_numeric($_GET[sid])) {
	$siteid=$_GET[sid];
	$siteid=htmlentities($siteid,ENT_QUOTES);
		}else{
			$siteid=0;
			}
?>
<html>
	<head>
		<title>Cookieless Web Counter - URI all<?=$sitename[$siteid] ?></title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes"/>
		<meta name="robots" content="noindex"/>
		<link rel="stylesheet" type="text/css" href="style.css"/>
	</head>
	<body>
		<h1>Cookieless Web Counter <span style="font-size: 15px; font-style: italic"></span></h1>
		Original (v. 20150324) by <a href = "https://github.com/luciomarinelli/cwc"> Lucio Marinelli</a>, modified by JF to meet own requirements
		<br/>&nbsp;
		<?php
			require"language.inc.php";
			//count the number of sites
			$number_of_sites=count($sitename)+1;
			$emptyy = "";
			//dump last visits/////////////////////////////////////////////////////////
			if ($_GET[action]=="dump" && $_GET[id]<$number_of_sites) {
				//show last 50-100-200-all(n) records for the selected site
				//get number of visits preventing injection
				if (is_numeric($_GET[n])) $n_vis=$_GET[n]+1;
					//else die ("$attack");
				//////////////////////////////////////////////////////////////////////////////////////
				echo "<h3>$sitename[$sid]</h3>";
				//////////list is here/////////////////////////////////////////////////////////////////
				echo "<div class='flex-container'; >";
				echo "<div><a href='cwclite.php'>$back</a></div>";
				echo "</div>";
				echo "<center><table cellpadding='5' style='border-spacing:5px'>";
				echo "<tr style='background-color:#a2a5a7;text-align: left;'>
					<!--th>Number</th-->						   
					<th>&nbsp;&nbsp;i</th>
					<th>URL</th>
					<th>Count</th>
					<!--th>Prev</th-->
					</tr>";
				//open the database////////////////////////////
				$db = new PDO("sqlite:$dbname1");
				$db->exec("PRAGMA synchronous = NORMAL;");
				$db->exec("PRAGMA journal_mode = TRUNCATE;");
				//www.plus2net.com/php_tutorial/sqlite-delete.php
				$db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
				$query="DELETE FROM $tablename1[$sid] where http_host=:http_host";
				$sql=$db->prepare($query);
				$sql->bindParam(':http_host',$emptyy);
				if($sql->execute()){
					echo "<div class='flex-container'>";
					echo "Database adjusted, number of empty rows deleted  : ".$sql->rowCount();
					echo "</div>";
					}
						else{
							print_r($sql->errorInfo()); // if any error is there it will be posted
							$msg=" Database problem, please contact site admin ";
							}
				$result = $db->query("SELECT http_host, request_uri, COUNT(request_uri) as 'sum' FROM $tablename1[$sid] GROUP BY http_host,request_uri ORDER BY sum DESC");
				//$result = $db->query("SELECT http_host, request_uri, COUNT(request_uri) as 'sum' FROM $tablename1[$sid] GROUP BY http_host,request_uri ORDER BY sum ASC");
				$total=0;
				$prevsum=1;
				$bright = "style= 'background-color: #cecece;'";//test other color
				$dark = "style= 'background-color: #779BAB;'";//test other color
				$style=$bright;
				
				foreach($result as $i=>$row)
					{
					//if ($i == $n_vis){break;}
					$timestamp = $row[timestamp];
					$atime = intval(substr($timestamp,8,2));
					$xtime = substr($timestamp,0,9);
					$http_host = $row[http_host];
					$http_host = htmlentities($http_host,ENT_QUOTES);
					$request_uri = $row[request_uri];
					$request_uri = htmlentities($request_uri,ENT_QUOTES);
					$currsum = $row[sum];
					$total=$total+$currsum;
					//Change background////////////////////////////////////////
					
					/*switch (TRUE) {
					case (($currsum == $prevsum) && (((intval($currsum))%2)==0)):
						$style=$bright;
					case (($currsum <> $prevsum) && ($style==$dark)):
						$style=$bright;
					case (($currsum <> $prevsum) && ($style==$bright)):
						$style=$dark;
					}*/

					/*if(($prevsum == $currsum) && (((intval($currsum))%2)<>0)) //&& ($style==$dark))
						{$style=$dark;}
					elseif(($prevsum == $currsum) && (((intval($currsum))%2)==0)) //&& ($style==$dark))
						{$style=$bright;}*/
					if (($prevsum == $currsum) && ($style==$dark))
						{$style=$dark;}
					elseif(($prevsum <> $currsum) && ($style==$dark))
						{$style=$bright;}
					elseif (($prevsum == $currsum) && ($style==$bright))
						{$style=$bright;}
					elseif(($prevsum <> $currsum) && ($style==$bright))
						{$style=$dark;}
					echo "<tr $style><td align='right'>$i</td>";
					echo "<td>$http_host$request_uri</td><td align='right'>$currsum</td><!--td align='right'>$prevsum</td--></tr>";
					//$currsum=$row[sum];
					$prevsum=$currsum;
					} // end foreach($result as $row)
				echo "<tr><td align='right'>.</td>";					
				echo "<td>total</td><td align='right'>$total</td></tr>";
				echo "</table></center>";
				$wal_status = $db->query("PRAGMA journal_mode;")->fetchColumn();
				echo $wal_status."<br />";																	
				$db = NULL;
				///////////////////////////////////////////////////////////////////////
				echo "<div class='flex-container'>";
				echo "<div><a href='cwclite.php'>$back</a></div>";
				echo "<div><a href='count_all_uri_lite_multicol.php'>multicolor display</a></div>";																					   
				echo "</div>";
				} // end if ($_GET[action]=="dump"...//////////////////////////////////////
					else{ //show the main page
						//Last visits//////////////////////////////////////////////////////////	
						echo "<table cellpadding='10' style = 'border-spacing:5px; width:50%'>";
						echo "<tr style='text-align: left; background-color: #a2a5a7'><th>$site_label</th><th>.</th><th>.</th><th>.</th><th>.</th><th>$last_visits</th></tr>";
						for ($siteid=1; $siteid<$number_of_sites; $siteid++){
							echo "<tr style='background-color:#cecece;'>
								  <td>$sitename[$siteid]</td>
								  <td>.</td>
								  <td>.</td>
								  <td>.</td>
								  <td>.</td>
								  <td><a href='$_SERVER[REQUEST_URI]?id=$siteid&amp;action=dump&amp;n=50'>50</a>&nbsp;&nbsp;
									  <a href='$_SERVER[REQUEST_URI]?id=$siteid&amp;action=dump&amp;n=100'>100</a>&nbsp;&nbsp;
									  <a href='$_SERVER[REQUEST_URI]?id=$siteid&amp;action=dump&amp;n=200'>200</a>&nbsp;&nbsp;
									  <a href='$_SERVER[REQUEST_URI]?id=$siteid&amp;action=dump&amp;n=$numrows'>all</a></td></tr>";
							} // end for ($siteid=1; $siteid<$number_of_sites; $siteid++)/////////
						echo "</table>";
						} // end else show the mainpage ///////////////////////////////////////////////////////
		?>
	</body>
</html>