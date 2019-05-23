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
	
		<div class="col-md-3 col-sm-6 col-xs-12" style="width: 44%;"><!--Quantidade de alunos no curso-->
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
			<div class="info-box1">
				<span class="info-box-icon bg-dodgerblue"><i class="fas fa-ellipsis-v"></i> <?php echo $total_aluno->quantidade; ?> Para o total de Alunos</span>
				<div class="info-box-content">
					
					<!--Gráfico Alunos x Turma-->
					<?php
						require_once("../../config.php");
						global $DB;
						$sql3 = "SELECT g.name as turma, COUNT(m.id) AS quantidade ";
						$sql3 .= "FROM mdl_groups_members m ";
						$sql3 .= "INNER JOIN mdl_groups g ON g.id=m.groupid ";
						$sql3 .= "INNER JOIN mdl_user u ON u.id=m.userid ";
						$sql3 .= "INNER JOIN mdl_role_assignments rs ON rs.userid=m.userid ";
						$sql3 .= "INNER JOIN mdl_role r ON rs.roleid=r.id ";
						$sql3 .= "INNER JOIN mdl_context e ON rs.contextid=e.id ";
						$sql3 .= "INNER JOIN mdl_course c ON g.courseid = c.id ";
						$sql3 .= "WHERE e.contextlevel=50 AND g.courseid=e.instanceid AND c.fullname='" . $_REQUEST["escolha_curso"] . "' AND (rs.roleid = 5 OR rs.roleid IS NULL) ";
						$sql3 .= "GROUP BY g.id; ";
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
								$rs3 = (array) $DB->get_records_sql($sql3);
								if (count($rs3)) 
								{
								echo "var data = google.visualization.arrayToDataTable([\n\r['Turma', 'Quantidade'],"; 
								foreach ($rs3 as $l3) 
								{
									echo "['" . $l3->turma .  "'," . $l3->quantidade .  "],\n\r";
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
						  var chart = new google.visualization.PieChart(document.getElementById('donutchart1'));
						  //desenha passando os dados e as opções
							  chart.draw(data, options);
						}
						//metodo chamado após o carregamento
						google.setOnLoadCallback(drawChart);
					</script>
					<!--fim grafico 1-->
					<div class="grafico8">
									<div class="description-block border-right">
										  <?php
											if (!empty($rs3))
											{
											  echo "<ul style=\"list-style:none;\">";
											  echo "<li id=\"donutchart1\" style=\"width: 400px; height: 300px; margin: 0px -36px;\"></li>";
											  echo "</ul>";
											}
											else
											{
											  echo "<p>Nenhum curso encontrado</p>";
											}
										  ?>
									</div>
					</div>
					<span class="info-box-number">
						<?php echo $total_aluno->quantidade; ?> 
						<small>Total de Alunos</small> 
					</span>
				</div>
			</div>
		</div>
		<div class="col-md-3 col-sm-6 col-xs-12" style="width: 20%;">
			<div class="info-box">
				<span class="info-box-icon bg-dodgerblue"><i class="fas fa-ellipsis-v"></i> Alunos separados por Turma</span>
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
	
		<div class="col-md-3 col-sm-6 col-xs-12" style="width: 48%;"><!--Quantidade de tutores no curso-->
			<div class="info-box">
				<span class="info-box-icon bg-dodgerblue"><i class="fas fa-ellipsis-v"></i> Tutores</span>
				<div class="info-box-content">
					<?php
						require_once("../../config.php");
						global $DB;
						$sql4 = "SELECT g.name as turma, COUNT(m.id) AS quantidade ";
						$sql4 .= "FROM mdl_groups_members m ";
						$sql4 .= "INNER JOIN mdl_groups g ON g.id=m.groupid ";
						$sql4 .= "INNER JOIN mdl_user u ON u.id=m.userid ";
						$sql4 .= "INNER JOIN mdl_role_assignments rs ON rs.userid=m.userid ";
						$sql4 .= "INNER JOIN mdl_role r ON rs.roleid=r.id ";
						$sql4 .= "INNER JOIN mdl_context e ON rs.contextid=e.id ";
						$sql4 .= "INNER JOIN mdl_course c ON g.courseid = c.id ";
						$sql4 .= "WHERE e.contextlevel=50 AND g.courseid=e.instanceid AND c.fullname='" . $_REQUEST["escolha_curso"] . "' AND (rs.roleid <> 5 OR rs.roleid IS NULL) ";
																	
						$tutores = (array) $DB->get_records_sql($sql4);
						$total_tutores = array_shift($tutores);
					?>
					
					<span class="info-box-number">
						<?php echo $total_tutores->quantidade; ?> 
						<small>Total de Tutores</small> 
					</span>
				</div>
				<div class="table">
					<table class="table no-margin">
							<tbody>
								<?php
									require_once("../../config.php");
									global $DB;
									$sql5 = "SELECT DISTINCT u.id, CONCAT(u.firstname,u.lastname) AS name,u.email,r.name AS profile,r.shortname AS profileshortname,g.name AS turma,u.institution,from_unixtime(u.lastaccess, '%d/%m/%Y %H:%i:%s') AS lastaccess ";
									$sql5 .= "FROM mdl_role_assignments rs ";
									$sql5 .= "INNER JOIN mdl_role r ON r.id=rs.roleid ";
									$sql5 .= "INNER JOIN mdl_user u ON u.id=rs.userid ";
									$sql5 .= "INNER JOIN mdl_context e ON rs.contextid=e.id ";
									$sql5 .= "INNER JOIN mdl_course c ON c.id=e.instanceid ";
									$sql5 .= "INNER JOIN mdl_groups g ON g.courseid=c.id ";
									$sql5 .= "INNER JOIN mdl_groups_members m ON g.id=m.groupid ";
									$sql5 .= "WHERE e.contextlevel=50 AND c.fullname='" . $_REQUEST["escolha_curso"] . "' AND (rs.roleid <> 5 OR rs.roleid IS NULL) ";
																		
									$rs5 = (array) $DB->get_records_sql($sql5);
									//print_r($rs5);
									if (count($rs5)) 
									{
										echo "<thead><tr role=\"row\"><th>Nome</th><th>Email</th><th>Papel</th><th>Grupo</th><th>Último Acesso</th></tr></thead>"; 
										foreach ($rs5 as $l5) {
											echo "<tr class=\"odd\">";
											echo "<td>" . $l5->name .  "</td><td>" . $l5->email .  "</td><td>" . $l5->profeileshortname .  "</td><td>" . $l5->turma .  "</td><td>" . $l5->lastaccess .  "</td>";
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
