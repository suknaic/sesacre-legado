$(document).ready(function () {
    //instacinado fucoes js
    func = new Funcoes();
    
    var url = "request.php";
    
    //select2
    $('body').find('select').select2({
        width: '100%'
    });
    
    $("#nr_liquidacao").mask("9999999999/9999");
    
    $('#dt_liquidacao').mask("99/99/9999");

    //busca pedido
    $('#modalItem').on('shown.bs.modal', function () {
        $('#codItemPesquisa').focus();
    });
    
    //Masca para valor
    $("body").on("focus", "#vl_liquidacao", function () {
        $(this).priceFormat({
            centsLimit: 4,
            prefix: '',
            centsSeparator: ',',
            thousandsSeparator: '.',
        });
    });
    
    //$('.docFis').hide();
    
    //função para pesquisa licitacao do gcon
    $('body').on('click', '#btn-pesquisa', function (e) {
        var dados = $("#codItemPesquisa").val();
        $.ajax({
            "url": url,
            "dataType": 'html',
            "data": {
                "acao": "retornaEmpenho",
                "dados": dados

            },
            "success": function (response) {
                func.carregaTabelaPadrao('tabelaItens', response, [], true);
            }
        });
    });
    
    $('body').on('keypress', '#codItemPesquisa', function (e) {
        let key = e.which;
        if (key == 13){
            $("#btn-pesquisa").trigger('click');
            return false;
        }
    });
    
    $.ajax({
        "url": url,
        "dataType": 'html',
        "data": {
            "acao": "retornaTipoRemetenteERemetente"
        },
        "success": function(response){
            $("#id_remetente").html("");
            $("#id_remetente").append(response);
        }
    });

    $('body').on('click', '.selecionaItem', function (e) {
        var $this = $(this);
        var dados = {
            "nr_pedido": $("body").find(".selecionaItem").attr("nrpedido"),
            "id_pedido": $("body").find(".selecionaItem").attr("pedido"),
            "id_empenho": $("body").find(".selecionaItem").attr("idEmpenho"),
        }
        
        carregaDadosParaEmpenho(dados)
        
        $('#modalItem').modal('hide');
    });
    
    function carregaDadosParaEmpenho(dados){
        
        limpaCampos();
        /**
         * retornaContratosPedido
         */
        $.ajax({
            "url": url,
            "dataType": 'html',
            "data": {
                "acao": "retornaContratosLiquidacao",
                "dados": dados

            },
            "success": function (response) {
                $(".contratos").html("");
                $(".contratos").append(response);
            }
        });
        /**
         * retornaDadosPedido
         */
        $.ajax({
            "url": url,
            "dataType": 'html',
            "data": {
                "acao": "retornaPedidoLiquidacao",
                "dados": dados

            },
            "success": function (response) {
                $(".pedido").html("");
                $(".pedido").append(response);
                
            }
        });
        /**
         * retornaDadosEmpenho
         */
        $.ajax({
            "url": url,
            "dataType": 'html',
            "data": {
                "acao": "retornaEmpenhoLiquidacao",
                "dados": dados

            },
            "success": function (response) {
                $(".empenho").html("");
                $(".empenho").append(response);
            }
        });
        
        /**
         * retornaDocumentosEmpenho
         */
        

        $.ajax({
            "url": url,
            "dataType": 'html',
            "data": {
                "acao": "retornaDocFiscaisLiquidacao",
                "dados": dados
            },
            "success": function (response){
                $("#selectDocumentoFiscal").html("");
                $("#selectDocumentoFiscal").append(response);
                habilitaDocumentosFiscais();
            }
        });
    }
    
    
    if($("#empenho_get").val() != 0){
        carregaLiquidacaoPesquisa();
    }
    
    //Carrega a Parte de Contrato, Dados, Aditivos se já existir um Contrato para ser usado
    function carregaLiquidacaoPesquisa(){
        if($("#empenho_get").val() == 0){
            return false;
        }
        
        $.ajax({
            "url": url,
            "dataType": 'json',
            "method": "get",
            "data": {
                "acao": "buscaEmpenho",
                "empenho": $("#empenho_get").val()
            },
            "success": function (response){         
                console.log(response)
                
                var dados = {
                    "nr_pedido": response.msg.nr_pedido,
                    "id_pedido": response.msg.id_pedido,
                    "id_empenho": response.msg.id_empenho,
                }
                carregaDadosParaEmpenho(dados)                                        
            }
        });                
    }
    
    $('body').on('click', '.ver-documento', function (e) {
        var id = $(this).val();
        window.open("/pages/financeiro/gdof/documentoFiscal/ver_documento/index.php?&id=" + id);
    });
    
    
    $('body').on('click', '.remover-documento', function (e) {
        $(this).closest("tr").remove();
        atualizaValorLiquidacao();
    });
    
    
    $('body').on('click','.addDocumento', function(e){
        
        var documento = $("#selectDocumentoFiscal option:selected").data('objeto');
        
        //Se não selecionou nenhum documento fiscal, retornar
        if (documento == undefined) {
            return false;
        }
        
        var erro = false;
        
        //percorre os documentos fiscais já inseridos ,caso já tenha sido inserido retorna erro e não continua
        $("tr.documentoFiscal").each(function() {
            if (documento.id_documento_fiscal == $(this).data('id')) {
                func.modalAlert("Documento fiscal já adicionado");
                erro = true;
            }
        });
        
        if (!erro) {
                        
            var linhaTabela = `<tr data-id=${documento.id_documento_fiscal} data-objeto='${JSON.stringify(documento)}' class="documentoFiscal">
                             <td class="text-center">${documento.nr_documento_fiscal}</td>
                             <td class="text-center">${documento.nm_tipo_documento}</td>
                             <td class="text-center">${documento.competencia}</td>
                             <td class="text-center">${documento.dt_emissao}</td>
                             <td class="text-center">${documento.dt_atesto}</td>
                             <td class="text-center">${documento.vl_documento}</td>
                             <td class="text-center">${documento.vl_documento}</td>
                             <td class="text-center">${documento.nm_situacao}</td>
                             <td class="text-center">
                                <button type="button" class="text-primary ver-documento" title="Ver Documento Fiscal" value="${documento.id_documento_fiscal}">
                                    <i class='fa fa-file-text-o' aria-hidden='true'></i>
                                </button>
                                <button type="button" class="text-danger remover-documento" title="Remover Documento Fiscal">
                                    <i class='fa fa-trash' aria-hidden='true'></i>
                                </button>
                            </td>
                          </tr>`;

            $('#tabelaDocumentos tbody').append(linhaTabela);
            atualizaValorLiquidacao();
        }
        
    });
    
    
    $("body").on("click", ".btn-salvar", function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else {
            e.preventDefault();
            var $this = $(this);
            $this.prop("disabled", true);
            
            var documentos = [];

            $(".documentoFiscal").each(function () {
                var linha = $(this).data('objeto');
                
                
                var vl_documento_liquidacao = linha.vl_doc_sem_mascara;
                
                var vl_documento_liquidacao_saldo = linha.vl_doc_sem_mascara;
                
                var documento = {
                    id_documento_fiscal: linha.id_documento_fiscal,
                    vl_liquidacao_doc: vl_documento_liquidacao_saldo,
                    vl_liquidacao_doc_saldo: vl_documento_liquidacao
                }
                documentos.push(documento);


            });
                        
            var dados = {
                "idEmpenho": $("#id_empenho").val(),
                "idLotacao": $("#id_remetente option:selected").data('lotacao'),
                "idDocTipoLotacao": $("#id_remetente option:selected").data('tipo-lotacao'),
                "tipoSolicitacao": $("#id_pedido").data('tipo-solicitacao'),
                "qtdDocumentos": $("#selectDocumentoFiscal option").size(),
                "nrLiquidacao": $("#nr_liquidacao").val(),
                "vlLiquidacao": $("#vl_liquidacao").val(),
                "dtLiquidacao": $("#dt_liquidacao").val(),
                "anotacoes": $("#anotacoes").val(),
                "docsLiquidacao": documentos
            }
            
            if (!(dados.idEmpenho && dados.idLotacao && dados.idDocTipoLotacao && dados.nrLiquidacao && dados.vlLiquidacao 
                    && dados.dtLiquidacao )) {
                func.modalAlert("Por favor preencha as informações obrigatórias.");
                $this.prop("disabled", false);
                return false;
            }
            
            var documentosGerados = $("#selectDocumentoFiscal option").size();
            
            if (dados.tipoSolicitacao == 1 && documentos.length <= 0 && documentosGerados > 1) {
                func.modalAlert("Por favor adicione algum documento fiscal para liquidar.");
                $this.prop("disabled", false);
                return false;
            }

            $.ajax({
                "url": "request.php",
                "method": "POST",
                "dataType": "html",
                "data": {
                    "acao": "cadastrarLiquidacao",
                    "dados": dados
                },
                "success": function (response) {
                    console.log(response);
                    $this.prop("disabled", false);
                    if (response.trim() == "SessaoExpirada") {
                        func.modalAlert(func.msgSemPermissao);
                        return false;
                    }

                    try {
                        response = JSON.parse(response);
                    } catch (e) {
                        func.modalAlert(func.msgErroPadrao);
                        console.log("Parse JSON");
                        return false;
                    }

                    if (response.tipoMsg === "Erro") {
                        if (response.tipoExibicao === "console") {
                            console.log('Console Mensagem');
                            func.modalAlert(func.msgErroPadrao);
                            return false;
                        } else if (response.tipoExibicao === "alert") {
                            func.modalAlert(response.msg);
                            return false;
                        }
                    } else if (response.tipoMsg === "ok") {
                        func.modalAlert(response.msg, 'success');
                        $('.modal-alert').on('hidden.bs.modal', function (e) {
                            window.location.href = "/pages/contabil/liquidacao/cad_liquidacao/";
                            //location.reload();
                        });
                        return false;
                    } else {
                        console.log('Ultimo else');
                        func.modalAlert(func.msgErroPadrao);
                        return false;
                    }
                },
                "error": function (response) {
                    $this.prop("disabled", false);
                    func.modalAlert(func.msgErroPadrao);
                    return false;
                }
            });
        }
    });

});

function atualizaValorLiquidacao(){
    var vl_liquidacao = 0;
    $("tr.documentoFiscal").each(function() {
        let documento = $(this).data('objeto'); 
        vl_liquidacao = func.converteValorIngFloat(documento.vl_documento) + vl_liquidacao;
    });
    
    $("#vl_liquidacao").val(valorComMascara(vl_liquidacao));
}

function valorComMascara(valor) { 
    var valor = Number(valor).toFixed(4);
    var valorStr = valor.toString();
    valorStr = valorStr.split('.');
    valorStr[0] = valorStr[0].split(/(?=(?:...)*$)/).join('.');
    return valorStr.join(',');
}

function habilitaDocumentosFiscais(){
    var tipo_solicitacao = $("#id_pedido").data('tipo-solicitacao');    
    var qtdDocs = $("#selectDocumentoFiscal option").size();    
//    if(qtdDocs > 1){
//        $('.docFis').show();
//        $("#vl_liquidacao").prop("disabled",true);
//        $("#selectDocumentoFiscal").focus();
//    }else{
//        $('.docFis').hide();
//        if(tipo_solicitacao == 2){
//            $("#vl_liquidacao").prop("disabled",true);            
//        }else{
//            $("#vl_liquidacao").prop("disabled",false);
//        }
//    }
    if ((tipo_solicitacao == 1 && qtdDocs == 1) || tipo_solicitacao > 2 ) {
        $('.docFis').hide();
        $("#vl_liquidacao").prop("disabled",false);
    } else if( (tipo_solicitacao == 1 && qtdDocs >= 2) || tipo_solicitacao == 2) {
        $('.docFis').show();
        $("#vl_liquidacao").prop("disabled",true);
        $("#selectDocumentoFiscal").focus();
    }
}

//COMO AS INFORMAÇÕES NÃO ESTÃO DENTRO DE UM 'FORM' FOI NECESSÁRIO LIMPAR OS CAMPOS MANUALMENTE
function limpaCampos(){
    $("#nr_pagamento").val("");
    $("#dt_pagamento").val("");
    $("#vl_pagamento").val("");
    $("#desc_pagamento").val("");
    $("#id_remetente").val("0").trigger('change');
}