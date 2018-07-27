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
                console.log(response);
                return false;
                $(".ordem").html("");
                $(".ordem").append(response);
            }
        });
    });

});
