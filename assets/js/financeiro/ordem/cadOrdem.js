$(document).ready(function () {
    //instacinado fucoes js
    func = new Funcoes();
    //busca pedido
    $('#modalItem').on('shown.bs.modal', function () {
        $('#codItemPesquisa').focus();
    });


    //Mascara do sistema
    $('.data').mask("99/99/9999")

    $.ajax({
        "url": "/model/financeiro/ordem/request.php",
        "dataType": 'html',
        "data": {
            "acao": "retornaLotacao"
        },
        "success": function (response) {
            $("#id_lotacao").append(response);
        }
    });

    $('body').find('select').select2({
    });

    //função para pesquisa licitacao do gcon
    $('body').on('click', '#btn-pesquisa', function (e) {
        var dados = $("#codItemPesquisa").val();
        $.ajax({
            "url": "/model/financeiro/ordem/request.php",
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
        var pedido = $this.attr('pedido');
        $("#id_pedido").val(pedido);
        $("#itemGrp").val($this.attr('item'));
        $("#pedido").text($this.find("td:eq(0)").text());
        $("#desc_pedido").text($this.find("td:eq(1)").text());
        $("#tipo_gasto").text($this.find("td:eq(2)").text());
        $("#fonte").text($this.find("td:eq(3)").text());
        $("#despesa").text($this.find("td:eq(4)").text());
        $("#valor").text($this.find("td:eq(5)").text());
        if ($this.find("td:eq(6)").text() == '1') {
            $("#ata").text($this.find("td:eq(7)").text());
            $("body").find(".divPrazo").removeClass("hidden");
        } else {
            $("#contrato").text($this.find("td:eq(7)").text());
            $("body").find(".divPrazo").addClass("hidden");
        }
        $("#modalidade").text($this.find("td:eq(8)").text());
        $("#projeto").text($this.find("td:eq(9)").text());
        $("#empenho").text($this.find("td:eq(10)").text());
        $('#modalItem').modal('hide');
        $.ajax({
            "url": "/model/financeiro/ordem/request.php",
            "dataType": 'html',
            "data": {
                "acao": "retornaItensPreOrdem",
                "dados": pedido

            },
            "success": function (response) {
                $("#tabela").find("tbody").html(response);
            }
        });

    });

    //Masca para valor
    $("body").on("focus", "#qtd", function () {
        $(this).priceFormat({
            centsLimit: 4,
            prefix: '',
            centsSeparator: ',',
            thousandsSeparator: '.',
        });
    });

    $("body").on("focus", "#vl", function () {
        $(this).priceFormat({
            centsLimit: 4,
            prefix: '',
            centsSeparator: ',',
            thousandsSeparator: '.',
        });
    });

    $("body").on("change", "#tipoOrdem", function () {
        if ($("#tipoOrdem").val() == '1') {
            $("body").find(".pergunta").removeClass("hidden");
        } else if ($("#tipoOrdem").val() == '2') {
            $("body").find(".pergunta").addClass("hidden");
        } else {
            $("body").find(".pergunta").addClass("hidden");
        }
    });

    $("body").on("click", "#radioSim", function () {
        $("body").find(".periodoConsumo").removeClass("hidden");
    });

    $("body").on("click", "#radioNao", function () {
        $("body").find(".periodoConsumo").addClass("hidden");
    });

    //Cadastrar item
    $("body").on("click", ".btn-salvar", function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else {
            e.preventDefault();
            var $this = $(this);
            $this.prop("disabled", true);
            if ($("#tipoOrdem").val() < '1') {
                func.modalAlert(func.msgPreencherCampos);
                $this.prop("disabled", false);
                return false;
            }

            if ($("input[name='optradio']:checked").val() == 1) {

                if ($("#vig_inicial").val() == "") {
                    func.modalAlert(func.msgPreencherCampos);
                    $this.prop("disabled", false);
                    return false;
                }

                if ($("#vig_final").val() == "") {
                    func.modalAlert(func.msgPreencherCampos);
                    $this.prop("disabled", false);
                    return false;
                }
            }

            if ($("#id_pedido").val() == "") {
                func.modalAlert(func.msgPreencherCampos);
                $this.prop("disabled", false);
                return false;
            }
            
            if ($("#id_lotacao").val() == "" || $("#id_lotacao").val() == "0") {
                func.modalAlert(func.msgPreencherCampos);
                $this.prop("disabled", false);
                return false;
            }
            
//            var $this = $(this);
            var itens = [];
            // $this.prop("disabled", true);
            var idPedido = $("#id_pedido").val();
            var local = $("body").find("#id_lotacao").val();
            var vig_inicial = $("body").find("#vig_inicial").val();
            var vig_final = $("body").find("#vig_final").val();
            var tipoOrdem = $("body").find("#tipoOrdem").val();
            var pergunta = $("input[name='optradio']:checked").val();
            
            
            $(".itens").each(function () {
                
                var quantidade = $(this).find(".qtd").val();
                var valor = $(this).find(".vl").val();
                var tp = $(this).data("tp-material");
                var idPreOrdem = $(this).data("id-pre-ordem");
                var flVariavel = $(this).data('fl-valor-variavel');
                
                if (!quantidade || quantidade == "0,0000") {
                    quantidade = 0;
                }
                
                if (!valor || valor == "0,0000") {
                    valor = 0;
                }
                
                var item = {
                    idPedido: idPedido,
                    idPreOrdem: idPreOrdem,
                    local: local,
                    tp: tp,
                    vig_inicial: vig_inicial,
                    vig_final: vig_final,
                    tipoOrdem: tipoOrdem,
                    pergunta: pergunta,
                    qtd: quantidade,
                    vl: valor,
                    flVariavel: flVariavel
                }
                
                if ((item.tp == "C" || item.tp == "P") && item.qtd != 0 && flVariavel == "0") {
                    itens.push(item);
                }
                
                if ((item.tp == "S" || flVariavel == '1') && item.qtd != 0 && item.vl != 0) {
                    itens.push(item);
                }
                
//                if (($(this).find(".qtd").length) == 1 && ($(this).find(".vl").length) == 0) {
//                    if ($(this).find(".qtd").val() != '0,0000' && $(this).find(".qtd").val() != '') {
//                        itens.push({'qtd': $(this).find(".qtd").val(), 'idPedido': $(this).find(".qtd").attr("idPedido"), 'id': $("body").find("#id").val(),
//                            'local': $("body").find("#id_lotacao").val(), 'tp': $(this).find(".qtd").attr("tp"), 'idPreOrdem': $(this).find(".qtd").attr("idPreOrdem"),
//                            'vig_inicial': $("body").find("#vig_inicial").val(), 'vig_final': $("body").find("#vig_final").val(),
//                            'prazo': $("body").find("#prazo").val(), 'tipoOrdem': $("body").find("#tipoOrdem").val(), 'pergunta': $("input[name='optradio']:checked").val()});
//                    }
//                }
//
//                if (($(this).find(".qtd").length) == 1 && ($(this).find(".vl").length) == 1) {
//                    if ($(this).find(".vl").val() != '0,0000' && $(this).find(".vl").val() != '' &&
//                            $(this).find(".qtd").val() != '0,0000' && $(this).find(".qtd").val() != '') {
//                        itens.push({'qtd': $(this).find(".qtd").val(), 'vl': $(this).find(".vl").val(), 'idPedido': $(this).find(".vl").attr("idPedido"),
//                            'id': $("body").find("#id").val(),
//                            'local': $("body").find("#id_lotacao").val(), 'tp': $(this).find(".qtd").attr("tp"), 'idPreOrdem': $(this).find(".qtd").attr("idPreOrdem"),
//                            'vig_inicial': $("body").find("#vig_inicial").val(), 'vig_final': $("body").find("#vig_final").val(),
//                            'prazo': $("body").find("#prazo").val(), 'tipoOrdem': $("body").find("#tipoOrdem").val(), 'pergunta': $("input[name='optradio']:checked").val()});
//                    }
//                }
            });
            
            var enc = JSON.stringify(itens);
            
            $.ajax({
                "type": "POST",
                "url": "/model/financeiro/ordem/request.php",
                "dataType": "html",
                "data": {
                    "acao": "cadastroOrdem",
                    "itens": enc
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
                            console.log(response);
                            console.log('Console Mensagem');
                            func.modalAlert(func.msgErroPadrao);
                            return false;
                        } else if (response.tipoExibicao === "alert") {
                            func.modalAlert(response.msg);
                            return false;
                        }
                    } else if (response.tipoMsg === "ok") {
                        func.modalAlert('Itens cadastros com Sucesso', 'success');
                        $('.modal-alert').on('hidden.bs.modal', function (e) {
                            window.location.href = "/pages/financeiro/ordem/index.php";
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

            $this.prop("disabled", false);
        }
    });
    //fim

});
