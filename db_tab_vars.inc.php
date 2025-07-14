<?php
$id = htmlspecialchars($row['id'], ENT_QUOTES, 'UTF-8');#0
$timestamp = htmlspecialchars($row['timestamp'], ENT_QUOTES, 'UTF-8');#1
####2
$remote_addr = htmlspecialchars($row['remote_addr'], ENT_QUOTES, 'UTF-8');#3
$http_host = htmlspecialchars($row['http_host'], ENT_QUOTES, 'UTF-8');#4
$request_uri = htmlspecialchars($row['request_uri'], ENT_QUOTES, 'UTF-8');#5
$http_referer = htmlspecialchars($row['referer'], ENT_QUOTES, 'UTF-8');#6
$http_user_agent = htmlspecialchars($row['http_user_agent'], ENT_QUOTES, 'UTF-8');#7
$remote_host = htmlspecialchars($row['remote_host'], ENT_QUOTES, 'UTF-8');#8
$country = htmlspecialchars($row['country'], ENT_QUOTES, 'UTF-8');#9
$datime_txt = htmlspecialchars($row['datime_txt'], ENT_QUOTES, 'UTF-8');#10
$date_txt = htmlspecialchars($row['date_txt'], ENT_QUOTES, 'UTF-8');#11
?>
