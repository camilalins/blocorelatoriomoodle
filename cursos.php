<?php
require_once("../../../config.php");
require_once("../../../inc/global.php");

global $CFG;

require_login();

$titulo = 'Controle de Cursos,Turmas e Inscritos';

$context = get_context_instance(CONTEXT_SYSTEM, 1);
$PAGE->set_context($context);
$PAGE->set_url('/plugins/relatorios/dashboard/cursos.php');
$PAGE->navbar->add($titulo, new moodle_url("$CFG->httpswwwroot/plugins/relatorios/dashboard/cursos.php"));
$PAGE->set_pagelayout('standard');
$PAGE->set_heading($titulo);

echo $OUTPUT->header();
echo GF::carregarLib(array("jquery", "jalert", "gFunctions", "gDisplay", "gAjax", "php.js", "json", "gValidate", "mask"));

//if (verificaAdminSite($USER->id)) {
if (verificaTutorOuAdmin($USER->id)) {
    ?>
    <h3 class="box-title"><?php echo $titulo; ?></h3>
    <link rel="stylesheet" href="meucss.css">
    
  

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">


    
<!--- nova section-->
<section class="hold-transition skin-blue sidebar-mini">
    <div class="row">
      <div class="col-md-12">
        <div class="box">
          <div class="box-header with-border">
            <h3 class="box-title"><small><a class="btn btn-success btn-sm ad-click-event" href="javascript:history.go(-1)"><i class="fa fa-arrow-left" aria-hidden="true"></i> Voltar</a></small><small> <a class="btn btn-success btn-sm ad-click-event" href="exportar_qtdade_cursos.php"><i class="fa fa-download" aria-hidden="true"></i> Exportar</a></small></h3>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="table-responsive">
            <table class="table no-margin">
              <tbody>
                

<?php

require_once("../../../config.php");

global $DB;

$sql = "SELECT c.id, c.fullname, COUNT(distinct g.name) AS turmas, COUNT(distinct m.id) AS usuarios ";
$sql .= " FROM mdl_groups_members m ";
$sql .= " INNER JOIN mdl_groups g ON g.id=m.groupid ";
$sql .= " INNER JOIN mdl_user u ON u.id=m.userid ";
$sql .= " INNER JOIN mdl_course c ON c.id=g.courseid ";
$sql .= " INNER JOIN mdl_groupings cgr ON c.id=cgr.courseid ";
$sql .= " group by c.fullname;";


$c = (array) $DB->get_records_sql($sql);

//echo "<div id=\"DataTables_Table_0_wrapper\" class=\"dataTables_wrapper container-fluid dt-bootstrap4 no-footer\">";
//echo "<table class=\"table table-striped table-bordered datatable dataTable no-footer\">";
    if (count($c)) {
    echo "<thead><tr role=\"row\"><th>Nome do Curso</th><th>Quantidade de Turmas</th><th>Quantidade de Inscritos</th><th></tr></thead>"; 

    foreach ($c as $l) {
    echo "<tr class=\"odd\">";
        
        echo "<td>" . $l->fullname .  "</td><td>" . $l->turmas .  "</td><td>" . $l->usuarios .  "</td>";
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
         </div>    </div>    </div>
</section>
<!--- fim nova section-->

    <?php
} else {
    echo msgNaoAutorizada();
}

echo $OUTPUT->footer();
?>
<link type="text/css" rel="stylesheet" href="../../../inc/css/global.css"></link>
<script type="text/javascript" src="../../js/functions.js"></script>
<script type="text/javascript" src="../../js/html2canvas.js"></script>
