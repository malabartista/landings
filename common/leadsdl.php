<?php

	require_once __DIR__ . '/../src/render/dbvars.php';

	$domain = '';
	$landing = '';
	$type = '';
	$controlC2CSend = '';
	$phone = '';
	$nombreSend = '';
	$emailSend = '';
	$ip = '';

	if(isset($_POST['iDomain'])) {$domain = $_POST['iDomain'];}
	if(isset($_POST['iLanding'])) {$landing = $_POST['iLanding'];}

	if(isset($_POST['iType'])) {$type = $_POST['iType'];}
	if(isset($_POST['iControl'])) {$controlC2CSend = $_POST['iControl'];}

	if(isset($_POST['iPhone'])) {$phone = $_POST['iPhone'];}
	if(isset($_POST['iName'])) {$nombreSend = $_POST['iName'];}
	if(isset($_POST['iMail'])) {$emailSend = $_POST['iMail'];}


	// database connection
	$mysqli = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
	if ($mysqli->connect_errno) {
	    //echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	}

	if (!$mysqli->query("INSERT INTO leads (phone,domain,baselanding,type,controlc2c,discharge_date,name,email,ip,response) 
			VALUES (" . $phone . ", '" . $domain . "', '" . $landing . "', '" . $type . "','" . $controlC2CSend . "',  CURRENT_TIMESTAMP, '" . $nombreSend . "', '" . $emailSend . "',INET_ATON('" . $_SERVER['REMOTE_ADDR']. "'),'" . $response . "')")) {
	    //echo "Table insert failed: (" . $mysqli->errno . ") " . $mysqli->error;
	}
