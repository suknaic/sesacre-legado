$(document).ready(function () {

    //******************************************************************************************
    func = new Funcoes();
    $("#cpf_servidor").mask("999.999.999-99");
    func.carregaTabelaPadrao('tabela', null, [8],true);
    //**************************************************************************
    $('body').on('click', '.btn-novoServidor', function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else {
            // top.location.href = "#";
            alert('Novo Servidor');
        }
    });
    //*************************************************************************
    $('body').on('click', '.btn-novoContrato', function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else {
            top.location.href = "/pages/rh/contrato/index.php";

        }
    });
    //************************************************************************
    $('body').on('click', '.btn-pesquisar', function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else {
            e.preventDefault();
            var servidor = {
                nomeServidor : $("#nm_servidor").val(),
                cpfServidor : $("#cpf_servidor").val()
            };

            if (servidor.nomeServidor === "" && servidor.cpfServidor === "") {
                func.modalAlert(func.msgPreencherCampos);
                return;
            }

            $.ajax({
                "url": "/pages/sistema/servidores/request.php",
                "dataType": 'html',
                "method": "POST",
                "data": {
                    acao: "listarFornecedor",
                    servidor: servidor
                },
                "success": function (response) {
                    try {
                        response = JSON.parse(response);
                    } catch (e) {
                        func.carregaTabelaPadrao('tabela', response, [8], true);
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
                }
            });
        }
    });


    $('body').on('click', '.btn-desativar', function (e) {
        var $this = $(this);
        var id = $this.val();
        var item = $this.closest('td').find('.btn-desativar').attr("nome");
        var idLotacao = id;
        bootbox.confirm({
            title: 'Caixa de Confirmação',
            message: 'Você tem Certeza que deseja Desativar:   <span class="text-danger">' + item + '</span>?',
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
                    var Lotacao = {
                        idLotacao: idLotacao

                    };

                    if (id == "") {
                        func.modalAlert(func.msgPreencherCampos);
                        $this.prop("disabled", false);
                        return false;
                    }

                    $.ajax({
                        "url": "/model/rh/lotacao/request.php",
                        "dataType": "html",
                        "data": {
                            "acao": "desativarLotacao",
                            "lotacao": Lotacao
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
                                return false;
                            }
                            if (response.tipoMsg === "Erro") {
                                if (response.tipoExibicao === "console") {
                                    func.modalAlert(func.msgErroPadrao);
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

    $('body').on('click', '.btn-ativar', function (e) {
        var $this = $(this);
        var id = $this.val();
        var item = $this.closest('td').find('.btn-ativar').attr("nome");
        var idLotacao = id;
        bootbox.confirm({
            title: 'Caixa de Confirmação',
            message: 'Você tem Certeza que deseja Desativar:   <span class="text-danger">' + item + '</span>?',
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
                    var Lotacao = {
                        idLotacao: idLotacao
                    };
                    if (id == "") {
                        func.modalAlert(func.msgPreencherCampos);
                        $this.prop("disabled", false);
                        return false;
                    }

                    $.ajax({
                        "url": "/model/rh/lotacao/request.php",
                        "dataType": "html",
                        "data": {
                            "acao": "ativarLotacao",
                            "lotacao": Lotacao
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
                                return false;
                            }

                            if (response.tipoMsg === "Erro") {
                                if (response.tipoExibicao === "console") {
                                    func.modalAlert(func.msgErroPadrao);
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

    $('body').on('click', '.btn-remove', function (e) {
        var $this = $(this);
        var id = $this.val();
        var item = $this.closest('td').find('.btn-ativar').attr("nome");
        var idLotacao = id;
        bootbox.confirm({
            title: 'Caixa de Confirmação',
            message: 'Você tem Certeza que deseja Excluir:   <span class="text-danger">' + item + '</span>?',
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
                    var Lotacao = {
                        idLotacao: idLotacao
                    };
                    if (id == "") {
                        func.modalAlert(func.msgPreencherCampos);
                        $this.prop("disabled", false);
                        return false;
                    }

                    $.ajax({
                        "url": "/model/rh/lotacao/request.php",
                        "dataType": "html",
                        "data": {
                            "acao": "removerLotacao",
                            "lotacao": Lotacao
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
                                return false;
                            }

                            if (response.tipoMsg === "Erro") {
                                if (response.tipoExibicao === "console") {
                                    func.modalAlert(func.msgErroPadrao);
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

    $('body').on('click', '.btn-edit', function (e) {
        e.preventDefault();
        var idLotacao = $(this).val();
        // top.location.href = "/pages/rh/lotacao/editaLotacao.php?id=" + idLotacao;
        alert('Edita Servidor');
    });

    $('body').on('click', '.btn-limpar', function (e) {
        $("#nm_servidor").val("");
        $("#cpf_servidor").val('');
    });

    $('.modal-alert').on('shown.bs.modal', function (e) {
        $("#nome").focus();
    });


    $('body').on('keypress', '.formPesquisaServidor', function (e) {
        var key = e.which;
        if (key == 13) {
            $(".btn-pesquisar").trigger('click');
            return false;
        }
    });

});
