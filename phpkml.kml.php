<?php
require_once("geographics.inc.php");
require_once("logFunctions.inc.php"); // Hooray for consistency

//header ("Content-Type: application/vnd.google-earth.kml+xml");
header("Content-Type: text/plain");
date_default_timezone_set("UTC");

$bigSquares = array();
$k = 0;
for ($i = 40; $i < 100; $i++) {
	$bigSquares[$k++] = "io" . str_pad($i, 2, "0", STR_PAD_LEFT);
}
for ($i = 40; $i < 100; $i++) {
	$bigSquares[$k++] = "in" . str_pad($i, 2, "0", STR_PAD_LEFT);
}
for ($i = 0; $i < 60; $i++) {
	$bigSquares[$k++] = "jo" . str_pad($i, 2, "0", STR_PAD_LEFT);
}
for ($i = 0; $i < 60; $i++) {
	$bigSquares[$k++] = "jn" . str_pad($i, 2, "0", STR_PAD_LEFT);
}

?>
<? echo "<?"; ?>xml version="1.0" encoding="UTF-8"?>
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
  <Style id="m_ylw-pushpin">
    <IconStyle>
      <scale>1.1</scale>
      <Icon>
        <href>http://maps.google.com/mapfiles/kml/pushpin/ylw-pushpin.png</href>
      </Icon>
      <hotSpot x="20" y="2" xunits="pixels" yunits="pixels"/>
    </IconStyle>
    <ListStyle>
    </ListStyle>
  </Style>
  <Style id="m_grn-pushpin">
    <IconStyle>
     <scale>1.1</scale>
     <Icon>
       <href>http://maps.google.com/mapfiles/kml/pushpin/grn-pushpin.png</href>
     </Icon>
     <hotSpot x="20" y="2" xunits="pixels" yunits="pixels"/>
    </IconStyle>
    <ListStyle>
    </ListStyle>
  </Style>
<?php
echo "
  <Folder>
    <name>Grid</name>
";
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
echo "
  </Folder>
  <Folder>
    <name>Contacts</name>
";
$cCnt = 0; // Colour count
foreach (getContacts() as $callsign => $locator) {
	?><Placemark>
		<name><?php echo ($callsign); ?></name>
                <styleUrl>#m_<?php if($cCnt < 5) { echo "grn"; } else { echo "ylw"; } $cCnt ++?>-pushpin</styleUrl>
		<Point><coordinates><?php echo (minLongFromMaidenhead(strtolower($locator)) . "," . minLatFromMaidenhead(strtolower($locator))); ?></coordinates></Point>
	</Placemark><?php
}
echo "
  </Folder>";
?>
</Document> 
</kml>
