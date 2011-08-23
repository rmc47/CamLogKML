<?php
require_once("geographics.inc.php");
$testVector = "AB12CD";
echo ($testVector . " -> " . minLatFromMaidenhead($testVector) . "; " . minLongFromMaidenhead($testVector) . " -> " . maxLatFromMaidenhead($testVector) . "; " . maxLongFromMaidenhead($testVector) . "<br />\n");

$testVector = "JO01";
echo ($testVector . " -> " . minLatFromMaidenhead($testVector) . "; " . minLongFromMaidenhead($testVector) . " -> " . maxLatFromMaidenhead($testVector) . "; " . maxLongFromMaidenhead($testVector) . "\n");

$testVector = "JO00";
echo ($testVector . " -> " . minLatFromMaidenhead($testVector) . "; " . minLongFromMaidenhead($testVector) . " -> " . maxLatFromMaidenhead($testVector) . "; " . maxLongFromMaidenhead($testVector) . "\n");

$fields = array("JO", "JN", "IO");
$bigSquares = array();
$k = 0;
for ($i = 0; $i < 100; $i++) {
	for ($j = 0; $j < count($fields); $j++) {
		$bigSquares[$k++] = $fields[$j] . str_pad($i, 2, "0");
	}
}
echo ("<pre>" . print_r($bigSquares) . "</pre>");
?>
<?php echo("Hello");?>