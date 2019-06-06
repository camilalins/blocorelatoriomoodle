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
	<small><a class="btn btn-comum" style="    margin: -1px 0px 0px 5px;" href="javascript:history.go(-1)"><i class="fas fa-arrow-left"></i> Voltar</a></small> <h3 class="box-title"><?php echo $_REQUEST["escolha_curso"] ?></h3>
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
				<span class="info-box-icon bg-dodgerblue"><i class="fas fa-ellipsis-v"></i> <?php echo $total_aluno->quantidade; ?> ALUNOS NO TOTAL</span>
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
											  echo "<li id=\"donutchart1\" style=\"width: 400px; height: 300px;\"></li>";
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
				<span class="info-box-icon bg-dodgerblue"><i class="fas fa-ellipsis-v"></i> Tutores / Moderadores / Professores</span>
				<div class="info-box-content">
					<?php
						require_once("../../config.php");
						global $DB;
						$sql4 = "SELECT COUNT(u.id) AS quantidade ";
						$sql4 .= "FROM mdl_role_assignments rs ";
						$sql4 .= "INNER JOIN mdl_user u ON u.id=rs.userid ";
						$sql4 .= "INNER JOIN mdl_context e ON rs.contextid=e.id ";
						$sql4 .= "INNER JOIN mdl_course c ON c.id=e.instanceid ";
						$sql4 .= "WHERE e.contextlevel=50 AND c.fullname='" . $_REQUEST["escolha_curso"] . "' AND rs.roleid <> 5 ";
																	
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
										echo "<thead><tr role=\"row\"><th>Nome</th><th>Email</th><th>Último Acesso</th></tr></thead>"; 
										foreach ($rs5 as $l5) {
											echo "<tr class=\"odd\">";
											echo "<td>" . $l5->name .  "</td><td>" . $l5->email .  "</td><td>" . $l5->lastaccess .  "</td>";
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
	<div class="rows">
		<div class="col-md-3 col-sm-6 col-xs-12" style="width: 34%;">
			<div class="info-box">
				<?php
					require_once("../../config.php");
					global $DB;
					$sql8 = "SELECT COUNT(u.id) AS quantidade ";
					$sql8 .= "FROM mdl_course_completions cc ";
					$sql8 .= "INNER JOIN mdl_user u ON cc.userid=u.id ";
					$sql8 .= "INNER JOIN mdl_course c ON c.id=cc.course ";
					$sql8 .= "INNER JOIN mdl_course c ON c.id=e.instanceid ";
					$sql8 .= "WHERE cc.timecompleted > 0 AND c.fullname='" . $_REQUEST["escolha_curso"] . "'";
																	
					$total = (array) $DB->get_records_sql($sql8);
					$total_concludente = array_shift($total);
				?>
								
				<span class="info-box-icon bg-dodgerblue"><i class="fas fa-ellipsis-v"></i> Usuários Concludentes</span><b> <?php echo $total_concludente->quantidade; ?></b>
				<div class="info-box-content">
					<table class="table no-margin">
						<tbody>
							<?php
								require_once("../../config.php");
								global $DB;
								$sql6 = "SELECT DISTINCT ue.id,en.courseid AS courseid,u.firstname,u.lastname,u.email,r.name AS rolename,r.shortname AS roleshortname,en.status AS methodstatus,en.enrol AS methodplugin,ue.status AS enrolstatus,ue.timestart,ue.timeend,from_unixtime(p.timecompleted, '%d/%m/%Y %H:%i:%s') as FIM,c.fullname AS course, c.id AS courseid, g.name AS turma, COUNT(u.id) AS quantidade ";
								$sql6 .= "FROM mdl_role_assignments rs ";
								$sql6 .= "INNER JOIN mdl_user u ON u.id=rs.userid ";
								$sql6 .= "INNER JOIN mdl_role r ON rs.roleid=r.id ";
								$sql6 .= "INNER JOIN mdl_context e ON rs.contextid=e.id ";
								$sql6 .= "INNER JOIN mdl_enrol en ON  e.instanceid=en.courseid ";
								$sql6 .= "INNER JOIN mdl_user_enrolments ue ON en.id=ue.enrolid ";
								$sql6 .= "INNER JOIN mdl_course_completions p ON p.course=en.courseid ";
								$sql6 .= "INNER JOIN mdl_course c ON c.id=en.courseid ";
								$sql6 .= "INNER JOIN mdl_groups g ON g.courseid=c.id ";
								$sql6 .= "WHERE e.contextlevel=50 AND rs.userid=ue.userid AND c.fullname='" . $_REQUEST["escolha_curso"] . "' AND p.userid=rs.userid  AND p.timecompleted > 0 ";
								$sql6 .= "group by g.name ";
										  
								$rs6 = (array) $DB->get_records_sql($sql6);
								if (count($rs6)) 
								{
									echo "<thead><tr role=\"row\"><th>Grupo</th><th>Quantidade</th></tr></thead>"; 
									foreach ($rs6 as $l6) {
										echo "<tr class=\"odd\">";
										echo "<td>" . $l6->turma .  "</td><td>" . $l6->quantidade .  "</td>";
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
					<i class="fas fa-chart-bar"></i> Quantidade Separados por Grupo
				</span>
				<div class="info-box-content">
					<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
					<script type="text/javascript">
						google.charts.load('current', {packages: ['corechart', 'bar']});
						google.charts.setOnLoadCallback(drawBasic);

						function drawBasic() {
							<?php
								$rs6 = (array) $DB->get_records_sql($sql6);
								$color = ['#ff9900','#dc3912','#3366cc','#65b20c','#153268','#c01fe0','#f9140c','#61829d','#8ebbe2','#83c6ff'];
								$positioncolor = 0;
								if (count($rs6)) 
								{

									echo "var data = google.visualization.arrayToDataTable([\n\r['Curso', 'Quantidade', { role: 'style' }],";
									foreach ($rs6 as $l6) 
									{
										echo "['" . $l6->turma .  "'," . $l6->quantidade . ",'" . $color[$positioncolor] . "'],\n\r";
										$positioncolor = $positioncolor + 1;
									} 
									echo "]);";
								};
							?>

							var options = {
								title: ' ',
								chartArea: {width: '40%'},
								hAxis: {
									title: 'Número de Concludentes',
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
											if (!empty($rs6))
											{
											  echo "<ul style=\"list-style:none;margin:0!important;\">";
											  echo "<li id=\"chart_div6\"></li>";
											  echo "</ul>";
											}
											else
											{
											  echo "<p>Nenhum resultado encontrado</p>";
											}
							?>				 
						</div>                
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
				<span class="info-box-icon bg-dodgerblue"><i class="fas fa-ellipsis-v"></i> Usuários Não Concludentes</span>
				<div class="info-box-content">
					<table class="table no-margin">
						<tbody>
							<?php
								require_once("../../config.php");
								global $DB;
								$sql7 = "SELECT DISTINCT ue.id,en.courseid AS courseid,u.firstname,u.lastname,u.email,r.name AS rolename,r.shortname AS roleshortname,en.status AS methodstatus,en.enrol AS methodplugin,ue.status AS enrolstatus,ue.timestart,ue.timeend,from_unixtime(p.timecompleted, '%d/%m/%Y %H:%i:%s') as FIM,c.fullname AS course, c.id AS courseid, g.name AS turma, COUNT(u.id) AS quantidade ";
								$sql7 .= "FROM mdl_role_assignments rs ";
								$sql7 .= "INNER JOIN mdl_user u ON u.id=rs.userid ";
								$sql7 .= "INNER JOIN mdl_role r ON rs.roleid=r.id ";
								$sql7 .= "INNER JOIN mdl_context e ON rs.contextid=e.id ";
								$sql7 .= "INNER JOIN mdl_enrol en ON  e.instanceid=en.courseid ";
								$sql7 .= "INNER JOIN mdl_user_enrolments ue ON en.id=ue.enrolid ";
								$sql7 .= "INNER JOIN mdl_course_completions p ON p.course=en.courseid ";
								$sql7 .= "INNER JOIN mdl_course c ON c.id=en.courseid ";
								$sql7 .= "INNER JOIN mdl_groups g ON g.courseid=c.id ";
								$sql7 .= "WHERE e.contextlevel=50 AND rs.userid=ue.userid AND c.fullname='" . $_REQUEST["escolha_curso"] . "' AND p.userid=rs.userid  AND p.timecompleted IS NULL ";
								$sql7 .= "group by g.name ";
										  
								$rs7 = (array) $DB->get_records_sql($sql7);
								if (count($rs7)) 
								{
									echo "<thead><tr role=\"row\"><th>Grupo</th><th>Quantidade</th></tr></thead>"; 
									foreach ($rs7 as $l7) {
										echo "<tr class=\"odd\">";
										echo "<td>" . $l7->turma .  "</td><td>" . $l7->quantidade .  "</td>";
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
					<i class="fas fa-chart-bar"></i> Quantidade Separados por Grupo
				</span>
				<div class="info-box-content">
					<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
					<script type="text/javascript">
						google.charts.load('current', {packages: ['corechart', 'bar']});
						google.charts.setOnLoadCallback(drawBasic);

						function drawBasic() {
							<?php
								$rs7 = (array) $DB->get_records_sql($sql7);
								$color = ['#dc3912','#3366cc','#83c6ff','#65b20c','#153268','#c01fe0','#f9140c','#61829d','#8ebbe2','#ff9900'];
								$positioncolor = 0;
								if (count($rs7)) 
								{

									echo "var data = google.visualization.arrayToDataTable([\n\r['Curso', 'Quantidade', { role: 'style' }],";
									foreach ($rs7 as $l7) 
									{
										echo "['" . $l7->turma .  "'," . $l7->quantidade . ",'" . $color[$positioncolor] . "'],\n\r";
										$positioncolor = $positioncolor + 1;
									} 
									echo "]);";
								};
							?>

							var options = {
								title: ' ',
								chartArea: {width: '40%'},
								hAxis: {
									title: 'Número de Não Concludentes',
									minValue: 0
								},
								vAxis: {
									title: ' '
								}
							};

							var chart = new google.visualization.BarChart(document.getElementById('chart_div7'));

							chart.draw(data, options);
						}
					</script>
					<div class="grafico6">
						<div class="description-block border-right border-none">
							<?php
											if (!empty($rs7))
											{
											  echo "<ul style=\"list-style:none;margin:0!important;\">";
											  echo "<li id=\"chart_div7\"></li>";
											  echo "</ul>";
											}
											else
											{
											  echo "<p>Nenhum resultado encontrado</p>";
											}
							?>				 
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
	$PAGE->set_url('/blocks/moodleversion/painel_academico.php');
	$PAGE->requires->jquery();
	// Never reached if download = true.
	echo $OUTPUT->footer();
?>
