 <?php
error_reporting(E_ALL);
require "config.inc.php";
//get site id for <TITLE> & dump page, preventing injection
if ($_GET['action']=="import" && is_numeric($_GET['sid'])){
	$siteid=$_GET['sid'];
	$siteid=htmlentities($siteid,ENT_QUOTES);
	}else{
	$siteid=0;
	}
?>	 
<html>
<head>
<title>Cookieless Web Counter - </title>
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
//$id="text";

require "language.inc.php";

//export entries///////////////////////////////////////////
		if(isset ($_POST[cbox]) && is_array($_POST[cbox]))
			{
			$cbox = $_POST[cbox];
			$csvfile = fopen('file.csv', 'w+');
			$db = new PDO("sqlite:$dbname");
			$db->exec("PRAGMA journal_mode = WAL;");
				foreach($cbox as $key => $value)
					{
					$result = $db->query("SELECT http_host,request_uri FROM $tablename[$sid] WHERE id = '$key'");
					if ($row = $result->fetch()) {
						do 
							{
							$numrows += 1;
							echo $numrows."-";
							fputcsv($csvfile, $row);
							}
						while ($row = $result->fetch());
						}
					}
					echo "<br />";
					fclose($csvfile);
					$csvfile = fopen('file.csv', 'r+');
					$handle = fopen('exp.csv', 'w+');
					while (!feof($csvfile)){
						$zeile = fgets($csvfile);
						$zeile = trim($zeile);
						$uniquezeile = implode(',', array_unique(explode(',',$zeile)));
						if (strlen($uniquezeile) < 5){
							$uniquezeile = "";
							}
						echo $uniquezeile."<br />";
						fputs($handle, $uniquezeile."\r\n");
						}
					fclose($handle);
					fclose($csvfile);
					$csvfile = fopen('file.csv', 'w');
					fclose($csvfile);
				$db = NULL;
			}
			echo "<br /><br />";
			echo "<div class='flex-container'>";
			echo "csv export successfull</div>";
			echo "<div class='flex-container'>";
			echo "<div><a href='cwclite.php'>$back</a></div>";
			echo "</div>";
			echo "<div class='flex-container'><div><a href='count_all_uri_lite.php'>Show archive as it is before import</a></div></div>";
			echo "<div class='flex-container'><div><a href='import_uri_lite.php?id=$siteid'>import into archive</a></div></div>";
			echo "</div>";
?>
</body>
</html>

