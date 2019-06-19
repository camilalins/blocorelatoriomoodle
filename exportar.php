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

	$sql106 = "SELECT g.id, g.name ";
    $sql106 .= "FROM mdl_groups g ";
    $sql106 .= "INNER JOIN mdl_course c ON c.id = g.courseid ";
    $sql106 .= "WHERE c.fullname='" . $_POST["curso"] . "' ";

    $turmas = (array) $DB->get_records_sql($sql106);
	$quantidadeTurmas = count($turmas);
        if ($quantidadeTurmas)
        {
            foreach ($turmas as $turma)
            {
                $sql116 = "SELECT COUNT(cc.id) AS quantidade ";
                $sql116 .= "FROM mdl_course_completions cc ";
                $sql116 .= "INNER JOIN mdl_user u ON u.id=cc.userid ";
                $sql116 .= "INNER JOIN mdl_course c ON c.id=cc.course ";
                $sql116 .= "INNER JOIN mdl_groups_members gm ON ( gm.userid = u.id AND gm.groupid = " . $turma-> id . " ) ";
                $sql116 .= "WHERE cc.timecompleted > 0 AND c.fullname='" . $_POST["curso"] . "' ";

                $alunosCompletos = (array) $DB->get_records_sql($sql116);

                $sql117 = "SELECT COUNT(cc.id) AS quantidade ";
                $sql117 .= "FROM mdl_course_completions cc ";
                $sql117 .= "INNER JOIN mdl_user u ON u.id=cc.userid ";
                $sql117 .= "INNER JOIN mdl_course c ON c.id=cc.course ";
                $sql117 .= "INNER JOIN mdl_groups_members gm ON ( gm.userid = u.id AND gm.groupid = " . $turma-> id . " ) ";
                $sql117 .= "WHERE cc.timecompleted IS NULL AND c.fullname='" . $_POST["curso"] . "' ";

                $alunosIncompletos = (array) $DB->get_records_sql($sql117);

                                       
                foreach ($alunosCompletos as $q)
                    {
					fputcsv($output, array_map("cvt", array(
						$turma->name,
						$q->quantidade
					)), ';');
				}
			}
		}
function cvt($texto) {
    return iconv("UTF-8", "ISO-8859-1", $texto);
}

?>
