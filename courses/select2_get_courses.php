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
	$coursesReturned = array();

	// build our results array
	$return = array();
	foreach ($rows as $course) {
		// build full title. Example: IT 5090: Data Comm and Networking
		$fullTitle = $course["Subject"] . " " . $course["Number"] . ": " . $course["Title"];
		$fullTitle = html_entity_decode($fullTitle);

		// the title we will use to eliminate duplicates
		// we need both an all-lowerecase and one which replaces ampersands with "and"
		// there are some courses that have duplicates with different capitalization, ampersands, etc.
		// this accounts for that
		$fullTitleDupe = strtolower($fullTitle);
		$fullTitleDupeAmp = str_ireplace("&", "and", $fullTitleDupe);

		// build course slug, used in the DIV ID
		$slug = $course["Subject"] . $course["Number"];

		// check for dupes and search the user's query
		$isDupe = in_array($fullTitleDupe, $coursesReturned) || in_array($fullTitleDupeAmp, $coursesReturned);
		$foundInQuery = (stripos($fullTitle, $_GET["q"]) !== false || empty($_GET["q"]));

		if ($foundInQuery && !$isDupe) {
			// save the information to return later
			$return[] = array(
				"id" => $slug,
				"text" => $fullTitle
			);

			// remember which courses we've already found
			$coursesReturned[] = $fullTitleDupe;
			$coursesReturned[] = $fullTitleDupeAmp;
		}
	}

	// return our json encoded results
	echo json_encode($return);

?>
