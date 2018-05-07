<?php

	require_once("database.php");

	// init our DB object from database.php
	$dbConn = new Database();
	$dbConn->openConn();

	// build our query options
	$query = array(
		"course_prefix" 		=> $_GET["subj"],
		"course_number" 		=> $_GET["courseNumber"],
		"course_availability" 	=> "",
		"course_term" 			=> $_GET["term"],
		"course_level" 			=> "",
		//"course_location" 		=> $_GET["campus"],
		"course_location" 		=> "",
		"course_keywords" 		=> "",
		"course_session" 		=> "",
		"course_starttime" 		=> "",
		"starttime_hour" 		=> "",
		"starttime_minute" 		=> "",
		"starttime_am_pm" 		=> "",
		"course_endtime" 		=> "",
		"endtime_hour" 			=> "",
		"endtime_minute" 		=> "",
		"endtime_am_pm" 		=> "",
		"course_startdate" 		=> "MM%2FDD%2FYYYY",
		"course_enddate" 		=> "MM%2FDD%2FYYYY",
		"course_instructor" 	=> "",
		"course_department" 	=> ""
	);

	// send our query off to Banner
	$rows = $dbConn->departmentSearch($query);

	// array for just the titles of courses, prevents duplicate entries
	$coursesRaw = array();

	// build our results array
	$return = array();
	foreach ($rows as $course) {
		// build full title. Example: IT 5090: Data Comm and Networking
		$fullTitle = $course["Subject"] . " " . $course["Number"] . ": " . $course["Title"];
		$fullTitle = html_entity_decode($fullTitle);

		// build course slug, used in the DIV ID
		$slug = $course["Subject"] . $course["Number"];
		if ((stripos($fullTitle, $_GET["q"]) !== false || empty($_GET["q"])) && !in_array($fullTitle, $coursesRaw) ) {
			$return[] = array(
				"id" => $slug,
				"text" => $fullTitle
			);
			$coursesRaw[] = $fullTitle;
		}
	}

	// return our json encoded results
	echo json_encode($return);

?>
