<?php

	require_once('../../config.php');
	global $CFG, $DB;
	$titulo = 'Consulta de Usuário';

	$PAGE->set_url($_SERVER['PHP_SELF']);
	$PAGE->set_pagelayout('admin');
	$PAGE->set_context(context_system::instance());
	$PAGE->set_url('/blocks/moodleversion/consulta_user.php');
	$PAGE->navbar->add($titulo, new moodle_url("$CFG->httpswwwroot/blocks/moodleversion/consulta_user.php"));
	echo $OUTPUT->header();
?>
<link rel="stylesheet" href="meucss.css">
<!-- Google Font -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
<!-- Font Awesome --> 
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
<!-- Total de usuários -->  

<h3 class="box-title"><?php echo $titulo; ?></h3>

<section>
	<div class="rows">
		<div class="coluna" style="width: 100%; ">
			<div class="box">
				<div class="box-header1 with-border1">
					<h3 class="box-title"><small>Digite o CPF sem traço ou ponto. Ex.: 99999999999</small></h3>
				</div>
				<div class="box-body">
					<div class="rows">
						<form action="<?php echo htmlentities($_SERVER['PHP_SELF']);?>" method="post" class="form-horizontal">
							<div class="col-md1">
								<div class="input-group-btn">
									<label class="col-md-3 form-control-label" for="hf-email">CPF</label>
									<input type="text" id="hf-email" name="user_name" class="form-control" placeholder="Digite o CPF">
									<button type="submit" class="btn btn-sm btn-primary" style="margin: 0px 0px 0px 20px !important;"><i class="fa fa-dot-circle-o"></i>  Pesquisar</button>
									<button type="submit" class="btn btn-sm btn-danger"><i class="fa fa-ban"></i>  Limpar</button>
									<small><a class="btn btn-comum" style="    margin: -1px 0px 0px 5px;" href="javascript:history.go(-1)"><i class="fas fa-arrow-left"></i> Voltar</a></small>
								</div> 
							</div>                                          
						</form>
					</div>
					<br>
					<br>
					
						<?php
							require_once('../../config.php');
							global $DB;
							$sql = "SELECT distinct aluno.firstname as nome, aluno.lastname as sobrenome, aluno.email as email, aluno.institution as instituicao ";
							$sql .= "FROM mdl_role_assignments rs ";
							$sql .= "INNER JOIN mdl_context e ON rs.contextid=e.id ";
							$sql .= "INNER JOIN mdl_course c ON c.id = e.instanceid ";
							$sql .= "INNER JOIN mdl_user aluno on aluno.id = rs.userid ";
							$sql .= "WHERE aluno.username= '" . $_REQUEST["user_name"] . "' ";
							$rs = (array) $DB->get_records_sql($sql);

							//print_r($rs);

							echo "<div id=\"DataTables_Table_0_wrapper\" class=\"table-responsive\">";
							echo "<table class=\"table no-margin\">";
							if (count($rs)) {
								echo "<thead><tr role=\"row\"><th class=\"sorting\" width=180px >Instituição</th><th class=\"sorting\" width= 356px>Nome</th><th class=\"sorting\" width= 256px>Email</th></tr></thead>"; 
								foreach ($rs as $l) {
									echo "<tr class=\"odd\">";
									echo "<td>" . $l->instituicao . "</td><td>" . $l->nome . ' ' . $l->sobrenome . "</td><td>" . $l->email . "</td>";
									;
									echo "</tr>";
								} 
							} 
							else {
								echo "<div align=center>";
								if ($_REQUEST["user_name"] <> "") {
									echo "Não foi encontrado nenhum curso para o usuário <b>" . $_REQUEST["user_name"] . "</b>.";
								} 
								else {
									echo "Insira o CPF do usuário desejado";
								};
								echo "</div>";
							}
								echo "</table></div>";
						?>
						<?php
							require_once('../../config.php');
							global $DB;

							$sql2 = "SELECT gm.id,c.fullname as curso, cc.name as categoria, u.firstname, u.lastname, u.email, g.name as turma, gr.name as ciclo ";
							$sql2 .= "FROM mdl_groups_members gm ";
							$sql2 .= "INNER JOIN mdl_user u ON u.id = gm.userid ";
							$sql2 .= "INNER JOIN mdl_groups g ON g.id = gm.groupid ";
							$sql2 .= "INNER JOIN mdl_course c ON c.id = g.courseid ";
							$sql2 .= "LEFT JOIN mdl_groupings_groups gg ON gg.groupid = g.id ";
							$sql2 .= "LEFT JOIN mdl_groupings gr ON gr.id = gg.groupingid ";
							$sql2 .= "INNER JOIN mdl_course_categories cc ON cc.id = c.category ";
							$sql2 .= "WHERE u.username= '" . $_REQUEST["user_name"] . "' ";
							
							$rs2 = (array) $DB->get_records_sql($sql2);
							
							echo "<div id=\"DataTables_Table_0_wrapper\" class=\"table-responsive\">";
							echo "<table class=\"table no-margin\">";
							if (count($rs2)) {
								echo "<thead><tr role=\"row\"><th class=\"sorting\" width=469px >Nome do Curso</th><th class=\"sorting\" width= 66px>Turma</th></tr></thead>"; 
								foreach ($rs2 as $l2) {
									echo "<tr class=\"odd\">";
									echo "<td>" . $l2->curso .  "</td><td>" . $l2->turma .  "</td>";
									;
									echo "</tr>";
								} 
							}
							echo "</table>";
						?>
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
