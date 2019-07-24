<?php

require_once("../../config.php");


global $DB;

header('Content-Type: text/csv; charset=UTF-8');
header('Content-Disposition: attachment; filename=Cadastro_Geral(' . date("d-m-y-H-i") . ').csv');

$output = fopen('php://output', 'w');
fputcsv($output, array_map("cvt", array(
    'Instituição',
    'Área de Atuação',
    'Quantidade'
        )), ';');
	$sql = "select id, institution, department, quantidade ";
	$sql .= " from (SELECT id, institution, department, COUNT(institution) AS quantidade";
	$sql .= " FROM mdl_user rs";
	$sql .= " WHERE deleted <> 1 and suspended <> 1 and username <> 'guest' and format(username, 0)";
	$sql .= " GROUP BY department, institution)x";
	$sql .= " ORDER BY quantidade DESC";
	$rs = (array) $DB->get_records_sql($sql);

foreach ($rs as $l) {
    fputcsv($output, array_map("cvt", array(
        $l->institution,
        $l->department,
        $l->quantidade
            )), ';');
}

function cvt($texto) {
    return iconv("UTF-8", "ISO-8859-1", $texto);
}
?>
