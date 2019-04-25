<?php
  require_once('../../../config.php');
  global $CFG, $DB;
  $titulo = 'Gráfico Cursos Online';

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
<h3 class="box-title"><?php echo $titulo; ?></h3>


<?php
	require_once("../../../config.php");
	global $DB;
	$sql = "SELECT g.id, c.fullname curso, g.name turma , gs.name ciclo, count(m.userid) AS quantidade, cate.path,g.idnumber ";
	$sql .= "FROM m31_groups_members m ";
	$sql .= "LEFT JOIN m31_groups g ON g.id=m.groupid ";
	$sql .= "INNER JOIN m31_course c ON c.id= g.courseid ";
	$sql .= "LEFT JOIN m31_groupings_groups gg on gg.groupid = g.id ";
	$sql .= "LEFT JOIN m31_groupings gs ON gs.id = gg.groupingid ";
	$sql .= "INNER JOIN m31_course_categories cate ON cate.id = c.category ";
	$sql .= "WHERE path like '/4/7%' AND g.idnumber = ' ' or path like '/5/10%' AND g.idnumber = ' ' ";
	$sql .= "group by c.fullname ";
?>
	
<!--inicio grafico-->
 <script type="text/javascript" src="https://www.google.com/jsapi"></script>
 <script type="text/javascript">
 //carregando modulo visualization
 google.load("visualization", "1", {packages:["corechart"]});
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

<section class="hold-transition skin-blue sidebar-mini">
	<div class="row">
    	<div class="col-md-12">
      		<div class="box">
        		<div class="box-header with-border">
          			<small><a class="btn btn-comum" href="javascript:history.go(-1)"><i class="fas fa-arrow-left"></i> Voltar</a></small>
        		</div>
        		<div class="box-body">
          			<div class="row">
          				<div class="box-footer">
              				<div class="col-sm-3 col-xs-6">
                    			<div class="description-block border-right">
			                      <?php
			                        if (!empty($rs))
			                        {
			                          echo "<ul style=\"list-style:none;\">";
			                          echo "<li id=\"chart_div4\"></li>";
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
        	</div>
        </div>
    </div>
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
										if (count($rs)) 
										{
											echo "<thead><tr role=\"row\"><th>Nome do Curso</th><th>Inscritos</th></tr></thead>"; 
											foreach ($rs as $l) 
											{
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
	</div>
</section>
<?php
$PAGE->set_context($context);
$PAGE->set_pagelayout('incourse');
$PAGE->set_url('/blocks/moodleversion/pages/painel_academico.php');
$PAGE->requires->jquery();
// Never reached if download = true.
echo $OUTPUT->footer();
?>