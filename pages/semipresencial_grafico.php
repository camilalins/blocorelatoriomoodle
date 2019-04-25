<?php
  require_once('../../../config.php');
  global $CFG, $DB;
  $titulo = 'Painel Acadêmico';

  $PAGE->set_url($_SERVER['PHP_SELF']);
  $PAGE->set_pagelayout('admin');
  $PAGE->set_context(context_system::instance());
  $PAGE->set_url('/blocks/moodleversion/pages/painel_academico.php');
  $PAGE->navbar->add($titulo, new moodle_url("$CFG->httpswwwroot/blocks/moodleversion/pages/painel_academico.php"));
  echo $OUTPUT->header();
?>
<link rel="stylesheet" href="../css/meucss.css">
<!-- Google Font -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
<!-- Font Awesome --> 
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
<section class="hold-transition skin-blue sidebar-mini">
	<div class="row">
		<div class="col-md-12">
			<div class="box">
				<div class="box-header with-border">
<small><a class="btn btn-success btn-sm ad-click-event" href="javascript:history.go(-1)"><i class="fa fa-arrow-left" aria-hidden="true"></i> Voltar</a></small>
					<h3 class="box-title"><small>Total de Inscritos em cursos na modalidade</small> Semipresencial </h3>
				</div>
				<div class="box-body">
					<div class="row">
						<div class="table-responsive">
							<div>
								<ul style="list-style:none;">
									<li id="chart_div4"></li>
								</ul>                                   
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>	

	<?php

	require_once("../../../config.php");

	global $DB;

	$sql = "SELECT g.id, c.fullname curso, g.name turma , gs.name ciclo, count(m.userid) AS quantidade, cate.path,g.idnumber";
	$sql .= " FROM mdl_groups_members m ";
	$sql .= " LEFT JOIN mdl_groups g ON g.id=m.groupid ";
	$sql .= " INNER JOIN mdl_course c ON c.id= g.courseid  ";
	$sql .= " LEFT JOIN mdl_groupings_groups gg on gg.groupid = g.id ";
	$sql .= " LEFT JOIN mdl_groupings gs ON gs.id = gg.groupingid";
  	$sql .= " INNER JOIN mdl_course_categories cate ON cate.id = c.category";
	$sql .= " WHERE path like '/25/34%' AND g.idnumber = ' ' or path like '/28/30%' AND g.idnumber = ' '";
	$sql .= " GROUP BY c.fullname ";
	?>

<!--inicio grafico1.1-->
 <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
    //carregando modulo visualization
      google.load("visualization", "1", {packages:["corechart"]});
      
    //função de monta e desenha o gráfico
      function drawChart() {
  //variavel com armazenamos os dados, um array de array's 
    //no qual a primeira posição são os nomes das colunas
<?php
$rs = (array) $DB->get_records_sql($sql);
    if (count($rs)) {
    echo "var data = google.visualization.arrayToDataTable([\n\r['Curso', 'Quantidade'],"; 
    foreach ($rs as $l) {
        echo "['" . $l->curso .  "'," . $l->quantidade .  "],\n\r";
    } 
echo "]);";
};
?>
    //opções para exibição do gráfico
        var options = {
			width: 750,
			height: 300,
              title: 'SEMIPRESENCIAL',//titulo do gráfico
    is3D: true // false para 2d e true para 3d o padrão é false
        };
    //cria novo objeto PeiChart que recebe 
    //como parâmetro uma div onde o gráfico será desenhado
        var chart = new google.visualization.PieChart(document.getElementById('chart_div4'));
    //desenha passando os dados e as opções
        chart.draw(data, options);
      }
  //metodo chamado após o carregamento
   google.setOnLoadCallback(drawChart);
    </script>
<!--fim grafico1.1-->	

<div class="row">
	<div class="col-md-12">
        <div class="box">
			<div class="box-header with-border">
				<h3 class="box-title"><small>Total de Inscritos em cursos na modalidade</small> Semipresencial </h3>
			</div>
        <div class="box-body">
			<div class="row">
				<div class="table-responsive">
					<table class="table no-margin">
						<tbody>
                

						<?php

						$rs = (array) $DB->get_records_sql($sql);

						//echo "<div id=\"DataTables_Table_0_wrapper\" class=\"dataTables_wrapper container-fluid dt-bootstrap4 no-footer\">";
						//echo "<table class=\"table table-striped table-bordered datatable dataTable no-footer\">";
							if (count($rs)) {
							echo "<thead><tr role=\"row\"><th>Nome do Curso</th><th>Inscritos</th></tr></thead>"; 

							foreach ($rs as $l) {
							echo "<tr class=\"odd\">";
								
								echo "<td>" . $l->curso .  "</td><td>" . $l->quantidade .  "</td>";
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
</div>           <!-- /.table-responsive -->


</section>
<?php
$PAGE->set_context($context);
$PAGE->set_pagelayout('incourse');
$PAGE->set_url('/blocks/moodleversion/pages/painel_academico.php');
$PAGE->requires->jquery();
// Never reached if download = true.
echo $OUTPUT->footer();
?>



