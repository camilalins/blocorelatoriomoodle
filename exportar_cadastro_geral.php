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
$sql = " SELECT id, institution, department, quantidade";
$sql .= " FROM mdl_role_assignments ass";
$sql .= " INNER JOIN mdl_user u ON  u.id = ass.userid";
$sql .= " WHERE roleid=5 AND deleted <> 1 AND suspended <> 1 AND username <> 'guest'";

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
