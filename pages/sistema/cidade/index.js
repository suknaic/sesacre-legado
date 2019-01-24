$(document).ready(function () {

    func = new Funcoes();
    //******** Carrega o DataTable pra tabela não ficar feia **********
    func.carregaTabelaPadrao('tabela', null, [7]);
    //*****************************************************************

    //************ Carrega o select2 em todos os select's *************
    $('.select').select2({ width:"100%" });
    //*****************************************************************

    //*********** Carregas todos os estado no select option ***********
    $.ajax({
        "url": "request.php",
        "dataType": 'html',
        "data": {
            acao: "SelectEstadoOption"
        },

        "success": function (response) {
            $('#idEstado').html(response);
        }
    });
    // ****************************************************************

    $('body').on('click', '.btn-pesquisar', function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else {
            e.preventDefault();
            var $this = $(this);
            $this.prop("disabled", true);
            var Cidade = {
                nome: $("#nmCidade").val(),
                idEstado: $("#idEstado").val()
            };

            if (Cidade.nome == '' && Cidade.idEstado == '') {
                func.modalAlert(func.msgPreencherCampos);
                $this.prop("disabled", false);
                return false;
            }

            $.ajax({
                "url": "request.php",
                "dataType": "html",
                "data": {
                    "acao": "listaCidadesTable",
                    "dados": Cidade
                },
                "success": function (response) {
                    try {
                        func.carregaTabelaPadrao('tabela', response, [8], true);
                        return false;
                    } catch (e) {
                        response = JSON.parse(response);
                    }

                    if (response.tipoMsg === "Erro") {
                        if (response.tipoExibicao === "console") {
                            func.modalAlert(func.msgErroPadrao, 'danger');
                            return false;

                        } else if (response.tipoExibicao === "alert") {
                            func.modalAlert(response.msg);
                            return false;
                        }

                    } else {
                        func.modalAlert(func.msgErroPadrao, 'danger');
                        return false;
                    }
                }
            });
            $this.prop("disabled", false);
        }
    });

    $('body').on('click', '.btn-remover', function (e) {
        var $this = $(this);
        var id = $this.val();
        var item = $this.closest('td').find('.btn-edit').attr("nome");

        bootbox.confirm({
            title: 'Caixa de Confirmação',
            message: 'Você tem certeza que deseja continuar com a exclusão da cidade <span class="text-danger">' + item + '</span>?',
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
                    var Cidade = {
                        id: id
                    };

                    if (Cidade.id == "" || Cidade.id == 0) {
                        func.modalAlert(func.msgPreencherCampos);
                        $this.prop("disabled", false);
                        return false;
                    }

                    $.ajax({
                        "url": "request.php",
                        "dataType": "html",
                        "data": {
                            "acao": "remCidade",
                            "dados": Cidade
                        },
                        "success": function (response) {
                            if (response.trim() == "SessaoExpirada") {
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
                                func.modalAlert(response.msg, 'success');
                                func.fechaModalReload();
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
            }
        });
    });

    $('body').on('click', '.btn-limpar', function (e) {
        $('#nmCidade').prop("disabled", false);
        $('#idEstado').prop("disabled", false);
        $("#nmCidade").val("");
        $('#idEstado').val('0').trigger('change.select2');
    });

    $('.modal-alert').on('shown.bs.modal', function (e) {
        $("#nmCidade").focus();
    });

    $('body').on('click', '.btn-newCidade', function (e) {
        top.location.href='cadEditCidade/index.php';
    });

    $('body').on('click', '.btn-edit', function (e) {
        var id = $(this).val();
        top.location.href='cadEditCidade/index.php?key='+id;
    });

    $('body').keypress(function (e) {
        if (e.which == 13) {
            $(".btn-pesquisar").trigger('click');
            return false;
        }
    });

    $("body").on("change", "#nmCidade", function () {
        var texto = $(this).val();
        if (texto != '') {
            $("#idEstado").prop('disabled', true);
        } else {
            $("#idEstado").prop('disabled', false);
        }
    });

    $("body").on("change", "#idEstado", function () {
        var texto = $(this).val();
        if (texto != '0') {
            $("#nmCidade").prop('disabled', true);
        } else {
            $("#nmCidade").prop('disabled', false);
        }
    });
});
