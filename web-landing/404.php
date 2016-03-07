<?php
	// landing
	include_once __DIR__ . '/landing.php';
	// template
	$landing->layout_template = '404';
	// twig replace
	include_once __DIR__ . '/../src/render/twig.php';