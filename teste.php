<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";

//------------------------------------------------------------teste para corrigir fin_despesa_elemeneto----------------------------------------------------------------------------------
$conexao = new Conexao();
$pdo = $conexao->connect();
$resut = 0;
$teste = 'Maçao';

try {
    $sql = "select id_despesa_elemento, ds_despesa_elemento from  view_despesa_elemento";

    $stmt = $pdo->prepare($sql);

    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $resut = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resut = 0;
    }

    foreach ($resut as $v) {

//        echo $v["ds_despesa_elemento"];
//        echo "<br/>";

    $sql = "update fin_despesa_elemento set ds_despesa_elemento = '" . substr_replace($v["ds_despesa_elemento"], '', 0, 19) . "' where id_despesa_elemento = " . $v["id_despesa_elemento"];
    
    $stmt = $pdo->prepare($sql);
    
    $stmt->execute();
    echo 'Nada';
    }
} catch (Error $e) {
    echo $e->getMessage();
}
//-----------------------------------------------------------------------------teste da classe finCentralLiberacao------------------------------------------------------------------------
//require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/fin/Qdd.class.php";
//require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/fin/QddValor.class.php";
//require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/central/FinCentralModel.class.php";
//require_once $_SERVER['DOCUMENT_ROOT'] . "/class/orcamento/liberacaoCentral/FinCentralLiberacaoTransModel.class.php";
//require_once $_SERVER['DOCUMENT_ROOT'] . "/class/pla/tipo_gasto/TipoGasto.class.php";
//require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/fin/Fonte.class.php";
//require_once $_SERVER['DOCUMENT_ROOT'] . "/class/orcamento/liberacaoCentral/FinCentralLiberacaoModel.class.php";
//
//$finCentralLiberacaoModel = new FinCentralLiberacaoModel();
//$dados =array(
//"ano"           => "2018",
//"fonte"         => "3",
//"projeto"       => "2",
//"despesa"       => "32",
//"tipoDeGasto"   => "1",
//"central"       => "5"
//);
//
//var_dump($finCentralLiberacaoModel->retornaSaldoValorLiberado($dados));
//-----------------------------------------------------------------------------teste do metodo para valida ------------------------------------------------------------------------
//var_dump(Metodos::ValidaData('2012-02-28 12:12:12'));


//$conexao = new Conexao();
//$pdo = $conexao->connect();
//$resut = 0;
//
//try {
//    $sql = "select * from  teste";
//
//    $stmt = $pdo->prepare($sql);
//
//    $stmt->execute();
//
//    if ($stmt->rowCount() > 0) {
//        $resut = $stmt->fetchAll(PDO::FETCH_ASSOC);
//    } else {
//        $resut = 0;
//    }
//
//    echo "<pre>";
//    print_r($resut);
//    echo "</pre>";
//    
//    $var = $resut[0]['info'];
//    $my_array_data = json_decode($var, TRUE);
//    echo "<pre>";
//    print_r($my_array_data);
//    echo "</pre>";
//    
//    $obitos = 500.52;
//    $formula = "";
//    
//    foreach ($my_array_data as $key => $value) {
//        
//        if(!is_array($value)){
//            $formula .= $value;
//        }else{
//            $formula .= $obitos;
//        }                        
//    }
//    echo $formula."<br>";
//    
//    class Field_calculate {
//        const PATTERN = '/(?:\-?\d+(?:\.?\d+)?[\+\-\*\/])+\-?\d+(?:\.?\d+)?/';
//
//        const PARENTHESIS_DEPTH = 10;
//
//        public function calculate($input){
//            if(strpos($input, '+') != null || strpos($input, '-') != null || strpos($input, '/') != null || strpos($input, '*') != null){
//                //  Remove white spaces and invalid math chars
//                $input = str_replace(',', '.', $input);
//                $input = preg_replace('[^0-9\.\+\-\*\/\(\)]', '', $input);
//
//                //  Calculate each of the parenthesis from the top
//                $i = 0;
//                while(strpos($input, '(') || strpos($input, ')')){
//                    $input = preg_replace_callback('/\(([^\(\)]+)\)/', 'self::callback', $input);
//
//                    $i++;
//                    if($i > self::PARENTHESIS_DEPTH){
//                        break;
//                    }
//                }
//
//                //  Calculate the result
//                if(preg_match(self::PATTERN, $input, $match)){
//                    return $this->compute($match[0]);
//                }
//
//                return 0;
//            }
//
//            return $input;
//        }
//
//        private function compute($input){
//            $compute = create_function('', 'return '.$input.';');
//
//            return 0 + $compute();
//        }
//
//        private function callback($input){
//            if(is_numeric($input[1])){
//                return $input[1];
//            }
//            elseif(preg_match(self::PATTERN, $input[1], $match)){
//                return $this->compute($match[0]);
//            }
//
//            return 0;
//        }
//    }
// 
//   $Cal = new Field_calculate();
//    $result = $Cal->calculate($formula);
//    echo $result;
//    
//    
//    
//} catch (Error $e) {
//    echo $e->getMessage();
//}
//?>
<!--<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>//<?php echo TITULO_DO_SISTEMA; ?></title>
         Tell the browser to be responsive to screen width 
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        Bootstrap Stylesheet [ REQUIRED ]
        <link href="/assets/lib/template/css/bootstrap.min.css" rel="stylesheet">
        Nifty Stylesheet [ REQUIRED ]
        <link href="/assets/lib/template/css/nifty.min.css" rel="stylesheet">
         Font Awesome [ REQUIRED ] 
        <link rel="stylesheet" href="/assets/lib/template/plugins/font-awesome/css/font-awesome.min.css">
         themify icons [ REQUIRED ] 
        <link rel="stylesheet" href="/assets/lib/template/plugins/themify-icons/themify-icons.min.css">  
         ion icons [ REQUIRED ] 
        <link rel="stylesheet" href="/assets/lib/template/plugins/ionicons/css/ionicons.min.css">
        DataTables [ OPT ]
        <link href="/assets/lib/template/plugins/datatables/media/css/dataTables.bootstrap.css" rel="stylesheet">
        <link href="/assets/lib/template/plugins/datatables/extensions/Responsive/css/dataTables.responsive.css" rel="stylesheet">
        <link href="/assets/lib/template/plugins/datatables/extensions/buttons/css/buttons.dataTables.min.css" rel="stylesheet">
        <link href="/assets/lib/template/plugins/datatables/extensions/buttons/css/buttons.bootstrap.min.css" rel="stylesheet">
         Estilo Default das Páginas [ REQUIRED ] 
        <link rel="stylesheet" href="/assets/css/estilo.css">
    </head>
    TIPS

    <body>
        <div id="container" class="effect aside-float aside-bright mainnav-sm">

           <div class="boxed">

                CONTENT CONTAINER
                ===================================================
                <div id="content-container">

                    Page Title
                    ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
                 
                    ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
                    End page title

                    Page content
                    ===================================================
                    <div id="page-content">
                        
                       
                        
                    
                        <div>
                            <button class="btn btn-primary operador" value="(">(</button>
                            <button class="btn btn-primary operador" value="+">+</button>
                            <button class="btn btn-primary operador" value="-">-</button>
                            <button class="btn btn-primary operador" value="/">/</button>
                            <button class="btn btn-primary operador" value="*">*</button>                            
                            <button class="btn btn-primary operador" value=")">)</button>
                            
                            <button class="btn btn-primary campo" value="">Informação do Usuário</button>
                            
                            <input type="text" value="" id="valor" />
                            <button class="btn btn-primary numero" value="">Adicionar Número</button>
                            
                            <button class="btn btn-primary apagar">Apagar</button>
                        </div>
                    
                        <div class="panel">
                            Formula:
                            <br>
                            <div id="formula" style="font-size: 30px;">
                                
                            </div>
                            <div id="formula1" style="display: none;">
                                
                            </div>
                        </div>

                    </div>
                    ===================================================
                    End page content

                </div>
                ===================================================
                END CONTENT CONTAINER
               
            </div>
             SCROLL PAGE BUTTON 
            ===================================================
            <button class="scroll-top btn">
                <i class="pci-chevron chevron-up"></i>
            </button>
            ===================================================



        </div>
        ===================================================
         END OF CONTAINER 

       

        jQuery [ REQUIRED ]
        <script src="/assets/lib/template/js/jquery-2.2.4.min.js"></script>
        BootstrapJS [ REQUIRED ]
        <script src="/assets/lib/template/js/bootstrap.min.js"></script>
        NiftyJS [ REQUIRED ]
        <script src="/assets/lib/template/js/nifty.min.js"></script>
        DataTables [OPT]
        <script src="/assets/lib/template/plugins/datatables/media/js/jquery.dataTables.js"></script>
        <script src="/assets/lib/template/plugins/datatables/media/js/dataTables.bootstrap.js"></script>
        <script src="/assets/lib/template/plugins/datatables/extensions/Responsive/js/dataTables.responsive.min.js"></script>        
        <script src="/assets/lib/template/plugins/datatables/extensions/buttons/js/dataTables.buttons.min.js"></script>           
        <script src="/assets/lib/template/plugins/datatables/extensions/buttons/js/jszip.min.js"></script>   
        <script src="/assets/lib/template/plugins/datatables/extensions/buttons/js/pdfmake.min.js"></script>   
        <script src="/assets/lib/template/plugins/datatables/extensions/buttons/js/vfs_fonts.js"></script>   
        <script src="/assets/lib/template/plugins/datatables/extensions/buttons/js/buttons.html5.min.js"></script>   
        <script src="/assets/lib/template/plugins/datatables/extensions/buttons/js/buttons.print.min.js"></script>
        <script src="/assets/lib/template/plugins/datatables/media/js/accent-neutralise.js"></script>  Search sem Acento 
         DIALOG CONFIRM [OPT] 
        <script src="/assets/lib/template/plugins/bootbox/bootbox.min.js"></script>     
        JAVASCRIP da pagina
        <script src="/assets/lib/loadingover/loadingoverlay.js"></script>
        <script src="/assets/lib/sesacre/funcoes.js"></script>
        <script>
        $(document).ready(function () {

            func = new Funcoes();
            
            $('body').on('click', '.operador', function(e){
               $("#formula").append($(this).val()); 
               $("#formula1").append($(this).val()); 
               $("#formula1").append('{input: text, label: numero de obitos}');
            });
            $('body').on('click', '.numero', function(e){
               $("#formula").append($("#valor").val()); 
            });
            
             $('body').on('click', '.campo', function(e){
               $("#formula").append("INformção"); 
            });
            
            $('body').on('click', '.apagar', function(e){
                $("#formula").html($("#formula").text().slice(0, -1)); 
              
            });
            
        });
        </script>
           
         END JAVASCRIPT 

    </body>
</html>-->
