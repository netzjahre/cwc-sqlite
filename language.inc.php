<?php
//Detect language from HTTP_ACCEPT_LANGUAGE string
$language=($_SERVER[HTTP_ACCEPT_LANGUAGE]);
$language = htmlentities($language,ENT_QUOTES);
$lang=substr($language,0,2);
$line = "0";
switch ($lang) {
case 'it': //ITALIAN LANGUAGE
	//pagina principale
	$site_label="Sito";
	$today_visits="Visite odierne";
	$today_visitors="Visitatori odierni";
	$yesterday_visits="Visite di ieri";
	$yesterday_visitors="Visitatori di ieri";
	$last_visits="Ultime visite";

	//dump page
	$back="Ritorna alla pagina principale";
	$timestamp_label="Data & ora";
	$php_self_label="Pagina visitata";
	$remote_host_label="Translate it";
	$remote_addr_label="Indirizzo IP";
	$http_host_label="Translate it";
	$request_uri_label="Translate it";
	$http_referer_label="Pagina di provenienza";
	$http_user_agent_label="Browser del visitatore";

	//errori
	$mysql_server_error="Errore nella connessione con il server MySQL!";
	$db_connection_error1="Errore nella connessione al database ";
	$db_connection_error2="";
	$attack="Attacco rilevato!";
	break;

default: //DEFAULT ENGLISH LANGUAGE
	//main page
	$site_label="Site";
	$today_visits="Today's visits";
	$today_visitors="Today's visitors";
	$yesterday_visits="Yesterday's visits";
	$yesterday_visitors="Yesterday's visitors";
	$last_visits="Last visits";

	//dump page
	$back="Back to the main page";
	$timestamp_label="Sort by Timestamp";
	$php_self_label="php_self";
	$remote_host_label="Remote Host";
	$remote_addr_label="IP";
	$http_host_label="Domain or Subdomain)";
	$request_uri_label="SORT BY URL";
	$http_referer_label="Referrer";
	$http_user_agent_label="User Agent";

	//errors
	$mysql_server_error="Error connecting to MySQL server!";
	$db_connection_error1="Error connecting to ";
	$db_connection_error2=" database!";
	$attack="Attack detected!";
	break;
} // end switch $language
?>