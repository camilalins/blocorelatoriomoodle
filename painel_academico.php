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
<h3 class="box-title"><?php echo $titulo; ?></h3>
<section class="hold-transition skin-blue sidebar-mini">
	<div class="row">
		<div class="col-md-3 col-sm-6 col-xs-12" style="width: 34%;">
			<div class="info-box">
				<span class="info-box-icon bg-dodgerblue"><i class="fas fa-user-graduate"></i></span>
				<div class="info-box-content">
					<span class="info-box-number"><a href="cadastro_geral.php"><?php echo $total_user->quantidade; ?> <small>Cadastro Geral</small></a></span>
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
