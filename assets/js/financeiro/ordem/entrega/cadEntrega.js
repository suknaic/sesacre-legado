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
            "protocolo": $("#protocolo").val()
        },
        "success": function (response) {
            let valores = [];
            if ($.trim(response)) {
                if (response.length) {
                    valores = response
                }
            }

            $("#pedido").text(valores[0]["nr_pedido"]);
            $("#desc_pedido").text(valores[0]["ds_pedido"]);
            $("#desc_pedido").text(valores[0]["ds_pedido"]);
            if (valores[0]["tp_contrato"] === '1') {
                $("#ata").text(valores[0]["nr_contrato"]);
            } else if (valores[0]["tp_contrato"] === '2') {
                $("#contrato").text(valores[0]["nr_contrato"]);
            }
            $("#empenho").text(valores[0]["nr_empenho"]);
            $("#ordem").text(valores[0]["nr_ordem"] + '/' + valores[0]["aa_ordem"]);
            $("#anotacoes").text(valores[0]["ds_protocolo"]);


            $("body").on("change", "#tipoEntrega", function () {
                var $this = $(this).val();


                if ($this === '1') {
                    let dataSet = [];
                    var oTable = $('#tabela').dataTable();
                    oTable.fnDestroy();

                    for (var i = valores.length - 1; i >= 0; i--) {

                        if (valores[i]['tp_material'] === 'C' || valores[i]['tp_material'] === 'P' && valores[i]['fl_valor_variavel'] === '0') {
                            var acao = 'Quantidade' + '<input type="text" name="qtd" id="qtd" itemid="' + valores[i]['id_ordem_itens'] + '" tp="' + valores[i]['tp_material'] + '"\n\
                                        class="form-control input-sm qtd">';
                        } else if (valores[i]['tp_material'] === 'S') {
                            var acao = 'Quantidade' + '<input type="text" name="qtd" id="qtd" itemid="' + valores[i]['id_ordem_itens'] + '" tp="' + valores[i]['tp_material'] + '" class="form-control input-sm qtd">' +
                                    '<br/>Valor' + '<input type="text" name="vl" id="vl" itemid="' + valores[i]['id_ordem_itens'] + '" tp="' + valores[i]['tp_material'] + '" class="form-control input-sm vl">';
                        }
                        let valor = [
                            valores[i]['nr_item'],
                            valores[i]['cd_desc_material'] + '-' + valores[i]['nm_material'],
                            valores[i]['nm_desc_material'],
                            valores[i]['cd_despesa'],
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

                        if (valores[i]['tp_material'] === 'C' || valores[i]['tp_material'] === 'P' && valores[i]['fl_valor_variavel'] === '0') {

                            if (valores[i]['entregue'] === '0,0000') {

                                var acao = 'Quantidade' + '<input type="text" name="qtd" id="qtd" itemid="' + valores[i]['id_ordem_itens'] + '" tp="' + valores[i]['tp_material'] + '" \n\
                                        value="' + valores[i]['qt_itens_ordem'].trim() + '" class="form-control input-sm qtd" disabled="true">';
                            } else {
                                var acao = 'Quantidade' + '<input type="text" name="qtd" id="qtd" itemid="' + valores[i]['id_ordem_itens'] + '" tp="' + valores[i]['tp_material'] + '" \n\
                                        value="' + valores[i]['aguardandoentrega'].trim() + '" class="form-control input-sm qtd" disabled="true">';
                            }


                        } else if (valores[i]['tp_material'] === 'S') {


                            if (valores[i]['entregue'] === '0,0000') {
                                var acao = 'Quantidade' + '<input type="text" name="qtd" id="qtd" itemid="' + valores[i]['id_ordem_itens'] + '" tp="' + valores[i]['tp_material'] + '" \n\
                                        value="' + valores[i]['qt_itens_ordem'].trim() + '" class="form-control input-sm qtd" disabled="true">' +
                                        '<br/>Valor' + '<input type="text" name="vl" id="vl" itemid="' + valores[i]['id_ordem_itens'] + '" tp="' + valores[i]['tp_material'] +
                                        '" value="' + valores[i]['vl_itens_ordem'].trim() + '" class="form-control input-sm vl" disabled="true">';
                            } else {

                                var acao = 'Quantidade' + '<input type="text" name="qtd" id="qtd" itemid="' + valores[i]['id_ordem_itens'] + '" tp="' + valores[i]['tp_material'] + '" \n\
                                        class="form-control input-sm qtd">' +
                                        '<br/>Valor' + '<input type="text" name="vl" id="vl" itemid="' + valores[i]['id_ordem_itens'] + '" tp="' + valores[i]['tp_material'] +
                                        '"  class="form-control input-sm vl" >';
                            }

                        }
                        let valor = [
                            valores[i]['nr_item'],
                            valores[i]['cd_desc_material'] + '-' + valores[i]['nm_material'],
                            valores[i]['nm_desc_material'],
                            valores[i]['cd_despesa'],
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

                        itens.push({'qtd': $(this).find(".qtd").val(), 'id': $("body").find("#id").val(), 'tp': $(this).find(".qtd").attr("tp"),
                            'itemId': $(this).find(".qtd").attr("itemid"), 'idOrdem': $(this).find("#idOrdem").val(), 'data': $("#data_entrega").val(),
                            'tipoEntrega': $("#tipoEntrega").val(), 'id_entrega': $("#id_entrega").val()});
                    }

                } else if (($(this).find(".qtd").length) == 1 && ($(this).find(".vl").length) == 1) {

                    if ($(this).find(".vl").val() != '0,0000' && $(this).find(".vl").val() != '' && $(this).find(".qtd").val() != '0,0000' && $(this).find(".qtd").val() != '') {

                        itens.push({'qtd': $(this).find(".qtd").val(), 'vl': $(this).find(".vl").val(), 'id': $("body").find("#id").val(),
                            'tp': $(this).find(".qtd").attr("tp"), 'itemId': $(this).find(".qtd").attr("itemid"), 'idOrdem': $(this).find("#idOrdem").val(),
                            'data': $("#data_entrega").val(), 'tipoEntrega': $("#tipoEntrega").val(), 'id_entrega': $("#id_entrega").val()});
                    }
                }
            });

            var enc = JSON.stringify(itens);

            $.ajax({
                "type": "POST",
                "url": "/model/financeiro/ordem/entrega/requesEntregaItens.php",
//                "dataType": "json",
                "dataType": "html",
                "data": {
                    "acao": "cadastroItensEntrega",
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
                        console.log(response);
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

    function carregaItensEntregue() {
        $.ajax({
            "url": "/model/financeiro/ordem/entrega/requesEntregaItens.php",
            "dataType": "json",
            "data": {
                "acao": "ListaItensEntregue",
                "id_entrega": $("#id_entrega").val()
            },
            "success": function (response) {
                if (response != 'Nenhum registro encontrado') {
                    let valores = [];
                    if ($.trim(response)) {
                        if (response.length) {
                            valores = response
                        }
                    }
                    let dataSet = [];
                    var oTable2 = $('#tabela2').dataTable();
                    oTable2.fnDestroy();
                    for (var i = valores.length - 1; i >= 0; i--) {

                        let valor = [
                            valores[i]['nr_item'],
                            valores[i]['cd_desc_material'] + '-' + valores[i]['nm_material'],
                            valores[i]['nm_desc_material'],
                            valores[i]['cd_despesa'],
                            valores[i]['tp_material'],
                            valores[i]['nr_lote'],
                            valores[i]['qt_itens_ordem'],
                            valores[i]['vl_itens_ordem'],
                            valores[i]['entregue'],
                            valores[i]['tipo'],
                            valores[i]['dt_entrega']
                        ]
                        dataSet.push(valor)
                    }

                    $('#tabela2').DataTable({
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
                            {title: "Tipo Entrega", className: "text-center"},
                            {title: "Data de Entrega", className: "text-center itens"}

                        ]
                    });
                }
            }
        });
    }
    carregaItensEntregue();

});




    