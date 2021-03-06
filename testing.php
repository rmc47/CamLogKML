<?php
require_once("geographics.inc.php");
require_once("logFunctions.php.inc"); // Hooray for consistency

//header ("Content-Type: application/vnd.google-earth.kml+xml");
header("Content-Type: text/plain");
date_default_timezone_set("UTC");

$bigSquares = array();
$k = 0;
for ($i = 40; $i < 100; $i++) {
	$bigSquares[$k++] = "IO" . str_pad($i, 2, "0", STR_PAD_LEFT);
}
for ($i = 40; $i < 100; $i++) {
	$bigSquares[$k++] = "IN" . str_pad($i, 2, "0", STR_PAD_LEFT);
}
for ($i = 0; $i < 60; $i++) {
	$bigSquares[$k++] = "JO" . str_pad($i, 2, "0", STR_PAD_LEFT);
}
for ($i = 0; $i < 60; $i++) {
	$bigSquares[$k++] = "JN" . str_pad($i, 2, "0", STR_PAD_LEFT);
}

?>
<?xml version="1.0" encoding="UTF-8"?>
<kml xmlns="http://www.opengis.net/kml/2.2">
<NetworkLinkControl>
	<expires><?php echo (date("c", strtotime("+15 seconds"))); ?></expires>
</NetworkLinkControl>
<Document>
  <Style id="red">
	<PolyStyle>
      <color>700000ff</color>
      <colorMode>normal</colorMode>
    </PolyStyle>
  </Style>
    <Style id="green">
	<PolyStyle>
      <color>7000ff00</color>
      <colorMode>normal</colorMode>
    </PolyStyle>
  </Style>
<?php
for ($i = 0; $i < count($bigSquares); $i++) {
	$bigSquare = $bigSquares[$i];
	?>
	  <Placemark>
		  <name><?php echo($bigSquare); ?></name>
		  <styleUrl>#<?php echo (getSquareColour($bigSquare)); ?></styleUrl>
		  <Polygon>
			<tessellate>1</tessellate>
			<altitudeMode>clampToGround</altitudeMode>
			<outerBoundaryIs>
			  <LinearRing>
				<coordinates>
				<?php
					echo (
						minLongFromMaidenhead($bigSquare) . "," . minLatFromMaidenhead($bigSquare) . ",10," .
						minLongFromMaidenhead($bigSquare) . "," . maxLatFromMaidenhead($bigSquare) . ",10," .
						maxLongFromMaidenhead($bigSquare) . "," . maxLatFromMaidenhead($bigSquare) . ",10," .
						maxLongFromMaidenhead($bigSquare) . "," . minLatFromMaidenhead($bigSquare) . ",10," .
						minLongFromMaidenhead($bigSquare) . "," . minLatFromMaidenhead($bigSquare) . ",10");
				?></coordinates>
			  </LinearRing>
			</outerBoundaryIs>
		  </Polygon>
	</Placemark>
	<?php
}

foreach (getContacts() as $callsign => $locator) {
	?><Placemark>
		<name><?php echo ($callsign); ?></name>
		<Point><Coordinates><?php echo (minLongFromMaidenhead($locator) . "," . minLatFromMaidenhead($locator)); ?></Coordinates></Point>
	</Placemark><?php
}
?>
</Document> 
</kml>