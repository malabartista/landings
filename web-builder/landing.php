<?php
	// landing object call
	include_once __DIR__ . '/../src/objects/landing2.php';
	// landing initialize
	$landing = new landing(0);
	$landing->title = "Web Builder";
	$landing->layout_template = "-builder";