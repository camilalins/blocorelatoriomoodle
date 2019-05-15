<?php

	require_once('../../config.php');
	global $CFG, $DB;
	$titulo = 'Cursos';

	$PAGE->set_url($_SERVER['PHP_SELF']);
	$PAGE->set_pagelayout('admin');
	$PAGE->set_context(context_system::instance());
	$PAGE->set_url('/blocks/moodleversion/cursos.php');
	$PAGE->navbar->add($titulo, new moodle_url("$CFG->httpswwwroot/local/moodleversion/cursos.php"));
	echo $OUTPUT->header();
?>
<link rel="stylesheet" href="meucss.css">
<!-- Google Font -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic"> 
<!-- Font Awesome --> 
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
	
<h3 class="box-title"><?php echo $titulo; ?></h3>
    
<section class="hold-transition skin-blue sidebar-mini">
	<div class="rows">
		<div class="col-md-12">
			<div class="box">
				<div class="box-header with-border">
					<h3 class="box-title">
						<small>
							<a class="btn btn-success btn-sm ad-click-event" href="javascript:history.go(-1)">
								<i class="fa fa-arrow-left" aria-hidden="true"></i> Voltar
							</a>
						</small>
						<small> 
							<a class="btn btn-success btn-sm ad-click-event" href="exportar_qtdade_cursos.php">
								<i class="fa fa-download" aria-hidden="true"></i> Exportar
							</a>
						</small>
					</h3>
				</div>
<div class="box-body">
<div class="row">
<div class="table-responsive">
<table class="table no-margin">
<tbody>
                

<?php

require_once("../../config.php");

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
	$PAGE->set_context($context);
	$PAGE->set_pagelayout('incourse');
	$PAGE->set_url('/blocks/moodleversion/cursos.php');
	$PAGE->requires->jquery();
	// Never reached if download = true.
	echo $OUTPUT->footer();
?>