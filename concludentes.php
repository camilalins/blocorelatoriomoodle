<?php

	require_once('../../config.php');
	global $CFG, $DB;
	$titulo = 'Consulta de Usuário';

	$PAGE->set_url($_SERVER['PHP_SELF']);
	$PAGE->set_pagelayout('admin');
	$PAGE->set_context(context_system::instance());
	$PAGE->set_url('/blocks/moodleversion/consulta_user.php');
	$PAGE->navbar->add($titulo, new moodle_url("$CFG->httpswwwroot/blocks/moodleversion/consulta_user.php"));
	echo $OUTPUT->header();
?>
<link rel="stylesheet" href="meucss.css">
<!-- Google Font -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
<!-- Font Awesome --> 
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
<!-- Total de usuários -->  

<h3 class="box-title"><?php echo $titulo; ?></h3>

<section>			
					<div class="col-md-3 col-sm-6 col-xs-12" style="width: 34%;">
				<div class="info-box">
					<span class="info-box-icon bg-dodgerblue"><i class="fas fa-ellipsis-v"></i> Usuários Separados por Grupo</span>
					<div class="info-box-content">
						<table class="table no-margin">
							<tbody>
								<?php
									require_once("../../config.php");
									global $DB;
									$sql5 = "SELECT DISTINCT rs.id,u.firstname,u.lastname,u.username,u.institution,u.department,u.email,u.city,c.id AS courseid,c.fullname AS course,ct.name AS category,r.shortname AS roleshortname,g.finalgrade,from_unixtime(g.timemodified, '%d/%m/%Y %H:%i:%s') AS gradetimeupdate,from_unixtime(ue.timestart, '%d/%m/%Y %H:%i:%s') AS enroltimestart,from_unixtime(ue.timeend, '%d/%m/%Y %H:%i:%s') AS enroltimeend,cf.name AS certificatename,cfi.code AS certificatecode,from_unixtime(cfi.timecreated, '%d/%m/%Y %H:%i:%s') AS datecertificate ";
									$sql5 .= "FROM mdl_role_assignments rs ";
									$sql5 .= "INNER JOIN mdl_role r ON rs.roleid=r.id ";
									$sql5 .= "INNER JOIN mdl_user u ON rs.userid=u.id ";
									$sql5 .= "INNER JOIN mdl_context e ON rs.contextid=e.id  ";
									$sql5 .= "INNER JOIN mdl_enrol en ON e.instanceid=en.courseid  ";
									$sql5 .= "INNER JOIN mdl_course c ON c.id=en.courseid  ";
									$sql5 .= "INNER JOIN mdl_course_categories ct ON ct.id=c.category ";
									$sql5 .= "INNER JOIN mdl_user_enrolments ue ON ( en.id=ue.enrolid AND rs.userid=ue.userid ) ";
									$sql5 .= "LEFT JOIN mdl_grade_items i ON c.id=i.courseid ";
									$sql5 .= "LEFT JOIN mdl_grade_grades g ON (g.itemid=i.id AND rs.userid=g.userid )  ";
									$sql5 .= "LEFT JOIN mdl_certificate cf ON cf.course=c.id ";
									$sql5 .= "LEFT JOIN mdl_certificate_issues cfi ON (cfi.certificateid=cf.id AND cfi.userid=rs.userid) ";					
									$sql5 .= "WHERE e.contextlevel=50 AND (i.itemtype = 'course' OR i.itemtype IS NULL ) AND c.visible= 1 AND ue.status = 0 AND en.status = 0 AND u.deleted=0 AND u.confirmed=1 ";
									
										  
									$rs5 = (array) $DB->get_records_sql($sql5);
									//print_r($rs5);
									if (count($rs5)) 
									{
										echo "<thead><tr role=\"row\"><th>Grupo</th><th>Quantidade</th></tr></thead>"; 
										foreach ($rs5 as $l5) {
											echo "<tr class=\"odd\">";
											echo "<td>" . $l5->name .  "</td><td>" . $l5->quantidade .  "</td>";
											;
											echo "</td></tr>";
										} 
									};
								?>
							</tbody>
						</table>
					</div>
				</div>
			</div>

</section>


	
<?php
	$PAGE->set_context($context);
	$PAGE->set_pagelayout('incourse');
	$PAGE->set_url('/blocks/moodleversion/consulta_user.php');
	$PAGE->requires->jquery();
	// Never reached if download = true.
	echo $OUTPUT->footer();
?>
