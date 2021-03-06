<?php
  require_once('../../config.php');
  global $CFG, $DB;
  $titulo = 'Cadastro Geral';

  $PAGE->set_url($_SERVER['PHP_SELF']);
  $PAGE->set_pagelayout('admin');
  $PAGE->set_context(context_system::instance());
  $PAGE->set_url('/blocks/moodleversion/cadastro_geral.php');
  $PAGE->navbar->add($titulo, new moodle_url("$CFG->httpswwwroot/blocks/moodleversion/cadastro_geral.php"));
  echo $OUTPUT->header();
?>
<link rel="stylesheet" href="meucss.css">
<!-- Google Font -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic"> 
<!-- Font Awesome --> 
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
<?php
	require_once("../../config.php");
    global $DB;
    $sql2 = "SELECT COUNT(institution) AS quantidade";
    $sql2 .= " FROM mdl_user";
    $sql2 .= " WHERE deleted <> 1 and suspended <> 1 and username <> 'guest' and format(username, 0)";
    $rss = (array) $DB->get_records_sql($sql2);
	$total_user = array_shift($rss);
?> 
  <h3 class="box-title"><?php echo $titulo; ?></h3>
	<section>
  		<div class="rows">
			<div class="box" style="width: 100%;" >
          		<div class="box-header with-border">
            		<small><a class="btn btn-comum" href="javascript:history.go(-1)"><i class="fas fa-arrow-left"></i> Voltar</a></small>
            		<small><a class="btn btn-comum" href="exportar_cadastro_geral.php"><i class="fas fa-download"></i> Exportar</a></small>
            		<br>
            		<br>
            		<h3 class="box-title"><small>Usuários Cadastrados</small> <?php echo $total_user->quantidade; ?></h3>
          		</div>
          		<div class="box-body">
            		<div class="rows">
              			<div class="table-responsive" style="width: 100%;">
            				<table class="table no-margin">
              					<tbody>
									<?php
										require_once("../../config.php");
										global $DB;
										$sql = "select id, institution, department, quantidade ";
										$sql .= " from (SELECT id, institution, department, COUNT(institution) AS quantidade";
										$sql .= " FROM mdl_user rs";
										$sql .= " WHERE deleted <> 1 and suspended <> 1 and username <> 'guest' and format(username, 0)";
										$sql .= " GROUP BY department, institution)x";
										$sql .= " ORDER BY quantidade DESC";
										$rs = (array) $DB->get_records_sql($sql);
										if (count($rs)) 
										{
											echo "<thead><tr role=\"row\"><th>Instituição</th><th>Área de Atuação</th><th>Quantidade</th></tr></thead>"; 
											foreach ($rs as $l) 
											{
												echo "<tr class=\"odd\">";
												echo "<td>" . $l->institution .  "</td><td>" . $l->department .  "</td><td>" . $l->quantidade .  "</td>";
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