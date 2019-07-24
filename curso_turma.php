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
<h3 class="box-title"><?php echo $titulo; ?></h3>
<section class="hold-transition skin-blue sidebar-mini">
  <div class="row">
    <div class="col-md-12">
      <div class="box">
        <div class="box-header with-border">
          <small><a class="btn btn-comum" href="javascript:history.go(-1)"><i class="fas fa-arrow-left"></i> Voltar</a></small>
          <small><a class="btn btn-comum" href="exportar_curso_turma.php"><i class="fas fa-download"></i> Exportar</a></small>
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
                  $sql .= " FROM m31_groups_members m ";
                  $sql .= " INNER JOIN m31_groups g ON g.id=m.groupid ";
                  $sql .= " INNER JOIN m31_user u ON u.id=m.userid ";
                  $sql .= " INNER JOIN m31_course c ON c.id=g.courseid ";
                  $sql .= " INNER JOIN m31_groupings cgr ON c.id=cgr.courseid ";
                  $sql .= " group by c.fullname;";
                  $c = (array) $DB->get_records_sql($sql);
                  if (count($c)) 
                  {
                    echo "<thead><tr role=\"row\"><th>Nome do Curso</th><th>Quantidade de Turmas</th><th>Quantidade de Inscritos</th><th></tr></thead>"; 
                    foreach ($c as $l) 
                    {
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