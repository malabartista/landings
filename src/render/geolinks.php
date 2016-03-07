<?php
	// Create connection
	$conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
	// Check connection
	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	}

	/*
	$sql = "SELECT name FROM cities ORDER BY rand() LIMIT 10";
	$result = $conn->query($sql);

	if ($result->num_rows > 0) {
	    // output data of each row
	    $cities_arr = array();
	    while($row = $result->fetch_assoc()) {
	    	$geocity = ['name' => $row["name"],'link' => str_replace(' ', '-',$row["name"])];
	    	array_push($cities_arr, $geocity);
	    }
	} else {
	    //echo "0 results";
	}
	*/

	$sql = "SELECT name FROM cities ORDER BY id LIMIT 51";
	$result = $conn->query($sql);

	if ($result->num_rows > 0) {
	    // output data of each row
	    $landing->cities_main_arr = array();
	    while($row = $result->fetch_assoc()) {
	    	$geocity = ['name' => $row["name"],'link' => str_replace(' ', '-',$row["name"])];
	    	array_push($landing->cities_main_arr, $geocity);
	    }
	} else {
	    //echo "0 results";
	}