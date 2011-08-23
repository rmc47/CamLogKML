<?php
//        public static void LatLongFromMaidenhead(string maidenhead, out double latitude, out double longitude)
//        {
//            if (maidenhead == null || maidenhead.Length != 6)
//                throw new ArgumentException("Locator must be 6 characters long", "maidenhead");
//
//            // Get everything into nice workable ints :-)
//            maidenhead = maidenhead.Trim().ToUpperInvariant();
//            int fieldLong = maidenhead[0] - 'A';
//            int fieldLat = maidenhead[1] - 'A';
//            if (fieldLong > 18 || fieldLong < 0 || fieldLat > 18 || fieldLat < 0)
//                throw new ArgumentException("Field is outside range A-R", "maidenhead");
//            int squareLong = maidenhead[2] - '0';
//            int squareLat = maidenhead[3] - '0';
//            if (squareLong > 9 || squareLong < 0 || squareLat > 9 || squareLat < 0)
//                throw new ArgumentException("Square must be 0-9", "maidenhead");
//            int subLong = maidenhead[4] - 'A';
//            int subLat = maidenhead[5] - 'A';
//            if (subLong > 24 || subLong < 0 || subLat > 24 || subLat < 0)
//                throw new ArgumentException("Subsquare must be a-x", "maidenhead");
//
//            latitude = ((double)fieldLat * 10) + (double)squareLat + ((double)subLat / 24) - 90;
//            longitude = ((double)fieldLong * 20) + (double)squareLong * 2 + ((double)subLong / 12) - 180;
//        }

function letterToInt($str, $index) {
	$alphabet = "abcdefghijklmnopqrstuvwxyz";
	$justOurLetter = substr($str, $index, 1);
	return strpos($alphabet, $justOurLetter, 0);
}

function numberToInt($str, $index) {
	$alphabet = "0123456789";
	$justOurLetter = substr($str, $index, 1);
	return strpos($alphabet, $justOurLetter, 0);
}

function minLongFromMaidenhead ($maidenhead) {
	$fieldLong = letterToInt($maidenhead, 0);
	$longitude = $fieldLong * 20;
	if (strlen($maidenhead) > 2) {
		$squareLong = numberToInt($maidenhead, 2);
		$longitude += $squareLong * 2;
	}
	if (strlen($maidenhead) > 4) {
		$subLong = letterToInt($maidenhead, 4);
		$longitude += $subLong / 12;
	}
	return $longitude - 180;
}

function minLatFromMaidenhead ($maidenhead) {
	$fieldLong = letterToInt($maidenhead, 1);
	$longitude = $fieldLong * 10;
	if (strlen($maidenhead) > 2) {
		$squareLong = numberToInt($maidenhead, 3);
		$longitude += $squareLong;
	}
	if (strlen($maidenhead) > 4) {
		$subLong = letterToInt($maidenhead, 5);
		$longitude += $subLong / 24;
	}
	return $longitude - 90;
}

function maxLongFromMaidenhead($maidenhead) {
	$figures = strlen($maidenhead);
	if ($figures == 2) {
		return minLongFromMaidenhead($maidenhead) + 20;
	} elseif ($figures == 4) {
		return minLongFromMaidenhead($maidenhead) + 2;
	} elseif ($figures == 6) {
		return minLongFromMaidenhead($maidenhead) + (1/12);
	} else {
		die("Invalid number of figures: " . $figures);
	}
}

function maxLatFromMaidenhead($maidenhead) {
	$figures = strlen($maidenhead);
	if ($figures == 2) {
		return minLatFromMaidenhead($maidenhead) + 10;
	} elseif ($figures == 4) {
		return minLatFromMaidenhead($maidenhead) + 1;
	} elseif ($figures == 6) {
		return minLatFromMaidenhead($maidenhead) + (1/24);
	} else {
		die("Invalid number of figures: " . $figures);
	}
}
?>