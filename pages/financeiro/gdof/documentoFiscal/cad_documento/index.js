$(document).ready(function () {
    //instacinado fucoes js
    func = new Funcoes();

    //Mascara do sistema
    $('#emissao').mask("99/99/9999");
    $('#atesto').mask("99/99/9999");
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
            "id_pedido": $("body").find(".selecionaItem").attr("pedido")
        }

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

    $("body").on("change", "#selectOrdem", function (e) {
        var idOrdem = $("body").find("#selectOrdem").val();
        if (idOrdem == 0) {
            return false;
        }
        $.ajax({
            "url": "/pages/financeiro/gdof/documentoFiscal/cad_documento/request.php",
            "dataType": 'html',
            "data": {
                "acao": "retornaTipoValorOrdem",
                "dados": idOrdem

            },
            "success": function (response) {
                var infoOrdem = JSON.parse(response);
                $("body").find("#tipoOrdem").html(infoOrdem.tipo);
                $("body").find("#valorOrdem").html(infoOrdem.valor);
            }
        });


    });

    var infTabOrdem = {};

    $("body").on("click", ".addOrdens", function (e) {

        if ($("#selectOrdem option:selected").val() == 0) {
            return false;
        }

        array = {
            "id_ordem": $("#selectOrdem option:selected").val(),
            "nr_ordem": $("#selectOrdem option:selected").text(),
            "tipo_ordem": $("#tipoOrdem").text(),
            "valorOrdem": $("#valorOrdem").text()
        }

        $.each(infTabOrdem, function (index, value) {
            if (value.id_ordem == $("#selectOrdem option:selected").val()) {
                func.modalAlert("Essa ordem já foi adicionada.");
            }
        });

        infTabOrdem[$("#selectOrdem option:selected").val()] = array;

        $.ajax({
            "method": "POST",
            "url": "/pages/financeiro/gdof/documentoFiscal/cad_documento/request.php",
            "dataType": 'html',
            "data": {
                "acao": "retornaTabelaOrdem",
                "dados": infTabOrdem

            },
            "success": function (response) {
                $("#tabelaOrdem").find("tbody").html(response);
            }
        });

        retornaOptionsDaEntrega(infTabOrdem);

    });
    //retorna options entrega
    function retornaOptionsDaEntrega(infTabOrdem) {
        $.ajax({
            "url": "/pages/financeiro/gdof/documentoFiscal/cad_documento/request.php",
            "dataType": 'html',
            "data": {
                "acao": "retornaOptionsDaEntrega",
                "dados": infTabOrdem

            },
            "success": function (response) {
                $("#selectEntrega").html(response);
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

        $("#" + $this.val()).remove();
        infTabOrdem = {};

        //esse codigo abaixo foi realizado para atualiza o select das entregas
        infNovaOrdem = {};
        $(".tabOrdem").each(function () {
            infNovaOrdem[$(this).attr("id")] = {"id_ordem": $(this).attr("id")}

        });
        //fim

        retornaOptionsDaEntrega(infNovaOrdem);

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
                totalizaEntregas();

            }
        });
    }

    function totalizaEntregas() {
        var totalEntregas = 0;
        var totalSaldos = 0;
        $(".trEntregas").each(function () {
            totalEntregas = parseFloat($(this).data('valor')) + totalEntregas;
            totalSaldos = parseFloat($(this).data('saldo')) + totalSaldos;
        });

        let valorEntregas = func.converteValorBrDecimal(totalEntregas, 4);
        let valorSaldos = func.converteValorBrDecimal(totalSaldos, 4);

        $("#tabelaEntrega").find(".entregaTotal").html("");

//        //Se existir entregas, vai inserir o totalizador
//        if (totalEntregas > 0) {
//            let rodapeEntregas = `<td class="text-right" colspan="6">Total</td>
//                                    <td class="text-center valorEntregaTotal" valor=${totalEntregas}>${valorEntregas}</td>
//                                    <td class="text-center valorSaldoTotal" valor=${totalSaldos}>${valorSaldos}</td>
//                                    <td class="text-center valorDocumentoTotal"></td>
//                                    <td class="text-right" colspan="4"></td>`;
//            $("#tabelaEntrega").find(".entregaTotal").html(rodapeEntregas);
//        }
                    let rodapeEntregas = `<td class="text-right" colspan="11"></td>`;
                    $("#tabelaEntrega").find(".entregaTotal").html(rodapeEntregas);
        //Atualiza a informaçao do valor do documento fiscal
//        $("#valorDocumentoFiscal").val(valorDocumentoFiscal);
    }

    $("body").on("keyup", ".valorRetEntrega", function (e) {
        let valoresRetirados = 0;
        $("input[name=valorRetEntrega\\[\\]]").each(function () {
            valoresRetirados = func.converteValorIngFloat($(this).val()) + valoresRetirados;
        });

        let valorDocumentoFiscal = func.converteValorBrDecimal(valoresRetirados, 4);
        $("#valorDocumentoFiscal").val(valorDocumentoFiscal);
        $(".valorDocumentoTotal").text(valorDocumentoFiscal);
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
        totalizaEntregas();
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
            var valoresRetEntregas = [];
            $(".trEntregas").each(function () {
                entregas.push($(this).attr("identrega"));
                
            });

            $("input[name=valorRetEntrega\\[\\]]").each(function () {
                valoresRetEntregas.push($(this).val());
            });
            
            if (entregas.length <= 0) {
                $this.prop("disabled", false);
                func.modalAlert("Nenhuma entrega foi adicionada.");
                return false;
            }

            if ($("#destinatario option:selected").val() == 0) {
                $this.prop("disabled", false);
                func.modalAlert("Nenhuma Destinatário foi selecionado.");
                return false;
            }

            var grp = "";

            if ($('input[name=grp_cod]:checked').val() === 1) {
                grp = $("#grp_sim").val();

            } else if ($('input[name=grp_cod]:checked').val() === 0) {
                grp = $("#grp_nao").val();

            }

            var dados = {
                "processoAdm": $("#processoAdm").val(),
                "nr_documento": $("#nr_documento").val(),
                "tpDocumento": $("#tpDocumento option:selected").val(),
                "competencia": $("#competencia").val(),
                "emissao": $("#emissao").val(),
                "atesto": $("#atesto").val(),
                "valorDocumentoFiscal": $("#valorDocumentoFiscal").val(),
                "grp": grp,
                "grpNumero": $("#nr_grp").val(),
                "id_lotacao": $("#destinatario option:selected").val(),
                "destinatario": $("#destinatario option:selected").attr("id_doc_lotacao")
            }

            $.ajax({
                "url": "/pages/financeiro/gdof/documentoFiscal/cad_documento/request.php",
                "method": "POST",
                "dataType": "html",
                "data": {
                    "acao": "cadastrarDocumentoFiscal",
                    "dados": dados,
                    "entrega": entregas,
                    "valoresRetEntregas": valoresRetEntregas
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
