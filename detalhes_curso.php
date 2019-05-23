<?php

	require_once('../../config.php');
	global $CFG, $DB;
	$titulo = 'Detalhes Curso';

	$PAGE->set_url($_SERVER['PHP_SELF']);
	$PAGE->set_pagelayout('admin');
	$PAGE->set_context(context_system::instance());
	$PAGE->set_url('/blocks/moodleversion/detalhes_curso.php');
	$PAGE->navbar->add($titulo, new moodle_url("$CFG->httpswwwroot/blocks/moodleversion/detalhes_curso.php"));
	echo $OUTPUT->header();
?>
<link rel="stylesheet" href="meucss.css">
<!-- Google Font -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic"> 
<!-- Font Awesome --> 
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
<!-- Total de usuários -->    


<section>
	<h3 class="box-title"><?php echo $_REQUEST["escolha_curso"] ?></h3>
	<div class="rows">
	
		<div class="col-md-3 col-sm-6 col-xs-12" style="width: 34%;"><!--Quantidade de alunos no curso-->
			<div class="info-box">
				<span class="info-box-icon bg-dodgerblue"><i class="fas fa-ellipsis-v"></i> Usuários Separados por Grupo</span>
				<div class="info-box-content">
					<?php
						require_once("../../config.php");
						global $DB;
						$sql2 = "SELECT g.name as turma, COUNT(m.id) AS quantidade ";
						$sql2 .= "FROM mdl_groups_members m ";
						$sql2 .= "INNER JOIN mdl_groups g ON g.id=m.groupid ";
						$sql2 .= "INNER JOIN mdl_user u ON u.id=m.userid ";
						$sql2 .= "INNER JOIN mdl_role_assignments rs ON rs.userid=m.userid ";
						$sql2 .= "INNER JOIN mdl_role r ON rs.roleid=r.id ";
						$sql2 .= "INNER JOIN mdl_context e ON rs.contextid=e.id ";
						$sql2 .= "INNER JOIN mdl_course c ON g.courseid = c.id ";
						$sql2 .= "WHERE e.contextlevel=50 AND g.courseid=e.instanceid AND c.fullname='" . $_REQUEST["escolha_curso"] . "' AND (rs.roleid = 5 OR rs.roleid IS NULL) ";
																	
						$aluno = (array) $DB->get_records_sql($sql2);
						$total_aluno = array_shift($aluno);
					?>					
					<span class="info-box-number">
						<?php echo $total_aluno->quantidade; ?> 
						<small>Total de Alunos</small> 
					</span>
				</div>
			</div>
		</div>
		
		<div class="col-md-3 col-sm-6 col-xs-12" style="width: 34%;"><!--Quantidade de tutores no curso-->
			<div class="info-box">
				<span class="info-box-icon bg-dodgerblue"><i class="fas fa-ellipsis-v"></i> Usuários Separados por Grupo</span>
				<div class="info-box-content">
					<?php
						require_once("../../config.php");
						global $DB;
						$sql2 = "SELECT g.name as turma, COUNT(m.id) AS quantidade ";
						$sql2 .= "FROM mdl_groups_members m ";
						$sql2 .= "INNER JOIN mdl_groups g ON g.id=m.groupid ";
						$sql2 .= "INNER JOIN mdl_user u ON u.id=m.userid ";
						$sql2 .= "INNER JOIN mdl_role_assignments rs ON rs.userid=m.userid ";
						$sql2 .= "INNER JOIN mdl_role r ON rs.roleid=r.id ";
						$sql2 .= "INNER JOIN mdl_context e ON rs.contextid=e.id ";
						$sql2 .= "INNER JOIN mdl_course c ON g.courseid = c.id ";
						$sql2 .= "WHERE e.contextlevel=50 AND g.courseid=e.instanceid AND c.fullname='" . $_REQUEST["escolha_curso"] . "' AND (rs.roleid <> 5 OR rs.roleid IS NULL) ";
																	
						$aluno = (array) $DB->get_records_sql($sql2);
						$total_aluno = array_shift($aluno);
					?>
					
					
					
					
					
					
					
					
					
					
					<span class="info-box-number">
						<?php echo $total_aluno->quantidade; ?> 
						<small>Total de Alunos</small> 
					</span>
				</div>
			</div>
		</div>
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
		<div class="col-md-3 col-sm-6 col-xs-12" style="width: 34%;">
			<div class="info-box">
				<span class="info-box-icon bg-dodgerblue"><i class="fas fa-ellipsis-v"></i> Usuários Separados por Grupo</span>
				<div class="info-box-content">
					<table class="table no-margin">
						<tbody>
							<?php
								require_once("../../config.php");
								global $DB;
								$sql1 = "SELECT g.name as turma, COUNT(m.id) AS quantidade ";
								$sql1 .= "FROM mdl_groups_members m ";
								$sql1 .= "INNER JOIN mdl_groups g ON g.id=m.groupid ";
								$sql1 .= "INNER JOIN mdl_user u ON u.id=m.userid ";
								$sql1 .= "INNER JOIN mdl_role_assignments rs ON rs.userid=m.userid ";
								$sql1 .= "INNER JOIN mdl_role r ON rs.roleid=r.id ";
								$sql1 .= "INNER JOIN mdl_context e ON rs.contextid=e.id ";
								$sql1 .= "INNER JOIN mdl_course c ON g.courseid = c.id ";
								$sql1 .= "WHERE e.contextlevel=50 AND g.courseid=e.instanceid AND c.fullname='" . $_REQUEST["escolha_curso"] . "' AND (rs.roleid <> 5 OR rs.roleid IS NULL) ";
								$sql1 .= "GROUP BY g.id; ";
																	
								$rs1 = (array) $DB->get_records_sql($sql1);
								//print_r($rs5);
								if (count($rs1)) 
								{
									echo "<thead><tr role=\"row\"><th>Grupo</th><th>Quantidade</th></tr></thead>"; 
									foreach ($rs1 as $l1) {
										echo "<tr class=\"odd\">";
										echo "<td>" . $l1->turma .  "</td><td>" . $l1->quantidade .  "</td>";
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
	</div>
</section>

<section>
	<h3 class="box-title"><?php echo $_REQUEST["escolha_curso"] ?></h3>
	<div class="rows">
		<div class="col-md-3 col-sm-6 col-xs-12" style="width: 34%;">
			<div class="info-box">
				<span class="info-box-icon bg-dodgerblue"><i class="fas fa-ellipsis-v"></i> Usuários Separados por Grupo</span>
				<div class="info-box-content">
					<table class="table no-margin">
						<tbody>
							<?php
								require_once("../../config.php");
								global $DB;
								$sql1 = "SELECT g.name as turma, COUNT(m.id) AS quantidade ";
								$sql1 .= "FROM mdl_groups_members m ";
								$sql1 .= "INNER JOIN mdl_groups g ON g.id=m.groupid ";
								$sql1 .= "INNER JOIN mdl_user u ON u.id=m.userid ";
								$sql1 .= "INNER JOIN mdl_role_assignments rs ON rs.userid=m.userid ";
								$sql1 .= "INNER JOIN mdl_role r ON rs.roleid=r.id ";
								$sql1 .= "INNER JOIN mdl_context e ON rs.contextid=e.id ";
								$sql1 .= "INNER JOIN mdl_course c ON g.courseid = c.id ";
								$sql1 .= "WHERE e.contextlevel=50 AND g.courseid=e.instanceid AND c.fullname='" . $_REQUEST["escolha_curso"] . "' AND (rs.roleid = 5 OR rs.roleid IS NULL) ";
								$sql1 .= "GROUP BY g.id; ";
																	
								$rs1 = (array) $DB->get_records_sql($sql1);
								//print_r($rs5);
								if (count($rs1)) 
								{
									echo "<thead><tr role=\"row\"><th>Grupo</th><th>Quantidade</th></tr></thead>"; 
									foreach ($rs1 as $l1) {
										echo "<tr class=\"odd\">";
										echo "<td>" . $l1->turma .  "</td><td>" . $l1->quantidade .  "</td>";
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
	</div>
</section>
	


















<?php
	$PAGE->set_context($context);
	$PAGE->set_pagelayout('incourse');
	$PAGE->set_url('/blocks/moodleversion/painel_academico.php');
	$PAGE->requires->jquery();
	// Never reached if download = true.
	echo $OUTPUT->footer();
?>
