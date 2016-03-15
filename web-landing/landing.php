<?php
	// landing object call
	include_once __DIR__ . '/../src/objects/landing.php';
	// get id_landing by domain
	$id_landing = getIdLandingByDomain($_SERVER['SERVER_NAME'],$database);
	// landing initialize
	$landing = new landing($id_landing);
	initLanding($landing,$database);
	// geo_links
	include_once __DIR__ . '/../src/render/geolinks.php';