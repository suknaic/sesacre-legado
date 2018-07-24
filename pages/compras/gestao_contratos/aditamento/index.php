<?php
    require_once $_SERVER['DOCUMENT_ROOT'] . "/model/compras/gestaoContratos/aditamento/index.load.php";
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title><?php echo TITULO_DO_SISTEMA; ?></title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!--Bootstrap Stylesheet [ REQUIRED ]-->
        <link href="/assets/lib/template/css/bootstrap.min.css" rel="stylesheet">
        <!--Nifty Stylesheet [ REQUIRED ]-->
        <link href="/assets/lib/template/css/nifty.min.css" rel="stylesheet">
        <!-- Font Awesome [ REQUIRED ] -->
        <link rel="stylesheet" href="/assets/lib/template/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet">
        <!-- themify icons [ REQUIRED ] -->
        <link rel="stylesheet" href="/assets/lib/template/plugins/themify-icons/themify-icons.min.css" rel="stylesheet">
        <!--Select2-->
        <link href="/assets/lib/template/plugins/select2/css/select2.min.css" rel="stylesheet">
        <!--DataTables [ OPT ]-->
        <link href="/assets/lib/template/plugins/datatables/media/css/dataTables.bootstrap.css" rel="stylesheet">
        <link href="/assets/lib/template/plugins/datatables/extensions/buttons/css/buttons.dataTables.min.css" rel="stylesheet">
        <link href="/assets/lib/template/plugins/datatables/extensions/buttons/css/buttons.bootstrap.min.css" rel="stylesheet">
        <!--Datapicker-->
        <link href="/assets/lib/template/plugins/bootstrap-datepicker/bootstrap-datepicker.min.css" rel="stylesheet">
        <!-- Estilo Default das Páginas [ REQUIRED ] -->
        <link rel="stylesheet" href="/assets/css/estilo.css" rel="stylesheet">
        <style>
            /* Important part */
            .modal-fu{
                /*overflow-y: initial !important
                overflow-y: scroll; */
                max-height:85%;                  
                bottom: 0;
                left: 0;
                position: absolute;
                right: 0;
                top: 0;
                margin: 0;
                width: 100%;
                animation-duration:0.6s;
                height: 80%;
            }
            .modal-fu-body{
                /*height: 100px;*/
                max-height: calc(100vh - 212px);
                overflow-y: auto;
            }
            .modal.modal-fu .modal-footer {
                bottom: 0;
            }                                   
        </style>
    
    </head>    
    <body>
        <div id="container" class="effect aside-float aside-bright mainnav-sm">
            <?php
                //Cabeçalho do Sistema
                require_once $_SERVER['DOCUMENT_ROOT'] . "/layout/header.php";
            ?>
            <?php
                //Modal Alert
                require_once $_SERVER['DOCUMENT_ROOT'] . "/layout/modalAlert.html";
            ?>
            <div class="boxed">
                <!--CONTENT CONTAINER-->
                <!--===================================================-->
                <div id="content-container">
                    <!--Modal itens content-->
                    <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" id="modalItem" data-keyboard="false">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    <h4 class="modal-title">Busca do Contrato</h4>
                                </div>
                                <div class="modal-body">
                                    <div class="input-group mar-btm">
                                        <input type="text" id="codItemPesquisa" placeholder="Número do Contrato" class="form-control">
                                        <span class="input-group-btn">
                                            <button class="btn btn-primary" type="button" id="btn-pesquisa">
                                                <i class="fa fa-search" aria-hidden="true"></i> Pesquisar
                                            </button>
                                        </span>
                                    </div>

                                    <div id="demo-dt-basic_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <table id="tabelaItens" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                                    <thead>
                                                        <tr>
                                                            <th>Número do Contrato</th>
                                                            <th>Fornecedor</th>
                                                            <th>Tipo de Gasto</th>
                                                            <th>Objeto</th>                                                            
                                                            <th>Modalidade</th>
                                                            <th>Valor do Contrato</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                                </div>
                            </div>
                        </div>
                    </div>                                                            
                    
                    <div class="modal fade footer-to-bottom" id="myModalFu" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-fu animated zoomInLeft modal-lg" role="document" >
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                        <h4 class="modal-title">Itens do Contrato</h4>
                                </div>
                                <div class="modal-body modal-fu-body">
                                    <div id="demo-dt-basic_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <table class="table table-striped table-bordered" id="tabelaFu">
                                                    <thead>
                                                        <tr>
                                                            <th class="text-center">Nº</th>
                                                            <th class="text-center">Item</th>
                                                            <th class="text-center">Descrição</th>
                                                            <th class="text-center">Grupo</th>
                                                            <th class="text-center">Sub Grupo</th>
                                                            <th class="text-center">Unid</th>
                                                            <th class="text-center">Elemento de Despesa</th>
                                                            <th class="text-center">Tipo</th>
                                                            <th class="text-center">Lote</th>
                                                            <th class="text-center">QTD</th>
                                                            <th class="text-center">Valor unit</th>
                                                            <th class="text-center">Aditivo</th>
                                                            <th class="text-center">Total</th>
                                                            <th class="text-center">Saldo</th>                                                         
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>                                    
                                </div>
                            </div>                            
                        </div>                        
                    </div>
                    
                    
                    <div class="modal fade footer-to-bottom" id="modalDetalhes" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-fu animated zoomInLeft modal-lg" role="document" >
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                        <h4 class="modal-title">Dados do Aditivo</h4>
                                </div>
                                <div class="modal-body modal-fu-body">
                                    
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>                                    
                                </div>
                            </div>                            
                        </div>                        
                    </div>
                    
                    
                    
                    <!-- /.modal -->
                    <!--Page content-->
                    <!--===================================================-->                    
                     <div id="page-title">
                        <h1 class="page-header text-overflow">Cadastro do <?php echo $motivoAditivo; ?></h1>                     
                    </div>
                    <ol class="breadcrumb">
                        <li><a href="../index.php">Voltar</a></li>
                        
                    </ol>
                    <div id="page-content" class="form-horizontal">
                        
                            <div class="panel">
                                
                                <div class="form-group">
                                    <div class="col-sm-3">
                                        <div class="panel-body">
                                            Pesquisa Contrato:<span class="text-danger">*</span>
                                            <div class="input-group">
                                                <span class="input-group-addon"><p class="fa fa-sort-numeric-asc" style="margin-bottom: -4px"></p></span>
                                                <input class="form-control" type="text" name="itemContrato" id="itemContrato" disabled />
                                                <span class="input-group-btn pesquisaContrato" data-target="#modalItem" data-toggle="modal">
                                                    <button type="button" class="btn btn-primary"><i class="fa fa-search" aria-hidden="true"></i></button>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">Dados do Contrato</h3>
                                    </div>
                                    <div class="panel-body">
                                        <input type="hidden" id="id_contrato" value="0" />
                                        <?php 
                                            foreach ($dadosContrato as $key => $value) {
                                                echo '<div class="row">
                                                        <div class="col-sm-2">
                                                            <p class="text-bold">'.$value.':</p>					                            
                                                        </div>
                                                        <div class="col-sm-10" id="'.$key.'">
                                                            <p></p>
                                                        </div>
                                                    </div>';
                                            }                                                                                      
                                        ?>                                        
                                    </div>
                                </div>
                                
                                <div class="panel panel-default" id="panel-aditivos">                                
                                    <div class="panel-heading">
                                        <h3 class="panel-title">Dados do(s) Aditivo(s):</h3>
                                    </div>
                                    <div class="panel-body">                                
                                        
                                    </div>
                                    <div class="panel-footer">                                   
                                        <button class="btn btn-primary btn-add-aditivo btn-rounded">
                                            <i class="fa fa-plus-circle fa-1x"></i> Iniciar Novo Aditivo
                                        </button>                                    
                                    </div>
                                </div>
                                
                                <div class="panel panel-default" id="panel-novo-atitivo" >                                
                                    <div class="panel-heading">
                                        <h3 class="panel-title">Novo Aditivo:</h3>
                                    </div>
                                    
                                    <div class="form-horizontal">
                                        <input type="hidden" id="motivo" value="<?php echo $motivo->getIdContratoMotivo(); ?>" />
                                        <input type="hidden" id="numero_novo_aditivo" value="0" />
                                        <div class="panel-body">                                             
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label text-left">Motivo do Aditamento: <span class="text-danger">*</span> </label>
                                                <div class="col-sm-6">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <p class="fa fa-file-text-o inputPFa"></p>
                                                        </span>
                                                        <input type="text" id="n_motivo" class="form-control" readonly="true" value="<?php echo $motivoAditivo; ?>" placeholder="Motivo do Aditamento">
                                                    </div>                                                    
                                                </div>
                                            </div>
                                                                                        
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label text-left">Número do Aditivo: <span class="text-danger">*</span></label>
                                                <div class="col-sm-6">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <p class="fa fa-sort-numeric-asc inputPFa"></p>
                                                        </span>
                                                        <input class="form-control" type="text" name="n_numero_aditivo" readonly="true" id="n_numero_aditivo" placeholder="1-90">
                                                    </div>                                                                                                 
                                                </div>
                                            </div>
                                            
                                            <div class="form-group" id="div_finalidade">
                                                <label class="col-sm-2 control-label text-left">Finalidade: <span class="text-danger">*</span></label>
                                                <div class="col-sm-6">
                                                    <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <p class="fa fa-list inputPFa"></p>
                                                            </span>
                                                        <select id="n_finalidade" class="form-control">
                                                            <option value="0">Selecione a Finalidade</option>
                                                            <?php echo $selectFinalidade; ?>
                                                        </select>                                                                
                                                    </div>                                                   
                                                </div>
                                            </div>
                                            
                                            <div class="form-group" id="div_instrumento">
                                                <label class="col-sm-2 control-label text-left">
                                                    Instrumento de Equilíbrio Econômico-Financeiro: <span class="text-danger">*</span></label>
                                                <div class="col-sm-6">
                                                    <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <p class="fa fa-list inputPFa"></p>
                                                            </span>
                                                        <select id="n_instrumento" class="form-control">
                                                            <option value="0">Selecione um Instrumento</option>
                                                            <?php echo $selectInstrumento; ?>
                                                        </select>                                                                
                                                    </div>                                                   
                                                </div>
                                            </div>
                                            
                                            <div class="form-group" id="div_base_calculo">
                                                <label class="col-sm-2 control-label text-left">Base de Cálculo: <span class="text-danger">*</span></label>
                                                <div class="col-sm-6">
                                                    <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <p class="fa fa-list inputPFa"></p>
                                                            </span>
                                                        <select id="n_base_calculo" class="form-control">
                                                            <option value="0">Selecione uma Base de Cálculo</option>
                                                            <?php echo $selectBaseCalculo; ?>
                                                        </select>                                                                
                                                    </div>                                                   
                                                </div>
                                            </div>
                                            
                                            <div class="form-group" id="div_unidade_calculo">
                                                <label class="col-sm-2 control-label text-left">Unidade de Cálculo: 
                                                    <span class="text-danger">*</span>
                                                    <span class="fa fa-question-circle add-tooltip" 
                                                          data-original-title="Unidade de Cálculo será Habilitado de acordo com o Instrumento de Equilíbrio Econômico-Financeiro e a Base de Cálculo" 
                                                        data-toggle="tooltip" data-container="body" data-placement="top" role="button">                                                              
                                                    </span>                                                    
                                                </label>
                                                <div class="col-sm-6">
                                                    <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <p class="fa fa-list inputPFa"></p>
                                                            </span>
                                                        <select id="n_unidade_calculo" class="form-control">
                                                            <option value="0">Selecione uma Unidade de Cálculo</option>
                                                            <?php echo $selectUnidadeCalculo; ?>
                                                        </select>                                                                
                                                    </div>                                                   
                                                </div>
                                            </div>
                                                                                                                                    
                                            <div class="form-group" id="div_tipo_aquisicao">
                                                <label class="col-sm-2 control-label text-left">Tipo de Aquisição: 
                                                    <span class="text-danger">*</span>
                                                    <span class="fa fa-question-circle add-tooltip" 
                                                          data-original-title="Tipo de Aquisição somente será Habilitado Quando Instrumento de Equilíbrio Econômico-Financeiro for Revisão" 
                                                        data-toggle="tooltip" data-container="body" data-placement="top" role="button">                                                              
                                                    </span>
                                                </label>
                                                <div class="col-sm-6">
                                                    <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <p class="fa fa-list inputPFa"></p>
                                                            </span>
                                                        <select id="n_tipo_aquisicao" class="form-control" disabled="">
                                                            <option value="0">Selecione a Aquisição</option>
                                                            <?php echo $selectTipoAquisicao; ?>
                                                        </select>                                                                
                                                    </div>                                                   
                                                </div>
                                            </div>
                                            
                                            <div class="form-group" id="div_percentual">
                                                <label class="col-sm-2 control-label text-left">Percentual: 
                                                    <span class="text-danger">*</span>
                                                    <span class="fa fa-question-circle add-tooltip" 
                                                          data-original-title="Campo Obrigatório Quando a Unidade de Cálculo for Percentual" 
                                                        data-toggle="tooltip" data-container="body" data-placement="top" role="button">                                                              
                                                    </span>
                                                </label>
                                                <div class="col-sm-6">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <p class="fa fa-sort-numeric-asc inputPFa"></p>
                                                        </span>
                                                        <input class="form-control" type="text" name="n_percentual" id="n_percentual" placeholder="%">
                                                    </div>                                                                                                     
                                                </div>
                                            </div>
                                            
                                            <div class="form-group" id="div_indice_correcao">
                                                <label class="col-sm-2 control-label text-left">Índice de Correção: <span class="text-danger">*</span></label>
                                                <div class="col-sm-6">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <p class="fa fa-sort-numeric-asc inputPFa"></p>
                                                        </span>
                                                        <input class="form-control" type="text" name="n_indice_correcao" id="n_indice_correcao" placeholder="%">
                                                    </div>                                                                                                     
                                                </div>
                                            </div>
                                            
                                            <div class="form-group" id="div_valor_aditivo">
                                                <label class="col-sm-2 control-label text-left">Valor do Aditivo: <span class="text-danger">*</span></label>
                                                <div class="col-sm-6">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <p class="fa fa-sort-numeric-asc inputPFa"></p>
                                                        </span>
                                                        <input class="form-control quatro_casas" type="text" name="n_valor_aditivo" id="n_valor_aditivo" placeholder="0.000,00" readonly="true">
                                                        <span class="input-group-btn" id="btn_itens_abrir_modal">
                                                            <button class="btn btn-primary add-itens" data-toggle="modal" data-target="#myModalFullscreen" type="button">
                                                                Itens
                                                            </button>
                                                        </span>  
                                                    </div>                                                                                                      
                                                </div>
                                            </div>                                                                                        
                                            
                                            <div class="form-group" id="div_periodo_inicial">
                                                <label class="col-sm-2 control-label text-left">Período Inicial: 
                                                    <span class="text-danger">*</span>
                                                    <span class="fa fa-question-circle add-tooltip" 
                                                          data-original-title="Campo Obrigatório Quando o Instrumento de Equilíbrio Econômico-Financeiro for Reajuste" 
                                                        data-toggle="tooltip" data-container="body" data-placement="top" role="button">                                                              
                                                    </span>
                                                </label>
                                                <div class="col-sm-6">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <p class="fa fa-calendar inputPFa"></p>
                                                        </span>
                                                        <input type="text" class="form-control data" name="n_periodo_inicial" id="n_periodo_inicial" placeholder="__/__/____">
                                                    </div>                                                  
                                                </div>
                                            </div>
                                            
                                            <div class="form-group" id="div_periodo_final">
                                                <label class="col-sm-2 control-label text-left">Período Final: 
                                                    <span class="text-danger">*</span>
                                                    <span class="fa fa-question-circle add-tooltip" 
                                                          data-original-title="Campo Obrigatório Quando o Instrumento de Equilíbrio Econômico-Financeiro for Reajuste" 
                                                        data-toggle="tooltip" data-container="body" data-placement="top" role="button">                                                              
                                                    </span>
                                                </label>
                                                <div class="col-sm-6">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <p class="fa fa-calendar inputPFa"></p>
                                                        </span>
                                                        <input type="text" class="form-control data" name="n_periodo_final" id="n_periodo_final" placeholder="__/__/____">
                                                    </div>                                                  
                                                </div>
                                            </div>
                                            
                                            <div class="form-group" id="div_vigencia_inicial">
                                                <label class="col-sm-2 control-label text-left">Data da Vigência Inicial: 
                                                    <span class="text-danger">*</span>                                                    
                                                </label>
                                                <div class="col-sm-6">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <p class="fa fa-calendar inputPFa"></p>
                                                        </span>
                                                        <input type="text" class="form-control data" name="n_vigencia_inicial" id="n_vigencia_inicial" placeholder="__/__/____">
                                                    </div>                                                  
                                                </div>
                                            </div>
                                            
                                            <div class="form-group" id="div_vigencia_final">
                                                <label class="col-sm-2 control-label text-left">Data da Vigência Final: 
                                                    <span class="text-danger">*</span>                                                    
                                                </label>
                                                <div class="col-sm-6">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <p class="fa fa-calendar inputPFa"></p>
                                                        </span>
                                                        <input type="text" class="form-control data" name="n_vigencia_final" id="n_vigencia_final" placeholder="__/__/____">
                                                    </div>                                                  
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label text-left">Data da Publicação: <span class="text-danger">*</span></label>
                                                <div class="col-sm-6">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <p class="fa fa-calendar inputPFa"></p>
                                                        </span>
                                                        <input type="text" class="form-control data" name="n_data_publicacao" id="n_data_publicacao" placeholder="__/__/____">
                                                    </div>                                                  
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label text-left">Data da Assinatura: <span class="text-danger">*</span></label>
                                                <div class="col-sm-6">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <p class="fa fa-calendar inputPFa"></p>
                                                        </span>
                                                        <input type="text" class="form-control data" name="n_data_assinatura" id="n_data_assinatura" placeholder="__/__/____">
                                                    </div>                                                  
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label text-left">Justificativa: </label>
                                                <div class="col-sm-6">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <p class="fa fa-file-text-o inputPFa"></p>
                                                        </span>
                                                        <textarea class="form-control" rows="4" cols="50" name="n_justificativa" id="n_justificativa"></textarea>                                                        
                                                    </div>                                                  
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label text-left">Gestores Titulares: <span class="text-danger">*</span></label>
                                                <div class="col-sm-6">
                                                    <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <p class="fa fa-list inputPFa"></p>
                                                            </span>
                                                        <select class="n_gestor_titular form-control select_funcionarios">
                                                        </select>    
                                                        <span class="input-group-btn">
                                                            <button class="btn btn-primary add-pessoa" type="button">
                                                                <i class="fa fa-plus-circle fa-1x"></i>
                                                            </button>
                                                        </span>                                                            
                                                    </div>                                                                                                       
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label text-left">Gestores Substitutos: <span class="text-danger">*</span></label>
                                                <div class="col-sm-6">
                                                    <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <p class="fa fa-list inputPFa"></p>
                                                            </span>
                                                        <select class="n_gestor_sub form-control select_funcionarios">                                                            
                                                        </select>   
                                                        <span class="input-group-btn">
                                                            <button class="btn btn-primary add-pessoa" type="button">
                                                                <i class="fa fa-plus-circle fa-1x"></i>
                                                            </button>
                                                        </span>  
                                                    </div>                                                   
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label text-left">Fiscais: <span class="text-danger">*</span></label>
                                                <div class="col-sm-6">
                                                    <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <p class="fa fa-list inputPFa"></p>
                                                            </span>
                                                        <select class="n_fiscal form-control select_funcionarios">                                                            
                                                        </select>   
                                                        <span class="input-group-btn">
                                                            <button class="btn btn-primary add-pessoa" type="button">
                                                                <i class="fa fa-plus-circle fa-1x"></i>
                                                            </button>
                                                        </span>
                                                    </div>                                                   
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label text-left">Fiscais Substitutos: <span class="text-danger">*</span></label>
                                                <div class="col-sm-6">
                                                    <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <p class="fa fa-list inputPFa"></p>
                                                            </span>
                                                        <select class="n_fiscal_sub form-control select_funcionarios">                                                            
                                                        </select>    
                                                        <span class="input-group-btn">
                                                            <button class="btn btn-primary add-pessoa" type="button">
                                                                <i class="fa fa-plus-circle fa-1x"></i>
                                                            </button>
                                                        </span>
                                                    </div>                                                   
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label text-left">Sub-Fiscais: <span class="text-danger">*</span></label>
                                                <div class="col-sm-6">
                                                    <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <p class="fa fa-list inputPFa"></p>
                                                            </span>
                                                        <select class="n_sub_fiscal form-control select_funcionarios">                                                            
                                                        </select>
                                                        <span class="input-group-btn">
                                                            <button class="btn btn-primary add-pessoa" type="button">
                                                                <i class="fa fa-plus-circle fa-1x"></i>
                                                            </button>
                                                        </span>
                                                    </div>                                                   
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label text-left">Sub-Fiscais Substitutos: <span class="text-danger">*</span></label>
                                                <div class="col-sm-6">
                                                    <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <p class="fa fa-list inputPFa"></p>
                                                            </span>
                                                        <select class="n_sub_fiscal_sub form-control select_funcionarios">                                                            
                                                        </select> 
                                                        <span class="input-group-btn">
                                                            <button class="btn btn-primary add-pessoa" type="button">
                                                                <i class="fa fa-plus-circle fa-1x"></i>
                                                            </button>
                                                        </span>
                                                    </div>                                                   
                                                </div>
                                            </div>
                                            
                                            
                                            
                                        </div>    
                                    </div>
                                    
                                    <div class="panel-footer text-right">                                   
                                        <button class="btn btn-success btn-salvar btn-rounded">
                                            <i class="fa fa-floppy-o fa-1x"></i> Salvar Aditivo
                                        </button>                                    
                                    </div>
                                </div>
                        
                                
                                
                                
                                
                        
                    </div>
                </div>
                <!--===================================================-->
                <!--End page content-->
            </div>
            <!--===================================================-->
            <!--END CONTENT CONTAINER-->

            <!--MENU LATERAL-->
            <?php require_once $_SERVER['DOCUMENT_ROOT'] . "/layout/menus/menuLateral.php"; ?>
            <!--END MENU LATERAL-->


            <!-- FOOTER -->
            <?php require_once $_SERVER['DOCUMENT_ROOT'] . "/layout/rodape.php"; ?>
            <!-- END FOOTER -->

            <!-- SCROLL PAGE BUTTON -->
            <!--===================================================-->
            <button class="scroll-top btn">
                <i class="pci-chevron chevron-up"></i>
            </button>
            <!--===================================================-->
        </div>
        <!--===================================================-->
        <!-- END OF CONTAINER -->
        <!-- /.login-box -->
        <!--jQuery [ REQUIRED ]-->
        <script src="/assets/lib/template/js/jquery-2.2.4.min.js"></script>
        <!--BootstrapJS [ REQUIRED ]-->
        <script src="/assets/lib/template/js/bootstrap.min.js"></script>
        <!--NiftyJS [ RECOMMENDED ]-->
        <script src="/assets/lib/template/js/nifty.min.js"></script>
        <!--Datapicker-->
        <script src="/assets/lib/template/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
        <!--MaskedInput-->
        <script src="/assets/lib/template/plugins/masked-input/jquery.maskedinput.min.js"></script>
        <!--Input valor priceformat-->
        <script src="/assets/lib/jquerypriceformat/jquery.priceformat.min.js"></script>
        <!--Select2-->
        <script src="/assets/lib/template/plugins/select2/js/select2.min.js"></script>
        <!-- DIALOG CONFIRM [OPT] -->
        <script src="/assets/lib/template/plugins/bootbox/bootbox.min.js"></script>     
        <!--DataTables [OPT]-->
        <script src="/assets/lib/template/plugins/datatables/media/js/jquery.dataTables.js"></script>
        <script src="/assets/lib/template/plugins/datatables/media/js/dataTables.bootstrap.js"></script>
        <script src="/assets/lib/template/plugins/datatables/media/js/accent-neutralise.js"></script> <!-- Search sem Acento -->
        <!--JAVASCRIP da pagina-->
        <script src="/assets/lib/loadingover/loadingoverlay.js"></script>
        <script src="/assets/lib/sesacre/funcoes.js"></script>        
        <script src="/assets/js/compras/gestao_contratos/aditamento/index.js"></script>
    </body>
</html>
