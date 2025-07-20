<?php
				echo "<table cellpadding='10' style='border-spacing:5px;'>";
				echo "<tr style='text-align: left; background-color: #a2a5a7'><th>$site_label</th><th>$today_visits</th><th>$today_visitors</th><th>$yesterday_visits</th><th>$yesterday_visitors</th><th>$last_visits</th></tr>";
				//for ($siteid=1; $siteid<$number_of_sites; $siteid++) {
				for ($sid=1; $sid<$number_of_sites; $sid++) {
					
						//count today's visits/////////////////////
						$today = date("Y-m-d");
						$yesterday = date("Y-m-d",strtotime("-1 days"));
						$visits_today = 0;
						$db = new PDO("sqlite:$dbname");
						$db->exec("PRAGMA journal_mode = TRUNCATE;");
						$stmt = $db->prepare("SELECT timestamp FROM $tablename[$sid] WHERE timestamp LIKE ?");
						$stmt->bindValue(1,$today.'%',SQLITE3_TEXT);
						$stmt->execute();
						if ($data = $stmt->fetch()) {
							do 
								{$visits_today += 1;}
							while ($data = $stmt->fetch());
							}
							else{
								echo '-';
								}
						$db = NULL;
						//count today's visitors/////////////////////
						$today = date("Y-m-d");
						$visitors_today = 0;
						$db = new PDO("sqlite:$dbname");
						$db->exec("PRAGMA journal_mode = TRUNCATE;");
						$stmt = $db->prepare("SELECT remote_addr FROM $tablename[$sid] WHERE timestamp LIKE ? GROUP BY remote_addr");
						$stmt->bindValue(1,$today.'%',SQLITE3_TEXT);
						$stmt->execute();
						if ($data = $stmt->fetch()) {
							do 
								{$visitors_today += 1;}
							while ($data = $stmt->fetch());
							}
							else{
								echo '-';
								}
						$db = NULL;
						//count yesterday's visits/////////////////////
						$today = date("Y-m-d");
						$yesterday = date("Y-m-d",strtotime("-1 days"));
						$visits_yesterday = 0;
						$db = new PDO("sqlite:$dbname");
						$db->exec("PRAGMA journal_mode = TRUNCATE;");
						$stmt = $db->prepare("SELECT timestamp FROM $tablename[$sid] WHERE timestamp LIKE ?");
						$stmt->bindValue(1,$yesterday.'%',SQLITE3_TEXT);
						$stmt->execute();
						if ($data = $stmt->fetch()) {
							do 
								{$visits_yesterday += 1;}
							while ($data = $stmt->fetch());
							}
							else{
								echo '-';
								}
						$db = NULL;
						//count yesterday's visitors/////////////////////
						$today = date("Y-m-d");
						$yesterday = date("Y-m-d",strtotime("-1 days"));
						$visitors_yesterday = 0;
						$db = new PDO("sqlite:$dbname");
						$db->exec("PRAGMA journal_mode = TRUNCATE;");
						$stmt = $db->prepare("SELECT remote_addr FROM $tablename[$sid] WHERE timestamp LIKE ? GROUP BY remote_addr");
						$stmt->bindValue(1,$yesterday.'%',SQLITE3_TEXT);
						$stmt->execute();
						if ($data = $stmt->fetch()) {
							do 
								{$visitors_yesterday += 1;}
							while ($data = $stmt->fetch());
							}
							else{
								echo '-';
								}
						$db = NULL; 
						//////////////////////////////////////////////////////////////////////////
						$result = 0;
						$numrows = 0;
							$db = new PDO("sqlite:$dbname");
							$db->exec("PRAGMA journal_mode = TRUNCATE;");
							$result = $db->query("SELECT * FROM $tablename[$sid]");
						if ($data = $result->fetch()) {
							do 
								{$numrows += 1;}
							while ($data = $result->fetch());
							}
							else{
								echo '-';
								}
						$wal_status = $db->query("PRAGMA journal_mode;")->fetchColumn();
						echo $wal_status."<br />";
						//counting values////////////////////////////////////////////////
						$db = NULL;
						include "phpself-scriptname.inc.php";
						echo "<tr style='background-color:#cecece;'>
							  <td>$sitename[$sid]</td>
							  <td>$visits_today</td>
							  <td>$visitors_today</td>
							  <td>$visits_yesterday</td>
							  <td>$visitors_yesterday</td>";
						//end counting values////////////////////////////////////////////
						echo "<td><a href='$myfile?id=$sid&amp;action=dump&amp;n=50'>50</a>&nbsp;&nbsp;
								  <a href='$myfile?id=$sid&amp;action=dump&amp;n=100'>100</a>&nbsp;&nbsp;
								  <a href='$myfile?id=$sid&amp;action=dump&amp;n=200'>200</a>&nbsp;&nbsp;
								  <a href='$myfile?id=$sid&amp;action=dump&amp;n=$numrows'>all</a></td></tr>";

				}//end for ($sid=1; $sid<$number_of_sites; $sid++)
				echo "</table>"; 
?>