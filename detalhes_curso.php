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
	<div class="rows">
		<div class="col-md-3 col-sm-6 col-xs-12" style="width: 33%;">
			<div class="info-box-topo">
				<span class="info-box-icon bg-aqua">
					<i class="fas fa-bullhorn" aria-hidden="true"></i>
				</span>
				<div class="info-box-content">
					<span class="info-box-number">
						<small>Total de alunos</small>
					</span>
				</div>
			</div>
				
				<!--Gráfico 3 CAPACITAÇÃO | SEMIPRESENCIAL-->
						<?php
						  require_once("../../config.php");
						  global $DB;
						  $sql3 = "SELECT c.fullname AS curso,count(u.id) AS quantidade ";
						  $sql3 .= "FROM mdl_role_assignments rs ";
						  $sql3 .= "INNER JOIN mdl_user u ON u.id=rs.userid ";
						  $sql3 .= "INNER JOIN mdl_context e ON rs.contextid=e.id ";
						  $sql3 .= "INNER JOIN mdl_course c ON c.id=e.instanceid ";
						  $sql3 .= "INNER JOIN mdl_course_categories cate  ON cate.id=c.category ";
						  $sql3 .= "INNER JOIN mdl_groups g ON g.courseid = c.id ";
						  $sql3 .= "WHERE e.contextlevel=50 AND rs.roleid=5 AND cate.path like '/4/12%' AND g.idnumber = ' ' ";
						  $sql3 .= "group by c.fullname ";

						  $rs3 = (array) $DB->get_records_sql($sql3);
						  //print_r($rs);
						?>
						<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
						<script type="text/javascript">
						//carregando modulo visualization
						  google.charts.load("current", {packages:["corechart"]});
						  google.charts.setOnLoadCallback(drawChart);
						//função de monta e desenha o gráfico
						function drawChart() 
						{
						  //variavel com armazenamos os dados, um array de array's 
						  //no qual a primeira posição são os nomes das colunas
						  <?php
							if (count($rs2)) 
							{
							  echo "var data = google.visualization.arrayToDataTable([\n\r['Curso', 'Quantidade'],"; 
							  foreach ($rs3 as $l3) 
							  {
							  echo "['" . $l3->curso .  "'," . $l3->quantidade .  "],\n\r";
							  } 
							  echo "]);";
							};
						  ?>
						  //opções para exibição do gráfico
						  var options = 
						  {
							title: ' ',
							pieHole: 0.4,
						  };
						  //cria novo objeto PeiChart que recebe 
						  //como parâmetro uma div onde o gráfico será desenhado
						  var chart = new google.visualization.PieChart(document.getElementById('donutchart'));
						  //desenha passando os dados e as opções
							  chart.draw(data, options);
						}
						//metodo chamado após o carregamento
						google.setOnLoadCallback(drawChart);
						</script>
						<!--fim grafico 3-->  
	
			<div class="coluna-grafico">							
				<div class="grafico3">
						<div class="description-block border-right border-none">
										  <?php
											if (!empty($rs3))
											{
											  echo "<ul style=\"list-style:none;\">";
											  echo "<li id=\"donutchart\" style=\"width: 600px; height: 300px;\"></li>";
											  echo "</ul>";
											  echo "<a href=\"grafico_presencial.php\"><span class=\"description-percentage text-green\"><i class=\"fa fa-caret-up\"></i> Veja Mais</span></a>";
											}
											else
											{
											  echo "<p>Nenhum curso encontrado</p>";
											}
										  ?>
							<h5 class="description-header">Capacitação | Semipresencial</h5>
						</div>                
				</div>
				<div class="grafico3">
					<div class="description-block border-right border-none">
										  <?php
											if (!empty($rs3))
											{
											  echo "<ul style=\"list-style:none;\">";
											  echo "<li id=\"donutchart\" style=\"width: 600px; height: 300px;\"></li>";
											  echo "</ul>";
											  echo "<a href=\"grafico_presencial.php\"><span class=\"description-percentage text-green\"><i class=\"fa fa-caret-up\"></i> Veja Mais</span></a>";
											}
											else
											{
											  echo "<p>Nenhum curso encontrado</p>";
											}
										  ?>
						<h5 class="description-header">Capacitação | Presencial</h5>
					</div>                
				</div>
			</div>
		</div>
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
									$sql5 = "SELECT DISTINCT aluno.username, aluno.firstname, aluno.lastname, polo.name, disciplina.fullname, count(polo.name) as quantidade ";
									$sql5 .= "FROM mdl_course disciplina ";
									$sql5 .= "INNER JOIN mdl_groups polo on polo.courseid = disciplina.id ";
									$sql5 .= "INNER JOIN mdl_groups_members alunos_polo on alunos_polo.groupid = polo.id ";
									$sql5 .= "INNER JOIN mdl_user_enrolments pre_inscr on pre_inscr.userid = alunos_polo.userid ";
									$sql5 .= "INNER JOIN mdl_role_assignments inscri on inscri.id = pre_inscr.enrolid ";
									$sql5 .= "INNER JOIN mdl_user aluno on aluno.id = alunos_polo.userid ";
									$sql5 .= "WHERE disciplina.id = '" . $_REQUEST["escolha_curso"] . "' AND inscri.roleid = 5 ";
									$sql5 .= "group by polo.name ";
									$sql5 .= "ORDER BY polo.name desc ";
									
										  
									$rs5 = (array) $DB->get_records_sql($sql5);
									//print_r($rs5);
									if (count($rs5)) 
									{
										echo "<thead><tr role=\"row\"><th>Grupo</th><th>Quantidade</th></tr></thead>"; 
										foreach ($rs5 as $l5) {
											echo "<tr class=\"odd\">";
											echo "<td>" . $l5->polo.name .  "</td><td>" . $l5->quantidade .  "</td>";
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
