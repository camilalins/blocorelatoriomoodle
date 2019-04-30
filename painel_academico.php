<?php

	require_once('../../config.php');
	global $CFG, $DB;
	$titulo = 'Painel Academico';

	$PAGE->set_url($_SERVER['PHP_SELF']);
	$PAGE->set_pagelayout('admin');
	$PAGE->set_context(context_system::instance());
	$PAGE->set_url('/local/moodleversion/painel_academico.php');
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
<section class="hold-transition skin-blue sidebar-mini">
	<div class="rows">
		<div class="col-md-3 col-sm-6 col-xs-12" style="width: 34%;">
			<div class="info-box">
				<span class="info-box-icon bg-dodgerblue"><i class="fas fa-user-graduate"></i></span>
				<div class="info-box-content">
					<span class="info-box-number"><a href="cadastro_geral.php"><small>Cadastro Geral</small><?php echo $total_user->quantidade; ?> </a></span><br>
					<span class="info-box-text"><?php echo $total_aluno->quantidade; ?> <small>Alunos</small></span>
				</div>
			</div>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12" style="width: 33%;">
			<div class="info-box">
				<span class="info-box-icon bg-cornflowerblue"><i class="fas fa-book"></i></span>
				<div class="info-box-content">
					<span class="info-box-number"><a href="curso_turma.php"><?php echo $total_curso_ativo->quantidade; ?> <small>Total de Cursos</small></a></span>
				</div>
			</div>
		</div>
        <div class="col-md-3 col-sm-6 col-xs-12" style="width: 33%;">
          <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="fas fa-bullhorn" aria-hidden="true"></i></span>
            <div class="info-box-content">
              <span class="info-box-number"><a href="pesquisa_satisfacao.php"><small>Pesquisa de Satisfação</small></a>
            </div>
          </div>
        </div>
    </div>   
</section>


<?php
	$PAGE->set_context($context);
	$PAGE->set_pagelayout('incourse');
	$PAGE->set_url('/blocks/moodleversion/consulta_user.php');
	$PAGE->requires->jquery();
	// Never reached if download = true.
	echo $OUTPUT->footer();
?>
