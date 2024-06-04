<?php
				echo "<table cellpadding='10' style='border-spacing:5px;'>";
				echo "<tr style='text-align: left; background-color: #a2a5a7'><th>$site_label</th><th>$today_visits</th><th>$today_visitors</th><th>$yesterday_visits</th><th>$yesterday_visitors</th><th>$last_visits</th></tr>";
				for ($siteid=1; $siteid<$number_of_sites; $siteid++) {
					
						//count today's visits/////////////////////
						$today = date("Y-m-d");
						$yesterday = date("Y-m-d",strtotime("-1 days"));
						$visite_odierne = 0;
						$db = new PDO("sqlite:$dbname");
						$db->exec("PRAGMA journal_mode = TRUNCATE;");
						$stmt = $db->prepare("SELECT timestamp FROM $tablename[$sid] WHERE timestamp LIKE ?");
						$stmt->bindValue(1,$today.'%',SQLITE3_TEXT);
						$stmt->execute();
						if ($data = $stmt->fetch()) {
							do 
								{$visite_odierne += 1;}
							while ($data = $stmt->fetch());
							}
							else{
								echo '-';
								}
						$db = NULL;
						//count today's visitors/////////////////////
						$today = date("Y-m-d");
						$visitatori_odierni = 0;
						$db = new PDO("sqlite:$dbname");
						$db->exec("PRAGMA journal_mode = TRUNCATE;");
						$stmt = $db->prepare("SELECT remote_addr FROM $tablename[$siteid] WHERE timestamp LIKE ? GROUP BY remote_addr");
						$stmt->bindValue(1,$today.'%',SQLITE3_TEXT);
						$stmt->execute();
						if ($data = $stmt->fetch()) {
							do 
								{$visitatori_odierni += 1;}
							while ($data = $stmt->fetch());
							}
							else{
								echo '-';
								}
						$db = NULL;
						//count yesterday's visits/////////////////////
						$today = date("Y-m-d");
						$yesterday = date("Y-m-d",strtotime("-1 days"));
						$visite_ieri = 0;
						$db = new PDO("sqlite:$dbname");
						$db->exec("PRAGMA journal_mode = TRUNCATE;");
						$stmt = $db->prepare("SELECT timestamp FROM $tablename[$sid] WHERE timestamp LIKE ?");
						$stmt->bindValue(1,$yesterday.'%',SQLITE3_TEXT);
						$stmt->execute();
						if ($data = $stmt->fetch()) {
							do 
								{$visite_ieri += 1;}
							while ($data = $stmt->fetch());
							}
							else{
								echo '-';
								}
						$db = NULL;
						//count yesterday's visitors/////////////////////
						$today = date("Y-m-d");
						$yesterday = date("Y-m-d",strtotime("-1 days"));
						$visitatori_ieri = 0;
						$db = new PDO("sqlite:$dbname");
						$db->exec("PRAGMA journal_mode = TRUNCATE;");
						$stmt = $db->prepare("SELECT remote_addr FROM $tablename[$siteid] WHERE timestamp LIKE ? GROUP BY remote_addr");
						$stmt->bindValue(1,$yesterday.'%',SQLITE3_TEXT);
						$stmt->execute();
						if ($data = $stmt->fetch()) {
							do 
								{$visitatori_ieri += 1;}
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
						echo "<tr style='background-color:#cecece;'>
							  <td>$sitename[$siteid]</td>
							  <td>$visite_odierne</td>
							  <td>$visitatori_odierni</td>
							  <td>$visite_ieri</td>
							  <td>$visitatori_ieri</td>";
						//end counting values////////////////////////////////////////////
						echo "<td><a href='$_SERVER[PHP_SELF]?id=$siteid&amp;action=dump&amp;n=50'>50</a>&nbsp;&nbsp;
								  <a href='$_SERVER[PHP_SELF]?id=$siteid&amp;action=dump&amp;n=100'>100</a>&nbsp;&nbsp;
								  <a href='$_SERVER[PHP_SELF]?id=$siteid&amp;action=dump&amp;n=200'>200</a>&nbsp;&nbsp;
								  <a href='$_SERVER[PHP_SELF]?id=$siteid&amp;action=dump&amp;n=$numrows'>all</a></td></tr>";

				}															   
				echo "</table>"; 
?>