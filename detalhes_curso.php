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
	
		<div class="col-md-3 col-sm-6 col-xs-12" style="width: 37%;"><!--Quantidade de alunos no curso-->
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
											  echo "<li id=\"donutchart1\" style=\"width: 300px; height: 200px;\"></li>";
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
						<!--<?php echo $total_tutores->quantidade; ?> 
						<small>Total de Tutores</small> -->
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
									}
									else
									{
										echo "Não há Tutores / Moderadores / Professores nesse curso.";
									}
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
					$sql8 .= "INNER JOIN mdl_user u ON u.id=cc.userid ";
					$sql8 .= "INNER JOIN mdl_course c ON c.id=cc.course ";
					$sql8 .= "WHERE cc.timecompleted > 0 AND c.fullname='" . $_REQUEST["escolha_curso"] . "' ";
																	
					$total = (array) $DB->get_records_sql($sql8);
					$total_concludente = array_shift($total);
				?>
				<br>
				<br>				
				<span class="info-box-icon bg-dodgerblue"><i class="fas fa-ellipsis-v"></i> Análise do Curso</span>
				<span class="input-group-btn">
					<form METHOD="post" ACTION="exportar.php">
					<?php
						$input = "";
						$input .= '<input type="text" style="display:none;" name="curso" value="';
						$input .= $_REQUEST["escolha_curso"];
						$input .= '">';
						echo $input;
					?>
					
						<input TYPE="submit" VALUE="Baixar">
					</form>
				</span>		
				<br>
				<div class="info-box-content">
					<table class="table no-margin">
						<tbody>
                            <?php
                                require_once("../../config.php");
                                global $DB;
                                $sql106 = "SELECT g.id, g.name ";
                                $sql106 .= "FROM mdl_groups g ";
                                $sql106 .= "INNER JOIN mdl_course c ON c.id = g.courseid ";
                                $sql106 .= "WHERE c.fullname='" . $_REQUEST["escolha_curso"] . "' ";

                                $turmas = (array) $DB->get_records_sql($sql106);

                                // Inicializa linha do Graf
                                $linhaGraf = "";

                                $quantidadeTurmas = count($turmas);
                                $iTurmas = 0;

                                if ($quantidadeTurmas)
                                {
                                    echo "<thead><tr role=\"row\"><th>Turma</th><th>Concludente</th><th>Não Concludente</th></tr></thead>";
                                    foreach ($turmas as $turma)
                                    {
                                        $sql116 = "SELECT COUNT(cc.id) AS quantidade ";
                                        $sql116 .= "FROM mdl_course_completions cc ";
                                        $sql116 .= "INNER JOIN mdl_user u ON u.id=cc.userid ";
                                        $sql116 .= "INNER JOIN mdl_course c ON c.id=cc.course ";
                                        $sql116 .= "INNER JOIN mdl_groups_members gm ON ( gm.userid = u.id AND gm.groupid = " . $turma-> id . " ) ";
                                        $sql116 .= "WHERE cc.timecompleted > 0 AND c.fullname='" . $_REQUEST["escolha_curso"] . "' ";

                                        $alunosCompletos = (array) $DB->get_records_sql($sql116);

                                        $sql117 = "SELECT COUNT(cc.id) AS quantidade ";
                                        $sql117 .= "FROM mdl_course_completions cc ";
                                        $sql117 .= "INNER JOIN mdl_user u ON u.id=cc.userid ";
                                        $sql117 .= "INNER JOIN mdl_course c ON c.id=cc.course ";
                                        $sql117 .= "INNER JOIN mdl_groups_members gm ON ( gm.userid = u.id AND gm.groupid = " . $turma-> id . " ) ";
                                        $sql117 .= "WHERE cc.timecompleted IS NULL AND c.fullname='" . $_REQUEST["escolha_curso"] . "' ";

                                        $alunosIncompletos = (array) $DB->get_records_sql($sql117);

                                        $iTurmas = $iTurmas + 1;

                                        foreach ($alunosCompletos as $q)
                                        {
                                            echo "<tr class=\"odd\">";
                                            echo "<td>" . $turma->name .  "</td><td>" . $q->quantidade .  "</td>";
                                            

                                            // Monta script do chart
                                            $linhaGraf .= "['" . $turma->name . "', " . $q->quantidade . ", ";
                                        }

                                        foreach ($alunosIncompletos as $qi)
                                        {
                                            if ($iTurmas == $quantidadeTurmas)
                                            {
                                                $linhaGraf .= $qi->quantidade . "]";
                                            }
                                            else
                                            {
                                                $linhaGraf .= $qi->quantidade . "],";
                                            }
										 echo "<td>" . $qi->quantidade .  "</td>";
										 echo "</tr>";
                                        }
                                    }
                                }
                                else
                                {
                                    echo "Não há turmas a serem mostradas.";
                                }
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
                        google.charts.load('current', {'packages':['corechart']});
                        google.charts.setOnLoadCallback(drawChart);
                        function drawChart() {
                            var data = google.visualization.arrayToDataTable([
                                ['Turma', 'Conludentes', 'Não Concludentes'],

                                <?php

                                    echo $linhaGraf;
                                ?>

                            ]);

                            var options = {
                                title: 'Curso / Turmas',
                                hAxis: {title: 'Turma',  titleTextStyle: {color: '#333'}},
                                vAxis: {minValue: 0}
                            };

                            var chart = new google.visualization.AreaChart(document.getElementById('chart_div6'));

							chart.draw(data, options);
						}
					</script>
					<div class="grafico6">
						<div class="description-block border-right border-none">
							<?php
                                if (!empty($alunosCompletos))
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

<?php
	$PAGE->set_context($context);
	$PAGE->set_pagelayout('incourse');
	$PAGE->set_url('/blocks/moodleversion/painel_academico.php');
	$PAGE->requires->jquery();
	// Never reached if download = true.
	echo $OUTPUT->footer();
?>
