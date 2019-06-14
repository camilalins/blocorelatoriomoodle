<?php

require_once("../../config.php");


global $DB;

header('Content-Type: text/csv; charset=UTF-8');
header('Content-Disposition: attachment; filename=Cadastro_Geral(' . date("d-m-y-H-i") . ').csv');

$output = fopen('php://output', 'w');
fputcsv($output, array_map("cvt", array(
    'turma',
    'quantidade'
        )), ';');


$sql = "SELECT cc.id, g.name AS turma, COUNT(g.id) as quantidade ";
$sql .= "FROM mdl_course_completions cc ";
$sql .= "INNER JOIN mdl_groups_members gm ON cc.userid = gm.userid ";
$sql .= "INNER JOIN mdl_groups g ON gm.groupid = g.id ";
$sql .= "INNER JOIN mdl_course c ON g.courseid = c.id ";
$sql .= "WHERE c.fullname='Curso Básico em Segurança da Informação' AND cc.timecompleted > 0 ";
$sql .= "group by g.id ";

$rs = (array) $DB->get_records_sql($sql);

foreach ($rs as $l) {
    fputcsv($output, array_map("cvt", array(
        $l->turma,
        $l->quantidade
            )), ';');
}

function cvt($texto) {
    return iconv("UTF-8", "ISO-8859-1", $texto);
}

?>
