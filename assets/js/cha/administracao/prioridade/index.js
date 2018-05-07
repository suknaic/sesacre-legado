$(document).ready(function () {
    //instacinado fucoes js
    func = new Funcoes();
    //buscando o select option
    $("#classificacao").select2();
    $(".btn-editar").hide();
    $(".btn-cancelar").hide();

    $('body').on('click', '.btn-limpar', function (e) {
        $("#prioridade").val("");
        $("#classificacao").select2('val', '0');
    });

    function listarTodasPrioridades() {
        $.ajax({
            "url": "/model/cha/administracao/prioridade/request.php",
            "dataType": "html",
            "data": {
                "acao": "listarPrioridade"
            },
            "success": function (response) {
                if (response.trim() == "SessaoExpirada") {
                    func.modalAlert(func.msgSemPermissao);
                    return false;
                }

                try {
                    response = JSON.parse(response);
                } catch (e) {
                    func.carregaTabelaPadrao('tabela', response, [2], true);
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
    listarTodasPrioridades();

    $('body').on('click', '.btn-cancelar', function (e) {
        $(".btn-salvar").show();
        $(".btn-limpar").show();
        $(".btn-editar").hide();
        $(".btn-cancelar").hide();
        $("#prioridade").val('');
        $("#classificacao").select2('val', '0');
    });

    $('body').on('click', '.btn-edit', function (e) {
        $(".btn-salvar").hide();
        $(".btn-limpar").hide();
        $(".btn-editar").show();
        $(".btn-cancelar").show();
        $("#prioridade").val($(this).attr('prioridade'));
        $("#nmPrioridade").val($(this).attr('prioridade'));
        $("#classificacao").select2('val', $(this).attr('classificacao'));
        $("#idPrioridade").val($(this).val());
    });

    $('body').on('click', '.btn-salvar', function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else {
            e.preventDefault();
            var $this = $(this);
            $this.prop("disabled", true);
            var prioridade = {
                prioridade: $("#prioridade").val(),
                classificacao: $('#classificacao').val()
            };

            $.ajax({
                "url": "/model/cha/administracao/prioridade/request.php",
                "dataType": "html",
                "data": {
                    "acao": "cadastrarPrioridade",
                    "prioridade": prioridade
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
            var prioridade = {
                idPrioridade: $('#idPrioridade').val(),
                nmPrioridade: $('#prioridade').val(),
                csPrioridade: $('#classificacao').val(),
                veriNmPrioridade: $('#nmPrioridade').val()
            };

            $.ajax({
                "url": "/model/cha/administracao/prioridade/request.php",
                "dataType": "html",
                "data": {
                    "acao": "editarPrioridade",
                    "prioridade": prioridade
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
        var prioridade = $this.closest('td').find('.btn-edit').attr("prioridade");

        bootbox.confirm({
            title: func.msgCaixaDeConfirmacao,
            message: 'Você tem Certeza que Deseja Continuar com a Desativação do Registro <span class="text-danger">' + prioridade + '</span> ?',
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
                    var prioridade = {
                        idPrioridade: id
                    };

                    if (id === "") {
                        func.modalAlert(func.msgPreencherCampos);
                        $this.prop("disabled", false);
                        return false;
                    }
                    $.ajax({
                        "url": "/model/cha/administracao/prioridade/request.php",
                        "dataType": "html",
                        "data": {
                            "acao": "desativarPrioridade",
                            "prioridade": prioridade
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
        var prioridade = $this.closest('td').find('.btn-edit').attr("prioridade");

        bootbox.confirm({
            title: func.msgCaixaDeConfirmacao,
            message: 'Você tem Certeza que Deseja Continuar com a Ativação do Registro <span class="text-danger">' + prioridade + '</span> ?',
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
                    var prioridade = {
                        idPrioridade: id
                    };

                    if (id === "") {
                        func.modalAlert(func.msgPreencherCampos);
                        $this.prop("disabled", false);
                        return false;
                    }
                    $.ajax({
                        "url": "/model/cha/administracao/prioridade/request.php",
                        "dataType": "html",
                        "data": {
                            "acao": "ativarPrioridade",
                            "prioridade": prioridade
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
        var prioridade = $this.closest('td').find('.btn-edit').attr("prioridade");
        bootbox.confirm({
            title: func.msgCaixaDeConfirmacao,
            message: 'Você tem Certeza que Deseja Continuar com a Exclusão do Registro <span class="text-danger">' + prioridade + '</span> ?',
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
                    var prioridade = {
                        idPrioridade: id
                    };

                    if (id === "") {
                        func.modalAlert(func.msgPreencherCampos);
                        $this.prop("disabled", false);
                        return false;
                    }
                    $.ajax({
                        "url": "/model/cha/administracao/prioridade/request.php",
                        "dataType": "html",
                        "data": {
                            "acao": "removerPrioridade",
                            "prioridade": prioridade
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
