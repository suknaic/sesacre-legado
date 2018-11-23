$(document).ready(function () {
    //instacinado fucoes js
    func = new Funcoes();

    var url = "request.php";

    $("#nr_pagamento").mask("9999999999/9999");

    //select2
    $('body').find('select').select2({
        width: '100%'
    });

    $('#dt_pagamento').mask("99/99/9999");

    //busca pedido
    $('#modalItem').on('shown.bs.modal', function () {
        $('#codItemPesquisa').focus();
    });

    //Masca para valor
    $("body").on("focus", ".valorRetPagamento", function () {
        $(this).priceFormat({
            centsLimit: 4,
            prefix: '',
            centsSeparator: ',',
            thousandsSeparator: '.',
        });
    });

    $("body").on("focus", "#vl_pagamento", function () {
        $(this).priceFormat({
            centsLimit: 4,
            prefix: '',
            centsSeparator: ',',
            thousandsSeparator: '.',
        });
    });
    
    $('body').on('keypress', '#codItemPesquisa', function (e) {
        let key = e.which;
        if (key == 13){
            $("#btn-pesquisa").trigger('click');
            return false;
        }
    });

    $('.docFis').hide();

    //função para pesquisa licitacao do gcon
    $('body').on('click', '#btn-pesquisa', function (e) {
        var dados = $("#codItemPesquisa").val();
        $.ajax({
            "url": url,
            "dataType": 'html',
            "data": {
                "acao": "retornaLiquidacao",
                "dados": dados

            },
            "success": function (response) {
                func.carregaTabelaPadrao('tabelaItens', response, [], true);
            }
        });
    });

    $.ajax({
        "url": url,
        "dataType": 'html',
        "data": {
            "acao": "retornaTipoRemetenteERemetente"
        },
        "success": function (response) {
            $("#id_remetente").html("");
            $("#id_remetente").append(response);
        }
    });

    $('body').on('click', '.selecionaItem', function (e) {
        var dados = {
            "nr_pedido": $("body").find(".selecionaItem").attr("nrpedido"),
            "id_pedido": $("body").find(".selecionaItem").attr("pedido"),
            "id_empenho": $("body").find(".selecionaItem").attr("idempenho"),
            "id_liquidacao": $("body").find(".selecionaItem").attr("idLiquidacao"),
            "nr_liquidacao": $("#codItemPesquisa").val()
        }

        carregaDadosParaPagamento(dados);

        $('#modalItem').modal('hide');
    });

    
    if($("#liquidacao_get").val() != 0){
        carregaPagamentoPesquisa();
    }
    
    //Carrega a Parte de Contrato, Dados, Aditivos se já existir um Contrato para ser usado
    function carregaPagamentoPesquisa(){
        if($("#liquidacao_get").val() == 0){
            return false;
        }

        $.ajax({
            "url": url,
            "dataType": 'json',
            "method": "get",
            "data": {
                "acao": "buscaLiquidacao",
                "liquidacao": $("#liquidacao_get").val()
            },
            "success": function (response){     
                var dados = {
                    "nr_pedido": response.msg.nr_pedido,
                    "id_pedido": response.msg.id_pedido,
                    "id_empenho": response.msg.id_empenho,
                    "id_liquidacao": response.msg.id_liquidacao,
                    "nr_liquidacao": response.msg.nr_liquidacao
                }
                
                carregaDadosParaPagamento(dados);
            }
        });                
    }
    
    function carregaDadosParaPagamento(dados){
        
        limpaCampos();
        /**
         * retornaContratosPedido
         */
        $.ajax({
            "url": url,
            "dataType": 'html',
            "data": {
                "acao": "retornaContratosPagamento",
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
                "acao": "retornaPedidoPagemento",
                "dados": dados

            },
            "success": function (response) {
                $(".pedido").html("");
                $(".pedido").append(response);

                habilitaDocumentosFiscais();
            }
        });
        /**
         * retornaDadosEmpenho
         */
        $.ajax({
            "url": url,
            "dataType": 'html',
            "data": {
                "acao": "retornaEmpenhoPagemento",
                "dados": dados

            },
            "success": function (response) {
                $(".empenho").html("");
                $(".empenho").append(response);
            }
        });
        /**
         * retornaDadosLiquidacao
         */
        $.ajax({
            "url": url,
            "dataType": 'html',
            "data": {
                "acao": "retornaLiquidacaoPagemento",
                "dados": dados

            },
            "success": function (response) {
                $(".dadosLiquidacao").html("");
                $(".dadosLiquidacao").append(response);
            }
        });
        /**
         * retornaDocumentosEmpenho
         */
        $.ajax({
            "url": url,
            "dataType": 'html',
            "data": {
                "acao": "retornaDocFiscaisPagemento",
                "dados": dados
            },
            "success": function (response) {
                $("#selectDocumentoFiscal").html("");
                $("#selectDocumentoFiscal").append(response);
            }
        });
    }

    $('body').on('click', '.ver-documento', function (e) {
        var id = $(this).val();
        window.open("/pages/financeiro/gdof/documentoFiscal/ver_documento/index.php?&id=" + id);
    });


    $('body').on('click', '.remover-documento', function (e) {
        $(this).closest("tr").remove();
        calculaValorPagamento();
    });


    $('body').on('click', '.addDocumento', function (e) {

        var documento = $("#selectDocumentoFiscal option:selected").data('objeto');

        //Se não selecionou nenhum documento fiscal, retornar
        if (documento == undefined) {
            return false;
        }

        var erro = false;

        //percorre os documentos fiscais já inseridos ,caso já tenha sido inserido retorna erro e não continua
        $("tr.documentoFiscal").each(function () {
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
                             <td class="text-center">${documento.saldo}</td>
                             <td class="text-center">
                            <input class="form-control valorRetPagamento" type="text" name="valorRetPagamento[]" id="valorRetPagamento[]" value="0,0000">
                            </td>
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

                var vl_documento_pagamento = $(this).find(".valorRetPagamento").val();

                var vl_documento_pagamento_saldo = linha.saldo;

                var documento = {
                    id_documento_fiscal: linha.id_documento_fiscal,
                    id_documento_situacao: linha.id_documento_situacao,
                    vl_pagamento_doc: vl_documento_pagamento,
                    vl_pagamento_doc_saldo: vl_documento_pagamento_saldo
                }
                documentos.push(documento);


            });

            if (documentos.length == 0) {
                documentos = [];
            }

            var dados = {
                "idLiquidacao": $("#id_liquidacao").val(),
                "idLiquidacaoSituacao": $("#id_liquidacao_situacao").val(),
                "id_pedido": $("#id_pedido").val(),
                "idEmpenho": $("#id_empenho").val(),
                "idLotacao": $("#id_remetente option:selected").data('lotacao'),
                "idDocTipoLotacao": $("#id_remetente option:selected").data('tipo-lotacao'),
                "nrPagamento": $("#nr_pagamento").val(),
                "vlPagamento": $("#vl_pagamento").val(),
                "dtPagamento": $("#dt_pagamento").val(),
                "anotacoes": $("#anotacoes").val(),
                "saldoLiquidacao": $("#saldoLiquidacao").val(),
                "docsPagamento": documentos
            }

            if (!(dados.idEmpenho || dados.idLotacao || dados.idDocTipoLotacao || dados.nrPagamento || dados.vlPagamento
                    || dados.dtPagamento)) {
                func.modalAlert("Por favor preencha as informações obrigatórias.");
                return false;
            }

            if ($("#id_pedido").data('tipo-solicitacao') == 2 && documentos.length <= 0) {
                func.modalAlert("Por favor adicione algum documento fiscal para pagar.");
                return false;
            }

            $.ajax({
                "url": "request.php",
                "method": "POST",
                "dataType": "html",
                "data": {
                    "acao": "cadastrarPagamento",
                    "dados": dados
                },
                "success": function (response) {
                    $this.prop("disabled", false);
                    console.log(response);
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
                            location.reload();
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

function calculaValorPagamento() {
    let valoresRetirados = 0;
    $("input[name=valorRetPagamento\\[\\]]").each(function () {
        valoresRetirados = (parseFloat(func.tranformaStringEmValorCalculavel($(this).val())) + valoresRetirados);

        if (valoresRetirados > '999999999.9999') {
            func.modalAlert("Valor do pagamento ultrapassa o valor máximo permitido");
            $(this).prop("disabled", true);
            return false;
        }
    });

    let valorPagamento = func.converteValorBrDecimal(valoresRetirados, 4);
    $("#vl_pagamento").val(valorPagamento);
}

$("body").on("keyup", ".valorRetPagamento", function (e) {
    calculaValorPagamento();
});

function habilitaDocumentosFiscais() {
    var tipo_solicitacao = $("#id_pedido").data('tipo-solicitacao');

    if (tipo_solicitacao != 2) {
        $('.docFis').hide();
        $("#vl_pagamento").prop("disabled", false);
    } else {
        $('.docFis').show();
        $("#vl_pagamento").prop("disabled", true);
        $("#selectDocumentoFiscal").focus();
    }
}

//COMO AS INFORMAÇÕES NÃO ESTÃO DENTRO DE UM 'FORM' FOI NECESSÁRIO LIMPAR OS CAMPOS MANUALMENTE
function limpaCampos() {
    $("#nr_pagamento").val("");
    $("#dt_pagamento").val("");
    $("#vl_pagamento").val("");
    $("#desc_pagamento").val("");
    $("#id_remetente").val("0").trigger('change');
}