func = new Funcoes();
func.carregaTabelaPadrao('tabela', null, [2]);
$('.obrigatorio').hide();
$('.btn-cancelar').hide();
//******************************************************************************************    
function listaEscolaridadeCombo() {
    $.ajax({
        "url": "/model/sistema/formacao/request.php",
        "dataType": 'html',
        "data": {
            acao: "listaEscolaridadeOption"
        },
        "success": function (response) {
            $("#id_escolaridade").append(response);
        }
    });
}
listaEscolaridadeCombo();
//**************************************************************************
$(document).ready(function () {

    $("#id_escolaridade").select2({});

    $('body').on('click', '.btn-pesquisar', function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else {
            e.preventDefault();
            var nome = $("#nm_formacao").val();
            var escolaridade = $("#id_escolaridade").val();
            
            $.ajax({
                "url": "/model/sistema/formacao/request.php",
                "dataType": 'html',
                "method": "POST",
                "data": {
                    acao: "listaFormacaoTable",
                    nome: nome,
                    escolaridade: escolaridade

                },
                "success": function (response) {
                    func.carregaTabelaPadrao('tabela', response, [2], true);
                }
            });
        }
    });
    //**********************************************************
    $('body').on('click', '.btn-salvar', function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else {
            e.preventDefault();
            var $this = $(this);
            $this.prop("disabled", true);
            var Formacao = {
                nome: $("#nm_formacao").val(),
                escolaridade: $("#id_escolaridade").val()
            };

            if ($("#nm_formacao").val() == "" || $("#id_escolaridade").val() == 0) {
                func.modalAlert(func.msgPreencherCampos);
                $this.prop("disabled", false);
                return false;
            }

            $.ajax({
                "url": "/model/sistema/formacao/request.php",
                "dataType": "html",
                "method": "POST",
                "data": {
                    "acao": "cadastrarFormacao",
                    "formacao": Formacao
                },
                "success": function (response) {
                    // console.log(response);
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
                        func.modalAlert(response.msg, "success");
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
            var Formacao = {
                nome: $("#nm_formacao").val(),
                escolaridade: $("#id_escolaridade").val(),
                id: $this.val()
            };

            if ($("#nm_formacao").val() == "" || $("#id_escolaridade").val() == 0) {
                func.modalAlert(func.msgPreencherCampos);
                $this.prop("disabled", false);
                return false;
            }

            $.ajax({
                "url": "/model/sistema/formacao/request.php",
                "dataType": "html",
                "method": "POST",
                "data": {
                    "acao": "editarFormacao",
                    "formacao": Formacao
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
                        func.modalAlert(response.msg, "success");
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
                    var Formacao = {
                        id: id
                    };

                    if (id == "") {
                        func.modalAlert(func.msgPreencherCampos);
                        $this.prop("disabled", false);
                        return false;
                    }

                    $.ajax({
                        "url": "/model/sistema/formacao/request.php",
                        "dataType": "html",
                        "method": "POST",
                        "data": {
                            "acao": "removerFormacao",
                            "formacao": Formacao
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
                                func.modalAlert(response.msg, "success");
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
    
    $('body').on('click', '.btn-desativar', function (e) {

        var $this = $(this);
        var id = $this.val();
        var item = $this.closest('td').find('.btn-desativar').attr("nome");

        bootbox.confirm({
            title: 'Caixa de Confirmação',
            message: 'Você tem Certeza que deseja continuar com a Desativação do Item <span class="text-danger">' + item + '</span>?',
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
                    var Formacao = {
                        id: id
                    };

                    if (id == "") {
                        func.modalAlert(func.msgPreencherCampos);
                        $this.prop("disabled", false);
                        return false;
                    }

                    $.ajax({
                        "url": "/model/sistema/formacao/request.php",
                        "dataType": "html",
                        "method": "POST",
                        "data": {
                            "acao": "desativarFormacao",
                            "formacao": Formacao
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
                                func.modalAlert(response.msg, "success");
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
    
    $('body').on('click', '.btn-ativar', function (e) {

        var $this = $(this);
        var id = $this.val();
        var item = $this.closest('td').find('.btn-ativar').attr("nome");

        bootbox.confirm({
            title: 'Caixa de Confirmação',
            message: 'Você tem Certeza que deseja continuar com a Ativação do Item <span class="text-danger">' + item + '</span>?',
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
                    var Formacao = {
                        id: id
                    };

                    if (id == "") {
                        func.modalAlert(func.msgPreencherCampos);
                        $this.prop("disabled", false);
                        return false;
                    }

                    $.ajax({
                        "url": "/model/sistema/formacao/request.php",
                        "dataType": "html",
                        "method": "POST",
                        "data": {
                            "acao": "ativarFormacao",
                            "formacao": Formacao
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
                                func.modalAlert(response.msg, "success");
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
    
    $('body').on('click', '.btn-novo', function (e) {
        $('.btn-salvar').prop("disabled", false);
        $('.btn-editar').prop("disabled", false);
        $('.btn-pesquisar').hide();
        $('.btn-editar').val(0);
        $('.btn-editar').hide();
        $('.btn-salvar').show();
        $('.btn-cancelar').show();
        $("#id_escolaridade").val(0).change();
        $("#nm_formacao").val("");
        $("#nm_formacao").focus();
        $('.obrigatorio').show();
    });

    $('body').on('click', '.btn-cancelar', function (e) {
        $('.btn-salvar').hide();
        $('.btn-salvar').prop("disabled", false);
        $('.btn-editar').prop("disabled", false);
        $('.btn-pesquisar').show();
        $('.btn-editar').val(0);
        $('.btn-editar').hide();
        $('.btn-cancelar').hide();
        $("#id_escolaridade").val(0).change();
        $("#nm_formacao").val("");
        $("#nm_formacao").focus();
        $('.obrigatorio').hide();
    });

    $('body').on('click', '.btn-edit', function (e) {
        e.preventDefault();
        var id = $(this).val();
        $('.btn-editar').val(id);
        $("#id_escolaridade").val($(this).attr('escolaridade')).change();
        $("#nm_formacao").val($(this).attr('nome'));
        $('.btn-salvar').hide();
        $('.btn-pesquisar').hide();
        $('.btn-editar').show();
        $("#nm_formacao").focus();
        $('.obrigatorio').show();
        $('.btn-cancelar').show();
    });
    $('body').on('click', '.btn-limpar', function (e) {
        $("#id_escolaridade").val(0).change();
        $("#nm_formacao").val("");

    });

    $('.modal-alert').on('shown.bs.modal', function (e) {
        $("#nm_formacao").focus();
    });


    $('body').on('keypress', '.formFormacao', function (e) {
        var key = e.which;
        if (key == 13) {
            $(".btn-pesquisar").trigger('click');
            return false;
        }
    });

});
