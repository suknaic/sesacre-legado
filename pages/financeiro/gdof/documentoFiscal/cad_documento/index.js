$(document).ready(function () {
    //instacinado fucoes js
    func = new Funcoes();

    //Mascara do sistema
    $('#emissao').mask("99/99/9999");
    $('#vencimento').mask("99/99/9999");
    $('#atesto').mask("99/99/9999");
    $('#dataVencimento').mask("99/99/9999");
    $('#competencia').mask("99/9999");
    //busca pedido
    $('#modalItem').on('shown.bs.modal', function () {
        $('#codItemPesquisa').focus();
    });

    $('body').find('select').select2({
        width: '100%'
    });

    //Masca para valor
    $("body").on("focus", ".valorRetEntrega", function () {
        $(this).priceFormat({
            centsLimit: 4,
            prefix: '',
            centsSeparator: ',',
            thousandsSeparator: '.',
        });
    });

    //Masca para valor

    $("#valorDocumentoFiscal").priceFormat({
        centsLimit: 4,
        prefix: '',
        centsSeparator: ',',
        thousandsSeparator: '.',
    });


    function limpaCampos() {
        $("#tabelaOrdem tbody").html("");
        $("#tabelaEntrega tbody").html("");
        $("#processoAdm").val("");
        $("#nr_documento").val("");
        $("#competencia").val("");
        $("#emissao").val("");
        $("#atesto").val("");
        $("#vencimento").val("");
        $("#valorDocumentoFiscal").val("");
        $("#tpDocumento").val("0").select2();
        $("#destinatario").val("0").select2();
    }

    //função para pesquisa licitacao do gcon
    $('body').on('click', '#btn-pesquisa', function (e) {
        var dados = $("#codItemPesquisa").val();
        $.ajax({
            "url": "/pages/financeiro/gdof/documentoFiscal/cad_documento/request.php",
            "dataType": 'html',
            "data": {
                "acao": "retornaPedido",
                "dados": dados

            },
            "success": function (response) {
                func.carregaTabelaPadrao('tabelaItens', response, [], true);
            }
        });
    });

    $('body').on('click', '.selecionaItem', function (e) {
        var $this = $(this);
        var dados = {
            "nr_pedido": $("#codItemPesquisa").val(),
            "id_pedido": $("body").find(".selecionaItem").attr("pedido"),
            "id_tipo_solicitacao": $("body").find(".selecionaItem").attr("tipo_solicitacao")
        }
        $("#tipo_solicitacao").val(dados.id_tipo_solicitacao)
        $("#pedido").val(dados.id_pedido)

        limpaCampos();
        /**
         * retornaContratosPedido
         */
        $.ajax({
            "url": "/pages/financeiro/gdof/documentoFiscal/cad_documento/request.php",
            "dataType": 'html',
            "data": {
                "acao": "retornaContratosGdof",
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
            "url": "/pages/financeiro/gdof/documentoFiscal/cad_documento/request.php",
            "dataType": 'html',
            "data": {
                "acao": "retornaPedidoGdof",
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
            "url": "/pages/financeiro/gdof/documentoFiscal/cad_documento/request.php",
            "dataType": 'html',
            "data": {
                "acao": "retornaEmpenhoGdof",
                "dados": dados

            },
            "success": function (response) {
                $(".empenho").html("");
                $(".empenho").append(response);
            }
        });
        /**
         * retornaDadosOrdem
         */
        $.ajax({
            "url": "/pages/financeiro/gdof/documentoFiscal/cad_documento/request.php",
            "dataType": 'html',
            "data": {
                "acao": "retornaOrdemGdof",
                "dados": dados

            },
            "success": function (response) {
                $("#selectOrdem").html(response);
            }
        });

        if (dados.id_tipo_solicitacao == 2) {
            $("#panel-entrega").show();
            $("#panel-ordem").show();
            $("#valorDocumentoFiscal").prop("disabled", true);
        } else if (dados.id_tipo_solicitacao == 1) {
            $("#panel-entrega").hide();
            $("#panel-ordem").hide();
            $("#valorDocumentoFiscal").prop("disabled", false);
        }

        $('#modalItem').modal('hide');
    });


    /**
     * retornaUmDestinatario
     */
    $.ajax({
        "url": "/pages/financeiro/gdof/documentoFiscal/cad_documento/request.php",
        "dataType": 'html',
        "data": {
            "acao": "retornaDestinatario",

        },
        "success": function (response) {
            $("#destinatario").append(response);
        }
    });

    $("body").on("click", ".addOrdens", function (e) {

        var id_ordem = $("#selectOrdem option:selected").val();

        //verifica se a ordem já está incluída
        $(".linha-ordem").each(function () {
            var linha = $(this);

            if (linha.data('id') == id_ordem) {
                func.modalAlert("Essa ordem já foi adicionada.");
                id_ordem = 0;
                return false
            }

        });

        if (id_ordem == 0) {
            return false;
        }

        $.ajax({
            "url": "/pages/financeiro/gdof/documentoFiscal/cad_documento/request.php",
            "dataType": 'html',
            "data": {
                "acao": "retornaTipoValorOrdem",
                "dados": id_ordem

            },
            "success": function (response) {
                var ordem = JSON.parse(response);
                var trOrdem = `<tr class="linha-ordem" data-id=${ordem.id_ordem}>
                                    <td class="text-center">${ordem.ordem}</td>
                                    <td class="text-center">${ordem.tipo}</td>
                                    <td class="text-center">${ordem.valor}</td>
                                    <td class="text-center">${ordem.situacao}</td>
                                    <td class="text-center">
                                        <button type="button" title="Excluir ordem" class="excluirOrdem text-danger" value = "${ordem.id_ordem}">
                                            <i class="fa fa-trash" aria-hidden="true"></i>
                                        </button>
                                    </td>
                               </tr>`;
                $("#tabelaOrdem").find("tbody").append(trOrdem);
                retornaOptionsDaEntrega();
            }
        });

    });
    //retorna options entrega
    function retornaOptionsDaEntrega() {

        var ordens = [];
        //percorre as ordens inseridas
        $(".linha-ordem").each(function () {
            ordens.push($(this).data('id'));
        });
        
        var dados = {
            ordens: ordens,
            documento: ""
        }

        $.ajax({
            "url": "/pages/financeiro/gdof/documentoFiscal/cad_documento/request.php",
            "dataType": 'html',
            "data": {
                "acao": "retornaOptionsDaEntrega",
                "dados": dados

            },
            "success": function (response) {
                $("#selectEntrega").html("");
                $("#selectEntrega").append(response);
            }
        });
    }

    //excluir ordem 
    $("body").on("click", ".excluirOrdem", function (e) {
        var $this = $(this);
        var erro = 0;
        //verificar ser tem entregas vinculadas pertencente a ordem excluida 
        $(".trEntregas").each(function () {
            if ($this.val() == $(this).attr("ordem")) {
                erro++;
            }
        });
        if (erro > 0) {
            func.modalAlert("Exclua as entregas para exluir a ordem");
            return false;
        }

        $this.closest('tr').remove();

        retornaOptionsDaEntrega();

    });

    var infTabEntrega = [];

    $("body").on("click", ".addEntrega", function (e) {
        let idEntrega = Number($("#selectEntrega option:selected").val());

        if (!infTabEntrega.includes(idEntrega)) {
            infTabEntrega.push(idEntrega);

            //CRIEI ESTA VARIAVEL QUE GUARDA APENAS O ID QUE ESTA SENDO ADICIONANDO, POIS NO BACKGROUND JA ESTA TRATADO PARA RECEBER UM ARRAY COM OS IDS
            //AGORA O ARRAY SO RECEBE UM ID ESPECIFICO 
            var idEntregas = [];
            idEntregas.push($("#selectEntrega option:selected").val());
            atualizaTabelaEntrega(/*infTabEntrega*/ idEntregas);
        } else {
            func.modalAlert("Esta entrega ja foi adicionada!");
            return false;
        }

    });

    function atualizaTabelaEntrega(/*infTabEntrega*/ idEntrega) {

        $.ajax({
            "url": "/pages/financeiro/gdof/documentoFiscal/cad_documento/request.php",
            "dataType": 'html',
            "data": {
                "acao": "retornaTabelaEntrega",
                "dados": idEntrega,
                "valorRetirado": $("#valorRetEntrega").val()
            },
            "success": function (response) {
                $("#tabelaEntrega").find("tbody").prepend(response);


            }
        });
    }

    function calculaValorDocumento() {
        let valoresRetirados = 0;
        $("input[name=valorRetEntrega\\[\\]]").each(function () {
            valoresRetirados = (parseFloat(func.tranformaStringEmValorCalculavel($(this).val())) + valoresRetirados);

            if (valoresRetirados > '999999999.9999') {
                func.modalAlert("Valor do documento fiscal ultrapassa o valor máximo permitido");
                $(this).prop("disabled", true);
                return false;
            }
        });




        let valorDocumentoFiscal = func.converteValorBrDecimal(valoresRetirados, 4);
        $("#valorDocumentoFiscal").val(valorDocumentoFiscal);
        $(".valorDocumentoTotal").text(valorDocumentoFiscal);
    }

    $("body").on("keyup", ".valorRetEntrega", function (e) {
        calculaValorDocumento();
    });


    $("body").on("click", ".excluirEntrega", function (e) {
        var $this = $(this);
        var entregaId = Number($this.closest('tr').attr('identrega'));

        //remover do array de entregas o ID da entrega
        var indice = infTabEntrega.indexOf(entregaId);

        if (indice > -1) {
            infTabEntrega.splice(indice, 1);
        }
        //---------------------------------------------
        $this.closest('tr').remove();
        calculaValorDocumento();
    });


    /*QUANDO CLICAR NO BOTAO NÃO ESCONDER OS CAMPOS DO NUMERO DO GRP*/

    $("body").on('click', '#grp_nao', function () {
        $(".divNumeroGrp").hide();
        $("#nr_grp").val("");
    });

    $("body").on('click', '#grp_sim', function () {
        $(".divNumeroGrp").show();
    });
    /****/
    $("body").on("click", ".btn-salvar", function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else {
            e.preventDefault();
            var $this = $(this);
            $this.prop("disabled", true);
            var entregas = [];
//            var valoresRetEntregas = [];

            var tipo_solicitacao = $("#tipo_solicitacao").val()

            if (tipo_solicitacao == 2) {

                $(".trEntregas").each(function () {

                    //converte o valor informado para a entrega em formato inglês com 4 casas
                    var valor_entrega_ingles = func.converteValorIngFloat($(this).find("input[name=valorRetEntrega\\[\\]]").val());
                    valor_entrega_ingles = func.arrendondaValorParaQuatroCasas(valor_entrega_ingles);

                    //converte o valor do saldo para o formato inglês com 4 casas
                    var valor_saldo_ingles = $(this).data('saldo');
                    valor_saldo_ingles = func.arrendondaValorParaQuatroCasas(valor_saldo_ingles);

                    var entrega = {
                        idEntrega: $(this).attr("identrega"),
                        vlSaldo: valor_saldo_ingles,
                        vlDocumento: valor_entrega_ingles
                    }
                    entregas.push(entrega);

                });

                if (entregas.length <= 0) {
                    $this.prop("disabled", false);
                    func.modalAlert("Nenhuma entrega foi adicionada.");
                    return false;
                }
            }

            if ($("#destinatario option:selected").val() == 0) {
                $this.prop("disabled", false);
                func.modalAlert("Nenhuma Destinatário foi selecionado.");
                return false;
            }

            var grp = "";

            if ($('input[name=grp_cod]:checked').val() == 1) {
                grp = $("#grp_sim").val();

            } else if ($('input[name=grp_cod]:checked').val() == 0) {
                grp = $("#grp_nao").val();

            }

            if (entregas.length <= 0) {
                entregas = null;
            }

            var dados = {
                "processoAdm": $("#processoAdm").val(),
                "nr_documento": $("#nr_documento").val(),
                "tpDocumento": $("#tpDocumento option:selected").val(),
                "competencia": $("#competencia").val(),
                "emissao": $("#emissao").val(),
                "vencimento": $("#vencimento").val(),
                "atesto": $("#atesto").val(),
                "valorDocumentoFiscal": $("#valorDocumentoFiscal").val(),
                "grp": grp,
                "grpNumero": $("#nr_grp").val(),
                "id_lotacao": $("#destinatario option:selected").val(),
                "destinatario": $("#destinatario option:selected").attr("id_doc_lotacao"),
                "entregas": entregas,
                "anotacoes": $("#anotacoes").val(),
                "tipo_solicitacao": $("#tipo_solicitacao").val(),
                "pedido": $("#pedido").val()
            }

            $.ajax({
                "url": "/pages/financeiro/gdof/documentoFiscal/cad_documento/request.php",
                "method": "POST",
                "dataType": "html",
                "data": {
                    "acao": "cadastrarDocumentoFiscal",
                    "dados": dados,

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
    
    
    $('body').on('click', '.ver-entrega', function (e) {
        var id = $(this).val();
        window.open("/pages/financeiro/ordem/entrega/ver_entrega/index.php?&id=" + id);
    });

});
