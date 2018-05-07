$(document).ready(function () {
    //instacinado fucoes js
    func = new Funcoes();
    //buscando o select option
    $("#idCategoriaPrimaria").select2();
    $(".btn-editar").hide();
    $(".btn-cancelar").hide();

    $("body").on("focus", "#vlCategoriaSecundaria", function () {
        $(this).priceFormat({
            prefix: '',
            centsSeparator: ',',
            thousandsSeparator: '.'
        });
    });
    $('body').on('click', '.btn-limpar', function (e) {
        $("#nmCategoriaSecundaria").val("");
        $("#vlCategoriaSecundaria").val("");
        $("#idCategoriaPrimaria").select2('val', '0');
    });


    function listarCategoriaSecundaria() {
        $.ajax({
            "url": "/model/cha/administracao/categoriaSecundaria/request.php",
            "dataType": "html",
            "data": {
                "acao": "listarCategoriaSecundaria"
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
    listarCategoriaSecundaria();

    function listarCategoriaPrimaria(idCategoriaTipo) {
        $.ajax({
            "url": "/model/cha/administracao/categoriaSecundaria/request.php",
            "dataType": "html",
            "data": {
                "acao": "listarCategoriaPrimaria",
                idCategoriaTipo: idCategoriaTipo
            },
            "success": function (response) {
                try {
                    response = JSON.parse(response);
                } catch (e) {
                    $("#idCategoriaPrimaria").append(response);
                    $("#idCategoriaPrimaria").select2({
                        width: " 100%"
                    });
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
    listarCategoriaPrimaria();

//    function listarCategoriaSecundarias(idCategoriaPrimaria) {
//        $.ajax({
//            "url": "/model/cha/administracao/categoriaSecundaria/request.php",
//            "dataType": "html",
//            "data": {
//                "acao": "listarCategoriaSecundarias",
//                idCategoriaPrimaria: idCategoriaPrimaria
//            },
//            "success": function (response) {
//                try {
//                    response = JSON.parse(response);
//                } catch (e) {
//                    $("#idCategoriaSecundaria").append(response);
//                    $("#idCategoriaSecundaria").select2({
//                        width: " 100%"
//                    });
//                }
//                if (response.tipoMsg === "Erro") {
//                    if (response.tipoExibicao === "alert") {
//                        func.modalAlert(response.msg);
//                        return false;
//                    }
//                }
//            }
//        });
//    }
//    listarCategoriaSecundarias();

    $('body').on('click', '.btn-cancelar', function (e) {
        $(".btn-salvar").show();
        $(".btn-limpar").show();
        $(".btn-editar").hide();
        $(".btn-cancelar").hide();
        $("#categoriaSecundaria").val('');
        $("#vlSecundaria").val('');
        $("#categoriaPrimaria").select2('val', '0');
    });

    $('body').on('click', '.btn-edit', function (e) {
        $(".btn-salvar").hide();
        $(".btn-limpar").hide();
        $(".btn-editar").show();
        $(".btn-cancelar").show();
        $("#nmCategoriaSecundaria").val($(this).attr('categoriaSecundaria'));
        $("#idCategoriaPrimaria").select2('val', $(this).attr('categoriaPrimaria'));
        $("#vlCategoriaSecundaria").val($(this).attr('vlSecundaria'));
        console.log($(this).attr('vlSecundaria'));
        $("#idCategoriaSecundaria").val($(this).val());
    });

    $('body').on('click', '.btn-salvar', function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else {
            e.preventDefault();
            var $this = $(this);
            $this.prop("disabled", true);
            var caSecundaria = {
                nmCaSecundaria: $("#nmCategoriaSecundaria").val(),
                vlCaSecundaria: $("#vlCategoriaSecundaria").val(),
                idCaPrimaria: $('#idCategoriaPrimaria').val()
            };

            $.ajax({
                "url": "/model/cha/administracao/categoriaSecundaria/request.php",
                "dataType": "html",
                "data": {
                    "acao": "cadastrarCategoriaSecundaria",
                    "caSecundaria": caSecundaria
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
            var caSecundaria = {
                idCategoriaSecundaria: $('#idCategoriaSecundaria').val(),
                nmCategoriaSecundaria: $('#nmCategoriaSecundaria').val(),
                vlCategoriaSecundaria: $('#vlCategoriaSecundaria').val(),
                idCategoriaPrimaria: $('#idCategoriaPrimaria').val()
            };

            $.ajax({
                "url": "/model/cha/administracao/categoriaSecundaria/request.php",
                "dataType": "html",
                "data": {
                    "acao": "editarCategoriaSecundaria",
                    "caSecundaria": caSecundaria
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
        var secundaria = $this.closest('td').find('.btn-edit').attr("categoriaSecundaria");
        var valor = $this.closest('td').find('.btn-edit').attr("vlSecundaria");
        var primaria = $this.closest('td').find('.btn-edit').attr("categoriaPrimaria");

        bootbox.confirm({
            title: func.msgCaixaDeConfirmacao,
            message: 'Você tem Certeza que Deseja Continuar com a Desativação do Registro <span class="text-danger">' + secundaria + '</span> ?',
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
                    var caSecundaria = {
                        idCategoriaSecundaria: id,
                        nmCategoriaSecundaria: secundaria,
                        vlCategoriaSecundaria: valor,
                        idCategoriaPrimaria: primaria
                    };

                    if (id === "" && secundaria === "" && valor === "" && primaria === "") {
                        func.modalAlert(func.msgPreencherCampos);
                        $this.prop("disabled", false);
                        return false;
                    }
                    $.ajax({
                        "url": "/model/cha/administracao/categoriaSecundaria/request.php",
                        "dataType": "html",
                        "data": {
                            "acao": "desativarCategoriaSecundaria",
                            "caSecundaria": caSecundaria
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
        var secundaria = $this.closest('td').find('.btn-edit').attr("categoriaSecundaria");
        var valor = $this.closest('td').find('.btn-edit').attr("vlSecundaria");
        var primaria = $this.closest('td').find('.btn-edit').attr("categoriaPrimaria");

        bootbox.confirm({
            title: func.msgCaixaDeConfirmacao,
            message: 'Você tem Certeza que Deseja Continuar com a Ativação do Registro <span class="text-danger">' + secundaria + '</span> ?',
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
                    var caSecundaria = {
                        idCategoriaSecundaria: id,
                        nmCategoriaSecundaria: secundaria,
                        vlCategoriaSecundaria: valor,
                        idCategoriaPrimaria: primaria
                    };

                    if (id === "" && secundaria === "" && valor === "" && primaria === "") {
                        func.modalAlert(func.msgPreencherCampos);
                        $this.prop("disabled", false);
                        return false;
                    }
                    $.ajax({
                        "url": "/model/cha/administracao/categoriaSecundaria/request.php",
                        "dataType": "html",
                        "data": {
                            "acao": "ativarCategoriaSecundaria",
                            "caSecundaria": caSecundaria
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
        var secundaria = $this.closest('td').find('.btn-edit').attr("categoriaSecundaria");
        var valor = $this.closest('td').find('.btn-edit').attr("vlSecundaria");
        var primaria = $this.closest('td').find('.btn-edit').attr("categoriaPrimaria");

        bootbox.confirm({
            title: func.msgCaixaDeConfirmacao,
            message: 'Você tem Certeza que Deseja Continuar com a Exclusão do Registro <span class="text-danger">' + secundaria + '</span> ?',
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
                    var caSecundaria = {
                        idCategoriaSecundaria: id,
                        nmCategoriaSecundaria: secundaria,
                        vlCategoriaSecundaria: valor,
                        idCategoriaPrimaria: primaria
                    };

                    if (id === "" && secundaria === "" && valor === "" && primaria === "") {

                        func.modalAlert(func.msgPreencherCampos);
                        $this.prop("disabled", false);
                        return false;
                    }
                    $.ajax({
                        "url": "/model/cha/administracao/categoriaSecundaria/request.php",
                        "dataType": "html",
                        "data": {
                            "acao": "removerCategoriaSecundaria",
                            "caSecundaria": caSecundaria
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
