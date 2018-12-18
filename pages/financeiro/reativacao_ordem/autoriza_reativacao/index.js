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
    //retorna remetente
    $.ajax({
        "url": "request.php",
        "dataType": 'html',
        "data": {
            "acao": "retornaTipoRemetenteERemetente"
        },
        "success": function (response) {
            $("#id_remetente").html("");
            $("#id_remetente").append(response);
        }
    });

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

    $('body').on('click', '.ver-ordem', function (e) {
        var id = $(this).val();
        window.open("/pages/financeiro/ordem/pdfBemProduto.php?&id=" + id);
    });


    $("body").on("click", ".btn-salvar", function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else {
            e.preventDefault();
            var $this = $(this);
            $this.prop("disabled", true);

            var dados = {
                "id_ordem": $("#id_ordem").val(),
                "id_protocolo": $("#id_protocolo").val(),
                "id_remetente": $("#id_remetente option:selected").data('tipo-lotacao'),
                "anotacoes": $("#anotacoes").val()
            }

            $.ajax({
                "url": "request.php",
                "method": "POST",
                "dataType": "html",
                "data": {
                    "acao": "cadastraReativacao",
                    "dados": dados
                },
                "success": function (response) {
                    $this.prop("disabled", false);
                    console.log(response);
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
