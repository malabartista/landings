<?php
	require_once __DIR__ . '/../../vendor/autoload.php';
	Twig_Autoloader::register();
	//$loader = new Twig_Loader_Filesystem(__DIR__ . '/../templates/landing' . $layout_template . '/');
	$loader = new Twig_Loader_Filesystem(__DIR__ . '/../templates/landing/');
	$twig = new Twig_Environment($loader, array());
	//$twig = new Twig_Environment($loader, array('cache' => __DIR__ . '/cache/compilation/',));

	// load template
	$template = $twig->loadTemplate('layout' . $landing->layout_template . '.html');