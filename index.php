<?php

	require_once('../../config.php');

	$PAGE->set_url($_SERVER['PHP_SELF']);
	$PAGE->set_pagelayout('admin');
	$PAGE->set_context(context_system::instance());
	echo $OUTPUT->header();
	echo $OUTPUT->heading(get_string('Estou aqui'));
	
?>
