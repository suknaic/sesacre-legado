$(document).ready(function () {

    func = new Funcoes();

    $(".btn-editar").hide();
    $(".btn-cancelar").hide();

    func.carregaTabelaPadrao('tabela', null, [1]);
//    var table = $('#tabela').DataTable({
//        "lengthMenu": [[10, 25, 50, 10, -1], [10, 25, 50, 100, "Todos"]],
//        "order": [[0, "asc"]],
//        "language": {
//            "url": "/assets/lib/template/plugins/datatables/media/js/Portuguese-Brasil.json"
//        },
//        responsive: true
//    });


    function listaStatuss() {
        $.ajax({
            "url": "/model/cha/administracao/status/request.php",
            "dataType": 'html',
            "data": {
                acao: "listaStatusTable"
            },
            "success": function (response) {
                if (response.trim() == "SessaoExpirada") {
                    func.modalAlert(func.msgSemPermissao);
                    return false;
                }

                try {
                    response = JSON.parse(response);
                } catch (e) {
                    func.carregaTabelaPadrao('tabela', response, [1], true);
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
    listaStatuss();

    $('body').on('click', '.btn-salvar', function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else {
            e.preventDefault();
            var $this = $(this);
            $this.prop("disabled", true);
            var Status = {
                nome: $("#nmStatus").val()
            };

            if ($("#nmStatus").val() == "") {
                func.modalAlert(func.msgPreencherCampos);
                $this.prop("disabled", false);
                return false;
            }

            $.ajax({
                "url": "/model/cha/administracao/status/request.php",
                "dataType": "html",
                "data": {
                    "acao": "cadStatus",
                    "status": Status
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
                        func.modalAlert(func.msgErroPadrao);
                        console.log("Parse JSON");
                        console.log(response);
                        return false;
                    }

                    if (response.tipoMsg === "Erro") {
                        if (response.tipoExibicao === "console") {
                            console.log('Console Mensagem');
                            console.log(response);
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
                        console.log(response);
                        func.modalAlert(func.msgErroPadrao);
                        return false;
                    }
                },
                "error": function (response) {
                    $this.prop("disabled", false);
                    console.log(response);
                    func.modalAlert(func.msgErroPadrao);
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
            var Status = {
                nome: $("#nmStatus").val(),
                id: $this.val()
            }

            if ($("#nmStatus").val() == "" || $this.val() == "") {
                func.modalAlert(func.msgPreencherCampos);
                $this.prop("disabled", false);
                return false;
            }

            $.ajax({
                "url": "/model/cha/administracao/status/request.php",
                "dataType": "html",
                "data": {
                    "acao": "edtStatus",
                    "status": Status
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
                        func.modalAlert(func.msgErroPadrao);
                        console.log("Parse JSON");
                        console.log(response);
                        return false;
                    }

                    if (response.tipoMsg === "Erro") {
                        if (response.tipoExibicao === "console") {
                            console.log('Console Mensagem');
                            console.log(response);
                            func.modalAlert(func.msgErroPadrao);
                            return false;
                        } else if (response.tipoExibicao === "alert") {
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
                        console.log('Ultimo else');
                        console.log(response);
                        func.modalAlert(func.msgErroPadrao);
                        return false;
                    }
                },
                "error": function (response) {
                    $this.prop("disabled", false);
                    console.log(response);
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
        var status = $this.closest('td').find('.btn-edit').attr("nome");

        bootbox.confirm({
            title: 'Caixa de Confirmação',
            message: 'Você tem Certeza que Deseja Continuar com a Exclusão do Registro <span class="text-danger">' + status + '</span>?',
            buttons: {
                'cancel': {
                    label: 'Não',
                    className: 'btn-default btn-rounded btn-rounded'
                },
                'confirm': {
                    label: 'Sim',
                    className: 'btn-primary btn-rounded btn-rounded'
                }
            },
            callback: function (result) {
                if (result) {
                    var Status = {
                        id: id
                    }

                    if (id == "") {
                        func.modalAlert(func.msgPreencherCampos);
                        $this.prop("disabled", false);
                        return false;
                    }

                    $.ajax({
                        "url": "/model/cha/administracao/status/request.php",
                        "dataType": "html",
                        "data": {
                            "acao": "remStatus",
                            "status": Status
                        },
                        "success": function (response) {
                            if (response.trim() == "SessaoExpirada") {
                                func.modalAlert(func.msgSemPermissao);
                                return false;
                            }

                            try {
                                response = JSON.parse(response);
                            } catch (e) {
                                func.modalAlert(func.msgErroPadrao);
                                console.log("Parse JSON");
                                console.log(response);
                                return false;
                            }

                            if (response.tipoMsg === "Erro") {
                                if (response.tipoExibicao === "console") {
                                    console.log('Console Mensagem');
                                    console.log(response);
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
                                console.log(response);
                                func.modalAlert(func.msgErroPadrao);
                                return false;
                            }
                        },
                        "error": function (response) {
                            console.log(response);
                            func.modalAlert(func.msgErroPadrao);
                            return false;
                        }
                    });


                }
            }
        });

    });

    $('body').on('click', '.btn-desativar', function (e) {
        var $this = $(this);
        var id = $this.val();
        var status = $this.closest('td').find('.btn-edit').attr("nome");

        bootbox.confirm({
            title: func.msgCaixaDeConfirmacao,
            message: 'Você tem Certeza que Deseja Continuar com a Desativação do Registro <span class="text-danger">' + status + '</span> ?',
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
                    var Status = {
                        id: id
                    };

                    if (id == "") {
                        func.modalAlert(func.msgPreencherCampos);
                        $this.prop("disabled", false);
                        return false;
                    }
                    $.ajax({
                        "url": "/model/cha/administracao/status/request.php",
                        "dataType": "html",
                        "data": {
                            "acao": "desStatus",
                            "status": Status
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
        var status = $this.closest('td').find('.btn-edit').attr("nome");

        bootbox.confirm({
            title: func.msgCaixaDeConfirmacao,
            message: 'Você tem Certeza que Deseja Continuar com a Ativação do Registro <span class="text-danger">' + status + '</span> ?',
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
                    var Status = {
                        id: id
                    };

                    if (id == "") {
                        func.modalAlert(func.msgPreencherCampos);
                        $this.prop("disabled", false);
                        return false;
                    }
                    $.ajax({
                        "url": "/model/cha/administracao/status/request.php",
                        "dataType": "html",
                        "data": {
                            "acao": "atiStatus",
                            "status": Status
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

    $('body').on('click', '.btn-edit', function (e) {
        e.preventDefault();
        var id = $(this).val();
        $('.btn-editar').val(id);
        $("#nmStatus").val($(this).attr('nome'));
        $('.btn-salvar').hide();
        $('.btn-limpar').hide();
        $('.btn-editar').show();
        $('.btn-cancelar').show();
        $("#nmStatus").focus();

    });
    $('body').on('click', '.btn-limpar', function (e) {
        $('.btn-salvar').prop("disabled", false);
        $('.btn-editar').prop("disabled", false);
        $('.btn-salvar').show();
        $('.btn-editar').val(0);
        $('.btn-editar').hide();
        $("#nmStatus").val("");

    });

    $('body').on('click', '.btn-cancelar', function (e) {
        $(".btn-salvar").show();
        $(".btn-limpar").show();
        $(".btn-editar").hide();
        $(".btn-cancelar").hide();
    });

    $('.modal-alert').on('shown.bs.modal', function (e) {
        $("#nmStatus").focus();
    });


    $('body').on('keypress', '.formStatus', function (e) {
        var key = e.which;
        if (key == 13) {
            $(".btn-salvar").trigger('click');
            return false;
        }
    });

});
