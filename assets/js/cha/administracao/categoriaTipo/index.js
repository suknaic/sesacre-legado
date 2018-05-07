$(document).ready(function () {
    //instacinado fucoes js
    func = new Funcoes();
    //buscando o select option
    $("#idCategoriaPrincipal").select2();
    $(".btn-editar").hide();
    $(".btn-cancelar").hide();

    $('body').on('click', '.btn-limpar', function (e) {
        $("#nmCategoriaTipo").val("");
        $("#idCategoriaPrincipal").select2('val', '0');
    });

//    var table = $('#tabela').DataTable({
//        "lengthMenu": [[10, 25, 50, 10, -1], [10, 25, 50, 100, "Todos"]],
//        "order": [[0, "asc"]],
//        "language": {
//            "url": "/assets/lib/template/plugins/datatables/media/js/Portuguese-Brasil.json"
//        },
//        responsive: true
//    });

//    function listaTipos() {
//        $.ajax({
//            "url": "/model/cha/administracao/categoriaTipo/request.php",
//            "dataType": 'html',
//            "data": {
//                acao: "listaTiposTable"
//            },
//
//            "success": function (response)
//
//            {
//                var oTable = $('#tabela').dataTable();
//                oTable.fnDestroy();
//                $("#tabela").find("tbody").html(response);
//                var table = $('#tabela').DataTable({
//                    "lengthMenu": [[10, 25, 50, 10, -1], [10, 25, 50, 100, "Todos"]],
//                    "order": [[0, "asc"]],
//                    "language": {
//                        "url": "/assets/lib/template/plugins/datatables/media/js/Portuguese-Brasil.json"
//                    },
//                    responsive: true
//                });
//                $("#tabela").show();
//            }
//        });
//    }
//    listaTipos();

    function listarCategoriaTipo() {
        $.ajax({
            "url": "/model/cha/administracao/categoriaTipo/request.php",
            "dataType": "html",
            "data": {
                "acao": "listarCategoriaTipo"
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
                        $("body").find("#nmCategoriaTipo").html("");
                        $("body").find("#idCategoriaPrincipal").html("0");
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
    listarCategoriaTipo();

    function listarCategoriaPrincipal() {
        $.ajax({
            "url": "/model/cha/administracao/categoriaTipo/request.php",
            "dataType": "html",
            "data": {
                "acao": "listarCategoriaPrincipal"
            },
            "success": function (response) {
                try {
                    response = JSON.parse(response);
                } catch (e) {
                    $("#idCategoriaPrincipal").append(response);
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
    listarCategoriaPrincipal();

    $('body').on('click', '.btn-salvar', function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else {
            e.preventDefault();
            var $this = $(this);
            $this.prop("disabled", true);
            var caTipo = {
                nmCaTipo: $("#nmCategoriaTipo").val(),
                idCatipo: $('#idCategoriaPrincipal').val()
            };

            $.ajax({
                "url": "/model/cha/administracao/categoriaTipo/request.php",
                "dataType": "html",
                "data": {
                    "acao": "cadastrarCategoriaTipo",
                    "caTipo": caTipo
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
            var caTipo = {
                idCategoriaTipo: $('#idCategoriaTipo').val(),
                nmCategoriaTipo: $('#nmCategoriaTipo').val(),
                idCategoriaPrincipal: $('#idCategoriaPrincipal').val()
            };

            $.ajax({
                "url": "/model/cha/administracao/categoriaTipo/request.php",
                "dataType": "html",
                "data": {
                    "acao": "editarCategoriaTipo",
                    "caTipo": caTipo
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
        var tipo = $this.closest('td').find('.btn-edit').attr("categoriaTipo");
        var principal = $this.closest('td').find('.btn-edit').attr("categoriaPrincipal");

        bootbox.confirm({
            title: func.msgCaixaDeConfirmacao,
            message: 'Você tem Certeza que Deseja Continuar com a Desativação do Registro <span class="text-danger">' + tipo + '</span> ?',
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
                    var caTipo = {
                        idCategoriaTipo: id,
                        nmCategoriaTipo: tipo,
                        idCategoriaPrincipal: principal
                    };

                    if (id === "" && tipo === "" && principal === "") {
                        func.modalAlert(func.msgPreencherCampos);
                        $this.prop("disabled", false);
                        return false;
                    }
                    $.ajax({
                        "url": "/model/cha/administracao/categoriaTipo/request.php",
                        "dataType": "html",
                        "data": {
                            "acao": "desativarCategoriaTipo",
                            "caTipo": caTipo
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
        var tipo = $this.closest('td').find('.btn-edit').attr("categoriaTipo");
        var principal = $this.closest('td').find('.btn-edit').attr("categoriaPrincipal");

        bootbox.confirm({
            title: func.msgCaixaDeConfirmacao,
            message: 'Você tem Certeza que Deseja Continuar com a Ativação do Registro <span class="text-danger">' + tipo + '</span> ?',
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
                    var caTipo = {
                        idCategoriaTipo: id,
                        nmCategoriaTipo: tipo,
                        idCategoriaPrincipal: principal
                    };

                    if (id === "" && tipo === "" && principal === "") {
                        func.modalAlert(func.msgPreencherCampos);
                        $this.prop("disabled", false);
                        return false;
                    }
                    $.ajax({
                        "url": "/model/cha/administracao/categoriaTipo/request.php",
                        "dataType": "html",
                        "data": {
                            "acao": "ativarCategoriaTipo",
                            "caTipo": caTipo
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
        var tipo = $this.closest('td').find('.btn-edit').attr("categoriaTipo");
        var principal = $this.closest('td').find('.btn-edit').attr("categoriaPrincipal");

        bootbox.confirm({
            title: func.msgCaixaDeConfirmacao,
            message: 'Você tem Certeza que Deseja Continuar com a Exclusão do Registro <span class="text-danger">' + tipo + '</span> ?',
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
                    var caTipo = {
                        idCategoriaTipo: id,
                        nmCategoriaTipo: tipo,
                        idCategoriaPrincipal: principal
                    };

                    if (id === "" && tipo === "" && principal === "") {
                        func.modalAlert(func.msgPreencherCampos);
                        $this.prop("disabled", false);
                        return false;
                    }
                    $.ajax({
                        "url": "/model/cha/administracao/categoriaTipo/request.php",
                        "dataType": "html",
                        "data": {
                            "acao": "removerCategoriaTipo",
                            "caTipo": caTipo
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
    
     $('body').on('click', '.btn-cancelar', function (e) {
        $(".btn-salvar").show();
        $(".btn-limpar").show();
        $(".btn-editar").hide();
        $(".btn-cancelar").hide();
        $("#categoriaTipo").val('');
        $("#categoriaPrincipal").select2('val', '0');
    });

    $('body').on('click', '.btn-edit', function (e) {
        e.preventDefault();
        var id = $(this).val();
        $('.btn-editar').val(id);       
        $("#nmCategoriaTipo").val($(this).attr('nome'));
        $("#idCategoriaPrincipal").val($(this).attr('id'));
        $('.btn-salvar').hide();
        $('.btn-editar').show();
        $("#nmCategoriaTipo").focus();

    });
    
    $('.modal-alert').on('shown.bs.modal', function (e) {
        $("#nmCategoriaTipo").focus();
    });


    $('body').on('keypress', '.formVinculo', function (e) {
        var key = e.which;
        if (key == 13) {
            $(".btn-salvar").trigger('click');
            return false;
        }
    });
});
