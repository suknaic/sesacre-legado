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
            "url": "request.php",
            "dataType": 'html',
            "data": {
                "acao": "pesquisaOrdemAdministracao",
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
            "id_pedido": $("body").find(".selecionaItem").attr("pedido"),
        }

        /**
         * retornaContratosPedido
         */
        $.ajax({
            "url": "request.php",
            "dataType": 'html',
            "data": {
                "acao": "retornaContratos",
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
            "url": "request.php",
            "dataType": 'html',
            "data": {
                "acao": "retornaPedido",
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
            "url": "request.php",
            "dataType": 'html',
            "data": {
                "acao": "retornaEmpenho",
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
            "url": "request.php",
            "dataType": 'html',
            "data": {
                "acao": "retornaOrdem",
                "dados": $("#codItemPesquisa").val()

            },
            "success": function (response) {
                $(".ordem").html(response);
                /**
                 * retorna Itens entrega
                 */
                $.ajax({
                    "url": "request.php",
                    "dataType": "json",
                    "data": {
                        "acao": "retornaItensEntrega",
                        "ordem": $("#id_ordem").val()
                    },
                    "success": function (response) {
                        let valores = [];
                        if ($.trim(response)) {
                            if (response.length) {
                                valores = response
                            }
                        }

                        /**
                         * Codigo abaixo e para lista os itens da entrega sem a acao
                         */
                        let dataSet = [];
                        var oTable = $('#tabela01').dataTable();
                        oTable.fnDestroy();
                        for (var i = valores.length - 1; i >= 0; i--) {
                            let valor = [
                                valores[i]['nr_item'],
                                valores[i]['cd_desc_material'] + '-' + valores[i]['nm_material'],
                                valores[i]['itendescricao'],
                                valores[i]['cd_elemento_despesa'],
                                valores[i]['tp_material'],
                                valores[i]['nr_lote'],
                                valores[i]['qt_itens_ordem'],
                                valores[i]['vl_itens_ordem'],
                                valores[i]['entregue'],
                                valores[i]['aguardandoentrega'],
                            ]
                            dataSet.push(valor)
                        }

                        $('#tabela01').DataTable({
                            data: dataSet,
                            "paging": false,
                            "searching": false,
                            language: {
                                "url": "/assets/lib/template/plugins/datatables/media/js/Portuguese-Brasil.json"
                            },

                            columns: [
                                {title: "Nº", className: "text-center"},
                                {title: "Item", className: "text-center"},
                                {title: "Descrição", className: "text-center"},
                                {title: "Elemento de Despesa", className: "text-center"},
                                {title: "Tipo", className: "text-center"},
                                {title: "Lote", className: "text-center"},
                                {title: "QTD", className: "text-center"},
                                {title: "Valor unit", className: "text-center"},
                                {title: "Entregue", className: "text-center"},
                                {title: "Aguardando Entrega", className: "text-center"},
                            ]
                        });
                    }
                });

            }
        });



        $('#modalItem').modal('hide');
    });




});
