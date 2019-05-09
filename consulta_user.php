<?php

	require_once('../../config.php');
	global $CFG, $DB;
	$titulo = 'Consulta de Usuário';

	$PAGE->set_url($_SERVER['PHP_SELF']);
	$PAGE->set_pagelayout('admin');
	$PAGE->set_context(context_system::instance());
	$PAGE->set_url('/blocks/moodleversion/consulta_user.php');
	$PAGE->navbar->add($titulo, new moodle_url("$CFG->httpswwwroot/local/moodleversion/consulta_user.php"));
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
		<div class="coluna">
			<div class="box">
				<div class="box-header1 with-border1">
					<h3 class="box-title"><small>Digite o CPF sem traço ou ponto. Ex.: 99999999999</small></h3>
				</div>
				<div class="box-body">
					<div class="row1">
						<form action="<?php echo htmlentities($_SERVER['PHP_SELF']);?>" method="post" class="form-horizontal">
							<div class="form-group row">
								<div class="col-md1">
									<div class="input-group-btn">
										<label class="col-md-3 form-control-label" for="hf-email">CPF</label>
										<input type="text" id="hf-email" name="user_name" class="form-control" placeholder="Digite o CPF">
										<div class="card-footer">
											<button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-dot-circle-o"></i> Pesquisar</button>
											<button type="reset" class="btn btn-sm btn-danger"><i class="fa fa-ban"></i>Limpar</button>
										</div>
									</div> 
								</div>                                          
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
	$PAGE->set_url('/blocks/moodleversion/consulta_user.php');
	$PAGE->requires->jquery();
	// Never reached if download = true.
	echo $OUTPUT->footer();
?>
