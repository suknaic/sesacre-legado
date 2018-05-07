$(document).ready(function () {
    //instacinado fucoes js
    func = new Funcoes();

    //Masca para valor
    $("body").on("focus", "#qtd", function () {
        $(this).priceFormat({
            centsLimit: 4,
            prefix: '',
            centsSeparator: ',',
            thousandsSeparator: '.',
        });
    });

    $("body").on("focus", "#valor_unitario", function () {
        $(this).priceFormat({
            centsLimit: 4,
            prefix: '',
            centsSeparator: ',',
            thousandsSeparator: '.',
        });
    });


    //carrega os itens de um fornecedor
    function retornatrItensFornecedor() {
        var dados = {
            "id": $("#id").val()
        }

        $.ajax({
            "url": "/model/financeiro/preOrdem/request.php",
            "dataType": 'html',
            "data": {
                "acao": "retornaItemPreOrdem",
                "dados": dados
            },
            "success": function (response) {
                $("#tabela").find("tbody").html(response);
            }
        });
    }
    retornatrItensFornecedor();

    //Inicia a edição do item
    $('body').on('click', '.btn-edit', function (e) {
        e.preventDefault();
        var Dados = {
            "idItem": $(this).val(),
            "idPedido": $("#id").val()
        }
        var $this = $(this);
        $.ajax({
            "url": "/model/financeiro/preOrdem/request.php",
            "dataType": 'html',
            "data": {
                acao: "retornaDadosEdicao",
                dados: Dados
            },
            "success": function (response) {
                try {
                    response = JSON.parse(response);
                } catch (e) {
                    return false;
                }

                if (response.tipoMsg == "nao_encontrou") {
                    func.modalAlert(func.msgRegistroNaoEncontrado);
                    $('.modal-alert').on('hidden.bs.modal', function (e) {
                        location.reload();
                    });
                }

                if (response.tipoMsg == "ok") {
                    var info = response.msg;
                    $("#codigo").val(info.cd_desc_material);
                    $("#fornecedor").val($this.attr("fornecedor"));
                    $("#idPreOrdem").val($this.attr("idPreOrdem"));
                    $("#desc-item").text(info.nm_desc_material);
                    $("#item").text(info.nm_material);
                    $("#grupo").text(info.nm_grupo);
                    $("#sub-grupo").text(info.nm_sub_grupo);
                    $("#despesa").text(info.cd_elemento_despesa);
                    $("#tipo").text(info.tp_material);
                    $("#marca").val(info.nm_marca);
                    $("#modelo").val(info.nm_modelo);
                    $("#lote").val(info.nr_lote);
                    $("#qtd").val(info.qt_itens);
                    $("#valor_unitario").val(info.vl_itens);
                    $("#pc_desconto").val(info.pc_desconto);
                    $(".btn-finaliza").hide();
                    $(".btn-editar").removeClass('hidden');
                    $(".btn-editar").val(Dados.idItem);
                    $('html, body').animate({
                        scrollTop: $('#page-content').offset().top + 'px'
                    }, 'slow');
                }
                if (info.tp_material == 'S') {
                    $('#valor_unitario').prop("disabled", false);
                } else {
                    $('#valor_unitario').prop("disabled", true);
                }
            }
        });

    });
    //fim

    $("body").on("click", ".btn-editar", function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else {
            e.preventDefault();
            var $this = $(this);
            $this.prop("disabled", true);
            //validação de campos js
            if ($("#qtd").val() == "") {
                func.modalAlert(func.msgPreencherCampos);
                $this.prop("disabled", false);
                return false;
            }

            if ($("#valor_unitario").val() == "") {
                func.modalAlert(func.msgPreencherCampos);
                $this.prop("disabled", false);
                return false;
            }

            var dados = {
                "tipo": $("#tipo").text(),
                "idPreOrdem": $("#idPreOrdem").val(),
                "idItem": $(this).val(),
                "id": $("#id").val(),
                "fornecedor": $("#fornecedor").val(),
                "qtd": $("#qtd").val(),
                "valor_unitario": $("#valor_unitario").val()
            }

            $.ajax({
                "url": "/model/financeiro/preOrdem/request.php",
                "dataType": "html",
                "data": {
                    "acao": "editarItemPreOrdem",
                    "dados": dados
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

            $this.prop("disabled", false);
        }
    });

    $('body').on('click', '.btn-remover', function (e) {
        var $this = $(this);
        var id = $this.val();
        var item = $this.closest('td').find('.btn-remover').attr("nomeMaterial");
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
                        "id": $("#id").val()
                    }

                    if (id == "") {
                        func.modalAlert(func.msgPreencherCampos);
                        $this.prop("disabled", false);
                        return false;
                    }

                    $.ajax({
                        "url": "/model/financeiro/preOrdem/request.php",
                        "dataType": "html",
                        "data": {
                            "acao": "removeItemPreOrdem",
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
                                func.modalAlert(response.msg);
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

    $("body").on("click", ".btn-finaliza", function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else {

            var dados = {
                "id": $("#id").val(),

            }
            $.ajax({
                "url": "/model/financeiro/preOrdem/request.php",
                "dataType": 'html',
                "data": {
                    "acao": "finalizaPreOrdem",
                    "dados": dados
                },
                "success": function (response) {
                    if (response == 'ok') {
                        func.modalAlert("Pre-ordem finalizada com sucesso.", 'success')
                        $('.modal-alert').on('hidden.bs.modal', function (e) {
                            window.location.href = "/pages/financeiro/necessidade_central/index.php";
                        });
                    } else {
                        func.modalAlert(func.msgErroPadrao, 'warning');
                    }
                }
            });
        }
    });
});
      