<?php

	require_once("database.php");
	require_once('../../api/portal/globals/oracle-connection.php');
	require_once('../../api/portal/globals/banner-functions.php');


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

	$return = array();
	$i = 0;
	foreach ($rows as $course) {
		$bldgNumQuery = "SELECT ssrmeet_bldg_code FROM ssrmeet WHERE ssrmeet_crn = :crn AND ssrmeet_term_code = :term";
		$bldgNumStmt = oci_parse($my_conn, $bldgNumQuery);

 		oci_bind_by_name($bldgNumStmt, ":crn", $course["crn"], 5);
 		oci_bind_by_name($bldgNumStmt, ":term", $_GET["term"], 6);
		oci_execute($bldgNumStmt);
		oci_fetch_all($bldgNumStmt, $bldgNum);

		$bldgNum = $bldgNum["SSRMEET_BLDG_CODE"][0];
		$bldgNum = ltrim($bldgNum, "0");

		$instructor = 		$course["Instructor"];
		$crn = 				$course["crn"];

		$return[$instructor]["sections"][$crn][] = array(
			"days"  				=> $course["DAYS"],
			"startTime"  			=> date("g:i a", strtotime($course["Class Start Time"])),
			"endTime"  				=> date("g:i a", strtotime($course["Class End Time"])),
			"seatsAvailable" 		=> $course["Seats Avail"],
			"seatsMax" 				=> $course["Max Seats"],
			"crn" 					=> $course["crn"],
			"section" 				=> $course["Section"],
			"subject" 				=> $course["Subject"],
			"number" 				=> $course["Number"],
			"title" 				=> $course["Title"],
			"location" 				=> $course["Building"] . " " . $course["Room"],
			"campus" 				=> $course["Location Desc"],
			"campusId"				=> $course["Location"],
			"credits"  				=> $course["Credit Hrs"],
			"session" 				=> $course["Session Desc"],
			"additionalInfo"		=> ($course["Addl Info"] !== "N" ? $course["Addl Info"] : false),
			"onlineOnly" 			=> ($course["Int Only"] == "Y"),
			"hybrid" 				=> ($course["Part/Hybrd"] == "Y"),
			"lab" 					=> ($course["Lab"] == "Y"),
			"approvalRequired" 		=> ($course["Approval"] == "Y" ? $course["Approval Desc"] : false),
			"description" 			=> $dbConn->courseDescription($_GET["term"], $_GET["subj"], $_GET["courseNumber"]),
			"buildingNum"			=> $bldgNum
		);
	}

	echo json_encode($return);

?>
