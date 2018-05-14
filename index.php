<?php
ob_start();
include('../../../portal/globals/template/head.inc.php');
include("courses/form_vars.php");
$nextTerm = $_SESSION["portalSettings"]->Settings->NextTerm;
$currentTerm = $_SESSION["portalSettings"]->Settings->CurrentTerm;
?>
<!-- CONTENT
=================================-->

<div class="modal fade" id="onboarding">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-body">
				<h2 class="text-center">
					How to use MyGS Schedule Builder
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</h2>
				<hr />
				<div class="row" id="onboarding-body">
					<div class="col-sm-12 col-md-4 text-center">
						<h3>Step 1</h3>
						<span class="blue glyphicons glyphicons-user-conversation"></span>
						<h4 class="blue">Get Advised</h4>
						<p>Visit your advisor to get a list of all the courses you need to take next semester.</p>
						<a href="http://academics.georgiasouthern.edu/advisement/" target="_blank" class="btn btn-default">Contact Your Advisor</a>
					</div>
					<div class="col-sm-12 col-md-4 text-center">
						<h3>Step 2</h3>
						<span class="blue glyphicons glyphicons-calendar"></span>
						<h4 class="blue">Build Your Schedule</h4>
						<p>Add your courses to MyGS Schedule Builder to build your perfect schedule.</p>
						<button class="btn btn-success" data-dismiss="modal">Start Building Your Schedule</button>
					</div>
					<div class="col-sm-12 col-md-4 text-center">
						<h3>Step 3</h3>
						<span class="blue glyphicons glyphicons-list"></span>
						<h4 class="blue">Register in WINGS</h4>
						<p>Use the CRNs provided by MyGS Schedule Builder to register at your assigned time.</p>
						<a href="/portal/services/process-wngs-auth.php" class="btn btn-default" target="_blank">
							Go to WINGS
						</a>
					</div>
				</div>

			</div>
			<div class="modal-footer">
				<p>
					<strong class="blue">Important Note:</strong>
					MyGS Schedule Builder is <i>not</i> a replacement for registering for courses in WINGS.<br />
					<strong>Students are still required to register through WINGS at their designating start times</strong>.<br />
					Consult WINGS or contact your advisor for more information.
				</p>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="course-details">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                Course Details
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body clearfix">

                <h2>
                    <span id="popup-courseTitle">Course Name</span>
                    <span class="pull-right">
                        <span class="label" id="popup-seats-label"><span id="popup-seats"></span></span>
                    </span>
                </h2>
                <span id="popup-courseID">Section ID</span> &bull;
                CRN: <span id="popup-crn">#####</span>


                <hr />

                <div class="pull-right" id="popup-infobox">
                    <ul class="list-group">
                        <li class="list-group-item">
                            <span class="glyphicon glyphicon-calendar"></span>
                            <span id="popup-session"></span>
                        </li>
                        <li class="list-group-item">
                            <span class="glyphicon glyphicon-user"></span>
                            <span id="popup-professor"></span>
                        </li>
                        <li class="list-group-item">
                            <span class="glyphicon glyphicon-tree-deciduous"></span>
                            <span id="popup-campus"></span>
                        </li>
                        <li class="list-group-item">
                            <span class="glyphicon glyphicon-time"></span>
                            <span id="popup-credits"></span> Credit Hours
                        </li>
                    </ul>
                </div>

                <p id="popup-description">
                    Course Description
                </p>

                <p>
                    <a href="#" class="btn btn-primary" target="_blank" id="popup-bookstore-link">
                        <span class="glyphicon glyphicon-book"></span>
                        View Textbooks
                    </a>
                </p>

                <div class="table-responsive">
                    <table id="popup-meet-times" class="table table-condensed">
                        <thead>
                            <tr>
                                <th>Days</th>
                                <th>Times</th>
                                <th class="popup-table-loc">Location</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>

                <p id="popup-notes">
                    <span class="label label-default note-label" id="note-onlineOnly">
						<span class="glyphicon glyphicon-globe"></span>&nbsp;
						Online Only
					</span>
                    <span class="label label-default note-label" id="note-approvalRequired">
						<span class="glyphicon glyphicon-lock"></span>&nbsp;
						<span id="note-approval-details"></span> Required
					</span>
                    <span class="label label-default note-label" id="note-hybrid">
						<span class="glyphicon glyphicon-book"></span>&nbsp;
						Hybrid Course
					</span>
                    <span class="label label-default note-label" id="note-lab">
						<span class="glyphicon glyphicon-pencil"></span>&nbsp;
						Lab Course
					</span>
                </p>

            </div>
        </div>
    </div>
</div>

<div class="container" id="main">
	<div class="row well">

		<div class="col-sm-12">
			<h1>Schedule Builder</h1>
			<a class="btn btn-sm btn-primary" data-toggle="modal" href="#onboarding">Show Onboarding Dialog</a>
			<hr />

			<div class="row">
				<div class="col-sm-8">
					<div id="scheduler-outer">
						<div id="calendar"></div>

						<div class="well">
							<strong>Selected course CRNs</strong>
							<div id="selected-crns"></div>
						</div>

					</div>
				</div>
				<div class="col-sm-4" id="scheduler-search">
					<div class="row" id="term-controls">
						<div class="col-sm-8">
							<div class="input-group input-group-sm">
								<div class="input-group-btn">
									<button class="btn btn-primary">
										<label for="term-select" id="term-select-label">Term</label>
									</button>
								</div>
								<select class="form-control" name="term-select" id="term-select">
									<?php
										foreach ($search_terms as $id => $term) {
											?>
											<option
												value="<?php echo $id?>"
												<?php echo ($id == $nextTerm?" selected":"")?>
												>
												<?php echo $term ?>
											<?php
										}
									?>
								</select>
							</div>

						</div>
						<div class="col-sm-4">
							<button id="term-reset" class="btn btn-default btn-sm btn-block">Clear Schedule</button>
						</div>
					</div>
					<div class="row" id="campus-controls">
						<div class="col-sm-8">
							<div class="input-group input-group-sm">
								<div class="input-group-btn">
									<button class="btn btn-primary">
										<label for="campus-select" id="campus-select-label">Campus</label>
									</button>
								</div>
								<select disabled name="campus-select" id="campus-select" class="form-control">
									<option value=""   id="campus-opt-anyc">Any Campus</option>
									<option value="10" id="campus-opt-boro">Statesboro Campus</option>
									<option value="20" id="campus-opt-sava">Armstrong Campus</option>
									<option value="30" id="campus-opt-hine">Liberty Campus</option>
									<option value="40" id="campus-opt-onli">Fully Online</option>
									<option value="50" id="campus-opt-offc">Off-Campus</option>
									<option value="60" id="campus-opt-goml">Georgia OnMyLine</option>
								</select>
							</div>
						</div>
					</div>
					<div id="saved-courses"></div>
					<div class="well">
						<input type="hidden" id="subject-code" name="subject-code" value="" />
						<div class="form-group">
							<label for="subject-dropdown" class="sr-only">Subject</label>
							<select name="subject-dropdown" class="form-control input-block" id="subject-dropdown"></select>
						</div>
						<div class="form-group">
							<label for="courses-dropdown" class="sr-only">Course</label>
							<select class="form-control input-block disabled" disabled id="courses-dropdown"></select>
						</div>
						<div class="form-group text-right">
							<button class="btn btn-success disabled" disabled id="courses-add">Save Course</button>
						</div>
					</div>

				</div>
			</div>

		</div>

	</div>
</div> <!-- /container -->

<script src="lib/sticky/jquery.sticky.js"></script>

<script type="text/javascript" src="lib/select2/js/select2.min.js"></script>
<link rel="stylesheet" href="lib/select2/css/select2.min.css">
<link rel="stylesheet" href="lib/select2/css/select2-bootstrap.min.css">

<script type="text/javascript" src="lib/moment/moment.js"></script>

<script type="text/javascript" src="courses/suggest_data.js"></script>

<link rel="stylesheet" media="print" href="lib/fullcalendar/fullcalendar.print.min.css">
<link rel="stylesheet" href="lib/fullcalendar/fullcalendar.min.css">
<script src="lib/fullcalendar/fullcalendar.min.js"></script>

<script type="text/javascript" src="local.js"></script>
<link rel="stylesheet" type="text/css" href="local.css">

<style>
</style>


<?php
include('../../../portal/globals/template/footer.inc.php');

?>
