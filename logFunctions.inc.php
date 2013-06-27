<?php
mysql_connect('localhost', 'user', 'passwd');
$dbName = mysql_real_escape_string($_GET["db"]);

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
	
	$res = mysql_db_query($dbName, "SELECT callsign, locator FROM log ORDER BY id DESC") or die ("Error getting log entries"); // List backwards so we can count off first ten fordifferent colour pin
	$i = 0;
	$contacts = array();
	while ($arr = mysql_fetch_array($res)) {
		$contacts[$arr[0]] = $arr[1];
	}
	return $contacts;
}
