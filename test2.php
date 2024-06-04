<?php
    // Fehlermeldungen anzeigen
    error_reporting(E_ALL);

    $row = 1;


    // Fehlermeldungen anzeigen
    error_reporting(E_ALL);

    $row = 1;
    //$handle = fopen("exp.csv", "r");
	if (($handle = fopen("exp.csv", "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ","))) {
				$num = count($data);
				echo "<p> $num Felder in Zeile $row: <br /></p>";
				$row++;
				for ($c=0; $c < $num; $c++) {
					echo $data[$c] . "<br />";
					}
				}
		}
		fclose($handle);


	$db=NULL;
?>
