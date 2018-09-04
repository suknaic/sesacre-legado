$(document).ready(function () {
    //instacinado fucoes js
    func = new Funcoes();
    
    var url = "request.php";
    
    //select2
    $('body').find('select').select2({
        width: '100%'
    });
    
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

    $('body').on('click', '.selecionaItem', function (e) {
        var $this = $(this);
        var dados = {
            "nr_pedido": $("body").find(".selecionaItem").attr("nrpedido"),
            "id_pedido": $("body").find(".selecionaItem").attr("pedido"),
            "id_empenho": $("body").find(".selecionaItem").attr("idEmpenho"),
        }

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
            }
        });
        
        $('#modalItem').modal('hide');
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
            $("#vl_liquidacao").prop("disabled",true);
            
            
            var vl_liquidacao = "0";
            
            if (!($("#vl_liquidacao").val() == "")) {
                vl_liquidacao = $("#vl_liquidacao").val();
            }
          
            
            var valor_total = (func.converteValorIngFloat(vl_liquidacao) + func.converteValorIngFloat(documento.vl_documento)).toFixed(4);
            
            $("#vl_liquidacao").val(valor_total);
            var linhaTabela = `<tr data-id=${documento.id_documento_fiscal} class="documentoFiscal">
                             <td class="text-center">${documento.nr_documento_fiscal}</td>
                             <td class="text-center">${documento.nm_tipo_documento}</td>
                             <td class="text-center">${documento.competencia}</td>
                             <td class="text-center">${documento.dt_emissao}</td>
                             <td class="text-center">${documento.dt_atesto}</td>
                             <td class="text-center">${documento.vl_documento}</td>
                             <td class="text-center">${documento.vl_documento}</td>
                             <td class="text-center">${documento.nm_situacao}</td>
                             <td class="text-center"><button type="button" class="text-danger" title="Remover Documento Fiscal"><i class='fa fa-trash' aria-hidden='true'></i></button></td>
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
                documentos.push($(this).data("id"));
            });

            var dados = {
                "idEmpenho": $("#id_empenho").val(),
                "idLotacao": $("#idLotacao").val(),
                "idDocTipoLotacao": $("#idDocTipoLotacao").val(),
                "nrLiquidacao": $("#nr_liquidacao").val(),
                "vlLiquidacao": $("#vl_liquidacao").val(),
                "dtLiquidacao": $("#dt_liquidacao").val(),
                "obsLiquidacao": $("#desc_liquidacao").val(),
                "docsLiquidacao": documentos
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
