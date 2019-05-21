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

    <h3 class="box-title"><?php echo $titulo; ?></h3>

    <link rel="stylesheet" href="meucss.css">
    

  <!-- Google Font -->
 <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic"> 
<section class="hold-transition skin-blue sidebar-mini">
  <div class="row">
      <div class="col-md-12">
        <div class="box">
          <div class="box-header with-border"><small><a class="btn btn-success btn-sm ad-click-event" href="javascript:history.go(-1)"><i class="fa fa-arrow-left" aria-hidden="true"></i> Voltar</a></small><!--<small> <a class="btn btn-success btn-sm ad-click-event" href="exportar_usuarios_curso.php"><i class="fa fa-download" aria-hidden="true"></i> Exportar</a></small>--></div>
          <div class="box-body">
            <div class="row">
				
				
<?php 

require_once("../../config.php");

global $DB;

$sql = "SELECT COUNT(com.id) AS countrecord  ";
$sql .= " FROM mdl_course_completions com ";
$sql .= " inner join mdl_course c on c.id = com.course";
$sql .= " WHERE c.fullname='" . $_REQUEST["escolha_curso"] . "' AND (timecompleted > 0) ";
//echo $sql;

$disciplina = (array) $DB->get_records_sql($sql);
foreach($disciplina as $site);

?>


<?php 

require_once("../../config.php");

global $DB;

$sql2 = "SELECT COUNT(com.id) AS count2  ";
$sql2 .= " FROM mdl_course_completions com ";
$sql2 .= " inner join mdl_course c on c.id = com.course";
$sql2 .= " WHERE c.fullname='" . $_REQUEST["escolha_curso"] . "' AND (timecompleted IS NULL) AND (reaggregate > 0) ";
//echo $sql;

$disciplina2 = (array) $DB->get_records_sql($sql2);
//print_r ($disciplina2);
foreach($disciplina2 as $site2);
?>

<?php 

require_once("../../config.php");

global $DB;

$sql3 = "SELECT COUNT(com.id) AS count3  ";
$sql3 .= " FROM mdl_course_completions com ";
$sql3 .= " inner join mdl_course c on c.id = com.course";
$sql3 .= " WHERE c.fullname='" . $_REQUEST["escolha_curso"] . "' AND (timestarted = 0) ";
//echo $sql;

$disciplina3 = (array) $DB->get_records_sql($sql3);
//print_r ($disciplina3);
foreach($disciplina3 as $site3);
?>


<div class="table-responsive"><table  class="table no-margin"><tbody>
	<thead><tr role="row"><th>Concludentes</th><th>Em Andamento</th><th>Não Iniciou</th></tr></thead>
	<tr class="odd">
		<td><?php echo $site->countrecord ; ?></td>
		<td><?php echo $site2->count2 ; ?></td>
		<td><?php echo $site3->count3 ; ?></td>
	</tr>



<?php 

require_once("../../config.php");

global $DB;

$sql5 = "SELECT gi.id as id, gi.itemname as nome, gi.itemtype as tipo, gi.gradetype as grade, gi.scaleid as escala ";
$sql5 .= " FROM mdl_grade_items gi ";
$sql5 .= " right JOIN mdl_course c ON c.id = gi.courseid ";
$sql5 .= " WHERE c.fullname='" . $_REQUEST["escolha_curso"] . "' ";

$disciplina5 = (array) $DB->get_records_sql($sql5);

echo "<h3 class=\"box-title\" style=\"padding: 0px 0px 0px 17px;\"><i class=\"fa fa-bookmark\" style=\"font-size: 14px; padding: 9px;\" aria-hidden=\"true\"></i>" . $_REQUEST["escolha_curso"] .  "</h3>";

    if (count($disciplina5)) {

		echo "<div class=\"table-responsive\"><table  class=\"table no-margin\"><tbody>"; 
    	echo "<thead><tr role=\"row\"><th>ID</th><th>Nome da Avaliação</th><th>Tipo de Avaliação</th><th>Módulo	</th><th>Módulo</th></tr></thead>"; 

    foreach ($disciplina5 as $l) {
    echo "<tr class=\"odd\">";
        
        echo "<td>" . $l->id .  "</td><td>" . $l->nome .  "</td><td>" . $l->tipo . "</td><td>" . $l->grade .  "</td><td>" . $l->itemmodule .  "</td>";
;
 echo "</td></tr>";
    } 

}else {
	echo "<div align=center>";
		
if ($_REQUEST["escolha_curso"] <> "") {
	   echo "Não foram encontrados usuários para o curso";
	   } else {
		   echo "Insira o nome de usuário desejado";
	};
	
echo "</tbody>";
}
echo "</table></div>";


?>






</div></div></div></div></div></section>







  <?php
} else {
    echo msgNaoAutorizada();
}

echo $OUTPUT->footer();
?>
<link type="text/css" rel="stylesheet" href="../../../inc/css/global.css"></link>
<script type="text/javascript" src="../../js/functions.js"></script>
<script type="text/javascript" src="../../js/html2canvas.js"></script>

