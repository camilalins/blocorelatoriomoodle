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
		<div class="col-md-3 col-sm-6 col-xs-12" style="width: 34%;">
			<div class="info-box">
				<span class="info-box-icon bg-dodgerblue"><i class="fas fa-ellipsis-v"></i> Usuários Separados por Grupo</span>
				<div class="info-box-content">
					<table class="table no-margin">
						<tbody>
							<?php
								require_once("../../config.php");
								global $DB;
								$sql5 = "SELECT curso.fullname as nomeCurso, grupos.name as nomeGrupo, count(usuarios_membros.userid) as quantidade ";
								$sql5 .= "FROM mdl_groups as grupos ";
								$sql5 .= "LEFT JOIN mdl_groups_members as usuarios_membros ON usuarios_membros.groupid = grupos.id ";
								$sql5 .= "INNER JOIN mdl_course as curso ON curso.id = grupos.courseid ";
								$sql5 .= "LEFT JOIN mdl_role_assignments as papel ON papel.userid = usuarios_membros.userid ";
								$sql5 .= "WHERE curso.fullname = '" . $_REQUEST["escolha_curso"] . "' AND (papel.roleid = 5 OR papel.roleid IS NULL) ";
								$sql5 .= "GROUP BY grupos.id; ";
																	
								$rs5 = (array) $DB->get_records_sql($sql5);
								//print_r($rs5);
								if (count($rs5)) 
								{
									echo "<thead><tr role=\"row\"><th>Grupo</th><th>Quantidade</th></tr></thead>"; 
									foreach ($rs5 as $l5) {
										echo "<tr class=\"odd\">";
										echo "<td>" . $l5->nomeGrupo .  "</td><td>" . $l5->quantidade .  "</td>";
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
