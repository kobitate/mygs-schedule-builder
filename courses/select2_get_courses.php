<?php

	require_once("database.php");

	$dbConn = new Database();
	$dbConn->openConn();

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

	$rows = $dbConn->departmentSearch($query);

	$coursesRaw = array();

	$return = array();
	foreach ($rows as $course) {
		$fullTitle = $course["Subject"] . " " . $course["Number"] . ": " . $course["Title"];
		$fullTitle = html_entity_decode($fullTitle);
		
		$slug = $course["Subject"] . $course["Number"];
		if ((stripos($fullTitle, $_GET["q"]) !== false || empty($_GET["q"])) && !in_array($fullTitle, $coursesRaw) ) {
			$return[] = array(
				"id" => $slug,
				"text" => $fullTitle
			);
			$coursesRaw[] = $fullTitle;
		}
	}

	echo json_encode($return);

?>
