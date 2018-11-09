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
        var $this = $(this);
        var dados = {
            "nr_pedido": $("body").find(".selecionaItem").attr("nrpedido"),
            "id_pedido": $("body").find(".selecionaItem").attr("pedido"),
            "id_empenho": $("body").find(".selecionaItem").attr("idempenho"),
            "id_liquidacao": $("body").find(".selecionaItem").attr("idLiquidacao"),
            "nr_liquidacao": $("#codItemPesquisa").val()
        }

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

        $('#modalItem').modal('hide');
    });

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

                var vl_documento_pagamento =  $(this).find(".valorRetPagamento").val();

                var vl_documento_pagamento_saldo = linha.saldo;

                var documento = {
                    id_documento_fiscal: linha.id_documento_fiscal,
                    vl_pagamento_doc: vl_documento_pagamento,
                    vl_pagamento_doc_saldo: vl_documento_pagamento_saldo
                }
                documentos.push(documento);


            });
           
            if(documentos.length == 0){
                documentos = [];
            }
            
            var dados = {
                "idLiquidacao": $("#id_liquidacao").val(),
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

function atualizaValorPagamento() {
    var vl_pagamento = 0;
    $("tr.documentoFiscal").each(function () {
        let documento = $(this).data('objeto');
        vl_pagamento = func.converteValorIngFloat(documento.vl_documento) + vl_pagamento;
    });

    $("#vl_pagamento").val(valorComMascara(vl_pagamento));
}

function valorComMascara(valor) {
    var valor = Number(valor).toFixed(4);
    var valorStr = valor.toString();
    valorStr = valorStr.split('.');
    valorStr[0] = valorStr[0].split(/(?=(?:...)*$)/).join('.');
    return valorStr.join(',');
}

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