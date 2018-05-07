$(document).ready(function () {

    func = new Funcoes();

    function retornarTodosTiposGastos() {
        $.ajax({
            "url": "/model/administracao/tipoGasto/request.php",
            "dataType": "html",
            "data": {
                "acao": "listar_tipo_gasto"
            },
            "success": function (response) {
                func.carregaTabelaPadrao('tabela', response, [], true);
                return false;
            }
        });
    }
    retornarTodosTiposGastos();

    $('body').on('click', '.btn-limpar', function (e) {
        $('#nm_tipo_gasto').val("");
    });
    
    $(".atualizar").hide();
    
    $('body').on('click', '.btn-edit', function (e) {
        $(".atualizar").show();
        $(".cadastrar").hide();
        $("#nmTipoGastoAntigo").val($(this).attr('tipoGasto'));
        $("#nm_tipo_gasto").val($(this).attr('tipoGasto'));
        $("#idTipoGasto").val($(this).val());
    });
    
    $('body').on('click', '.btn-cancelar', function (e) {
        $(".atualizar").hide();
        $(".cadastrar").show();
        $("#idTipoGasto").val("");
        $('#nm_tipo_gasto').val("");
    });
    
    $('body').on('click', '.btn-salvar', function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else {
            e.preventDefault();
            var $this = $(this);
            $this.prop("disabled", false);
            var tipoGasto = $('#nm_tipo_gasto').val();

            if (tipoGasto === '') {
                func.modalAlert(func.msgPreencherCampos);
                return false;
            } else {
                $.ajax({
                    "url": "/model/administracao/tipoGasto/request.php",
                    "dataType": "html",
                    "data": {
                        "acao": "cadastrar_tipo_gasto",
                        "dados": tipoGasto
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
        }
    });
    
    $('body').on('click', '.btn-atualizar', function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else {
            e.preventDefault();
            var $this = $(this);
            $this.prop("disabled", true);
            var idTipoGasto = $('#idTipoGasto').val();
            var nmTipoGasto = $('#nm_tipo_gasto').val();
            
            if (idTipoGasto === '' || nmTipoGasto === '') {
                func.modalAlert(func.msgPreencherCampos);
                return false;
            } else {
                $.ajax({
                    "url": "/model/administracao/tipoGasto/request.php",
                    "dataType": "html",
                    "data": {
                        "acao": "editar_tipo_gasto",
                        "idTipoGasto": idTipoGasto,
                        "nmTipoGastoNovo": nmTipoGasto
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
                        console.log(response);
                        $this.prop("disabled", false);
                        func.modalAlert(func.msgErroPadrao, 'danger');
                        return false;
                    }
                });
                $this.prop("disabled", false);
            }
        }
    });
    
    $('body').on('click', '.btn-remover', function (e) {

        var $this = $(this);
        var id = $this.val();
        var nmTipogasto = $this.closest('td').find('.btn-edit').attr("tipoGasto");
        
        bootbox.confirm({
            title: func.msgCaixaDeConfirmacao,
            message: 'Você tem Certeza que Deseja Continuar com a Exclusão do Registro <span class="text-danger">' + nmTipogasto + '</span> ?',
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
                    if (id === "") {
                        func.modalAlert(func.msgPreencherCampos);
                        $this.prop("disabled", false);
                        return false;
                    }
                    $.ajax({
                        "url": "/model/administracao/tipoGasto/request.php",
                        "dataType": "html",
                        "data": {
                            "acao": "desativar_tipo_gasto",
                            "idTipoGasto": id
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
});


