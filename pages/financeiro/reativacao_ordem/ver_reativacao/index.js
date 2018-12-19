$(document).ready(function () {
    //instacinado fucoes js
    func = new Funcoes();
    
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

    function listaAnotacoes() {
        $.ajax({
            "url": "/pages/financeiro/reativacao_ordem/anotacoes/request.php",
            "method": "GET",
            "dataType": "html",
            "data": {
                "acao": "listaAnotacoes",
                "id_ordem_administracao": $("#id_ordem_administracao").val()
            },

            "success": function (response) {
                if (response.trim() === "SessaoExpirada") {
                    func.modalAlert(func.msgSemPermissao);
                    return false;
                }

                try {
                    response = JSON.parse(response);
                } catch (e) {
                    func.modalAlert(func.msgErroPadrao, 'danger');
                    return false;
                }

                if (response.tipoMsg === "Erro") {
                    if (response.tipoExibicao === "console") {

                        func.modalAlert(func.msgErroPadrao, 'danger');
                        return false;
                    } else if (response.tipoExibicao === "alert") {
                        func.modalAlert(response.msg);
                        return false;
                    }
                } else if (response.tipoMsg === "ok") {

                    $("#anotacoes").html("");
                    $("#anotacoes").html(response.msg);
                    return false;
                } else {
                    func.modalAlert(func.msgErroPadrao, 'danger');
                    return false;
                }
            },
            "error": function (response) {
                func.modalAlert(func.msgErroPadrao, 'danger');
                return false;
            }
        });
    }

    listaAnotacoes();

    $('body').on('click', '.btn-addAnotacao', function (e) {
        $('#adAnotacao').modal();

    });

    $('#adAnotacao').on('shown.bs.modal', function () {
        $('#anotacao').focus()
    });


    $('body').on('click', '.btn-enviarAnotacao', function (e) {
        var Dados = {
            "id_ordem_administracao": $("#id_ordem_administracao").val(),
            "anotacao": $('#anotacao').val()
        };
        $.ajax({
            "url": "/pages/financeiro/reativacao_ordem/anotacoes/request.php",
            "method": "POST",
            "dataType": "html",
            "data": {
                "acao": "salvaAnotacao",
                "dados": Dados
            },

            "success": function (response) {
                console.log(response);
                if (response.trim() === "SessaoExpirada") {
                    $("#adAnotacao").modal('hide');
                    func.modalAlert(func.msgSemPermissao);
                    return false;
                }

                try {
                    response = JSON.parse(response);
                } catch (e) {
                    $("#adAnotacao").modal('hide');
                    func.modalAlert(func.msgErroPadrao, 'danger');
                    return false;
                }

                if (response.tipoMsg === "Erro") {
                    if (response.tipoExibicao === "console") {
                        $("#adAnotacao").modal('hide');
                        func.modalAlert(func.msgErroPadrao, 'danger');
                        return false;
                    } else if (response.tipoExibicao === "alert") {
                        $("#adAnotacao").modal('hide');
                        func.modalAlert(response.msg);
                        return false;
                    }
                } else if (response.tipoMsg === "ok") {
                    $("#adAnotacao").modal('hide');
                    func.modalAlert(response.msg, 'success');
                    $('.modal-alert').on('hidden.bs.modal', function (e) {
                        listaAnotacoes();
                    });
                    return false;
                } else {
                    $("#adAnotacao").modal('hide');
                    func.modalAlert(func.msgErroPadrao, 'danger');
                    return false;
                }
            },
            "error": function (response) {
                $("#adAnotacao").modal('hide');
                func.modalAlert(func.msgErroPadrao, 'danger');
                return false;
            }
        });

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
                "id_ordem_administracao": $("#id_ordem_administracao").val(),
                "id_remetente": $("#id_remetente option:selected").data('tipo-lotacao')
            }

            $.ajax({
                "url": "request.php",
                "method": "POST",
                "dataType": "html",
                "data": {
                    "acao": "autorizaReativacao",
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
