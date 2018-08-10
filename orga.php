<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";

$session = new Session();

$token = (int)filter_input(INPUT_GET, 'token', FILTER_DEFAULT);   

$conexao = new Conexao();
$pdo = $conexao->connect();

$sql = " WITH RECURSIVE cte_recursiva (id_lotacao,nome,nivel,arvore)
AS
(


    -- 1a PARTE ANCORA
    SELECT L.id_lotacao
         , L.nm_lotacao
         , 1 AS nivel
         , CAST(L.nm_lotacao AS VARCHAR(255)) AS arvore
         , L.id_pai
         , P.nm_lotacao AS lotacaoPai
      FROM ses_lotacao L
      INNER JOIN ses_lotacao P ON P.id_lotacao = L.id_pai
     WHERE L.id_lotacao = :idPai AND L.st_ativo = '1'
     
    UNION ALL
     
    -- 2a PARTE RECURSIVA
    SELECT g.id_lotacao
         , g.nm_lotacao
         , c.nivel + 1 AS nivel
         , CAST((c.arvore || '/' || g.nm_lotacao) AS VARCHAR(255)) AS arvore 
	 , g.id_pai
	 , P.nm_lotacao AS lotacaoPai
      FROM ses_lotacao g
INNER JOIN cte_recursiva c 
        ON g.id_pai = c.id_lotacao
INNER JOIN ses_lotacao P ON P.id_lotacao = g.id_pai
WHERE g.st_ativo = '1'
        
     
)
SELECT *
  FROM cte_recursiva;";


try {
    $sth = $pdo->prepare($sql);  
    $sth->bindValue(":idPai", $token, PDO::PARAM_INT);
    $sth->execute();
    if ($sth->rowCount() >= 1) {
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $result = "";
    }
    
} catch (PDOException $e) {
    echo $e->getMessage();
    return $retorno;
}

//$array = "";
$array = json_encode("");
if(is_array($result)){
    $array = json_encode($result);    
}


?>

<html>
  <head>
    <script src="/assets/lib/template/js/jquery-2.2.4.min.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {packages:["orgchart"]});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Name');
        data.addColumn('string', 'Manager');
        data.addColumn('string', 'ToolTip');
        
        var a = <?php echo $array; ?>;
        var b = [];                
        
        $.each(a, function(i, a){            
            b.push([a.nome, a.lotacaopai, '']);
        });
        
        //console.log(b);
        data.addRows(b);  

        // Create the chart.
        var chart = new google.visualization.OrgChart(document.getElementById('chart_div'));
        // Draw the chart, setting the allowHtml option to true for the tooltips.
        chart.draw(data, {allowHtml:true});
      }
   </script>
    </head>
    <body>
      
        <div class="butoes">
            <a href="orga.php?token=3">Secretaria Adjunta Atenção à Saúde</a> &nbsp;
            <a href="orga.php?token=4">Secretaria Adjunta Administração e Finanças</a> &nbsp;
            <a href="orga.php?token=2">Secretaria Adjunta de Planejamento e Gestão</a> &nbsp;
            <a href="orga.php?token=142">Departamento de Regional de Saúde</a>
        </div>
      
        <div id="chart_div"></div>
    </body>
</html>



<?php exit; ?>


