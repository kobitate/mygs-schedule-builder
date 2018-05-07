<?php

	include "form_vars.php";

	// initialize our arrays to save results
	$fullMatch = array(); // matches based on subj name
	$subjMatch = array(); // mathces based on subj code

	// loop through subjects from form_vars.php
	foreach ($search_subjects as $subj => $title) {
		// boolean will prevent duplicates if we match the subject name
		$matchedSubj = false;

		// search the current subject name for the query
		if (stripos($subj, $_GET["q"]) !== false && !empty($_GET["q"])) {
			// add our match to the array
			$subjMatch[count($subjMatch)+1] = array(
				"id" => $subj,
				"text" =>  html_entity_decode($title),
				"subj" => $subj
			);
			$matchedSubj = true;
		}

		// search teh current subject code for the query
		if ((stripos($title, $_GET["q"]) !== false && !$matchedSubj) || empty($_GET["q"])) {
			// the 1000 + puts the non-subject matches after the subject matches
			$fullMatch[1000 + count($fullMatch)+1] = array(
				"id" => $subj,
				"text" => html_entity_decode($title),
				"subj" => $subj
			);
		}
	}

	// combine the two ordered arrays
	$merged = array_merge($subjMatch, $fullMatch);

	// return the json encoded data
	echo json_encode($merged);

?>
