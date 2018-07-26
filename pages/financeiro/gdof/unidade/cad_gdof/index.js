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
        var dados = $("#codItemPesquisa").val();
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
                console.log(response);
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
                console.log(response);
                $(".pedido").html("");
                $(".pedido").append(response);
            }
        });
    });

});
