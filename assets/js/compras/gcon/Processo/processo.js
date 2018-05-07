$(document).ready(function () {

    func = new Funcoes();

    $.ajax({
        "url": "/layout/menus/compras/gcon/menu_gcon.php",
        "dataType": "html",
        "method": "POST",
        "success": function (response) {
            $("body").find("#menu_gcon").html(response);
        }
    });

    $("#data_process").mask("99/99/9999");

    $('#data_process').datepicker({
        format: 'dd/mm/yyyy',
        language: "pt-BR"
    });

    $('#data_process').datepicker().on('changeDate', function () {
        $('#data_process').datepicker('hide');
    });

    $("body").on("focus", "#valor_process", function () {
        $(this).priceFormat({
            prefix: '',
            centsSeparator: ',',
            thousandsSeparator: '.'
        });
    });
    $("body").on("focus", "#val_homo_process", function () {
        $(this).priceFormat({
            prefix: '',
            centsSeparator: ',',
            thousandsSeparator: '.'
        });
    });
    $("body").on("focus", "#val_tipo_gasto", function () {
        $(this).priceFormat({
            prefix: '',
            centsSeparator: ',',
            thousandsSeparator: '.'
        });
    });

    $('body').on('click', '.btn-limpar', function (e) {
        $('.btn-salvar').prop("disabled", false);
        $("#ADA_process").val("");
        $("#uni_cont_process").select2('val', '0');
        $("#nume_pregao_process").val("");
        $("#tipoGasto").select2('val', '0');
        $("#objeto_process").select2('val', '0');
        $("#abrangencia_process").select2('val', '0');
        $("#sit_acom_process").select2('val', '0');
        $("#modalidade_process").select2('val', '0');
        $("#centraisAtendimento").select2('val', '0');
        $("#data_process").val("");
        $("#val_tipo_gasto").val("");
        $("#val_homo_process").val("");
        $("#valor_process").val("");
        $("#anotacoes_process").val("");
    });

    $('body').find("select").select2({});

    function gerarCloneSelectCentrais() {
        $("#centrais").append(' <div class="centrais row">\n\
                                        <div class="col-md-4">\n\
                                            <div class="panel-body">Centrais de Atendimento: <span class="text-danger"><i class="glyphicon glyphicon-asterisk"></i></span>\n\
                                                <div class="centraisCampos">\n\
                                                    <select class="form-control selectCentrais" name="centraisAtendimento[]" required id="centraisAtendimento">\n\
                                                        <option value="0" selected="">Selecione uma central</option>\n\
                                                    </select>\n\
                                                </div>\n\
                                            </div>\n\
                                        </div><br>\n\
                                        <div class="col-md-3">\n\
                                            <div class="panel-body">\n\
                                                <button class="fa fa-remove btn btn-danger btn-removerCentral"></button>\n\
                                            </div>\n\
                                        <div>\n\
                                    </div>');

    }

    $("body").on("click", ".addCentrais", function (e) {
        e.preventDefault();
        gerarCloneSelectCentrais();
        $(".selectCentrais").select2({
            width: " 100%"
        });
        retornarCentrais();

    });

    $("body").on('click', '.btn-removerCentral', function (e) {
        e.preventDefault();
        var $this = $(this);
        $this.closest(".centrais").remove();
    });

    function gerarCloneSelectTipoGasto() {
        $("#tipogasto").append('<div class="tipoGastoCampos row">\n\
                                    <div class="col-md-4 ">\n\
                                        <div class="panel-body">Tipo de Gasto: <span class="text-danger"><i class="glyphicon glyphicon-asterisk"></i></span>\n\
                                            <select class="form-control tipoGastoSelect" name="tipoGasto">\n\
                                                <option value="0" selected>Selecione a categoria</option>\n\
                                            </select>\n\
                                        </div>\n\
                                    </div>\n\
                                    <div class="col-md-3">\n\
                                        <div class="panel-body">Valor do Tipo de Gasto: <span class="text-danger"><i class="glyphicon glyphicon-asterisk"></i></span>\n\
                                            <input class="form-control valorTipoGasto" type="text" name="val_tipo_gasto[]" id="val_tipo_gasto" placeholder="1.000.000,00">\n\
                                        </div>\n\
                                    </div><br>\n\
                                    <div class="col-md-3">\n\
                                        <div class="panel-body">\n\
                                            <button class="fa fa-remove btn btn-danger btn-removerTipoGasto"></button>\n\
                                        </div>\n\
                                    </div>\n\
                                </div>');
    }



    $("body").on("click", ".addTipoGastoValorHomologado", function (e) {
        e.preventDefault();
        gerarCloneSelectTipoGasto();
        $(".tipoGastoSelect").select2({
            width: " 100%"
        });
        retornaTipoDeGasto();

    });

    $("body").on('click', '.btn-removerTipoGasto', function (e) {
        e.preventDefault();
        var $this = $(this);
        $this.closest(".tipoGastoCampos").remove();
    });

    function retornaTipoDeGasto() {
        $.ajax({
            "url": "/model/compras/gcon/processo/request.php",
            "dataType": "html",
            "method": "POST",
            "data": {
                "acao": "retorna_tipo_de_gasto"
            },
            "success": function (response) {
                $(".tipoGastoSelect").append(response);
            }
        });
    }
    retornaTipoDeGasto();

    function retornarCentrais() {
        $.ajax({
            "url": "/model/compras/gcon/processo/request.php",
            "dataType": "html",
            "method": "POST",
            "data": {
                "acao": "listar_centrais"
            },
            "success": function (response) {
                $(".selectCentrais").append(response);
            }
        });
    }
    retornarCentrais();

    function retornaObjeto() {
        $.ajax({
            "url": "/model/compras/gcon/processo/request.php",
            "dataType": "html",
            "method": "POST",
            "data": {
                "acao": "retorna_objeto"
            },
            "success": function (response) {
                $("#objeto_process").append(response);
            }
        });
    }
    retornaObjeto();

    function retornarUnidades() {
        $.ajax({
            "url": "/model/compras/gcon/processo/request.php",
            "dataType": "html",
            "method": "POST",
            "data": {
                "acao": "retorna_unidade"
            },
            "success": function (response) {
                $("#uni_cont_process").append(response);
            }
        });
    }
    retornarUnidades();

    function retornaAreaAbragencia() {
        $.ajax({
            "url": "/model/compras/gcon/processo/request.php",
            "dataType": "html",
            "method": "POST",
            "data": {
                "acao": "retorna_area"
            },
            "success": function (response) {
                $("#abrangencia_process").append(response);
            }
        });
    }
    retornaAreaAbragencia();

    function retornaSituacao() {
        $.ajax({
            "url": "/model/compras/gcon/processo/request.php",
            "dataType": "html",
            "method": "POST",
            "data": {
                "acao": "retorna_situacao"
            },
            "success": function (response) {
                $("#sit_acom_process").append(response);
            }
        });
    }
    retornaSituacao();

    function retornaModalidade() {
        $.ajax({
            "url": "/model/compras/gcon/processo/request.php",
            "dataType": "html",
            "method": "POST",
            "data": {
                "acao": "retorna_modalidade"
            },
            "success": function (response) {
                $("#modalidade_process").append(response);
            }
        });
    }
    retornaModalidade();

    function retornaTecnicos() {
        $.ajax({
            "url": "/model/compras/gcon/processo/request.php",
            "dataType": "html",
            "method": "POST",
            "data": {
                "acao": "retorna_todos_tecnicos"
            },
            "success": function (response) {
                $("#tecnico_process").append(response);
            }
        });
    }
    retornaTecnicos();

    $('body').on('click', '.btn-salvar', function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else {
            e.preventDefault();
            var $this = $(this);
            $this.prop("disabled", false);

            var central = [];
            $('#centrais .centrais').each(function () {
                var $this = $(this);
                var centrais = $this.find('.selectCentrais').val();
                central.push(centrais);
            });

            var tipoDeGasto = [];
             $('#tipogasto .tipoGastoCampos').each(function () {
                var $this = $(this);
                var tpGast = $this.find('.tipoGastoSelect').val();
                var vlGast = $this.find('.valorTipoGasto').val();
                tipoDeGasto.push({'tpg': tpGast, 'valor': vlGast});
            });
            
            var processo = {
                ada_process: $("#ADA_process").val(),
                valor_estim_process: $("#valor_process").val(),
                uni_cont_process: $("#uni_cont_process").val(),
                data_process: $("#data_process").val(),
                nume_pregao_process: $("#nume_pregao_process").val(),
                centrais_atendimento: central,
                val_homo_process: $("#val_homo_process").val(),
                anotacoes_process: $("#anotacoes_process").val(),
                id_tipo_gasto: tipoDeGasto,
                id_objeto: $("#objeto_process").val(),
                id_area: $("#abrangencia_process").val(),
                id_situacao: $("#sit_acom_process").val(),
                id_modalidade: $("#modalidade_process").val(),
                id_tecnico: $("#tecnico_process").val()
            };
            
            if (processo.ada_process === "" & processo.uni_cont_process === "" & processo.id_tecnico === "" & processo.id_area === "" & processo.id_situacao === "" & processo.data_process === "" & tipoDeGasto === null & central === null){
                return func.modalAlert(func.msgPreencherCampos);
                return false;
            }
            
            $.ajax({
                "method": "POST",
                "url": "/model/compras/gcon/processo/request.php",
                "dataType": "html",
                "data": {
                    "acao": "cadastra_processo",
                    "cadProcesso": processo
                },
                "success": function (response) {
                    console.log(response);
                    $this.prop("disabled", false);
                    if (response.trim() === "SessaoExpirada") {
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
});