$(document).ready(function () {

    func = new Funcoes();
    func.carregaTabelaPadrao('tabela', null, [5], true);


    function listaEstados() {
        $.ajax({
            "url": "/model/sistema/estado/request.php",
            "dataType": 'html',
            "data": {
                acao: "listaEstadosTable"
            },

            "success": function (response)

            {
                func.carregaTabelaPadrao('tabela', response, [5], true);
            }
        });
    }
    listaEstados();

    $('body').on('click', '.btn-salvar', function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else {
            e.preventDefault();
            var $this = $(this);
            $this.prop("disabled", true);
            var Estado = {
                nome: $("#nmEstado").val(),
                sigla: $("#nmSigla").val(),
                idp: $("#idPais").val()
            }            

            if ($("#nmEstado").val() == "") {
                func.modalAlert(func.msgPreencherCampos);
                $this.prop("disabled", false);
                return false;
            }

            $.ajax({
                "url": "/model/sistema/estado/request.php",
                "dataType": "html",
                "data": {
                    "acao": "cadEstado",
                    "estado": Estado
                },
                "success": function (response) {
                    $this.prop("disabled", false);
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
                    $this.prop("disabled", false);
                    func.modalAlert(func.msgErroPadrao, 'danger');
                    return false;
                }
            });
            $this.prop("disabled", false);
        }
    });


    $('body').on('click', '.btn-editar', function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else {
            e.preventDefault();
            var $this = $(this);
            $this.prop("disabled", true);
            var Estado = {
                nome: $("#nmEstado").val(),
                sigla: $("#nmSigla").val(),
                id: $this.val(),
                idp: $("#idPais").val()


            };

            if (Estado.nome == "" || $this.val() == "") {
                func.modalAlert(func.msgPreencherCampos);
                $this.prop("disabled", false);
                return false;
            }

            $.ajax({
                "url": "/model/sistema/estado/request.php",
                "dataType": "html",
                "data": {
                    "acao": "edtEstado",
                    "estado": Estado
                },
                "success": function (response) {
                    $this.prop("disabled", false);
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
                    $this.prop("disabled", false);
                    func.modalAlert(func.msgErroPadrao, 'danger');
                    return false;
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
            message: 'Você tem Certeza que deseja continuar com a Exclusão do Item <span class="text-danger">' + item + '</span>?',
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
                    var Estado = {
                        id: id
                    };

                    if (Estado.id == "") {
                        func.modalAlert(func.msgPreencherCampos);
                        $this.prop("disabled", false);
                        return false;
                    }

                    $.ajax({
                        "url": "/model/sistema/estado/request.php",
                        "dataType": "html",
                        "data": {
                            "acao": "remEstado",
                            "estado": Estado
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

    //******** Carrega o select2 em todos os select's ********
    $('#idPais').select2({ width:"100%" });
    //********************************************************

    $('body').on('click', '.btn-edit', function (e) {
        e.preventDefault();
        var id = $(this).val();
        $('.btn-editar').val(id);       
        $("#nmEstado").val($(this).attr('nome'));
        $("#nmSigla").val($(this).attr('sigla'));
        $("#idPais").val($(this).attr('idpa'));
        $('.btn-salvar').hide();
        $('.btn-editar').show();
        $("#nmEstado").focus();

    });
    $('body').on('click', '.btn-limpar', function (e) {
        $('.btn-salvar').prop("disabled", false);
        $('.btn-editar').prop("disabled", false);
        $('.btn-salvar').show();
        $('.btn-editar').val(0);
        $('.btn-editar').hide();
        $("#nmEstado").val("");
        $("#nmSigla").val("");
        $("#idPais").val("");

    });

    $('.modal-alert').on('shown.bs.modal', function (e) {
        $("#nmEstado").focus();
    });


    $('body').on('keypress', '.formVinculo', function (e) {
        var key = e.which;
        if (key == 13) {
            $(".btn-salvar").trigger('click');
            return false;
        }
    });

});
