//instacinado fucoes js
func = new Funcoes();

$(document).ready(function () {

    $('body').find('select').select2({
        width: '100%'
    });

    $.ajax({
        "url": "/model/financeiro/ordem/requestIndex.php",
        "dataType": 'html',
        "data": {
            "acao": "retornaCentrais"
        },
        "success": function (response) {
            $("body").find("#central").html(response);
        }
    });


    $("body").on("click", ".btn-pesquisar", function () {
        lista();
    });

    $('body').on('click', '.ver-reativacao', function (e) {
        var id = $(this).val();
        window.open("/pages/financeiro/reativacao_ordem/autoriza_reativacao/index.php?&id=" + id);
    });

    $('body').on('click', '.editar-pagamento', function (e) {
        var id = $(this).val();
        window.open("/pages/contabil/pagamento/edit_pagamento/index.php?&id=" + id);
    });


    $('body').on('click', '.excluir-pagamento', function (e) {

        var $this = $(this);
        var item = $this.closest('tr').data('objeto');
        var id = item.id_pagamento;

        bootbox.confirm({
            title: 'Cancelamento do Pagamento',
            message: 'Você tem Certeza que deseja continuar com o \n\
                Cancelamento do Pagamento <span class="text-danger">' + item.nr_pagamento + '</span>?\n\
                <br> \n\
                <div class="form-group"> \n\
                    <label for="rem_justificativa">Justificativa: <span class="text-danger">*</span></label> \n\
                    <div class="input-group"> \n\
                        <span class="input-group-addon"> \n\
                            <p class="fa fa-list inputPFa"></p> \n\
                        </span> \n\
                        <textarea id="rem_justificativa" class="form-control"></textarea>\n\
                    </div> \n\
                </div>',
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
                    if (id == "") {
                        func.modalAlert(func.msgPreencherCampos);
                        return true;
                    }
                    if ($("#rem_justificativa").val() == "") {
                        func.modalAlert("É Necessário Informar uma Justificativa.");
                        return true;
                    }

                    var dados = {
                        id: id,
                        justificativa: $("#rem_justificativa").val()
                    }

                    $.ajax({
                        "url": "request.php",
                        "dataType": "html",
                        "method": "post",
                        "data": {
                            "acao": "cancelarPagamento",
                            "dados": dados
                        },
                        "success": function (response) {
                            console.log(response);
                            if (response.trim() == "SessaoExpirada") {
                                func.modalAlert(func.msgSemPermissao);
                                return true;
                            }

                            try {
                                response = JSON.parse(response);
                            } catch (e) {
                                func.modalAlert(func.msgErroPadrao);
                                return true;
                            }

                            if (response.tipoMsg === "Erro") {
                                if (response.tipoExibicao === "console") {
                                    func.modalAlert(func.msgErroPadrao);
                                    return false;
                                } else if (response.tipoExibicao === "alert") {
                                    func.modalAlert(response.msg);
                                    return true;
                                }
                            } else if (response.tipoMsg === "ok") {
                                func.modalAlert(response.msg, 'success');
                                $('.modal-alert').on('hidden.bs.modal', function (e) {
                                    location.reload();
                                });
                                return true;
                            } else {
                                func.modalAlert(func.msgErroPadrao);
                                return true;
                            }
                        },
                        "error": function (response) {
                            func.modalAlert(func.msgErroPadrao);
                            return true;
                        }
                    });
                }
            }
        });

    });

});


function lista() {
    var dados = {
        nr_ordem: $("#nr_ordem").val(),
        exercicio: $("#ano_ordem option:selected").val(),
        fornecedor: $("#id_contratado option:selected").val(),
        contrato: $("#nr_contrato").val(),
        pedido: $("#nr_pedido").val(),
        empenho: $("#nr_empenho").val(),
        central: $("#central").val(),
        tpGasto: $("#tipo_gasto option:selected").val(),
        situacao: $("#situacao option:selected").val()
    }

    $.ajax({
        "url": "request.php",
        "method": "POST",
        "dataType": 'html',
        "data": {
            "acao": "retornaOrdemAdministracao",
            "dados": dados
        },
        "success": function (response) {
            func.carregaTabelaPadrao('tabela', response, [4], true);
        }
    });
}

