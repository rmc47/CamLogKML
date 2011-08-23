<?php
mysql_connect("192.168.43.137", "root", "g3pye");
$dbName = "ukac0823";

function getSquareColour($square) {
	global $dbName;

	$res = mysql_db_query($dbName, "SELECT COUNT(*) FROM log WHERE locator LIKE '$square%'") or die ("Error getting whether square worked" . mysql_error());
	if ($arr = mysql_fetch_array($res)) {
		$count = $arr[0];
		if ($count > 0)
			return "green";
		else
			return "red";
	}
}

function getContacts() {
	global $dbName;
	
	$res = mysql_db_query($dbName, "SELECT callsign, locator FROM log") or die ("Error getting log entries");
	$i = 0;
	$contacts = array();
	while ($arr = mysql_fetch_array($res)) {
		$contacts[$arr[0]] = $arr[1];
	}
	return $contacts;
}