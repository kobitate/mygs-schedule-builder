var M = 1;
var T = 2;
var W = 3;
var R = 4;
var F = 5;

var MWF = [M,W,F];
var MW 	= [M,W];
var TR 	= [T,R];

// the January 1st 2001 works out to have monday as the first, tuesday as the second, etc.
// this simplifies things for us, hence the start date of January 1st 2001
var DATE_M = "2001-01-01";
var DATE_T = "2001-01-02";
var DATE_W = "2001-01-03";
var DATE_R = "2001-01-04";
var DATE_F = "2001-01-05";

var CAL_TIME_START 		= "08:00:00";
var CAL_TIME_END		= "22:00:00";
var CAL_TIME_INTERVAL	= "01:00:00";

var cal;

// event info placeholders
var hoveredEvents = [];
var events = [];
var eventDetails = [];

// saved courses
var saved = [];

// define some pretty colors for the events
var eventColors = [
	"#d50000",
	"#00b8d4",
	"#6200ea",
	"#2962ff",
	"#0091ea",
	"#304ffe",
	"#c51162",
	"#aa00ff"
];

// init to the first color
var eventColorN = 0;

function addEvent(day, startTime, endTime, course, courseTitle, crn, location, color, type) {

	// convert week character into date on scheduler
	var date 		= window["DATE_" + day];

	// build a ISO8601 date string
	var startDate 	= date + "T" + startTime + ":00";
	var endDate 	= date + "T" + endTime + ":00";

	// format title
	var title = course.trim() + ": "+ courseTitle.trim();

	var id = crn + "_" + day;

	var calendarEvent = [{
		id:			id,
		title: 		title,
		start: 		startDate,
		end:		endDate,
		color:		color,
		className:	[type],
		details:	{
			location: location.trim(),
			course:	course.trim(),
			crn: crn
		}
	}];

	// add to scheduler
	cal.fullCalendar("addEventSource", calendarEvent);

	return id;

}

function saveCourse(course, courseTitle, profs) {
	// build the ids
	var elementID = "course-" + ($(".course").length + 1);
	var panelID = "course-panel-" + course.trim().replace(/ /g,"_").replace(".", "-ARM");

	// build the HTML template for the panel
	var html = `
		<div class="panel panel-default" id="${panelID}">
			<div class="panel-heading">
				<span class="course-title" data-toggle="collapse" href="#${elementID}">
					<span class="course-color"></span>
					${course}: ${courseTitle}
				</span>
				<span class="course-remove pull-right close">&times;</span>
			</div>
			<div class="collapse in course" id="${elementID}" data-eventcolor="${eventColors[eventColorN]}">
				<table class="table table-condensed">
					<tbody></tbody>
				</table>
			</div>
		</div>
	`;

	// add the panel to the list of saved courses
	$("#saved-courses").append(html);

	// get the newly added list
	var courseElement = $("#" + elementID);

	// loop through list of professors teaching the course
	$.each(profs, function(profName, sections){
		// build the HTML template
		var profHtml = `
			<tr class="professor">
				<th colspan="5">
					<strong>${profName}</strong>
				</th>
			</tr>
		`;

		// loop through each section the professor is teaching
		// note that sections may have multiple instances (sectionBlock) to display separate rooms/times
		$.each(sections.sections, function(crn, sectionBlock) {
			// loop through instances of courses
			$.each(sectionBlock, function(sectionIndex, section) {
				// define the template
				var sectionHtml;

				// clean up the description
				section.description = section.description.addSlashes();

				// check if the course already exists in the saved list (for courses with multiple instances)
				var sectionRow = $(profHtml).filter("tr.course-section-" + section.crn);
				if (sectionRow.length > 0) {
					/* // Remove times within 1 minute (used for when a class is in one of two rooms)
					var prevStartTime = sectionRow.find("td.course-hours").first().text().split(" - ")[0];
					var prevDays = sectionRow.find("td.course-days").first().text();

					var prevStart = moment(prevStartTime, "h:mm a");
					var thisStart = moment(section.startTime, "h:mm a");
					var diff = Math.abs(prevStart.diff(thisStart));

					if (!(prevDays == section.days && diff > 6000)) {
						var newDays = "<br />" + section.days;
						var newHours = "<br />" + section.startTime + " - " + section.endTime
						sectionRow.find("td.course-days").append(newDays);
						sectionRow.find("td.course-hours").append(newHours);
						profHtml = $(profHtml).filter("tr.course-section-" + section.crn).html(sectionRow).html();
					} */

					// append new data
					var newDays = "<br />" + section.days;
					var newHours = "<br />" + section.startTime + " - " + section.endTime
					var locString = sectionRow.data("location") + "," + section.location;
					var bldgString = sectionRow.data("building") + "," + section.buildingNum;

					sectionRow.find("td.course-days").append(newDays);
					sectionRow.find("td.course-hours").append(newHours);
					sectionRow.attr("data-location", locString);
					sectionRow.attr("data-building", bldgString);

					profHtml = $(profHtml).filter("tr.course-section-" + section.crn).html(sectionRow).html();
				}
				// check if course is an online class 
				else if (!section.onlineOnly) {
					var displayTimes;

					if (section.days === null) {
						displayTimes = `<td colspan="2">Unspecified</td>`;
					} else {
						displayTimes = `
							<td class="course-days">${sections.days}</td>
							<td class="course-hours">${section.startTime} - ${section.endTime}</td>
						`;
					}

					// define the html template
					sectionHtml = `
						<tr class="course-section course-section-${section.crn} course-at-${section.campusId}"
								data-crn="${section.crn}"
								data-location="${section.location}"
								data-building="${section.buildingNum}"
								data-campus="${section.campus}"
								data-description="${section.description}"
								data-session="${section.session}"
								data-credits="${section.credits}"
								data-additionalinfo="${section.additionalInfo}"
								data-approvalrequired="${section.approvalRequired}"
								data-hybrid="${section.hybrid}"
								data-lab="${section.lab}"
								data-onlineonly="${section.onlineOnly}"
								data-session="${section.session}">
							<td><span class="glyphicon glyphicon-ok course-active"></span></td>
							${displayTimes}
							<td class="course-seats">${section.seatsAvailable}/${section.seatsMax}</td>
							<td class="course-infolink">
								<a href="#" class="btn btn-xs btn-default">Info</a>
							</td>
						</tr>
					`;
				}
				// define a new course
				else {
					// define the html template
					sectionHtml = `
						<tr class="course-section course-section-online course-section-${section.crn} course-at-${section.campusId}"
								data-crn="${section.crn}"
								data-location="${section.location}"
								data-building="${section.buildingNum}"
								data-campus="${section.campus}"
								data-description="${section.description}"
								data-session="${section.session}"
								data-credits="${section.credits}"
								data-additionalinfo="${section.additionalInfo}"
								data-approvalrequired="${section.approvalRequired}"
								data-hybrid="${section.hybrid}"
								data-lab="${section.lab}"
								data-onlineonly="${section.onlineOnly}"
								data-session="${section.session}">
							<td><span class="glyphicon glyphicon-ok course-active"></span></td>
							<td class="course-days"><span class="glyphicons glyphicons-globe"></span></td>
							<td class="course-hours">Online Only</td>
							<td class="course-seats">${section.seatsAvailable}/${section.seatsMax}</td>
							<td class="course-infolink">
								<a href="#" class="btn btn-xs btn-default">Info</a>
							</td>
						</tr>
					`;
				}
				// append the prof's courses to the section's list of courses
				profHtml += sectionHtml;
			});
		});
		courseElement.find("tbody").append(profHtml);
	});

	// define the course's color
	courseElement.closest(".panel").find(".course-color").css("background-color", eventColors[eventColorN]);
	courseElement.find(".course-active").css("color", eventColors[eventColorN]);

	toCampus(getSelectedCampus());

	// increment color index
	eventColorN++;

	// if the color index is too high, reset to 0
	if (eventColorN >= eventColors.length) {
		eventColorN = 0;
	}

	// bind click to info button in list of sections
	$(".course-infolink a").click(function() {
		// get the course info the user clicked on
		var course = $(this).closest("tr.course-section");

		// parse, save, and display the details
		saveCourseDetails(course, false)
		displayCourseDetails(eventDetails[course.data("crn")]);
	});

	/*
	─────────────────────────────▄██▄
	─────────────────────────────▀███
	──BIND ALL THE THINGS───────────█
	───────────────▄▄▄▄▄────────────█
	──────────────▀▄────▀▄──────────█
	──────────▄▀▀▀▄─█▄▄▄▄█▄▄─▄▀▀▀▄──█
	─────────█──▄──█────────█───▄─█─█
	─────────▀▄───▄▀────────▀▄───▄▀─█
	──────────█▀▀▀────────────▀▀▀─█─█
	──────────█───────────────────█─█
	▄▀▄▄▀▄────█──▄█▀█▀█▀█▀█▀█▄────█─█
	█▒▒▒▒█────█──█████████████▄───█─█
	█▒▒▒▒█────█──██████████████▄──█─█
	█▒▒▒▒█────█───██████████████▄─█─█
	█▒▒▒▒█────█────██████████████─█─█
	█▒▒▒▒█────█───██████████████▀─█─█
	█▒▒▒▒█───██───██████████████──█─█
	▀████▀──██▀█──█████████████▀──█▄█
	──██───██──▀█──█▄█▄█▄█▄█▄█▀──▄█▀
	──██──██────▀█─────────────▄▀▓█
	──██─██──────▀█▀▄▄▄▄▄▄▄▄▄▀▀▓▓▓█
	──████────────█▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓█
	──███─────────█▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓█
	──██──────────█▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓█
	──██──────────█▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓█
	──██─────────▐█▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓█
	──██────────▐█▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓█
	──██───────▐█▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓█▌
	──██──────▐█▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓█▌
	──██─────▐█▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓█▌
	──██────▐█▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓█▌
	*/
	registerCourseListeners();

}

function saveCourseDetails(sectionElement, shouldAddToCalendar) {
	// get the section information
	var days = 				sectionElement.find("td.course-days").html();
	var hours = 			sectionElement.find("td.course-hours").html();
	var title = 			sectionElement.closest(".panel").find(".panel-heading .course-title").text();
	var color = 			sectionElement.closest(".course").data("eventcolor");

	var location = 			sectionElement.data("location");
	var campus = 			sectionElement.data("campus");
	var building = 			sectionElement.data("building") + "";
	var crn = 				sectionElement.data("crn");
	var description = 		sectionElement.data("description");
	var session = 			sectionElement.data("session");
	var credits = 			sectionElement.data("credits");
	var professor = 		sectionElement.prev(".professor").text().trim();
	var seats =				sectionElement.find("td.course-seats").text().trim();
	var additionalInfo =	sectionElement.data("additionalinfo");
	var session =			sectionElement.data("session");
	var approvalRequired = 	sectionElement.data("approvalrequired");
	var hybrid = 			sectionElement.data("hybrid");
	var lab = 				sectionElement.data("lab");
	var onlineOnly = 		sectionElement.data("onlineonly");

	var isOnline = 		sectionElement.hasClass("course-section-online");

	// break apart the days, hours, and location into each individual session
	days = days.split("<br>");
	hours = hours.split("<br>");
	location = location.split(",");
	building = building.split(",");

	// split the title into the course ID (Ex: IT 1000) and the title (Ex: Intro to IT)
	title = title.split(": ");

	// create an array to add our event objects to
	var newEvents = [];

	// loop through the sessions
	for (var i = 0; i < days.length; i++) {
		// split days into individual weekdays (ex: MWF becomes ["M","W","F"])
		var dayLine = days[i].split("");

		// split time into start and ed times, convert to 24 hour time
		var hourLine = [];
		if (!isOnline) {
			hourLine = hours[i].split(" - ");
			hourLine[0] = convertTo24Hour(hourLine[0]).trim();
			hourLine[1] = convertTo24Hour(hourLine[1]).trim();
		} else {
			hourLine[0] = "";
			hourLine[1] = "";
		}

		// loop through individual days
		for (var j = 0; j < dayLine.length; j++) {
			// create event object and add to the events list
			var k = newEvents.length;
			if (shouldAddToCalendar  && days !== null) {
				newEvents[k] = addEvent(dayLine[j], hourLine[0], hourLine[1], title[0], title[1], crn, location[0], color, "added");
			}
			// save the details of each session
			var thisEventDetails = [];

			thisEventDetails["days"] = days;
			thisEventDetails["times"] = hours;
			thisEventDetails["courseID"] = title[0];
			thisEventDetails["courseTitle"] = title[1];
			thisEventDetails["location"] = location;
			thisEventDetails["isOnline"] = isOnline;
			thisEventDetails["campus"] = campus;
			thisEventDetails["building"] = building;
			thisEventDetails["seats"] = seats;
			thisEventDetails["eventColor"] = color;
			thisEventDetails["crn"] = crn;
			thisEventDetails["description"] = description;
			thisEventDetails["session"] = session;
			thisEventDetails["credits"] = credits;
			thisEventDetails["professor"] = professor;
			thisEventDetails["additionalInfo"] = additionalInfo;
			thisEventDetails["session"] = session;
			thisEventDetails["approvalRequired"] = approvalRequired;
			thisEventDetails["hybrid"] = hybrid;
			thisEventDetails["lab"] = lab;
			thisEventDetails["onlineOnly"] = onlineOnly;

			eventDetails[crn] = thisEventDetails;
		}
	}

	events[crn] = newEvents;
}

function displayCourseDetails(details) {
	// add basic text information to modal
	$("#popup-courseTitle").text(details["courseTitle"]);
	$("#popup-courseID").text(details["courseID"]);
	$("#popup-crn").text(details["crn"]);
	$("#popup-session").text(details["session"]);
	$("#popup-professor").text(details["professor"]);
	$("#popup-campus").text(details["campus"]);
	$("#popup-credits").text(details["credits"]);
	$("#popup-description").text(details["description"]);

	// parse seats available string (format is AVAIL/MAX)
	var seats = details["seats"].split("/");

	// get maximum and remaining seats in the section
	var maxSeats = parseInt(seats[1]);
	var remaining = parseInt(seats[0]);

	// calculate percent of seats left (in decimal form)
	var ratio = remaining/maxSeats;

	// display seats remaining in modal
	$("#popup-seats").text(remaining + " of " + maxSeats + " seats remaining");

	// strip all colors from remaining seats label
	$("#popup-seats-label")
		.removeClass("label-danger")
		.removeClass("label-warning")
		.removeClass("label-success");

	// determine color based on percent seats remaining
	if (ratio <= 0.25) {
		// red
		$("#popup-seats-label").addClass("label-danger");
	}
	else if (ratio <= 0.5) {
		// yellow
		$("#popup-seats-label").addClass("label-warning");
	}
	else {
		// green
		$("#popup-seats-label").addClass("label-success");
	}

	$("#popup-meet-times tbody").empty();

	// add meeting times
	$.each(details["days"], function(i, days) {
		var time = details["times"][i];
		var location = details["location"][i];
		var building = details["building"][i];
		var row = `
			<tr>
				<td>${days}</td>
				<td>${time}</td>
				<td class="popup-table-loc">${location} <a target="_blank" class="label label-primary" href="http://georgiasouthern.edu/map/?id=${building}">Map</a></td>
			</tr>
		`;
		$("#popup-meet-times tbody").append(row);
	});

	// display Online Only label if needed
	if (details["onlineOnly"]) {
		$("#note-onlineOnly").show();
	} else {
		$("#note-onlineOnly").hide();
	}

	// display Hybrid Course label if needed
	if (details["hybrid"]) {
		$("#note-hybrid").show();
	} else {
		$("#note-hybrid").hide();
	}

	// display Lab label if needed
	if (details["lab"]) {
		$("#note-lab").show();
	} else {
		$("#note-lab").hide();
	}

	// display approval details if needed
	if (details["approvalRequired"] !== false) {
		$("#note-approvalRequired").show();
		// gets some details from the database
		$("#note-approval-details").text(details["approvalRequired"]);
	} else {
		$("#note-approvalRequired").hide();
	}

	// hide location column in the table if online course
	$(".popup-table-loc").toggle(!details["isOnline"]);

	// show the modal
	$("#course-details").modal("show");
}

function setupFullCalendar() {
	// initiate the calendar plugin
	$("#calendar").fullCalendar({
		defaultView: 			"agendaWeek", 		// agenda view
		weekends: 				false,				// hide weekends
		allDaySlot: 			false,				// hide all day slot
		contentHeight: 			"auto",				// expand the calendar to the size of the div
		themeSystem: 			"bootstrap3",		// use built in bootstrap theme
		slotDuration: 			CAL_TIME_INTERVAL,	// the interval between displayed hours
		slotLabelFormat: 		"h:mm a",			// format the displayed hours
		minTime: 				CAL_TIME_START,		// start time
		maxTime: 				CAL_TIME_END,		// end time
		defaultDate: 			DATE_M,				// start date
		columnHeaderFormat: 	"dddd",				// weekday display format
		// hide all controls
		header: {
			left: "",
			center: "",
			right: ""
		},
		// setup event clicking
		eventClick: function(event, jsEvent, view) {
			displayCourseDetails(eventDetails[event.details.crn]);
		}
	});

	// set the cal variable for future access
	cal = $("#calendar");
}

function registerCourseListeners() {
	// unbind all jquery actions to prevent duplicate additions
	$(".course-section").unbind("mouseover");
	$(".course-section").unbind("mouseout");
	$(".course-section").unbind("click");
	$(".course-remove").unbind("click");
	$(".course-remove").tooltip("destroy");

	// bind remove button (top right corner "x")
	$(".course-remove").click(function() {
		// remove from view
		$(this).closest(".panel").remove();

		var selectedSection = $(this).closest(".panel").find(".course-section.active");
		if (selectedSection.length > 0) {
			var selectedCrn = selectedSection.data("crn");
			$.each(events[selectedCrn], function(i, event) {
				cal.fullCalendar("removeEvents", event)
			});

		}
	});

	// add tooltip to remove button
	$(".course-remove").tooltip({
		title: "Remove Saved Course"
	})

	// bind in-schedule preview to sections table hover
	$(".course-section").mouseover(function() {
		// don't worry about it if the course is already selected
		if ($(this).hasClass("active")) {
			return false;
		}
		// check if course is online only – don't worry about it if it is
		if (!$(this).hasClass("course-section-online")) {
			// retrieve information about the course section
			var days = $(this).find("td.course-days").html();
			var hours = $(this).find("td.course-hours").html();
			var crn = $(this).data("crn");
			var title = $(this).closest(".panel").find(".panel-heading .course-title").text();
			var color = $(this).closest(".course").data("eventcolor");

			// break apart the days an hours for courses that have multiple
			days = days.split("<br>");
			hours = hours.split("<br>");

			// break the title into its course code and title (Ex: "IT 4130: IT Issues and Management")
			title = title.split(": ");

			// loop through days
			for (var i = 0; i < days.length; i++) {
				// split days by character (Ex: "MWF")
				var dayLine = days[i].split("");

				// split hour into start and end time (Ex: "10:10 am - 11:15 am") and convert to 24 hour time
				var hourLine = hours[i].split(" - ");
				hourLine[0] = convertTo24Hour(hourLine[0]).trim();
				hourLine[1] = convertTo24Hour(hourLine[1]).trim();

				// loop through days and add each "ghost" event
				for (var j = 0; j < dayLine.length; j++) {
					hoveredEvents.push(addEvent(dayLine[j], hourLine[0], hourLine[1], title[0], title[1], crn, "Somewhere", color, "hovered"));
				}
			}
		}
	}).mouseout(function() {
		// don't worry about it if the course is already selected
		if ($(this).hasClass("active")) {
			return false;
		} else {
			// remove all hovered ghost events
			for(var i = 0; i < hoveredEvents.length; i++) {
				cal.fullCalendar("removeEvents", hoveredEvents[i]);
			}

			hoveredEvents = [];
		}
	});

	// bind course section click function
	$(".course-section").click(function(e) {
		// ignore the click if we're launching the details modal via link
		if (e.target.nodeName.toLowerCase() == "a") {
			return false;
		} else {
			// delete any hovered events (shouldn't actually matter, but just in case)
			for(var i = 0; i < hoveredEvents.length; i++) {
				cal.fullCalendar("removeEvents", hoveredEvents[i]);
			}
			hoveredEvents = [];

			// get course information
			var course = $(this).closest(".course");
			var crn = $(this).data("crn");
			var activeCourse = course.find(".active");

			// if a section is already selected, we want to remove it first
			if (activeCourse.length > 0) {
				// get the crn we want to remove
				var removeCrn = activeCourse.data("crn");

				// check if an event already exists (mainly to account for online courses)
				if (events[removeCrn] != undefined) {
					// loop through all events and remove them from the scheduler
					for(var i = 0; i < events[removeCrn].length; i++) {
						cal.fullCalendar("removeEvents", events[removeCrn][i]);
					}
					// remove the CRN
					$("#crn-" + removeCrn).remove();
					// @TODO make this better. it is really broken tbh
					$("#selected-crns .crn-spacer").last().remove();
				}

				// unmark the course as active
				activeCourse.removeClass("active");
				if (removeCrn == crn) {
					// do nothing else if we're clicking the same course (removes it without re-adding it to toggle the course)
					return false;
				}
			}

			// mark the current course as selected
			$(this).addClass("active");

			// make sure this isn't an online section
			if (!$(this).hasClass("course-section-online")) {
				// parse and save the course details
				saveCourseDetails($(this), true);

				// @TODO Fix displaying the CRNs... it's terrible right now
				// get the crn and color
				var crn = $(this).data("crn");
				var color = $(this).closest(".course").data("eventcolor");

				// add crn to list
				var crnLabel = $('<div class="label text-white">'+ crn +'</div>');
				crnLabel.attr("id", "crn-" + crn);
				crnLabel.css("background-color", color);

				if ($("#selected-crns .label").length > 0) {
					$("#selected-crns").append('<span class="crn-spacer">&nbsp;</span>');
				}
				$("#selected-crns").append(crnLabel);
			}
		}
	});
}

function getSelectedTerm() {
	return $("#term-select").select2("data")[0].id.toString();
}

function getSelectedCampus() {
	return $("#campus-select").select2("data")[0].id.toString();
}

function toCampus(campusID) {
	// if the string is empty, we need to display all campuses
	if (campusID !== "") {
		// hide everything to start
		$(".course-section").addClass("hidden");

		// show only the courses on our selected campus
		$(".course-section.course-at-"+ campusID).removeClass("hidden");

		// check for professors with no classes displayed
		$(".professor").each(function() {
			// count all the sibling rows between the current and the next professor
			// this gives us a list of all the courses this prof has listed
			var countCoursesAtCampus = $(this).nextUntil(".professor", ".course-at-" + campusID).length;
			if (countCoursesAtCampus == 0) {
				// hide this professor
				$(this).addClass("hidden");
			} else {
				// show this professor
				$(this).removeClass("hidden");
			}
		});

		// check if there are no courses displayed
		$(".course").each(function() {
			// count the number of visible courses
			var visible = $(this).find(".course-section:not(.hidden)").length;

			// display an error if no sections of the selected course are on the selected campus
			if (visible == 0) {
				if ($(this).find(".on-campus-error").length == 0) {
					$(this).find("tbody").append('<tr class="warning on-campus-error"><td>Sorry, that course is not available on your selected campus.</td></tr>');
				}
			} else {
				$(this).find(".on-campus-error").remove();
			}
		});

	} else {
		// show everything
		$(".course-section").removeClass("hidden");
		$(".professor").removeClass("hidden");
		$(".on-campus-error").remove();
	}
	//registerCourseListeners();
}

// via https://stackoverflow.com/a/39336333/1465353
if (!String.prototype.hasOwnProperty('addSlashes')) {
    String.prototype.addSlashes = function() {
        return this.replace(/&/g, '&amp;') /* This MUST be the 1st replacement. */
             .replace(/'/g, '&apos;') /* The 4 other predefined entities, required. */
             .replace(/"/g, '&quot;')
             .replace(/\\/g, '\\\\')
             .replace(/</g, '&lt;')
             .replace(/>/g, '&gt;')
             .replace(/\u0000/g, '\\0');
        }
}

// via https://stackoverflow.com/a/17555888
function convertTo24Hour(time) {
	var hours = time.split(":");
	hours = parseInt(hours[0]);
    if(time.indexOf('am') !== -1 && hours === 12) {
        time = time.replace('12', '0');
    }
    if (time.indexOf('am')  !== -1 && hours > 0 && hours < 10) {
	    time = time.replace(hours, "0" + hours);
    }
    if(time.indexOf('pm')  !== -1 && hours < 12) {
        time = time.replace(hours, (hours + 12));
    }
    return time.replace(/(am|pm)/, '');
}

$(document).ready(function() {

	setupFullCalendar();

	// keep the scheduler in view as we scroll down
	$("#scheduler-outer").sticky({
		topSpacing: 65,
		responsiveWidth: true,
		bottomSpacing: 165
	});

	$("#campus-select").select2({
		theme: "bootstrap",
		// hides the search box
		minimumResultsForSearch: Infinity
	});

	// switching campuses
	$("#campus-select").on("select2:select", function(e) {
		toCampus(getSelectedCampus());
	});

	// switching terms
	$("#term-select").select2({
		theme: "bootstrap",
		// hides the search box
		minimumResultsForSearch: Infinity
	});

	// initializing saved course arrays
	$("#term-select option").each(function() {
		saved[$(this).val()] = [];
		saved[$(this).val()]["schedule"] = "[]";
		saved[$(this).val()]["courses"] = "";
	});

	// saving course data for term switching
	$("#term-select").on("select2:selecting", function(e) {
		saved[$(this).val()]["schedule"] = cal.fullCalendar("clientEvents");
		saved[$(this).val()]["courses"] = $("#saved-courses").html();

		cal.fullCalendar("removeEvents");
		$("#saved-courses").empty();
	});

	$("#term-select").on("select2:select", function(e) {
		if (saved[$(this).val()] != null) {
			cal.fullCalendar("addEventSource", saved[$(this).val()]["schedule"]);
			$("#saved-courses").html(saved[$(this).val()]["courses"]);
			registerCourseListeners();
			eventColorN = $("#saved-courses .panel").length;

			if ($(this).val() === "201801") {
				$("#campus-select").prop("disabled", true).val("").trigger("change");
			} else {
				$("#campus-select").prop("disabled", false);
			}

		} else {
			eventColorN = 0;
		}
	});

	// make addon button open the select menu
	$("#term-select-label").click(function() {
		$("#term-select").select2("open");
	});

	// init subjects dropdown
	$("#subject-dropdown").select2({
		theme: "bootstrap",
		placeholder: "Subject",
		ajax: {
			url: "courses/select2_get_subjects.php",
			delay: 250,
			data: function(params) {
				return {
					term: getSelectedTerm(),
					q: params.term,
					page: params.page
				};
			},
			processResults: function(data) {
				var items = JSON.parse(data);
				return {
					results: items
				};
			}
		}
	});

	var createdCoursesSelect2 = false;

	$("#subject-dropdown").on("select2:select", function() {
		$("#courses-dropdown").empty();
		$("#courses-dropdown").removeClass("disabled").prop("disabled", false);
		$("#courses-add").addClass("disabled").prop("disabled", true);

		var subject = $(this).select2("data")[0].subj;

		$("#subject-code").val(subject);

		if (!createdCoursesSelect2) {
			$("#courses-dropdown").select2({
				theme: "bootstrap",
				placeholder: "Course",
				ajax: {
					url: "courses/select2_get_courses.php",
					delay: 250,
					data: function(params) {
						return {
							subj: $("#subject-code").val(),
							term: getSelectedTerm(),
							campus: getSelectedCampus(),
							q: params.term,
							page: params.page
						};
					},
					processResults: function(data) {
						var items = JSON.parse(data);
						return {
							results: items
						};
					}
				},
				language: {
					noResults: function() {
						return "No Results Found<br /><small>Have you selected the correct term?</small>";
					}
				},
				escapeMarkup: function(m) {
					return m;
				}
			});
		}
		createdCoursesSelect2 = true;

		$("#courses-dropdown").select2("open");
	});

	$("#courses-dropdown").on("select2:select", function() {
		$("#courses-add").removeClass("disabled").prop("disabled", false);
	});

	$("#courses-add").click(function(){
		var course = $("#courses-dropdown").select2("data")[0].text.split(" ");
		var title = $("#courses-dropdown").select2("data")[0].text.split(": ")[1];
		course[1] = course[1].replace(":","");
		$.ajax({
			url: "courses/get_courses_by_professor.php",
			method: "get",
			data: {
				term: getSelectedTerm(),
				campus: getSelectedCampus(),
				subj: course[0],
				courseNumber: course[1]
			},
			dataType: "json",
			success: function(data) {
				var courseID = course[0] + " " + course[1];
				var panelID = "course-panel-" + courseID.replace(/ /g,"_").replace(".", "-ARM");

				if ($("#" + panelID).length == 0) {
					saveCourse(courseID, title, data);
					registerCourseListeners();
					$("#courses-dropdown").val('').change();
				}
				else {
					var thisPanel = $("#" + panelID);
					var fadeSpeed = 100;
					var delaySpeed = 50;
					thisPanel
						.animate({opacity: 0}, fadeSpeed)
						.delay(delaySpeed)
						.animate({opacity: 1}, fadeSpeed)
						.delay(delaySpeed)
						.animate({opacity: 0}, fadeSpeed)
						.delay(delaySpeed)
						.animate({opacity: 1}, fadeSpeed)
						.delay(delaySpeed)
						.animate({opacity: 0}, fadeSpeed)
						.delay(delaySpeed)
						.animate({opacity: 1}, fadeSpeed)
						.delay(delaySpeed);
				}
			}
		});
	});
});
