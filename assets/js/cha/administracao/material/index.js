$(document).ready(function () {

    func = new Funcoes();

    $.ajax({
        "url": "/layout/menus/cha/material/botõesMaterial.php",
        "dataType": "html",
        "success": function (response) {
            $("body").find("#menu_material").html(response);
        }
    });

    function retornarUnidadesDeMedida() {
        $.ajax({
            "url": "/model/cha/administracao/material/request.php",
            "dataType": "html",
            "method": "POST",
            "data": {
                "acao": "retornar_Unidades_De_Medida"
            },
            "success": function (response) {
                $("#id_unidade_medida").append(response);
            }
        });
    }
    retornarUnidadesDeMedida();

    $("body").on("change", "#nm_material", function () {
        var texto = $(this).val();
        if (texto.length > 0) {
            $("#nm_serie").prop('disabled', true);
            $("#nm_patrimonio").prop('disabled', true);
        } else {
            $("#nm_serie").prop('disabled', false);
            $("#nm_patrimonio").prop('disabled', false);
        }
    });

    $("body").on("change", "#nm_serie", function () {
        var texto = $(this).val();
        if (texto.length > 0) {
            $("#nm_material").prop('disabled', true);
            $("#nm_patrimonio").prop('disabled', true);
        } else {
            $("#nm_material").prop('disabled', false);
            $("#nm_patrimonio").prop('disabled', false);
        }
    });

    $("body").on("change", "#nm_patrimonio", function () {
        var texto = $(this).val();
        if (texto.length > 0) {
            $("#nm_material").prop('disabled', true);
            $("#nm_serie").prop('disabled', true);
        } else {
            $("#nm_material").prop('disabled', false);
            $("#nm_serie").prop('disabled', false);
        }
    });
    
    $(".esconder").hide();
    
    $('body').on('click', '.btn-novoMaterial', function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else {
            top.location.href = "/pages/cha/administracao/material/newMaterial/";

        }
    });
    
    $('body').on('click', '.btn-buscaMaterial', function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else {
            top.location.href = "/pages/cha/administracao/material/";

        }
    });
    
    $('body').on('click', '.btn-pesquisar', function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else {
            e.preventDefault();
            var $this = $(this);
            var material = {
                nm_material: $("#nm_material").val(),
                nm_serie: $("#nm_serie").val(),
                nm_patrimonio: $("#nm_patrimonio").val()
            };
            
            if (material['nm_material'] === '' && material['nm_serie'] === '' && material['nm_patrimonio'] === '') {
                func.modalAlert(func.msgPreencherCampos);
                return false;
            } else {
                $.ajax({
                    "url": "/model/cha/administracao/material/request.php",
                    "dataType": "html",
                    "method": 'POST',
                    "data": {
                        "acao": "pesquisar_material",
                        "dados": material
                    },
                    "success": function (response) {
                        if (response.trim() == "SessaoExpirada") {
                            func.modalAlert(func.msgSemPermissao);
                            return false;
                        }

                        try {
                            response = JSON.parse(response);
                        } catch (e) {
                            $(".esconder").show();
                            func.carregaTabelaPadrao('tabela', response, [], true);
                            return false;
                        }
                        
                        if (response.tipoMsg === "Erro") {
                            if (response.tipoExibicao === "console") {
                                func.modalAlert(func.msgErroPadrao, 'danger');
                                return false;

                            } else if (response.tipoExibicao === "alert") {
                                $("body").find("#nm_material").html("");
                                $("body").find("#nm_serie").html("");
                                $("body").find("#nm_patrimonio").html("");
                                func.modalAlert(response.msg);
                                return false;
                            }
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
            }
        }
    });
    
    $("body").on("click", ".btn-edit", function () {
        var $this = $(this);
        var idMaterial = $this.val();
        top.location = '/pages/cha/administracao/material/newMaterial/?idMaterial=' + idMaterial, '_blank';
    });
    
    $('body').on('click', '.btn-remover', function (e) {

        var $this = $(this);
        var id = $this.val();
        var material = $this.closest('td').find('.btn-edit').attr("material");
        
        bootbox.confirm({
            title: func.msgCaixaDeConfirmacao,
            message: 'Você tem Certeza que Deseja Continuar com a Exclusão do Registro <span class="text-danger">' + material + '</span> ?',
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
                        "url": "/model/cha/administracao/material/request.php",
                        "dataType": "html",
                        "data": {
                            "acao": "deletar_material",
                            "idMaterial": id
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