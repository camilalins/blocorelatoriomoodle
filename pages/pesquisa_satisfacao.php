<?php
  require_once('../../../config.php');
  global $CFG, $DB;
  $titulo = 'Pesquisa de Satisfação';

  $PAGE->set_url($_SERVER['PHP_SELF']);
  $PAGE->set_pagelayout('admin');
  $PAGE->set_context(context_system::instance());
  $PAGE->set_url('/blocks/moodleversion/pages/pesquisa_satisfacao.php');
  $PAGE->navbar->add($titulo, new moodle_url("$CFG->httpswwwroot/blocks/moodleversion/pages/pesquisa_satisfacao.php"));
  echo $OUTPUT->header();
?>
<link rel="stylesheet" href="../css/meucss.css">
<!-- Google Font -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic"> 
<!-- Font Awesome --> 
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
<h3 class="box-title"><?php echo $titulo; ?></h3>
<section class="hold-transition skin-blue sidebar-mini">
  <div class="row">
    <div class="col-md-12">
      <div class="box">
        <div class="box-header with-border"><h3 class="box-title"><small>Escolha o curso</small></h3></div>
        <div class="box-body">
          <div class="row">
            <form action="pesquisa_resposta.php" method="post" class="form-horizontal">
              <div class="input-group input-group-sm" style="width: 479px!important;" >
                <?php
                  require_once("../../../config.php");
                  global $DB;
                  $sql = "SELECT disciplina.fullname as curso ";
                  $sql .= " FROM m31_feedback f ";
                  $sql .= " INNER JOIN m31_course disciplina on disciplina.id = f.course ";
                  $disciplina = (array) $DB->get_records_sql($sql);
                  if (count($disciplina)) 
                  {
                    echo "<div class=\"input-group input-group-sm\">"; 
                    echo "<select name=\"escolha_curso\" class=\"form-control\" style=\"width: 479px!important;\"><option>Escolha o curso</option>";
                    foreach ($disciplina as $l) 
                    {
                      echo "<option value=\"". $l->curso ."\">" . $l->curso . "</option>";
                    } 
                    echo "</select>";
                  };
                ?>  
                <span class="input-group-btn">
                  <small><a class="btn btn-comum" href="javascript:history.go(-1)"><i class="fas fa-arrow-left"></i> Voltar</a></small>
                </span>
              </div>
            </form> 
          </div>
        </div>
      </div>    
    </div> 
  </div>  
</section>
<?php
  $PAGE->set_context($context);
  $PAGE->set_pagelayout('incourse');
  $PAGE->set_url('/blocks/moodleversion/pages/pesquisa_satisfacao.php');
  $PAGE->requires->jquery();
  // Never reached if download = true.
  echo $OUTPUT->footer();
?>