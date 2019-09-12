<?php

	require_once('../../config.php');
	global $CFG, $DB;
	$titulo = 'Painel Academico';

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
 <?php
   require_once("../../config.php");
   global $DB;
   $sql = "SELECT COUNT(institution) AS quantidade";
   $sql .= " FROM mdl_user";
   $sql .= " WHERE deleted <> 1 and suspended <> 1 and username <> 'guest' and format(username, 0)";
   $rs = (array) $DB->get_records_sql($sql);
   //print_r ($rs);
   $total_user = array_shift($rs);
 ?>
  <!-- Alunos habilitados -->         
 <?php
   require_once("../../config.php");
   global $DB;
   $sql = "SELECT count(*) as quantidade";
   $sql .= " FROM mdl_role_assignments ass";
   $sql .= " INNER JOIN mdl_user u ON  u.id = ass.userid";
   $sql .= " WHERE roleid=5 AND deleted <> 1 AND suspended <> 1 AND username <> 'guest'";
   $aluno = (array) $DB->get_records_sql($sql);
   //print_r ($rs);
   $total_aluno = array_shift($aluno);
 ?>
  <!-- Total de curso -->         
  <?php
    require_once("../../config.php");
    global $DB;
    $sql = "SELECT count(*) as quantidade";
    $sql .= " FROM mdl_course";
    $curso = (array) $DB->get_records_sql($sql);
    $total_course = array_shift($curso);
  ?>
  <!-- Curso Ativo -->          
  <?php
    require_once("../../config.php");
    global $DB;
    $sql = "SELECT count(*) as quantidade";
    $sql .= " FROM mdl_course";
    $curso_ativo = (array) $DB->get_records_sql($sql);
    //print_r ($rs);
    $total_curso_ativo = array_shift($curso_ativo);
  ?>        
<h3 class="box-title"><?php echo $titulo; ?></h3>
	<section>
		<div class="rows">
			<div class="col-md-3 col-sm-6 col-xs-12" style="width: 34%;">
				<div class="info-box-topo">
					<span class="info-box-icon bg-dodgerblue"><i class="fas fa-user-graduate" style="color:#51666C;"></i></span>
					<a href="cadastro_geral.php" style="font-weight:800!important; font-size:20px; "> <?php echo $total_user->quantidade; ?></a>
					<div class="info-box-content">
						<span class="info-box-number">
							<a href="cadastro_geral.php">
								<small style="font-weight:100!important;">Usuários Cadastrados</small> 
							</a>
						</span>
					</div>
				</div>
			</div>
			<div class="col-md-3 col-sm-6 col-xs-12" style="width: 33%;">
				<div class="info-box-topo">
					<span class="info-box-icon bg-cornflowerblue"><i class="fas fa-book" style="color:#51666C;"></i></span>
					<a href="curso_turma.php" style="font-weight:800!important; font-size:20px; "><?php echo $total_curso_ativo->quantidade; ?></a>
					<div class="info-box-content">
						<span class="info-box-number">
							<a href="curso_turma.php" >
								<small style="font-weight:100!important;">Cursos Cadastrados</small>
							</a>
						</span>
					</div>
				</div>
			</div>
			<!--<div class="col-md-3 col-sm-6 col-xs-12" style="width: 33%;">
				<div class="info-box-topo">
					<span class="info-box-icon bg-aqua">
						<i class="fas fa-bullhorn" aria-hidden="true"></i>
					</span>
					<div class="info-box-content">
						<span class="info-box-number">
							<a href="pesquisa_satisfacao.php">
								<small>Pesquisa de Satisfação</small>
							</a>
						</span>
					</div>
				</div>
			</div>-->
		</div>  
	</section>

	<section>
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
									$sql5 = "SELECT c.name,count(u.username) AS quantidade ";
									$sql5 .= "FROM mdl_user u ";
									$sql5 .= "INNER JOIN mdl_cohort_members cm ON cm.userid=u.id ";
									$sql5 .= "INNER JOIN mdl_cohort c ON c.id=cm.cohortid ";
									$sql5 .= "WHERE u.deleted=0 AND u.confirmed=1 ";
									$sql5 .= "group by c.name ";
										  
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
			<div class="col-md-3 col-sm-6 col-xs-12" style="width: 66%;">
	<div class="info-box">
		<span class="info-box-icon bg-dodgerblue">
			<i class="fas fa-chart-bar"></i> Usuários Separados por Grupo
		</span>
		<div class="info-box-content">
			<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
			<script type="text/javascript">
				google.charts.load('current', {packages: ['corechart', 'bar']});
				google.charts.setOnLoadCallback(drawBasic);

				function drawBasic() {
					<?php
						$rs5 = (array) $DB->get_records_sql($sql5);
						$color = ['#ff9900','#dc3912','#3366cc','#65b20c','#153268','#c01fe0','#f9140c','#61829d','#8ebbe2','#83c6ff'];
						$positioncolor = 0;
						if (count($rs5)) 
						{

							echo "var data = google.visualization.arrayToDataTable([\n\r['Curso', 'Quantidade', { role: 'style' }],";
							foreach ($rs5 as $l5) 
							{
								echo "['" . $l5->name .  "'," . $l5->quantidade . ",'" . $color[$positioncolor] . "'],\n\r";
								$positioncolor = $positioncolor + 1;
							} 
							echo "]);";
						};
					?>

				  var options = {
					title: ' ',
					chartArea: {width: '40%'},
					hAxis: {
					  title: 'Número de Usuários',
					  minValue: 0
					},
					vAxis: {
					  title: ' '
					}
				  };

				  var chart = new google.visualization.BarChart(document.getElementById('chart_div6'));

				  chart.draw(data, options);
				}
			</script>
			<div class="grafico6">
				<div class="description-block border-right border-none">
					<?php
											if (!empty($rs5))
											{
											  echo "<ul style=\"list-style:none;margin:0!important;\">";
											  echo "<li id=\"chart_div6\"></li>";
											  echo "</ul>";
											}
											else
											{
											  echo "<p>Nenhum curso encontrado</p>";
											}
					?>				 
				</div>                
			</div>						
	</div>
	</div>
</div>



    <!--fim grafico 6-->  
			
			
		</div>
	</section>
	
	
<!--	
<section>
	<div class="rows">
		<div class="col-md-3 col-sm-6 col-xs-12" style="width: 100%;">
				<div class="info-box-topo">
					
					<div class="info-box-content">
						<span class="info-box-number">
							<h3 class="box-title"><span class="info-box-icon bg-dodgerblue"><i class="fas fa-user-graduate"></i></span><small> Detalhes Sobre o Curso </small></h3>
						</span>
						<form action="detalhes_curso.php" method="post" class="form-horizontal">
							<div class="input-group input-group-sm">    
								<?php

									require_once("../../config.php");
									global $DB;
									$sql7 = "SELECT disciplina.id, aluno.username as cpf, aluno.firstname as nome, aluno.lastname as Sobrenome, aluno.institution as instituicao, aluno.department as departamento, aluno.email as email,polo.name as turma, disciplina.id as ID, disciplina.fullname as curso ";
									$sql7 .= "FROM mdl_course disciplina ";
									$sql7 .= "inner join mdl_groups polo on polo.courseid = disciplina.id ";
									$sql7 .= "inner join mdl_groups_members alunos_polo on alunos_polo.groupid = polo.id ";
									$sql7 .= "inner join mdl_user_enrolments pre_inscr on pre_inscr.userid = alunos_polo.userid ";
									$sql7 .= "inner join mdl_role_assignments inscri on inscri.id = pre_inscr.enrolid ";
									$sql7 .= "inner join mdl_user aluno on aluno.id = alunos_polo.userid ";
									$sql7 .= "inner join mdl_context e on inscri.contextid = e.id ";
									$sql7 .= "WHERE format <> 'site' AND e.contextlevel=50 AND inscri.roleid=5 ";
									$sql7 .= "group by curso ";
									$disciplina = (array) $DB->get_records_sql($sql7);

									if (count($disciplina)) {
										echo "<div class=\"input-group input-group-sm\">"; 
										echo "<select name=\"escolha_curso\" class=\"form-control\"><option>Escolha o curso</option>";
										foreach ($disciplina as $l7) {
											echo "<option value=\"". $l7->curso ."\">" . $l7->curso . "</option>";
										} 
										echo "</select>";
									};
								?>	
								<span class="input-group-btn">
									<button type="submit" class="btn btn-info btn-flat">Pesquisar</button>
								</span>
							</div>
						</form>	
					</div>
				</div>
		</div>
	</div>
</section>	
	
	
-->	
	
	
	
	





	<section>
		<div class="rows">
			
			
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
