$(document).ready(function () {
    func = new Funcoes();

    //******** Carrega o select2 em todos os select's ********
    $('.select').select2({ width:"100%" });
    //********************************************************

    //********** Carrega todos os Estados no select **********
    function carregaEstados(idCidade = null) {
        $.ajax({
            "url": "/pages/sistema/cidade/request.php",
            "dataType": 'html',
            "data": {
                acao: "SelectEstadoOption",
                id_cidade: idCidade
            },

            "success": function (response) {
                $('#idEstado').html(response);
            }
        });
    }
    carregaEstados();

    function carregaRegiopnaisSaude(idRegional = null) {
        $.ajax({
            "url": "/pages/sistema/cidade/request.php",
            "dataType": 'html',
            "data": {
                acao: "SelectRegionalSaudeOption",
                id_regional: idRegional
            },

            "success": function (response) {
                $('#idRegionalSaude').html(response);
            }
        });
    }
    carregaRegiopnaisSaude();

    function carregaRegionaisGeo(idRegional = null) {
        $.ajax({
            "url": "/pages/sistema/cidade/request.php",
            "dataType": 'html',
            "data": {
                acao: "SelectRegionalGeoOption",
                id_regional: idRegional
            },

            "success": function (response) {
                $('#idRegionalGeografica').html(response);
            }
        });
    }
    carregaRegionaisGeo();
    //********************************************************

    //*********** Carregas dados da cidade ***********
    function carregaDadosCidade(){
        $.ajax({
            "url": "/pages/sistema/cidade/request.php",
            "dataType": 'html',
            "data": {
                acao: "carregaDadosCidade",
                "id_cidade": $('#id_cidade').val()
            },

            "success": function (response) {
                var dados = JSON.parse(response);
                if (dados.tipoMsg === "Erro") {
                    if (dados.tipoExibicao === "console") {
                        func.modalAlert(func.msgErroPadrao, 'danger');
                        return false;
                    } else if (dados.tipoExibicao === "alert") {
                        func.modalAlert(dados.msg, 'danger');
                        return false;
                    }
                } else if (dados.tipoMsg === "ok") {
                    func.modalAlert(dados.msg, 'success');
                    func.fechaModalReload();
                    return false;
                } else {
                    $.each(dados, function () {
                        $('#nmCidade').val(this.nm_cidade);
                        carregaEstados(this.id_estado);
                        carregaRegionaisGeo(this.id_regional_geo);
                        carregaRegiopnaisSaude(this.id_regional_saude)
                    });
                    $('.btn-salvar').hide();
                    $('.btn-voltar').hide();
                    $('.btn-editar').show();
                    $('.btn-cancelar').show();
                }
            }
        });
    }
    if ($('#id_cidade').val() != '') {
        carregaDadosCidade();
    }
    // ****************************************************************

    $('body').on('click', '.btn-salvar', function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else {
            e.preventDefault();
            var $this = $(this);
            $this.prop("disabled", true);
            var Cidade = {
                nome: $("#nmCidade").val(),
                regionalSaude: $("#idRegionalSaude").val(),
                regionalGeo: $("#idRegionalGeografica").val(),
                estado: $("#idEstado").val()
            };

            if (Cidade.nome == '' && (Cidade.estado == '' || Cidade.estado == 0)) {
                func.modalAlert(func.msgPreencherCampos);
                $this.prop("disabled", false);
                return false;
            }

            $.ajax({
                "url": "/pages/sistema/cidade/request.php",
                "dataType": "html",
                "data": {
                    "acao": "cadCidade",
                    "dados": Cidade
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
                        func.fechaModalHref('/pages/sistema/cidade/index.php');
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
            var Cidade = {
                id: $('#id_cidade').val(),
                nome: $("#nmCidade").val(),
                regionalSaude: $("#idRegionalSaude").val(),
                regionalGeo: $("#idRegionalGeografica").val(),
                estado: $("#idEstado").val()
            };

            if (Cidade.nome == '' && (Cidade.estado == '' || Cidade.estado == 0)) {
                func.modalAlert(func.msgPreencherCampos);
                $this.prop("disabled", false);
                return false;
            }

            $.ajax({
                "url": "/pages/sistema/cidade/request.php",
                "dataType": "html",
                "data": {
                    "acao": "edtCidade",
                    "dados": Cidade
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
                        func.fechaModalHref('/pages/sistema/cidade/index.php');
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

    $('.btn-cancelar').hide();

    $('body').on('click', '.btn-limpar', function (e) {
        $("#nmCidade").val("");
        $('#idRegionalGeografica').val('').trigger('change.select2');
        $('#idRegionalSaude').val('').trigger('change.select2');
        $('#idEstado').val('').trigger('change.select2');
    });

    $('body').on('click', '.btn-voltar', function (e) {
        top.location.href='/pages/sistema/cidade/index.php';
    });

    $('body').on('click', '.btn-cancelar', function (e) {
        top.location.href='/pages/sistema/cidade/index.php';
    });

    $('.modal-alert').on('shown.bs.modal', function (e) {
        $("#nmCidade").focus();
    });

    $('body').on('keypress', '.formCidade', function (e) {
        var key = e.which;
        if (key == 13) {
            $(".btn-salvar").trigger('click');
            return false;
        }
    });
});
