$(document).ready(function () {

    func = new Funcoes();
    
    $.ajax({
        "url": "/layout/menus/cha/material/botõesMaterial.php",
        "dataType": "html",
        "success": function (response) {
            $("body").find("#menu_material").html(response);
        }
    });
    
    $("#data_aquisicao").mask("99/99/9999");

    $("body").on("focus", "#valor", function () {
        $(this).priceFormat({
            prefix: '',
            centsSeparator: ',',
            thousandsSeparator: '.'
        });
    });

    $('#data_aquisicao').datepicker({
        format: 'dd/mm/yyyy',
        language: "pt-BR"
    });

    $('#data_aquisicao').datepicker().on('changeDate', function () {
        $('#data_aquisicao').datepicker('hide');
    });

    $('body').on('click', '.btn-limpar', function (e) {
        $('.btn-salvar').prop("disabled", false);
        $("#nm_material").val("");
        $("#id_unidade_medida").select2('val', '0');
        $("#data_aquisicao").val("");
        $("#qt_garantia").val("");
        $("#nm_patrimonio").val("");
        $("#valor").val("");
        $("#ds_modelo").val("");
        $("#ds_marca").val("");
        $("#ds_processador").val("");
        $("#ds_hd").val("");
        $("#ds_fonte").val("");
        $("#ds_wireless").select2('val', '0');
        $("#tp_estado").select2('val', '0');
        $("#qt_memoria_ram").val("");
        $("#nm_serie").val("");
    });

    $("#id_unidade_medida").select2();
    $("#ds_wireless").select2();
    $("#tp_estado").select2();

    function retornarUnidadesDeMedida() {
        var idUnidadeMedida = $("#idUnidadeMedida").val();
        $.ajax({
            "url": "/model/cha/administracao/material/request.php",
            "dataType": "html",
            "data": {
                "acao": "retornar_Unidades_De_Medida",
                "id": idUnidadeMedida
            },
            "success": function (response) {
                $("#id_unidade_medida").append(response);
            }
        });
    }
    retornarUnidadesDeMedida();
    
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
    
    $('body').on('click', '.btn-cancelar', function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else {
            top.location.href = "/pages/cha/administracao/material/";
        }
    });
    
    $('body').on('click', '.btn-salvar', function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else {
            e.preventDefault();
            var $this = $(this);
            $this.prop("disabled", true);
            var material = {
                nm_material: $("#nm_material").val(),
                id_unidade_medida: $("#id_unidade_medida").val(),
                data_aquisicao: $("#data_aquisicao").val(),
                ds_garantia: $("#qt_garantia").val(),
                nm_patrimonio: $("#nm_patrimonio").val(),
                valor: $("#valor").val(),
                ds_modelo: $("#ds_modelo").val(),
                ds_marca: $("#ds_marca").val(),
                ds_processador: $("#ds_processador").val(),
                ds_hd: $("#ds_hd").val(),
                ds_fonte: $("#ds_fonte").val(),
                ds_wireless: $("#ds_wireless").val(),
                tp_estado: $("#tp_estado").val(),
                qt_memoria_ram: $("#qt_memoria_ram").val(),
                nm_serie: $("#nm_serie").val()
            };

            if (material['nm_material'] === '' || material['id_unidade_medida'] === '0' || material['tp_estado'] === '0') {
                func.modalAlert(func.msgPreencherCampos);
                return false;
            } else {
                $.ajax({
                    "url": "/model/cha/administracao/material/request.php",
                    "dataType": "html",
                    "data": {
                        "acao": "cadastrar_material",
                        "dados": material
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
            var material = {
                id_material : $("#idMaterial").val(),
                nm_material: $("#nm_material").val(),
                id_unidade_medida: $("#id_unidade_medida").val(),
                data_aquisicao: $("#data_aquisicao").val(),
                ds_garantia: $("#qt_garantia").val(),
                nm_patrimonio: $("#nm_patrimonio").val(),
                valor: $("#valor").val(),
                ds_modelo: $("#ds_modelo").val(),
                ds_marca: $("#ds_marca").val(),
                ds_processador: $("#ds_processador").val(),
                ds_hd: $("#ds_hd").val(),
                ds_fonte: $("#ds_fonte").val(),
                ds_wireless: $("#ds_wireless").val(),
                tp_estado: $("#tp_estado").val(),
                qt_memoria_ram: $("#qt_memoria_ram").val(),
                nm_serie: $("#nm_serie").val()
            };

            if (material['nm_material'] === '' || material['id_unidade_medida'] === '0' || material['tp_estado'] === '0') {
                func.modalAlert(func.msgPreencherCampos);
                return false;
            } else {
                $.ajax({
                    "url": "/model/cha/administracao/material/request.php",
                    "dataType": "html",
                    "data": {
                        "acao": "editar_material",
                        "dados": material
                    },
                    "success": function (response) {
                        console.log(response);
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
                                top.location.href = "/pages/cha/administracao/material/";
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
});