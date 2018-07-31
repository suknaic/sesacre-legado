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

});
