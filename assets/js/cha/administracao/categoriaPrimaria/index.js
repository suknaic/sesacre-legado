$(document).ready(function () {
    //instacinado fucoes js
    func = new Funcoes();
    //buscando o select option
    $("#idCategoriaTipo").select2();
    $(".btn-editar").hide();
    $(".btn-cancelar").hide();

    $('body').on('click', '.btn-limpar', function (e) {
        $("#nmCategoriaPrimaria").val("");
        $("#idCategoriaTipo").select2('val', '0');
    });

    function listarCategoriaPrimaria() {
        $.ajax({
            "url": "/model/cha/administracao/categoriaPrimaria/request.php",
            "dataType": "html",
            "data": {
                "acao": "listarCategoriaPrimaria"
            },
            "success": function (response) {
                if (response.trim() == "SessaoExpirada") {
                    func.modalAlert(func.msgSemPermissao);
                    return false;
                }

                try {
                    response = JSON.parse(response);
                } catch (e) {
                    func.carregaTabelaPadrao('tabela', response, [], true);
                    return false;
                }
                if (response.tipoMsg === "Erro") {
                    if (response.tipoExibicao === "console") {
                        func.modalAlert(func.msgErroPadrao, 'danger');
                        return false;

                    } else if (response.tipoExibicao === "alert") {
                        $("body").find("#nmCategoriaPrimaria").html("");
                        $("body").find("#idCategoriaTipo").html("0");
                        func.modalAlert(response.msg);
                        return false;
                    }
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
    }
    listarCategoriaPrimaria();

    function listarCategoriaTipo() {
        $.ajax({
            "url": "/model/cha/administracao/categoriaPrimaria/request.php",
            "dataType": "html",
            "data": {
                "acao": "listarCategoriaTipo"
            },
            "success": function (response) {
                try {
                    response = JSON.parse(response);
                } catch (e) {
                    $("#idCategoriaTipo").append(response);
                }
                if (response.tipoMsg === "Erro") {
                    if (response.tipoExibicao === "alert") {
                        func.modalAlert(response.msg);
                        return false;
                    }
                }
            }
        });
    }
    listarCategoriaTipo();

    $('body').on('click', '.btn-cancelar', function (e) {
        $(".btn-salvar").show();
        $(".btn-limpar").show();
        $(".btn-editar").hide();
        $(".btn-cancelar").hide();
        $("#categoriaPrimaria").val('');
        $("#categoriaTipo").select2('val', '0');
    });

    $('body').on('click', '.btn-edit', function (e) {
        $(".btn-salvar").hide();
        $(".btn-limpar").hide();
        $(".btn-editar").show();
        $(".btn-cancelar").show();
        $("#nmCategoriaPrimaria").val($(this).attr('categoriaPrimaria'));
        $("#idCategoriaTipo").select2('val', $(this).attr('categoriaTipo'));
        $("#idCategoriaPrimaria").val($(this).val());
    });

    $('body').on('click', '.btn-salvar', function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else {
            e.preventDefault();
            var $this = $(this);
            $this.prop("disabled", true);
            var caPrimaria = {
                nmCaPrimaria: $("#nmCategoriaPrimaria").val(),
                idCaTipo: $('#idCategoriaTipo').val()
            };

            $.ajax({
                "url": "/model/cha/administracao/categoriaPrimaria/request.php",
                "dataType": "html",
                "data": {
                    "acao": "cadastrarCategoriaPrimaria",
                    "caPrimaria": caPrimaria
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
                            $("body").find("#codigo").html("");
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
            var caPrimaria = {
                idCategoriaPrimaria: $('#idCategoriaPrimaria').val(),
                nmCategoriaPrimaria: $('#nmCategoriaPrimaria').val(),
                idCategoriaTipo: $('#idCategoriaTipo').val()
            };

            $.ajax({
                "url": "/model/cha/administracao/categoriaPrimaria/request.php",
                "dataType": "html",
                "data": {
                    "acao": "editarCategoriaPrimaria",
                    "caPrimaria": caPrimaria
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
                            $("body").find("#codigo").html("");
                            func.modalAlert(response.msg);
                            return false;
                        }
                    } else if (response.tipoMsg === "ok") {
                        func.modalAlert(response.msg, 'primary');
                        $('.modal-alert').on('hidden.bs.modal', function (e) {
                            location.reload();
                        });
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

    $('body').on('click', '.btn-desativar', function (e) {
        var $this = $(this);
        var id = $this.val();
        var primaria = $this.closest('td').find('.btn-edit').attr("categoriaPrimaria");
        var tipo = $this.closest('td').find('.btn-edit').attr("categoriaTipo");

        bootbox.confirm({
            title: func.msgCaixaDeConfirmacao,
            message: 'Você tem Certeza que Deseja Continuar com a Desativação do Registro <span class="text-danger">' + primaria + '</span> ?',
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
                    var caPrimaria = {
                        idCategoriaPrimaria: id,
                        nmCategoriaPrimaria: primaria,
                        idCategoriaTipo: tipo
                    };

                    if (id === "" && primaria === "" && tipo === "") {
                        func.modalAlert(func.msgPreencherCampos);
                        $this.prop("disabled", false);
                        return false;
                    }
                    $.ajax({
                        "url": "/model/cha/administracao/categoriaPrimaria/request.php",
                        "dataType": "html",
                        "data": {
                            "acao": "desativarCategoriaPrimaria",
                            "caPrimaria": caPrimaria
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
                                $('.modal-alert').on('hidden.bs.modal', function (e) {
                                    location.reload();
                                });
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

    $('body').on('click', '.btn-ativar', function (e) {
        var $this = $(this);
        var id = $this.val();
        var primaria = $this.closest('td').find('.btn-edit').attr("categoriaPrimaria");
        var tipo = $this.closest('td').find('.btn-edit').attr("categoriaTipo");

        bootbox.confirm({
            title: func.msgCaixaDeConfirmacao,
            message: 'Você tem Certeza que Deseja Continuar com a Ativação do Registro <span class="text-danger">' + primaria + '</span> ?',
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
                    var caPrimaria = {
                        idCategoriaPrimaria: id,
                        nmCategoriaPrimaria: primaria,
                        idCategoriaTipo: tipo
                    };

                    if (id === "" && primaria === "" && tipo === "") {
                        func.modalAlert(func.msgPreencherCampos);
                        $this.prop("disabled", false);
                        return false;
                    }
                    $.ajax({
                        "url": "/model/cha/administracao/categoriaPrimaria/request.php",
                        "dataType": "html",
                        "data": {
                            "acao": "ativarCategoriaPrimaria",
                            "caPrimaria": caPrimaria
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
                                $('.modal-alert').on('hidden.bs.modal', function (e) {
                                    location.reload();
                                });
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

    $('body').on('click', '.btn-remover', function (e) {

        var $this = $(this);
        var id = $this.val();
        var primaria = $this.closest('td').find('.btn-edit').attr("categoriaPrimaria");
        var tipo = $this.closest('td').find('.btn-edit').attr("categoriaTipo");

        bootbox.confirm({
            title: func.msgCaixaDeConfirmacao,
            message: 'Você tem Certeza que Deseja Continuar com a Exclusão do Registro <span class="text-danger">' + primaria + '</span> ?',
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
                    var caPrimaria = {
                        idCategoriaPrimaria: id,
                        nmCategoriaPrimaria: primaria,
                        idCategoriaTipo: tipo
                    };

                    if (id === "" && primaria === "" && tipo === "") {

                        func.modalAlert(func.msgPreencherCampos);
                        $this.prop("disabled", false);
                        return false;
                    }
                    $.ajax({
                        "url": "/model/cha/administracao/categoriaPrimaria/request.php",
                        "dataType": "html",
                        "data": {
                            "acao": "removerCategoriaPrimaria",
                            "caPrimaria": caPrimaria
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
                                $('.modal-alert').on('hidden.bs.modal', function (e) {
                                    location.reload();
                                });
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
});
