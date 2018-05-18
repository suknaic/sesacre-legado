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
                    <!--Page content-->
                    <!--===================================================-->                    
                     <div id="page-title">
                        <h1 class="page-header text-overflow">Cadastro do Aditivo de Valor</h1>                     
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
                                        <input type="hidden" id="id_contrato" value="" />
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
                                
                                <div class="panel panel-default">                                
                                    <div class="panel-heading">
                                        <h3 class="panel-title">Dados do(s) Aditivo(s):</h3>
                                    </div>
                                    <div class="panel-body">                                
                                        <table class="table table-striped table-bordered table-condensed">
                                            <thead>
                                                <tr>
                                                    <th>Número do Aditivo</th>
                                                    <th>Motivo do Aditamento</th>
                                                    <th>Vigência</th>
                                                    <th>Publicação</th>
                                                    <th>Valor do Aditivo</th>
                                                    <th>Opções</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="panel-footer">                                   
                                        <button class="btn btn-primary btn-add-aditivo btn-rounded">
                                            <i class="fa fa-plus-circle fa-1x"></i> Adicionar Aditivo
                                        </button>                                    
                                    </div>
                                </div>
                                
                                <div class="panel panel-default">                                
                                    <div class="panel-heading">
                                        <h3 class="panel-title">Novo Aditivo:</h3>
                                    </div>
                                    
                                    <div class="form-horizontal">
                                        <div class="panel-body"> 
                                            
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label text-left">Motivo do Aditamento: <span class="text-danger">*</span></label>
                                                <div class="col-sm-6">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <p class="fa fa-file-text-o inputPFa"></p>
                                                        </span>
                                                        <input type="text" id="n_motivo" class="form-control" placeholder="Motivo do Aditamento">
                                                    </div>                                                    
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label text-left">Finalidade: <span class="text-danger">*</span></label>
                                                <div class="col-sm-6">
                                                    <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <p class="fa fa-list inputPFa"></p>
                                                            </span>
                                                        <select id="n_finalidade" class="form-control">
                                                            <option value="0">Selecione a Finalidade</option>
                                                        </select>                                                                
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
                                                        <input class="form-control" type="text" name="n_numero_aditivo" id="n_numero_aditivo" placeholder="1-90">
                                                    </div>                                                                                                 
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label text-left">Tipo de Aquisição: <span class="text-danger">*</span></label>
                                                <div class="col-sm-6">
                                                    <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <p class="fa fa-list inputPFa"></p>
                                                            </span>
                                                        <select id="n_tipo_aquisicao" class="form-control">
                                                            <option value="0">Selecione a Aquisição</option>
                                                        </select>                                                                
                                                    </div>                                                   
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label text-left">Valor do Aditivo: <span class="text-danger">*</span></label>
                                                <div class="col-sm-6">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <p class="fa fa-sort-numeric-asc inputPFa"></p>
                                                        </span>
                                                        <input class="form-control" type="text" name="n_valor_aditivo" id="n_valor_aditivo" placeholder="R$ 0.000,00">
                                                    </div>                                                                                                      
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label text-left">Percentual do Aditivo: <span class="text-danger">*</span></label>
                                                <div class="col-sm-6">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <p class="fa fa-sort-numeric-asc inputPFa"></p>
                                                        </span>
                                                        <input class="form-control" type="text" name="n_percentual_aditivo" id="n_percentual_aditivo" placeholder="%">
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
                                                        <input type="text" class="form-control" name="n_data_publicacao" id="n_data_publicacao" placeholder="__/__/____">
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
                                                        <select id="n_gestor_sub" class="form-control select_funcionarios">                                                            
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
                                                        <select id="n_fiscal" class="form-control select_funcionarios">                                                            
                                                        </select>                                                                
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
                                                        <select id="n_fiscal_sub" class="form-control select_funcionarios">                                                            
                                                        </select>                                                                
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
                                                        <select id="n_sub_fiscal" class="form-control select_funcionarios">                                                            
                                                        </select>                                                                
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
                                                        <select id="n_sub_fiscal_sub" class="form-control select_funcionarios">                                                            
                                                        </select>                                                                
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
                        
                                <div class="form-group">
                                    <div class="col-sm-3">
                                        <div class="panel-body">
                                            Nº do contrato:<span class="text-danger">*</span>
                                            <div class="input-group">
                                                <span class="input-group-addon"><p class="fa fa-sort-numeric-asc" style="margin-bottom: -4px"></p></span>
                                                <input class="form-control" type="text" name="num_cont" id="num_cont" required="true" />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-3">
                                        <div class="panel-body">
                                            Data de assinatura:<span class="text-danger">*</span>
                                            <div class="input-group">
                                                <span class="input-group-addon"><p class="fa fa-calendar" style="margin-bottom: -4px"></p></span>
                                                <input class="form-control data" type="text" name="data_assinatura" id="data_assinatura" />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-3">
                                        <div class="panel-body">
                                            Data de publicação:<span class="text-danger">*</span>
                                            <div class="input-group">
                                                <span class="input-group-addon"><p class="fa fa-calendar" style="margin-bottom: -4px"></p></span>
                                                <input class="form-control data" type="text" name="data_publicacao" id="data_publicacao" required="true" />
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-sm-3">
                                        <div class="panel-body">
                                            Vigência inicial:<span class="text-danger">*</span>
                                            <div class="input-group">
                                                <span class="input-group-addon"><p class="fa fa-calendar" style="margin-bottom: -4px"></p></span>
                                                <input class="form-control data" type="text" name="vig_inicial" id="vig_inicial" required="true" />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-3">
                                        <div class="panel-body">
                                            Vigência final:<span class="text-danger">*</span>
                                            <div class="input-group">
                                                <span class="input-group-addon"><p class="fa fa-calendar" style="margin-bottom: -4px"></p></span>
                                                <input class="form-control data" type="text" name="vig_final" id="vig_final" required="true" />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-3">
                                        <div class="panel-body">
                                            Prazo de entrega:<span class="text-danger">*</span>
                                            <div class="input-group">
                                                <span class="input-group-addon"><p class="fa fa-sort-numeric-asc" style="margin-bottom: -4px"></p></span>
                                                <input class="form-control" type="text" name="prazo_entrega" id="prazo_entrega" required="true" >
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group campoAta hidden">
                                    <div class="col-sm-6">
                                        <div class="panel-body">
                                            ATA:<span class="text-danger">*</span>
                                            <div class="input-group">
                                                <span class="input-group-addon"><p class="fa fa-list" style="margin-bottom: -4px"></p></span>
                                                <select class="form-control select" name="ata" id="ata" required="true">
                                                    <option value="">Selecionar uma ATA</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-sm-6">
                                        <div class="panel-body">
                                            Descrição do objeto:<span class="text-danger">*</span>
                                            <textarea class="form-control" rows="4" id="desc_objeto"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="panel-body">
                                            Observações do contrato:<span class="text-danger">*</span>
                                            <textarea class="form-control" rows="4" id="obs_contrato"></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="panel-heading">
                                    <h3 class="panel-title">Informações do contratado</h3>
                                </div>

                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <div class="panel-body">
                                            <div class="radio">
                                                <label><input type="radio" id="cont_pj" value="1" name="contratado" checked>Pessoa juridica</label>
                                                <label><input type="radio" id="cont_pf" value="2" name="contratado">Pessoa Física</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-sm-5">
                                        <div class="panel-body">
                                            Nome do contratado:<span class="text-danger">*</span>
                                            <div class="input-group">
                                                <span class="input-group-addon"><p class="fa fa-list" style="margin-bottom: -4px"></p></span>
                                                <select class="form-control select" name="empresa" id="empresa" required="true">
                                                    <option value="">Selecionar uma contratado</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="panel-body">
                                            CNPJ/CPF:<span class="text-danger">*</span>
                                            <div class="input-group">
                                                <span class="input-group-addon"><p class="fa fa-sort-numeric-asc" style="margin-bottom: -4px"></p></span>
                                                <input class="form-control" type="text" name="cnpj" id="cnpj" required="true"
                                                       disabled>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="panel-heading">
                                    <h3 class="panel-title">Configuração do contrato</h3>
                                </div>

                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <div class="panel-body">
                                            <div class="checkbox">
                                                <label><input type="checkbox" value="S" name="cofiguracaoCont" id="cofiguracaoCont">Serviço Continuado</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <div class="panel-body">
                                            <div class="checkbox">
                                                <label><input type="checkbox" value="C" name="cofiguracaoAta" id="cofiguracaoAta">Carona</label>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                
                                <div id="orgao"></div>
                                
                                <div class="panel-heading">
                                    <h3 class="panel-title">Tipo de Gasto</h3>
                                </div>
                                <div class="campoCentrais">
                                    <div class="form-group">
                                        <div class="col-sm-5">
                                            <div class="panel-body">
                                                Tipo de Gasto:<span class="text-danger">*</span>
                                                <div class="centraisCampos">
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><p class="fa fa-list" style="margin-bottom: -4px"></p></span>
                                                        <select class="form-control" name="tipoDeGasto" id="tipoDeGasto" required="true">
                                                            <option value="">Selecione um tipo de gasto</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-7"></div>
                                    </div>
                                </div>
                                
                                <div class="panel-heading">
                                    <h3 class="panel-title">Centrais</h3>
                                </div>
                                <div class="campoCentrais">
                                    <div class="form-group">
                                        <div class="col-sm-5">
                                            <div class="panel-body">
                                                Central:<span class="text-danger">*</span>
                                                <div class="centraisCampos">
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><p class="fa fa-list" style="margin-bottom: -4px"></p></span>
                                                        <select class="form-control select selectCentrais" name="central[]" id="central" required="true">
                                                            <option value="">Selecione uma central</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-7"></div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-sm-3">
                                        <div class="panel-body">
                                            <a href="#" class="addCentrais btn btn-info">+</a>
                                        </div>
                                    </div>
                                    <div class="col-sm-9"></div>
                                </div>

                                <div class="panel-heading">
                                    <h3 class="panel-title">Gestores Titulares</h3>
                                </div>
                                <div class="campoGestores">
                                    <div class="form-group">
                                        <div class="col-sm-5">
                                            <div class="panel-body">
                                                Gestores Titulares:<span class="text-danger">*</span>
                                                <div class="gestoresCampos">
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><p class="fa fa-list" style="margin-bottom: -4px"></p></span>
                                                        <select class="form-control select selectGestores" name="gestores[]" id="gestores" required="true">
                                                            <option value="">Selecione um gestor</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-7"></div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-3">
                                        <div class="panel-body">
                                            <a href="#" class="addGestores btn btn-info">+</a>
                                        </div>
                                    </div>
                                    <div class="col-sm-9"></div>
                                </div>


                                <div class="panel-heading">
                                    <h3 class="panel-title">Gestores Substitutos</h3>
                                </div>

                                <div class="campoGestoresSub">
                                    <div class="form-group">
                                        <div class="col-sm-5">
                                            <div class="panel-body">
                                                Gestores Substitutos:<span class="text-danger">*</span>
                                                <div class="gestoresCamposSub">
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><p class="fa fa-list" style="margin-bottom: -4px"></p></span>
                                                        <select class="form-control select selectGestoresSub" name="gestoresSub[]" id="gestoresSub" required="true">
                                                            <option value="">Selecione um gestor</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-7"></div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-sm-3">
                                        <div class="panel-body">
                                            <a href="#" class="addGestorSubstituto btn btn-info">+</a>
                                        </div>
                                    </div>
                                    <div class="col-sm-9"></div>
                                </div>

                                <div class="panel-heading">
                                    <h3 class="panel-title">Fiscais Titulares</h3>
                                </div>
                                <div class="campoFiscais">
                                    <div class="form-group">
                                        <div class="col-sm-5">
                                            <div class="panel-body">
                                                Fiscais:<span class="text-danger">*</span>
                                                <div class="fiscaisCampos">
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><p class="fa fa-list" style="margin-bottom: -4px"></p></span>
                                                        <select class="form-control select selectFiscais" name="fiscais[]" id="fiscais" required="true">
                                                            <option value="">Selecione um fiscal</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-7"></div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-sm-3">
                                        <div class="panel-body">
                                            <a href="#" class="addFiscais btn btn-info">+</a>
                                        </div>
                                    </div>
                                    <div class="col-sm-9"></div>
                                </div>


                                <div class="panel-heading">
                                    <h3 class="panel-title">Fiscais Substitutos</h3>
                                </div>
                                <div class="campoFiscaisSub">
                                    <div class="form-group">
                                        <div class="col-sm-5">
                                            <div class="panel-body">
                                                Fiscais Substitutos:<span class="text-danger">*</span>
                                                <div class="fiscaisSubCampos">
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><p class="fa fa-list" style="margin-bottom: -4px"></p></span>
                                                        <select class="form-control select selectFiscaisSub" name="fiscaisSub[]" id="fiscaisSub" required="true">
                                                            <option value="">Selecione um fiscal</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-7"></div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-sm-3">
                                        <div class="panel-body">
                                            <a href="#" class="addFiscaisSub btn btn-info">+</a>
                                        </div>
                                    </div>
                                    <div class="col-sm-9"></div>
                                </div>

                                <div class="panel-heading">
                                    <h3 class="panel-title">Sub-Fiscais</h3>
                                </div>
                                <div class="campoSubFiscais">
                                    <div class="form-group">
                                        <div class="col-sm-5">
                                            <div class="panel-body">
                                                Sub-Fiscais:<span class="text-danger">*</span>
                                                <div class="SubFiscaisCampos">
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><p class="fa fa-list" style="margin-bottom: -4px"></p></span>
                                                        <select class="form-control select selectSubFiscais" name="subFiscais[]" id="subFiscais" required="true">
                                                            <option value="">Selecione um sub-fiscal</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-7"></div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-sm-3">
                                        <div class="panel-body">
                                            <a href="#" class="addSubFiscais btn btn-info">+</a>
                                        </div>
                                    </div>
                                    <div class="col-sm-9"></div>
                                </div>

                                <div class="panel-heading">
                                    <h3 class="panel-title">Sub-Fiscais Substitutos</h3>
                                </div>
                                <div class="campoSubFiscaisSub">
                                    <div class="form-group">
                                        <div class="col-sm-5">
                                            <div class="panel-body">
                                                Sub-Fiscais Substitutos:<span class="text-danger">*</span>
                                                <div class="SubFiscaisCamposSub">
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><p class="fa fa-list" style="margin-bottom: -4px"></p></span>
                                                        <select class="form-control select selectSubFiscaisSub" name="subFiscaisSub[]" id="subFiscaisSub" required="true">
                                                            <option value="">Selecione um sub-fiscal</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-7"></div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-sm-3">
                                        <div class="panel-body">
                                            <a href="#" class="addSubFiscaisSub btn btn-info">+</a>
                                        </div>
                                    </div>
                                    <div class="col-sm-9"></div>
                                </div>
                            </div>

                            <div id="doc_botao">
                                <button class="btn btn-success btn-salvar btn-rounded btn-block" type="button">
                                    <i class="fa fa-floppy-o" aria-hidden="true"></i>Salvar
                                </button>
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
        <script src="/assets/lib/template/plugins/priceformat/Jquery.Price_Fromat.js"></script>
        <!--Select2-->
        <script src="/assets/lib/template/plugins/select2/js/select2.min.js"></script>
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
