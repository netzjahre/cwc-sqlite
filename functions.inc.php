<?php
// Log-Datei definieren
define('LOG_FILE', '/cwc-lite/statelog.txt');

// Funktion zur Überprüfung des Log-Dateipfads
function check_log_file() {
    if (!file_exists(LOG_FILE)) {
        error_log("Log-Datei existiert nicht: " . LOG_FILE, 3, LOG_FILE);
        return false;
    }
    if (!is_writable(LOG_FILE)) {
        error_log("Log-Datei ist nicht beschreibbar: " . LOG_FILE, 3, LOG_FILE);
        return false;
    }
    return true;
}

function get_country_from_ip($ip) {
    // Ziel-URL
    $url = "https://get.geojs.io/v1/ip/country/$ip.json";

    // cURL-Initialisierung
    $ch = curl_init();

    // cURL-Optionen setzen
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    // API-Anfrage ausführen
    $response = curl_exec($ch);
    $error = curl_error($ch);
    curl_close($ch);

    // Sicherstellen, dass die Log-Datei beschreibbar ist
    if (!check_log_file()) {
        return "Log-Fehler";
    }

    // Debugging-Ausgaben in die Log-Datei schreiben
    //error_log("GeoJS-Antwort: $response\n", 3, LOG_FILE);
    if (!empty($error)) {
        error_log("cURL-Fehler: $error\n", 3, LOG_FILE);
    }

    // Wenn die Antwort fehlschlägt
    if ($response === false || $error) {
        error_log("Land konnte für IP $ip nicht ermittelt werden.\n", 3, LOG_FILE);
        return "Ukn";
    }

    // Antwort decodieren
    $data = json_decode($response, true);

    // Prüfen, ob der Schlüssel 'country' existiert
    if (isset($data['country'])) {
        return $data['country']; // Ländercode zurückgeben (z. B. 'DE')
    }

    // Wenn 'country' nicht gefunden wird
    error_log("Land konnte für IP $ip nicht ermittelt werden.\n", 3, LOG_FILE);
    return "Ukn";
}
###############################################################################
function import_csv_to_sqlite(&$pdo, $csv_path, $options = array())
{
	extract($options);
	
	if (($csv_handle = fopen($csv_path, "r")) === FALSE)
		throw new Exception('Cannot open CSV file');
		
	if(!$delimiter)
		$delimiter = ',';
		
	if(!$table)
		$table = preg_replace("/[^A-Z0-9]/i", '', basename($csv_path));
	
	if(!$fields){
		$fields = array_map(function ($field){
			return strtolower(preg_replace("/[^A-Z0-9]/i", '', $field));
		}, fgetcsv($csv_handle, 0, $delimiter));
	}
	
	$create_fields_str = join(', ', array_map(function ($field){
		return "$field TEXT NULL";
	}, $fields));
	
	$pdo->beginTransaction();
	
	$create_table_sql = "CREATE TABLE IF NOT EXISTS $table ($create_fields_str)";
	$pdo->exec($create_table_sql);

	$insert_fields_str = join(', ', $fields);
	$insert_values_str = join(', ', array_fill(0, count($fields),  '?'));
	$insert_sql = "INSERT INTO $table ($insert_fields_str) VALUES ($insert_values_str)";
	$insert_sth = $pdo->prepare($insert_sql);
	
	$inserted_rows = 0;
	while (($data = fgetcsv($csv_handle, 0, $delimiter)) !== FALSE) {
		$insert_sth->execute($data);
		$inserted_rows++;
	}
	
	$pdo->commit();
	
	fclose($csv_handle);
	
	return array(
			'table' => $table,
			'fields' => $fields,
			'insert' => $insert_sth,
			'inserted_rows' => $inserted_rows
		);

}
?>