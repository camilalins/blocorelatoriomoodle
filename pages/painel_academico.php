<?php
  require_once('../../../config.php');
  global $CFG, $DB;
  $titulo = 'Painel Acadêmico';

  $PAGE->set_url($_SERVER['PHP_SELF']);
  $PAGE->set_pagelayout('admin');
  $PAGE->set_context(context_system::instance());
  $PAGE->set_url('/blocks/moodleversion/pages/painel_academico.php');
  $PAGE->navbar->add($titulo, new moodle_url("$CFG->httpswwwroot/blocks/moodleversion/pages/painel_academico.php"));
  echo $OUTPUT->header();
?>
<link rel="stylesheet" href="../css/meucss.css">
<!-- Google Font -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
<!-- Font Awesome --> 
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">

  <!-- Total de usuários -->    
  <?php
    require_once("../../../config.php");
    global $DB;
    $sql = "SELECT COUNT(institution) AS quantidade";
    $sql .= " FROM mdl_user";
    $sql .= " WHERE deleted <> 1 and suspended <> 1 and username <> 'guest' and format(username, 0)";
    $rs = (array) $DB->get_records_sql($sql);
    //print_r ($rs);
    $total_user = array_shift($rs);
  ?>
  <!-- Alunos habilitados -->         
  <?php
    require_once("../../../config.php");
    global $DB;
    $sql = "SELECT count(*) as quantidade";
    $sql .= " FROM mdl_role_assignments ass";
    $sql .= " INNER JOIN mdl_user u ON  u.id = ass.userid";
    $sql .= " WHERE roleid=5 AND deleted <> 1 AND suspended <> 1 AND username <> 'guest'";
    $aluno = (array) $DB->get_records_sql($sql);
    //print_r ($rs);
    $total_aluno = array_shift($aluno);
  ?>
  <!-- Total de curso -->         
  <?php
    require_once("../../../config.php");
    global $DB;
    $sql = "SELECT count(*) as quantidade";
    $sql .= " FROM mdl_course";
    $curso = (array) $DB->get_records_sql($sql);
    $total_course = array_shift($curso);
  ?>
  <!-- Curso Ativo -->          
  <?php
    require_once("../../../config.php");
    global $DB;
    $sql = "SELECT count(*) as quantidade";
    $sql .= " FROM mdl_course";
    $curso_ativo = (array) $DB->get_records_sql($sql);
    //print_r ($rs);
    $total_curso_ativo = array_shift($curso_ativo);
  ?>        
  <h3 class="box-title"><?php echo $titulo; ?></h3>
  <section class="hold-transition skin-blue sidebar-mini">
    <div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12" style="width: 34%;">
          <div class="info-box">
            <span class="info-box-icon bg-dodgerblue"><i class="fas fa-user-graduate"></i></span>
            <div class="info-box-content">
              <span class="info-box-number"><a href="cadastro_geral.php"><?php echo $total_user->quantidade; ?> <small>Cadastro Geral</small></a></span>
              <span class="info-box-text"><?php echo $total_aluno->quantidade; ?> <small>Alunos</small></span>
            </div>
          </div>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12" style="width: 33%;">
          <div class="info-box">
            <span class="info-box-icon bg-cornflowerblue"><i class="fas fa-book"></i></span>
            <div class="info-box-content">
              <span class="info-box-number"><a href="curso_turma.php"><?php echo $total_curso_ativo->quantidade; ?> <small>Total de Cursos</small></a></span>
            </div>
          </div>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12" style="width: 33%;">
          <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="fas fa-bullhorn" aria-hidden="true"></i></span>
            <div class="info-box-content">
              <span class="info-box-number"><a href="pesquisa_satisfacao.php"><small>Pesquisa de Satisfação</small></a>
            </div>
          </div>
        </div>
    </div>   
  </section>
  <section class="hold-transition skin-blue sidebar-mini">
    <!--Gráfico 1-->
    <?php
      require_once("../../../config.php");
      global $DB;
      $sql = "SELECT g.id, c.fullname curso, g.name turma , gs.name ciclo, count(m.userid) AS quantidade, cate.path,g.idnumber ";
      $sql .= "FROM mdl_groups_members m ";
      $sql .= "LEFT JOIN mdl_groups g ON g.id=m.groupid ";
      $sql .= "INNER JOIN mdl_course c ON c.id= g.courseid ";
      $sql .= "LEFT JOIN mdl_groupings_groups gg on gg.groupid = g.id ";
      $sql .= "LEFT JOIN mdl_groupings gs ON gs.id = gg.groupingid ";
      $sql .= "INNER JOIN mdl_course_categories cate ON cate.id = c.category ";
      $sql .= "WHERE path like '/2/3%' AND g.idnumber = ' ' or path like '/7/8%' AND g.idnumber = ' ' ";
      $sql .= "group by c.fullname ";
    ?>

    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
    //carregando modulo visualization
      google.load("visualization", "1", {packages:["corechart"]});
    //função de monta e desenha o gráfico
    function drawChart() 
    {
      //variavel com armazenamos os dados, um array de array's 
      //no qual a primeira posição são os nomes das colunas
      <?php
      $rs = (array) $DB->get_records_sql($sql);
        if (count($rs)) 
        {
          echo "var data = google.visualization.arrayToDataTable([\n\r['Curso', 'Quantidade'],"; 
          foreach ($rs as $l) 
          {
          echo "['" . $l->curso .  "'," . $l->quantidade .  "],\n\r";
          } 
          echo "]);";
        };
      ?>
      //opções para exibição do gráfico
      var options = 
      {
        chartArea:{left:5,right:5,bottom:5,top:5,width:'30%',height:'30%'},
        legend:'none',
        title: 'ONLINE',//titulo do gráfico
        is3D: true // false para 2d e true para 3d o padrão é false
      };
      //cria novo objeto PeiChart que recebe 
      //como parâmetro uma div onde o gráfico será desenhado
      var chart = new google.visualization.PieChart(document.getElementById('chart_div1'));
      //desenha passando os dados e as opções
          chart.draw(data, options);
    }
    //metodo chamado após o carregamento
    google.setOnLoadCallback(drawChart);
    </script>
    <!--fim grafico1.1-->
    <!--Gráfico 2-->
    <?php
      require_once("../../../config.php");
      global $DB;
      $sql2 = "SELECT g.id, c.fullname curso, g.name turma , gs.name ciclo, count(m.userid) AS quantidade, cate.path,g.idnumber";
      $sql2 .= " FROM mdl_groups_members m  ";
      $sql2 .= " LEFT JOIN mdl_groups g ON g.id=m.groupid ";
      $sql2 .= " INNER JOIN mdl_course c ON c.id= g.courseid   ";
      $sql2 .= " LEFT JOIN mdl_groupings_groups gg on gg.groupid = g.id ";
      $sql2 .= " LEFT JOIN mdl_groupings gs ON gs.id = gg.groupingid";
      $sql2 .= " INNER JOIN mdl_course_categories cate ON cate.id = c.category";
      $sql2 .= " WHERE path like '/2/5%' AND g.idnumber = ' ' or path like '/7/9%' AND g.idnumber = ' '";
      $sql2 .= " group by c.fullname ";

      $rs2 = (array) $DB->get_records_sql($sql2);
      //print_r($rs);
    ?>
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
    //carregando modulo visualization
      google.load("visualization", "1", {packages:["corechart"]});
    //função de monta e desenha o gráfico
    function drawChart() 
    {
      //variavel com armazenamos os dados, um array de array's 
      //no qual a primeira posição são os nomes das colunas
      <?php
        if (count($rs2)) 
        {
          echo "var data = google.visualization.arrayToDataTable([\n\r['Curso', 'Quantidade'],"; 
          foreach ($rs2 as $l2) 
          {
          echo "['" . $l2->curso .  "'," . $l2->quantidade .  "],\n\r";
          } 
          echo "]);";
        };
      ?>
      //opções para exibição do gráfico
      var options = 
      {
        chartArea:{left:5,right:5,bottom:5,top:5,width:'30%',height:'30%'},
        legend:'none',
        title: 'ONLINE',//titulo do gráfico
        is3D: true // false para 2d e true para 3d o padrão é false
      };
      //cria novo objeto PeiChart que recebe 
      //como parâmetro uma div onde o gráfico será desenhado
      var chart = new google.visualization.PieChart(document.getElementById('chart_div2'));
      //desenha passando os dados e as opções
          chart.draw(data, options);
    }
    //metodo chamado após o carregamento
    google.setOnLoadCallback(drawChart);
    </script>
    <!--fim grafico 2-->
    <!--Gráfico 3-->
    <?php
      require_once("../../../config.php");
      global $DB;
      $sql3 = " SELECT g.id, c.fullname curso, g.name turma , gs.name ciclo, count(m.userid) AS quantidade, cate.path,g.idnumber";
      $sql3 .= " FROM mdl_groups_members m ";
      $sql3 .= " LEFT JOIN mdl_groups g ON g.id=m.groupid ";
      $sql3 .= " INNER JOIN mdl_course c ON c.id= g.courseid ";
      $sql3 .= " LEFT JOIN mdl_groupings_groups gg on gg.groupid = g.id ";
      $sql3 .= " LEFT JOIN mdl_groupings gs ON gs.id = gg.groupingid ";
      $sql3 .= " INNER JOIN mdl_course_categories cate ON cate.id = c.category ";
      $sql3 .= " WHERE path like '/2/6%' AND g.idnumber = ' ' or path like '/7/10%' AND g.idnumber = ' ' ";
      $sql3 .= " group by c.fullname ";

      $rs3 = (array) $DB->get_records_sql($sql3);
      //print_r($rs);
    ?>
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
    //carregando modulo visualization
      google.load("visualization", "1", {packages:["corechart"]});
    //função de monta e desenha o gráfico
    function drawChart() 
    {
      //variavel com armazenamos os dados, um array de array's 
      //no qual a primeira posição são os nomes das colunas
      <?php
        if (count($rs2)) 
        {
          echo "var data = google.visualization.arrayToDataTable([\n\r['Curso', 'Quantidade'],"; 
          foreach ($rs3 as $l3) 
          {
          echo "['" . $l3->curso .  "'," . $l3->quantidade .  "],\n\r";
          } 
          echo "]);";
        };
      ?>
      //opções para exibição do gráfico
      var options = 
      {
        chartArea:{left:5,right:5,bottom:5,top:5,width:'30%',height:'30%'},
        legend:'none',
        title: 'ONLINE',//titulo do gráfico
        is3D: true // false para 2d e true para 3d o padrão é false
      };
      //cria novo objeto PeiChart que recebe 
      //como parâmetro uma div onde o gráfico será desenhado
      var chart = new google.visualization.PieChart(document.getElementById('chart_div3'));
      //desenha passando os dados e as opções
          chart.draw(data, options);
    }
    //metodo chamado após o carregamento
    google.setOnLoadCallback(drawChart);
    </script>
    <!--fim grafico 3-->  

    <div class="row">
      <div class="col-md-12">
        <div class="box">
          <div class="box-header with-border">
            <h3 class="box-title">Cursos Disponíveis</h3>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="box-footer">
                <div class="row">
                  <div class="col-sm-3 col-xs-6">
                    <div class="description-block border-right">
                      <?php
                        if (!empty($rs))
                        {
                          echo "<ul style=\"list-style:none;\">";
                          echo "<li id=\"chart_div1\"></li>";
                          echo "</ul>";
                          echo "<a href=\"grafico_online.php\"><span class=\"description-percentage text-green\"><i class=\"fa fa-caret-up\"></i> Veja Mais</span></a>";
                        }
                        else
                        {
                          echo "<p>Nenhum curso encontrado</p>";
                        }
                      ?>
                      <h5 class="description-header">Online</h5>
                    </div>
                  </div>
                  <div class="col-sm-3 col-xs-6">
                    <div class="description-block border-right">
                      <?php
                        if (!empty($rs2))
                        {
                          echo "<ul style=\"list-style:none;\">";
                          echo "<li id=\"chart_div2\"></li>";
                          echo "</ul>";
                          echo "<a href=\"grafico_semipresencial.php\"><span class=\"description-percentage text-green\"><i class=\"fa fa-caret-up\"></i> Veja Mais</span></a>";
                        }
                        else
                        {
                          echo "<p>Nenhum curso encontrado</p>";
                        }
                      ?>
                      <h5 class="description-header">Semipresencial</h5>
                    </div>
                  </div>
                  <div class="col-sm-3 col-xs-6">
                    <div class="description-block border-right border-none">
                      <?php
                        if (!empty($rs3))
                        {
                          echo "<ul style=\"list-style:none;\">";
                          echo "<li id=\"chart_div3\"></li>";
                          echo "</ul>";
                          echo "<a href=\"grafico_presencial.php\"><span class=\"description-percentage text-green\"><i class=\"fa fa-caret-up\"></i> Veja Mais</span></a>";
                        }
                        else
                        {
                          echo "<p>Nenhum curso encontrado</p>";
                        }
                      ?>
                      <h5 class="description-header">Presencial</h5>
                    </div>                
                  </div>
                </div>
              </div>
            </div>  
          </div>  
        </div>
      </div>
    </div>
  </section>
  <section class="hold-transition skin-blue sidebar-mini"><!-- Registro por Ciclo   -->
    <div class="row">
      <div class="col-md-12">
        <div class="box">
          <div class="box-header with-border">
            <h3 class="box-title">Registro por Ciclo</h3>
          </div>
          <div class="box-body">
            <div class="row">
              <!--Gráfico 4-->
              <?php
                require_once("../../../config.php");
                global $DB;
                $sql8 = " SELECT gs.id, gs.name as ciclo, COUNT(m.userid) as total";
                $sql8 .= " FROM mdl_groups_members m ";
                $sql8 .= " LEFT JOIN mdl_groups g ON g.id=m.groupid";
                $sql8 .= " INNER JOIN mdl_course c ON c.id= g.courseid";
                $sql8 .= " INNER JOIN mdl_course_categories cate ON cate.id = c.category";
                $sql8 .= " INNER JOIN mdl_groupings gs ON gs.courseid=c.id";
                $sql8 .= " INNER JOIN mdl_groupings_groups gg ON g.id = gg.groupid";
                $sql8 .= " INNER JOIN mdl_user u ON  u.id = m.userid";
                $sql8 .= " INNER JOIN mdl_role_assignments ass ON ass.userid=u.id";
                $sql8 .= " WHERE ass.roleid=5 AND u.deleted <> 1 AND u.suspended <> 1 AND u.username <> 'guest' ";
                $sql8 .= " GROUP BY gs.name ";
                $rs3 = (array) $DB->get_records_sql($sql8);
                //print_r ($rs3);
              ?>
              <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
              <script type="text/javascript">
                google.charts.load("current", {packages:["corechart"]});
                google.charts.setOnLoadCallback(drawChart);
                function drawChart() 
                {
                  <?php
                    $rs4 = (array) $DB->get_records_sql($sql8);
                    if (count($rs4)) 
                    {
                      echo "var data = google.visualization.arrayToDataTable([\n\r['Curso', 'Quantidade'],"; 
                      foreach ($rs4 as $l) 
                      {
                        echo "['" . $l->ciclo .  "'," . $l->total .  "],\n\r";
                      } 
                      echo "]);";
                    };
                  ?>
                  var options = {
                    chartArea:{left:5,right:5,bottom:5,top:5,width:'10%',height:'10%'},
                    title: 'Registro por ciclo',
                    pieHole: 0.4,
                  };
                  var chart = new google.visualization.PieChart(document.getElementById('donutchart'));
                    chart.draw(data, options);
                  }
                </script>
                <div id="donutchart" style="width: 400px; height: 300px; margin: 0 auto;"></div>
              </div>
            </div>
        </div>
      </div>
    </div>    
  </section>
  <section class="hold-transition skin-blue sidebar-mini"> <!-- Registro por Modalidade   -->
    <!-- online    -->
      <?php
            require_once("../../../config.php");
            global $DB;
            $sql5 = " SELECT COUNT(m.userid) as total";
              $sql5 .= " FROM mdl_groups_members m   ";
              $sql5 .= " LEFT JOIN mdl_groups g ON g.id=m.groupid";
              $sql5 .= " INNER JOIN mdl_course c ON c.id= g.courseid";
              $sql5 .= " INNER JOIN mdl_course_categories cate ON cate.id = c.category";
              $sql5 .= " INNER JOIN mdl_groupings gs ON gs.courseid=c.id";
              $sql5 .= " INNER JOIN mdl_user u ON  u.id = m.userid";
              $sql5 .= " INNER JOIN mdl_role_assignments ass ON ass.userid=u.id";
              $sql5 .= " WHERE cate.path like '/2/3%' and ass.roleid=5 AND u.deleted <> 1 AND u.suspended <> 1 AND u.username <> 'guest' or cate.path like '/7/8%' and ass.roleid=5 AND u.deleted <> 1 AND u.suspended <> 1 AND u.username <> 'guest' ";
            //print_r ($rsonline)
          ?><!-- Fim Online   -->
          <!-- semipresencial    -->
          <?php
            require_once("../../../config.php");
            global $DB;
            $sql6 = " SELECT COUNT(m.userid) as total";
            $sql6 .= " FROM m31_groups_members m   ";
            $sql6 .= " LEFT JOIN m31_groups g ON g.id=m.groupid";
            $sql6 .= " INNER JOIN m31_course c ON c.id= g.courseid";
            $sql6 .= " INNER JOIN m31_course_categories cate ON cate.id = c.category";
            $sql6 .= " INNER JOIN m31_groupings gs ON gs.courseid=c.id";
            $sql6 .= " INNER JOIN m31_user u ON  u.id = m.userid";
            $sql6 .= " INNER JOIN m31_role_assignments ass ON ass.userid=u.id";
            $sql6 .= " WHERE cate.path like '/2/5%' and ass.roleid=5 AND u.deleted <> 1 AND u.suspended <> 1 AND u.username <> 'guest' or cate.path like '/7/9%' and ass.roleid=5 AND u.deleted <> 1 AND u.suspended <> 1 AND u.username <> 'guest' ";
            //print_r ($rsonline)
          ?><!-- Fim Semipresencial    -->
          <!-- Presencial    -->
          <?php
            require_once("../../../config.php");
            global $DB;
            $sql7 = " SELECT COUNT(m.userid) as total";
            $sql7 .= " FROM m31_groups_members m   ";
            $sql7 .= " LEFT JOIN m31_groups g ON g.id=m.groupid";
            $sql7 .= " INNER JOIN m31_course c ON c.id= g.courseid";
            $sql7 .= " INNER JOIN m31_course_categories cate ON cate.id = c.category";
            $sql7 .= " INNER JOIN m31_groupings gs ON gs.courseid=c.id";
            $sql7 .= " INNER JOIN m31_user u ON  u.id = m.userid";
            $sql7 .= " INNER JOIN m31_role_assignments ass ON ass.userid=u.id";
            $sql7 .= " WHERE cate.path like '/2/6%' and ass.roleid=5 AND u.deleted <> 1 AND u.suspended <> 1 AND u.username <> 'guest' or cate.path like '/7/10%' and ass.roleid=5 AND u.deleted <> 1 AND u.suspended <> 1 AND u.username <> 'guest' ";
            //print_r ($rsonline)
          ?><!-- Fim Presencial    -->
    <div class="row">
      <div class="col-md-12">
        <div class="box">
          <div class="box-header with-border">
            <h3 class="box-title">Registro por Modalidade</h3>
          </div>
          <div class="box-body">
            <div class="row">        
              <div class="col-sm-3 col-xs-6">
                <div class="row">
                  <div class="description-block border-right">
                    <span class="description-percentage text-yellow"><i class="fa fa-caret-left"></i> Online</span>
                      <?php
                        $rsonline = (array) $DB->get_records_sql($sql5);
                        if (count($rsonline)) 
                        { 
                          foreach ($rsonline as $lonline) 
                          {
                          echo "<h5>" . $lonline->total .  "</h5>\n\r";
                          };
                        };
                      ?>
                    <span class="description-text">TOTAL DE INSCRITOS</span>
                  </div>
                </div>   
              </div>
              <div class="col-sm-3 col-xs-6">
                <div class="row">
                  <div class="description-block border-right">
                    <span class="description-percentage text-yellow"><i class="fa fa-caret-left"></i> Semipresencial</span>
                      <?php
                        $rssemi = (array) $DB->get_records_sql($sql6);
                        if (count($rssemi)) 
                        { 
                          foreach ($rssemi as $lsemi) 
                          {
                            echo "<h5>" . $lsemi->total .  "</h5>\n\r";
                          };
                        };
                      ?>
                    <span class="description-text">TOTAL DE INSCRITOS</span>
                  </div>
                </div>   
              </div>        
              <div class="col-sm-3 col-xs-6">
                <div class="row">
                  <div class="description-block border-right border-none">
                    <span class="description-percentage text-yellow"><i class="fa fa-caret-left"></i> Presencial</span>
                      <?php
                        $rspresencial = (array) $DB->get_records_sql($sql7);
                        if (count($rspresencial)) 
                        { 
                          foreach ($rspresencial as $lpresencial) 
                          {
                            echo "<h5>" . $lpresencial->total .  "</h5>\n\r";
                          };
                        };
                      ?>                     
                    <span class="description-text">TOTAL DE INSCRITOS</span>
                  </div>
                </div>   
              </div>
            </div> 
          </div>
        </div>
      </div>
    </div>  
  </section>
<?php
$PAGE->set_context($context);
$PAGE->set_pagelayout('incourse');
$PAGE->set_url('/blocks/moodleversion/pages/painel_academico.php');
$PAGE->requires->jquery();
// Never reached if download = true.
echo $OUTPUT->footer();
?>

