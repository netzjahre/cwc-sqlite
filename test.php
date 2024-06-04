	<?php
	//Cookieless Web Counter by Lucio Marinelli, modified by JF to meet own requirements
	//Please see attached GNU GENERAL PUBLIC LICENSE version 3

	error_reporting(E_ALL);
	require "config.inc.php";
	require "language.inc.php";


$i = 0;

echo "<table>";

		$db = new PDO("sqlite:$dbname1");
		$result = $db->query("SELECT *, COUNT(request_uri) as 'sum' FROM $tablename1[$sid] ORDER BY http_host GROUP BY COUNT(request_uri)");
		foreach($result as $row)
			{
			$http_host = $row[http_host];
			$http_host = htmlentities($http_host,ENT_QUOTES);
			$request_uri = $row[request_uri];
			$request_uri = htmlentities($request_uri,ENT_QUOTES);
			$sum = $row[sum];
			if (((($i)%2)==0)) {$stile="style= 'background-color: #cecece;'";} //Change background
			if (((($i)%2)>0)) {$stile="style= 'background-color: #779BAB;'";} //Change background
			
	
			echo "<tr $stile><td>.</td>";
			echo "<td>$http_host$request_uri</td><td>$sum</td></tr>";
			$i=$i+1;
			}
			//$db=null;
	echo "</table>";		




?>