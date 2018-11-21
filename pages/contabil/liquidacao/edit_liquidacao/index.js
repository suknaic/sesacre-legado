func = new Funcoes();

$(document).ready(function () {
    
    //select2
    $('body').find('select').select2({
        width: '100%'
    });
    
    $('#dt_liquidacao').mask("99/99/9999");
    
    $("#nr_liquidacao").mask("9999999999/9999");
    
        //Masca para valor
    $("body").on("focus", "#vl_liquidacao", function () {
        $(this).priceFormat({
            centsLimit: 4,
            prefix: '',
            centsSeparator: ',',
            thousandsSeparator: '.',
        });
    });
    
    var qtdArq = $("#selectDocumentoFiscal option").size() - 1;
    if (qtdArq > 1) {
        $("#vl_liquidacao").prop("disabled", true);
    } else {
        $("#vl_liquidacao").prop("disabled", false);
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
                                <button type="button" class="ver-documento" title="Ver Documento Fiscal" value="${documento.id_documento_fiscal}">
                                    <i class='fa fa-file-text-o text-info' aria-hidden='true'></i>
                                </button>
                                <button type="button" class="remover-documento" title="Remover Documento Fiscal">
                                    <i class='fa fa-trash text-danger' aria-hidden='true'></i>
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
                
                var vl_documento_liquidacao = linha.vl_doc_sm;
                
                var vl_documento_liquidacao_saldo = linha.vl_doc_sm;
                
                var documento = {
                    id_liquidacao_doc: linha.id_liquidacao_doc,
                    id_documento_fiscal: linha.id_documento_fiscal,
                    vl_liquidacao_doc: vl_documento_liquidacao_saldo,
                    vl_liquidacao_doc_saldo: vl_documento_liquidacao,
                }
                documentos.push(documento);
            });

            var dados = {
                "idLiquidacao": $("#id_liquidacao").val(),
                "nrLiquidacao": $("#nr_liquidacao").val(),
                "vlLiquidacao": $("#vl_liquidacao").val(),
                "dtLiquidacao": $("#dt_liquidacao").val(),
                "tipoSolicitacao": $("#id_pedido").data('tipo-solicitacao'),
                "qtdDocumentos": $("#selectDocumentoFiscal option").size() - 1, //Não contar com o valor 'Default'
                "obsLiquidacao": $("#desc_liquidacao").val(),
                "docsLiquidacao": documentos
            }
            
            if (!(dados.idLiquidacao || dados.nrLiquidacao || dados.vlLiquidacao || dados.dtLiquidacao )) {
                func.modalAlert("Por favor preencha as informações obrigatórias.");
                $this.prop("disabled", false);
                return false;
            }
            
            if ($("#id_pedido").data('tipo-solicitacao') == 2 && documentos.length <= 0) {
                func.modalAlert("Por favor adicione algum documento fiscal para liquidar.");
                $this.prop("disabled", false);
                return false;
            }

            $.ajax({
                "url": "request.php",
                "method": "POST",
                "dataType": "html",
                "data": {
                    "acao": "atualizaLiquidacao",
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
    
    listaAnotacoes();

    $('body').on('click', '.btn-addAnotacao', function (e) {
        $('#adAnotacao').modal();

    });

    $('#adAnotacao').on('shown.bs.modal', function () {
        $('#anotacao').focus()
    })


    $('body').on('click', '.btn-enviarAnotacao', function (e) {
        var Dados = {
            liquidacao: $("#id_liquidacao").val(),
            anotacao: $('#anotacao').val()
        };
        $.ajax({
            "url": "/pages/contabil/liquidacao/anotacao_liquidacao/request.php",
            "method": "POST",
            "dataType": "html",
            "data": {
                "acao": "salvaAnotacao",
                "dados": Dados
            },

            "success": function (response) {
//                console.log(response);
                if (response.trim() === "SessaoExpirada") {
                    $("#adAnotacao").modal('hide');
                    func.modalAlert(func.msgSemPermissao);
                    return false;
                }

                try {
                    response = JSON.parse(response);
                } catch (e) {
                    $("#adAnotacao").modal('hide');
                    func.modalAlert(func.msgErroPadrao, 'danger');
                    return false;
                }

                if (response.tipoMsg === "Erro") {
                    if (response.tipoExibicao === "console") {
                        $("#adAnotacao").modal('hide');
                        func.modalAlert(func.msgErroPadrao, 'danger');
                        return false;
                    } else if (response.tipoExibicao === "alert") {
                        $("#adAnotacao").modal('hide');
                        func.modalAlert(response.msg);
                        return false;
                    }
                } else if (response.tipoMsg === "ok") {
                    $("#adAnotacao").modal('hide');
                    func.modalAlert(response.msg, 'success');
                    $('.modal-alert').on('hidden.bs.modal', function (e) {
                        listaAnotacoes();
                    });
                    return false;
                } else {
                    $("#adAnotacao").modal('hide');
                    func.modalAlert(func.msgErroPadrao, 'danger');
                    return false;
                }
            },
            "error": function (response) {
                $("#adAnotacao").modal('hide');
                func.modalAlert(func.msgErroPadrao, 'danger');
                return false;
            }
        });

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


function listaAnotacoes() {
    $.ajax({
        "url": "/pages/contabil/liquidacao/anotacao_liquidacao/request.php",
        "method": "POST",
        "dataType": "html",
        "data": {
            "acao": "listaAnotacoes",
            "liquidacao": $("#id_liquidacao").val()
        },

        "success": function (response) {
            if (response.trim() === "SessaoExpirada") {
                func.modalAlert(func.msgSemPermissao);
                return false;
            }

            try {
                response = JSON.parse(response);
            } catch (e) {
                func.modalAlert(func.msgErroPadrao, 'danger');
                return false;
            }

            if (response.tipoMsg === "Erro") {
                if (response.tipoExibicao === "console") {

                    func.modalAlert(func.msgErroPadrao, 'danger');
                    return false;
                } else if (response.tipoExibicao === "alert") {
                    func.modalAlert(response.msg);
                    return false;
                }
            } else if (response.tipoMsg === "ok") {

                $(".anotacoes").html("");
                $(".anotacoes").html(response.msg);
                return false;
            } else {
                func.modalAlert(func.msgErroPadrao, 'danger');
                return false;
            }
        },
        "error": function (response) {
            func.modalAlert(func.msgErroPadrao, 'danger');
            return false;
        }
    });
}
