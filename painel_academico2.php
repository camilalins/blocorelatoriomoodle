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
	
	
	
	
	
	
	



<section class="hold-transition skin-blue sidebar-mini">
	<!--Gráfico 1 LIVRE | ONLINE-->
    <?php
      require_once("../../config.php");
      global $DB;
      $sql = "SELECT c.fullname AS curso,count(u.id) AS quantidade ";
      $sql .= "FROM mdl_role_assignments rs ";
      $sql .= "INNER JOIN mdl_user u ON u.id=rs.userid ";
      $sql .= "INNER JOIN mdl_context e ON rs.contextid=e.id ";
      $sql .= "INNER JOIN mdl_course c ON c.id=e.instanceid ";
      $sql .= "INNER JOIN mdl_course_categories cate  ON cate.id=c.category ";
      $sql .= "INNER JOIN mdl_groups g ON g.courseid = c.id ";
      $sql .= "WHERE e.contextlevel=50 AND rs.roleid=5 AND cate.path like '/3/5%' AND g.idnumber = ' ' ";
	  $sql .= "group by c.fullname ";
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
		  $rs = (array) $DB->get_records_sql($sql);
			if (count($rs)) 
			{
			  echo "var data = google.visualization.arrayToDataTable([\n\r['Curso', 'Quantidade'],"; 
			  foreach ($rs as $l) 
			  {
				echo "['" . $l->curso .  "'," . $l->quantidade .  "],\n\r";
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
    <!--Gráfico 2 CAPACITAÇÃO | ONLINE-->
    <?php
      require_once("../../config.php");
      global $DB;
      $sql2 = "SELECT c.fullname AS curso,count(u.id) AS quantidade ";
      $sql2 .= "FROM mdl_role_assignments rs ";
      $sql2 .= "INNER JOIN mdl_user u ON u.id=rs.userid ";
      $sql2 .= "INNER JOIN mdl_context e ON rs.contextid=e.id ";
      $sql2 .= "INNER JOIN mdl_course c ON c.id=e.instanceid ";
      $sql2 .= "INNER JOIN mdl_course_categories cate  ON cate.id=c.category ";
      $sql2 .= "INNER JOIN mdl_groups g ON g.courseid = c.id ";
      $sql2 .= "WHERE e.contextlevel=50 AND rs.roleid=5 AND cate.path like '/4/11%' AND g.idnumber = ' ' ";
	  $sql2 .= "group by c.fullname ";

      $rs2 = (array) $DB->get_records_sql($sql2);
      //print_r($rs);
    ?>
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
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
          foreach ($rs2 as $l2) 
          {
          echo "['" . $l2->curso .  "'," . $l2->quantidade .  "],\n\r";
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
      var chart = new google.visualization.PieChart(document.getElementById('donutchart2'));
      //desenha passando os dados e as opções
          chart.draw(data, options);
    }
    //metodo chamado após o carregamento
    google.setOnLoadCallback(drawChart);
    </script>
    <!--fim grafico 2-->
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
	<!--Gráfico 4 CAPACITAÇÃO | PRESENCIAL-->
    <?php
      require_once("../../config.php");
      global $DB;
      $sql4 = "SELECT c.fullname AS curso,count(u.id) AS quantidade ";
      $sql4 .= "FROM mdl_role_assignments rs ";
      $sql4 .= "INNER JOIN mdl_user u ON u.id=rs.userid ";
      $sql4 .= "INNER JOIN mdl_context e ON rs.contextid=e.id ";
      $sql4 .= "INNER JOIN mdl_course c ON c.id=e.instanceid ";
      $sql4 .= "INNER JOIN mdl_course_categories cate  ON cate.id=c.category ";
      $sql4 .= "INNER JOIN mdl_groups g ON g.courseid = c.id ";
      $sql4 .= "WHERE e.contextlevel=50 AND rs.roleid=5 AND cate.path like '/4/13%' AND g.idnumber = ' ' ";
	  $sql4 .= "group by c.fullname ";

      $rs4 = (array) $DB->get_records_sql($sql4);
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
          foreach ($rs4 as $l4) 
          {
          echo "['" . $l4->curso .  "'," . $l4->quantidade .  "],\n\r";
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
      var chart = new google.visualization.PieChart(document.getElementById('donutchart4'));
      //desenha passando os dados e as opções
          chart.draw(data, options);
    }
    //metodo chamado após o carregamento
    google.setOnLoadCallback(drawChart);
    </script>
    <!--fim grafico 4-->  

    <div class="rows">
		<div class="col-md-12" style="width: 100%;">
			<div class="box">
				<div class="box-header with-border">
					<h3 class="box-title">Cursos em Andamento</h3>
				</div>
				<div class="box-body">
					<div class="rows1">
							<div class="coluna-grafico">
								<div class="grafico1">
									<div class="description-block border-right">
										  <?php
											if (!empty($rs))
											{
											  echo "<ul style=\"list-style:none;\">";
											  echo "<li id=\"donutchart1\" style=\"width: 400px; height: 300px;\"></li>";
											  echo "</ul>";
											  //echo "<a href=\"grafico_online.php\"><span class=\"description-percentage text-green\"><i class=\"fa fa-caret-up\"></i> Veja Mais</span></a>";
											}
											else
											{
											  echo "<p>Nenhum curso encontrado</p>";
											}
										  ?>
										<h5 class="description-header">Livre | Online</h5>
									</div>
								</div>
								<div class="grafico2">
									<div class="description-block border-right">
										  <?php
											if (!empty($rs2))
											{
											  echo "<ul style=\"list-style:none;\">";
											  echo "<li id=\"donutchart2\" style=\"width: 400px; height: 300px;\"></li>";
											  echo "</ul>";
											  //echo "<a href=\"grafico_semipresencial.php\"><span class=\"description-percentage text-green\"><i class=\"fa fa-caret-up\"></i> Veja Mais</span></a>";
											}
											else
											{
											  echo "<p>Nenhum curso encontrado</p>";
											}
										  ?>
										<h5 class="description-header">Capacitação | Online</h5>
									</div>
								</div>
							</div>
							<div class="coluna-grafico">							
								<div class="grafico3">
									<div class="description-block border-right border-none">
										  <?php
											if (!empty($rs3))
											{
											  echo "<ul style=\"list-style:none;\">";
											  echo "<li id=\"donutchart\" style=\"width: 400px; height: 300px;\"></li>";
											  echo "</ul>";
											  //echo "<a href=\"grafico_presencial.php\"><span class=\"description-percentage text-green\"><i class=\"fa fa-caret-up\"></i> Veja Mais</span></a>";
											}
											else
											{
											  echo "<p>Nenhum curso encontrado</p>";
											}
										  ?>
										<h5 class="description-header">Capacitação | Semipresencial</h5>
									</div>                
								</div>
								<div class="grafico4">
									<div class="description-block border-right border-none">
										  <?php
											if (!empty($rs3))
											{
											  echo "<ul style=\"list-style:none;\">";
											  echo "<li id=\"donutchart4\" style=\"width: 400px; height: 300px;\"></li>";
											  echo "</ul>";
											  //echo "<a href=\"grafico_presencial.php\"><span class=\"description-percentage text-green\"><i class=\"fa fa-caret-up\"></i> Veja Mais</span></a>";
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
			</div>
		</div>
    </div>
</section>

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
