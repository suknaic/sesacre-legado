$(document).ready(function () {
    //instacinado fucoes js
    func = new Funcoes();

    $('.data').mask("99/99/9999");

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

    $.ajax({
        "url": "/model/financeiro/ordem/entrega/requesEntregaItens.php",
        "dataType": "json",
        "data": {
            "acao": "itensCadEntrega",
            "ordem": $("#idOrdem").val()
        },
        "success": function (response) {
            let valores = [];
            if ($.trim(response)) {
                if (response.length) {
                    valores = response
                }
            }

            $("body").on("change", "#tipoEntrega", function () {
                var $this = $(this).val();


                if ($this === '1') {
                    let dataSet = [];
                    var oTable = $('#tabela').dataTable();
                    oTable.fnDestroy();

                    for (var i = valores.length - 1; i >= 0; i--) {

                        if ((valores[i]['tp_material'] === 'C' || valores[i]['tp_material'] === 'P') && valores[i]['fl_valor_variavel'] === '0') {
                            var acao = 'Quantidade' + '<input type="text" name="qtd" id="qtd" itemid="' + valores[i]['id_ordem_itens'] + '" tp="' + valores[i]['tp_material'] + '"\n\
                                        fl_valor="' + valores[i]['fl_valor_variavel'] + '" class="form-control input-sm qtd">';
                        } else {
                            var acao = 'Quantidade' + '<input type="text" name="qtd" id="qtd" itemid="' + valores[i]['id_ordem_itens'] + '" tp="' + valores[i]['tp_material'] + '" \n\
                                        fl_valor="' + valores[i]['fl_valor_variavel'] + '" class="form-control input-sm qtd">' +
                                    '<br/>Valor' + '<input type="text" name="vl" id="vl" itemid="' + valores[i]['id_ordem_itens'] + '" tp="' + valores[i]['tp_material'] + '" \n\
                                        fl_valor="' + valores[i]['fl_valor_variavel'] + '" class="form-control input-sm vl">';
                        }
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
                            acao
                        ]
                        dataSet.push(valor)
                    }

                    $('#tabela').DataTable({
                        data: dataSet,
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
                            {title: "Ação", className: "text-center itens"}

                        ]
                    });
                } else if ($this === '2') {
                    let dataSet = [];
                    var oTable = $('#tabela').dataTable();
                    oTable.fnDestroy();

                    for (var i = valores.length - 1; i >= 0; i--) {

                        if ((valores[i]['tp_material'] === 'C' || valores[i]['tp_material'] === 'P') && valores[i]['fl_valor_variavel'] === '0') {

                            if (valores[i]['entregue'] === '0,0000') {

                                var acao = 'Quantidade' + '<input type="text" name="qtd" id="qtd" itemid="' + valores[i]['id_ordem_itens'] + '" tp="' + valores[i]['tp_material'] + '" \n\
                                        value="' + valores[i]['qt_itens_ordem'].trim() + '" fl_valor="' + valores[i]['fl_valor_variavel'] + '" class="form-control input-sm qtd" disabled="true">';
                            } else {
                                var acao = 'Quantidade' + '<input type="text" name="qtd" id="qtd" itemid="' + valores[i]['id_ordem_itens'] + '" tp="' + valores[i]['tp_material'] + '" \n\
                                        value="' + valores[i]['aguardandoentrega'].trim() + '" fl_valor="' + valores[i]['fl_valor_variavel'] + '" class="form-control input-sm qtd" disabled="true">';
                            }


                        } else {


                            if (valores[i]['entregue'] === '0,0000') {
                                var acao = 'Quantidade' + '<input type="text" name="qtd" id="qtd" itemid="' + valores[i]['id_ordem_itens'] + '" tp="' + valores[i]['tp_material'] + '" \n\
                                        value="' + valores[i]['qt_itens_ordem'].trim() + '" fl_valor="' + valores[i]['fl_valor_variavel'] + '" class="form-control input-sm qtd" disabled="true">' +
                                        '<br/>Valor' + '<input type="text" name="vl" id="vl" itemid="' + valores[i]['id_ordem_itens'] + '" tp="' + valores[i]['tp_material'] +
                                        '" value="' + valores[i]['vl_itens_ordem'].trim() + '" fl_valor="' + valores[i]['fl_valor_variavel'] + '" class="form-control input-sm vl" disabled="true">';
                            } else {

                                var acao = 'Quantidade' + '<input type="text" name="qtd" id="qtd" itemid="' + valores[i]['id_ordem_itens'] + '" tp="' + valores[i]['tp_material'] + '" \n\
                                        fl_valor="' + valores[i]['fl_valor_variavel'] + '" class="form-control input-sm qtd">' +
                                        '<br/>Valor' + '<input type="text" name="vl" id="vl" itemid="' + valores[i]['id_ordem_itens'] + '" tp="' + valores[i]['tp_material'] + '"  \n\
                                        fl_valor="' + valores[i]['fl_valor_variavel'] + '" class="form-control input-sm vl" >';
                            }

                        }
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
                            acao
                        ]
                        dataSet.push(valor)
                    }

                    $('#tabela').DataTable({
                        data: dataSet,
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
                            {title: "Ação", className: "text-center itens"}

                        ]
                    });
                }

            });
        }
    });

    //Cadastrar item entrega
    $("body").on("click", ".btn-salvar", function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else {
            e.preventDefault();
            var $this = $(this);

            if ($("#data_entrega").val() == "") {
                func.modalAlert(func.msgPreencherCampos);
                $this.prop("disabled", false);
                return false;
            }

            if ($("#tipoEntrega").val() == 0) {
                func.modalAlert(func.msgPreencherCampos);
                $this.prop("disabled", false);
                return false;
            }

            var itens = [];
            // $this.prop("disabled", true);
            $(".itens").each(function () {

                if (($(this).find(".qtd").length) == 1 && ($(this).find(".vl").length) == 0) {

                    if ($(this).find(".qtd").val() != '0,0000' && $(this).find(".qtd").val() != '') {

                        itens.push({'qtd': $(this).find(".qtd").val(), 'tp': $(this).find(".qtd").attr("tp"), 'idOrdemItens': $(this).find(".qtd").attr("itemid"),
                            'idOrdem': $("#idOrdem").val(), 'data': $("#data_entrega").val(), 'tipoEntrega': $("#tipoEntrega").val(),
                            'id_protocolo': $("#id_protocolo").val(), 'fl_valor': $(this).find(".qtd").attr("fl_valor")});
                    }

                } else if (($(this).find(".qtd").length) == 1 && ($(this).find(".vl").length) == 1) {

                    if ($(this).find(".vl").val() != '0,0000' && $(this).find(".vl").val() != '' && $(this).find(".qtd").val() != '0,0000' && $(this).find(".qtd").val() != '') {

                        itens.push({'qtd': $(this).find(".qtd").val(), 'vl': $(this).find(".vl").val(), 'tp': $(this).find(".qtd").attr("tp"),
                            'idOrdemItens': $(this).find(".qtd").attr("itemid"), 'idOrdem': $("#idOrdem").val(), 'data': $("#data_entrega").val(),
                            'tipoEntrega': $("#tipoEntrega").val(), 'id_protocolo': $("#id_protocolo").val(), 'fl_valor': $(this).find(".qtd").attr("fl_valor")});
                    }
                }
            });

            var enc = JSON.stringify(itens);

            $.ajax({
                "type": "POST",
                "url": "/model/financeiro/ordem/entrega/requesEntregaItens.php",
                "dataType": "json",
                "data": {
                    "acao": "cadastroItensEntrega",
                    "itens": enc
                },
                "success": function (response) {
                    $this.prop("disabled", false);

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
                        func.modalAlert('Itens da entrega cadastros com Sucesso', 'success');
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

            $this.prop("disabled", false);
        }
    });
    //fim

    $('body').on('click', '.btn-addAnotacao', function (e) {
        $('#adAnotacao').modal();
    });

    $('body').on('click', '.btn-enviarAnotacao', function (e) {
        $("#anotacoes").append('\n' + $("#anotacao").val());

    });

    $('body').on('click', '.excluir', function (e) {
        var $this = $(this);
        var id = $this.val();
        var idEntrega = $this.closest('td').find('.excluir').attr("idEntrega");
        var idProtocolo = $("#id_protocolo").val();
        var item = $this.closest('td').find('.excluir').attr("nomeitem");

        bootbox.confirm({
            title: func.msgCaixaDeConfirmacao,
            message: 'Você tem Certeza que deseja continuar com a Exclusão do Item: <span class="text-danger">' + item + '</span> ?',
            buttons: {
                'cancel': {
                    label: 'Não',
                    className: 'btn-default btn-rounded'
                },
                'confirm': {
                    label: 'Sim',
                    className: 'btn-primary btn-rounded'
                }
            },
            callback: function (result) {
                if (result) {
                    var dados = {
                        "idItem": id,
                        "idEntrega": idEntrega,
                        "idProtocolo": idProtocolo
                    }

                    if (id == "") {
                        func.modalAlert(func.msgPreencherCampos);
                        $this.prop("disabled", false);
                        return false;
                    }

                    $.ajax({
                        "url": "/model/financeiro/ordem/entrega/requesEntregaItens.php",
                        "method": "POST",
                        "dataType": "html",
                        "data": {
                            "acao": "excluirItemEntrega",
                            "dados": dados
                        },
                        "success": function (response) {
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
                            func.modalAlert(func.msgErroPadrao);
                            return false;
                        }
                    });
                }
            }
        });
    });

});




    