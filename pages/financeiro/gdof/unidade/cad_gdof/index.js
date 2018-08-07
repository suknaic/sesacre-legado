$(document).ready(function () {
    //instacinado fucoes js
    func = new Funcoes();

    //Mascara do sistema
    $('#competencia').mask("99/9999");
    $('#emissao').mask("99/99/9999");
    $('#atesto').mask("99/99/9999");
    //busca pedido
    $('#modalItem').on('shown.bs.modal', function () {
        $('#codItemPesquisa').focus();
    });

    //função para pesquisa licitacao do gcon
    $('body').on('click', '#btn-pesquisa', function (e) {
        var dados = $("#codItemPesquisa").val();
        $.ajax({
            "url": "/pages/financeiro/gdof/unidade/cad_gdof/request.php",
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
            "url": "/pages/financeiro/gdof/unidade/cad_gdof/request.php",
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
            "url": "/pages/financeiro/gdof/unidade/cad_gdof/request.php",
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
            "url": "/pages/financeiro/gdof/unidade/cad_gdof/request.php",
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
            "url": "/pages/financeiro/gdof/unidade/cad_gdof/request.php",
            "dataType": 'html',
            "data": {
                "acao": "retornaOrdemGdof",
                "dados": dados

            },
            "success": function (response) {
                $("#selectOrdem").html(response);
            }
        });
    });

    $("body").on("change", "#selectOrdem", function (e) {
        var idOrdem = $("body").find("#selectOrdem").val();
        $.ajax({
            "url": "/pages/financeiro/gdof/unidade/cad_gdof/request.php",
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
            "url": "/pages/financeiro/gdof/unidade/cad_gdof/request.php",
            "dataType": 'html',
            "data": {
                "acao": "retornaTabelaOrdem",
                "dados": infTabOrdem

            },
            "success": function (response) {
                $("#tabelaOrdem").find("tbody").html(response);
            }
        });

        $.ajax({
            "url": "/pages/financeiro/gdof/unidade/cad_gdof/request.php",
            "dataType": 'html',
            "data": {
                "acao": "retornaOptionsDaEntrega",
                "dados": infTabOrdem

            },
            "success": function (response) {
                $("#selectEntrega").html(response);
            }
        });

    });



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
        
        $.each($(".tabOrdem"), function (index, value) {
          console.log(value);
        });

//        $.ajax({
//            "url": "/pages/financeiro/gdof/unidade/cad_gdof/request.php",
//            "dataType": 'html',
//            "data": {
//                "acao": "retornaOptionsDaEntrega",
//                "dados": infTabOrdem
//
//            },
//            "success": function (response) {
//                $("#selectEntrega").html(response);
//            }
//        });
    });

    var infTabEntrega = [];

    $("body").on("click", ".addEntrega", function (e) {
        infTabEntrega.push($("#selectEntrega option:selected").val());
        atualizaTabelaEntrega(infTabEntrega);
    });


    function atualizaTabelaEntrega(infTabEntrega) {

        $.ajax({
            "url": "/pages/financeiro/gdof/unidade/cad_gdof/request.php",
            "dataType": 'html',
            "data": {
                "acao": "retornaTabelaEntrega",
                "dados": infTabEntrega

            },
            "success": function (response) {
                $("#tabelaEntrega").find("tbody").html(response);
                $("#valorDocumentoFiscal").val($("body").find(".valorEntregaTotal").attr("valor"));
            }
        });
    }


    $("body").on("click", ".excluirEntrega", function (e) {
        var $this = $(this);
        $("#ent" + $this.val()).remove();
        infTabEntrega = [];
        var qtdEntrega = 0;
        $(".trEntregas").each(function () {
            infTabEntrega.push($(this).attr("identrega"));
            qtdEntrega++;
        });
        if (qtdEntrega > 0) {
            atualizaTabelaEntrega(infTabEntrega);
        }
    });


});
