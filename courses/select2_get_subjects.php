<?php

	include "form_vars.php";

	$fullMatch = array();
	$subjMatch = array();

	foreach ($search_subjects as $subj => $title) {
		$matchedSubj = false;
		if (stripos($subj, $_GET["q"]) !== false && !empty($_GET["q"])) {
			$subjMatch[count($subjMatch)+1] = array(
				"id" => $subj,
				"text" =>  html_entity_decode($title),
				"subj" => $subj
			);
			$matchedSubj = true;
		}
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

	echo json_encode($merged);

?>
