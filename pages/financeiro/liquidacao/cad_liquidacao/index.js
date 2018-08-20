$(document).ready(function () {
    //instacinado fucoes js
    func = new Funcoes();

    //busca pedido
    $('#modalItem').on('shown.bs.modal', function () {
        $('#codItemPesquisa').focus();
    });

    //função para pesquisa licitacao do gcon
    $('body').on('click', '#btn-pesquisa', function (e) {
        var dados = $("#codItemPesquisa").val();
        $.ajax({
            "url": "/pages/financeiro/liquidacao/cad_liquidacao/request.php",
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

    $('body').on('click', '.selecionaItem', function (e) {
        var $this = $(this);
        var dados = {
            "nr_pedido": $("body").find(".selecionaItem").attr("nrpedido"),
            "id_pedido": $("body").find(".selecionaItem").attr("pedido")
        }

        /**
         * retornaContratosPedido
         */
        $.ajax({
            "url": "/pages/financeiro/liquidacao/cad_liquidacao/request.php",
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
            "url": "/pages/financeiro/liquidacao/cad_liquidacao/request.php",
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
            "url": "/pages/financeiro/liquidacao/cad_liquidacao/request.php",
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
        $('#modalItem').modal('hide');
    });

});
