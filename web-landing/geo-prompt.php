<?php
	require_once __DIR__ . '/../vendor/geonames/Geonames.php';

	$lat = floatval($_GET["lat"]);
	$lng = floatval($_GET["lng"]);
	$geo = new Geonames("elchampion");
	$prompt = "Ofertas";
	try {
	   $place = $geo->getPlaceName($lat, $lng);
	   if ($place != "Unknown") {
	       $prompt .= " en " . $place;
	   }
	}
	catch (Exception $e) {
	   error_log("Error with web service: " . $e->getMessage());
	}
	header("Content-Type: text/plain");
	echo $prompt;