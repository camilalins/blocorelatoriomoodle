<?php
require_once("../../../config.php");
require_once("../../../inc/global.php");

global $CFG;

require_login();

$titulo = 'Modalidade Online';

$context = get_context_instance(CONTEXT_SYSTEM, 1);
$PAGE->set_context($context);
$PAGE->set_url('/plugins/relatorios/dashboard/curso_usuario.php');
$PAGE->navbar->add($titulo, new moodle_url("$CFG->httpswwwroot/plugins/relatorios/dashboard/curso_usuario.php"));
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


<section class="hold-transition skin-blue sidebar-mini">
  <div class="row">
      <div class="col-md-12">
        <div class="box">
          <div class="box-header with-border"><h3 class="box-title"><small>Escolha o curso que deseja e o departamento</small></h3></div>
          <div class="box-body">
            <div class="row">
				<form action="atividades_curso_resposta.php" method="post" class="form-horizontal">
					<div class="input-group input-group-sm">
						<?php

require_once("../../../config.php");

global $DB;

$sql = "SELECT disciplina.id, aluno.username as cpf, aluno.firstname as nome, aluno.lastname as Sobrenome, aluno.institution as instituicao, aluno.department as departamento, aluno.email as email,polo.name as turma, disciplina.id as ID, disciplina.fullname as curso";
$sql .= " FROM mdl_course disciplina";
$sql .= " inner join mdl_groups polo on polo.courseid = disciplina.id ";
$sql .= " inner join mdl_groups_members alunos_polo on alunos_polo.groupid = polo.id";
$sql .= " inner join mdl_user_enrolments pre_inscr on pre_inscr.userid = alunos_polo.userid";
$sql .= " inner join mdl_role_assignments inscri on inscri.id = pre_inscr.enrolid";
$sql .= " inner join mdl_user aluno on aluno.id = alunos_polo.userid";
$sql .= " inner join mdl_context e on inscri.contextid = e.id ";
$sql .= " WHERE format <> 'site' AND e.contextlevel=50 AND inscri.roleid=5";
$sql .= " group by curso ";


$disciplina = (array) $DB->get_records_sql($sql);


    if (count($disciplina)) {
    echo "<div class=\"input-group input-group-sm\">"; 
	echo "<select name=\"escolha_curso\" class=\"form-control\"><option>Escolha o curso</option>";
    foreach ($disciplina as $l) {
    
        
        echo "<option value=\"". $l->curso ."\">" . $l->curso . "</option>";

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
   </div>  


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
