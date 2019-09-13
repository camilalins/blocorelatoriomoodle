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

// Traz o total de "Usuários Cadastrados"
$sqlTotalUser = "SELECT COUNT(institution) AS quantidade";
$sqlTotalUser .= " FROM mdl_user";
$sqlTotalUser .= " WHERE deleted <> 1 and suspended <> 1 and username <> 'guest' and format(username, 0)";
$rs = (array) $DB->get_records_sql($sqlTotalUser);
$total_user = array_shift($rs);

// Traz o total de "Cursos Cadastrados"
$sqlTotalCursos = "SELECT count(*) as quantidade";
$sqlTotalCursos .= " FROM mdl_course";
$curso_ativo = (array) $DB->get_records_sql($sqlTotalCursos);
$total_curso_ativo = array_shift($curso_ativo);

// Traz os Cursos em "Detalhes Sobre o Curso" (select/option)
$sqlGetCursos = "SELECT disciplina.id, aluno.username as cpf, aluno.firstname as nome, aluno.lastname as Sobrenome, aluno.institution as instituicao, aluno.department as departamento, aluno.email as email,polo.name as turma, disciplina.id as ID, disciplina.fullname as curso ";
$sqlGetCursos .= "FROM mdl_course disciplina ";
$sqlGetCursos .= "inner join mdl_groups polo on polo.courseid = disciplina.id ";
$sqlGetCursos .= "inner join mdl_groups_members alunos_polo on alunos_polo.groupid = polo.id ";
$sqlGetCursos .= "inner join mdl_user_enrolments pre_inscr on pre_inscr.userid = alunos_polo.userid ";
$sqlGetCursos .= "inner join mdl_role_assignments inscri on inscri.id = pre_inscr.enrolid ";
$sqlGetCursos .= "inner join mdl_user aluno on aluno.id = alunos_polo.userid ";
$sqlGetCursos .= "inner join mdl_context e on inscri.contextid = e.id ";
$sqlGetCursos .= "WHERE format <> 'site' AND e.contextlevel=50 AND inscri.roleid=5 ";
$sqlGetCursos .= "group by curso ";
$disciplina = (array) $DB->get_records_sql($sqlGetCursos);

?>

<h3 class="box-title"><?php echo $titulo; ?></h3>
<section>
	<div class="rows">
		<div class="col-md-3 col-sm-6 col-xs-12" style="width: 34%;">
			<div class="info-box-topo">
				<span class="info-box-icon bg-dodgerblue"><i class="fas fa-user-graduate" style="color:#51666C;"></i></span>
				<a href="cadastro_geral.php" style="font-weight:800!important; font-size:20px; "> <?php echo $total_user->quantidade; ?></a>
				<div class="info-box-content">
					<span class="info-box-number">
						<a href="cadastro_geral.php">
							<small style="font-weight:100!important;">Usuários Cadastrados</small> 
						</a>
					</span>
				</div>
			</div>
		</div>
		<div class="col-md-3 col-sm-6 col-xs-12" style="width: 33%;">
			<div class="info-box-topo">
				<span class="info-box-icon bg-cornflowerblue"><i class="fas fa-book" style="color:#51666C;"></i></span>
				<a href="curso_turma.php" style="font-weight:800!important; font-size:20px; "><?php echo $total_curso_ativo->quantidade; ?></a>
				<div class="info-box-content">
					<span class="info-box-number">
						<a href="curso_turma.php" >
							<small style="font-weight:100!important;">Cursos Cadastrados</small>
						</a>
					</span>
				</div>
			</div>
		</div>
	</div>  
</section>
<section>
	<div class="rows">
		<div class="col-md-3 col-sm-6 col-xs-12" style="width: 100%;">
				<div class="info-box-topo">
					
					<div class="info-box-content">
						<span class="info-box-number">
							<h3 class="box-title"><span class="info-box-icon bg-dodgerblue"><i class="fas fa-user-graduate"></i></span><small> Detalhes Sobre o Curso </small></h3>
						</span>
						<form action="detalhes_curso.php" method="post" class="form-horizontal">
							<div class="input-group input-group-sm">    
								<?php
									if (count($disciplina)) {
										echo "<div class=\"input-group input-group-sm\">"; 
										echo "<select name=\"escolha_curso\" class=\"form-control\"><option>Escolha o curso</option>";
										foreach ($disciplina as $l7) {
											echo "<option value=\"". $l7->curso ."\">" . $l7->curso . "</option>";
										} 
										echo "</select>";
									};
								?>	
								<span class="input-group-btn">
									<button type="submit" class="btn btn-info btn-flat">Pesquisar</button>
								</span>
							</div>
						</form>	
					</div>
				</div>
		</div>
	</div>
</section>

