<?php

	require_once('../../config.php');
	global $CFG, $DB;
	$titulo = 'Relação de Cursos';

	$PAGE->set_url($_SERVER['PHP_SELF']);
	$PAGE->set_pagelayout('admin');
	$PAGE->set_context(context_system::instance());
	$PAGE->set_url('/blocks/moodleversion/painel_academico.php');
	$PAGE->navbar->add($titulo, new moodle_url("$CFG->httpswwwroot/local/moodleversion/painel_academico.php"));
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
	<div class="rows">
		<div class="col-md-12">
			<div class="box">
				<div class="box-body">
					<div class="rows">
						<div class="table-responsive">
							<table class="table no-margin">
								<tbody>
								  <?php
								  require_once("../../config.php");
								  global $DB;
								  $sql = "SELECT c.id, c.fullname As nome, cct.name AS tipo, cc.name AS modalidade, ct.name As Categoria";
								  $sql .= " FROM mdl_course c";
								  $sql .= " INNER JOIN mdl_course_categories ct ON ct.id=c.category";
								  $sql .= " INNER JOIN mdl_course_categories cc ON cc.id=ct.parent";
								  $sql .= " INNER JOIN mdl_course_categories cct ON cct.id=cc.parent";
								  $sql .= " ORDER BY cct.name DESC";
								  $c = (array) $DB->get_records_sql($sql);
								  if (count($c)) 
								  {
									echo "<thead><tr role=\"row\"><th>Nome do Curso</th><th>Tipo</th><th>Modalidade</th><th>Categoria</th></tr></thead>"; 
									foreach ($c as $l) 
									{
									  echo "<tr class=\"odd\">";
									  echo "<td>" . $l->nome .  "</td><td>" . $l->tipo .  "</td><td>" . $l->modalidade .  "</td><td>" . $l->categoria .  "</td>";
									  ;
									  echo "</tr>";
									} 
								  };
								  ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>    
		</div>    
	</div>
</section>
<?php
	$PAGE->set_context($context);
	$PAGE->set_pagelayout('incourse');
	$PAGE->set_url('/blocks/moodleversion/curso_turma.php');
	$PAGE->requires->jquery();
	// Never reached if download = true.
	echo $OUTPUT->footer();
?>
