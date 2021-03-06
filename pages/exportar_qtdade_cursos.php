<?php

require_once("../../../config.php");
require_once("../../../inc/global.php");

global $DB;

header('Content-Type: text/csv; charset=UTF-8');
header('Content-Disposition: attachment; filename=Acessos(' . date("d-m-y-H-i") . ').csv');

$output = fopen('php://output', 'w');
fputcsv($output, array_map("cvt", array(
    'Curso',
    'Quantidade de Turmas',
    'Quantidade de Inscritos'
        )), ';');


$sql = "SELECT c.id, c.fullname, COUNT(distinct g.name) AS turmas, COUNT(distinct m.id) AS usuarios ";
$sql .= " FROM mdl_groups_members m ";
$sql .= " INNER JOIN mdl_groups g ON g.id=m.groupid ";
$sql .= " INNER JOIN mdl_user u ON u.id=m.userid ";
$sql .= " INNER JOIN mdl_course c ON c.id=g.courseid ";
$sql .= " INNER JOIN mdl_groupings cgr ON c.id=cgr.courseid ";
$sql .= " group by c.fullname;";

$rs = (array) $DB->get_records_sql($sql);

foreach ($rs as $l) {
    fputcsv($output, array_map("cvt", array(
        $l->fullname,
        $l->turmas,
        $l->usuarios
            )), ';');
}

function cvt($texto) {
    return iconv("UTF-8", "ISO-8859-1", $texto);
}

?>
