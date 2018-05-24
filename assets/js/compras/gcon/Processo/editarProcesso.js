$(document).ready(function () {

    func = new Funcoes();

    $.ajax({
        "url": "/layout/menus/compras/gcon/menu_gcon.php",
        "dataType": "html",
        "data" : {
            "menu" : 'menu_1'
        },
        "success": function (response) {
            $("body").find("#menu_gcon").append(response);
            $("body").find("#restoMenu").append('<li class="dropdown">\n\
                                                    <a href="/pages/compras/gcon/processo/processo.php">Novo Processo</a>\n\
                                                </li>\n\
                                                <li class="dropdown">\n\
                                                    <a href="/pages/compras/gcon/processo/processosDesativados.php">Processos Desativados</a>\n\
                                                </li>');
        }
    });
    
    $("#butao").mouseover(function () {
        $('#menu').css('display', 'block');
    }).mouseout(function () {
        $("#menu").mouseover(function () {
            $("#menu").css('display', 'block');
        }).mouseout(function () {
            $("#menu").css('display', 'none');
        });
    }).mouseout(function () {
        $("#menu").css('display', 'none');
    });
    
    $("#data_process").mask("99/99/9999");

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

    $('#data_process').datepicker({
        format: 'dd/mm/yyyy',
        language: "pt-BR"
    });

    $('#data_process').datepicker().on('changeDate', function () {
        $('#data_process').datepicker('hide');
    });

    $('body').on('click', '.btn-cancelar', function (e) {
        top.location = "/pages/compras/gcon/pesquisa/pesquisa.php";
    });

    //buscando o select option
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
        var tipoGasto = $("#id_categoria").val();
        $.ajax({
            "url": "/model/compras/gcon/processo/request.php",
            "dataType": "html",
            "method": "POST",
            "data": {
                "acao": "retorna_tipo_de_gasto",
                "tipo_gasto": tipoGasto
            },
            "success": function (response) {
                $(".tipoGastoSelect").append(response);
                $('.valorTipoGasto').priceFormat({
                    prefix: '',
                    centsSeparator: ',',
                    thousandsSeparator: '.'
                });
            }
        });
    }

    function retornaObjeto() {
        var id_objeto = $("#id_objeto").val();
        $.ajax({
            "url": "/model/compras/gcon/processo/request.php",
            "dataType": "html",
            "method": "POST",
            "data": {
                "acao": "retorna_objeto",
                "id_objeto": id_objeto
            },
            "success": function (response) {
                $("#objeto_process").append(response);
            }
        });

    }
    retornaObjeto();

    function retornaTecnicos() {
        var id_tecnico = $("#id_tecnico").val();
        $.ajax({
            "url": "/model/compras/gcon/processo/request.php",
            "dataType": "html",
            "method": "POST",
            "data": {
                "acao": "retorna_todos_tecnicos",
                "id_tecnico": id_tecnico
            },
            "success": function (response) {
                $("#tecnico_process").append(response);
            }
        });
    }
    retornaTecnicos();

    function retornaAreaAbragencia() {
        var id_area = $("#id_area").val();
        $.ajax({
            "url": "/model/compras/gcon/processo/request.php",
            "dataType": "html",
            "method": "POST",
            "data": {
                "acao": "retorna_area",
                "id_area": id_area
            },
            "success": function (response) {
                $("#abrangencia_process").append(response);
            }
        });
    }
    retornaAreaAbragencia();

    function retornaSituacao() {
        var id_situacao = $("#id_situacao").val();
        $.ajax({
            "url": "/model/compras/gcon/processo/request.php",
            "dataType": "html",
            "method": "POST",
            "data": {
                "acao": "retorna_situacao",
                "id_situacao": id_situacao
            },
            "success": function (response) {
                $("#sit_acom_process").append(response);
            }
        });
    }

    retornaSituacao();

    function retornaModalidade() {
        var id_modalidade = $("#id_modalidade").val();

        $.ajax({
            "url": "/model/compras/gcon/processo/request.php",
            "dataType": "html",
            "method": "POST",
            "data": {
                "acao": "retorna_modalidade",
                "id_modalidade": id_modalidade
            },
            "success": function (response) {
                $("#modalidade_process").append(response);
            }
        });
    }
    retornaModalidade();

    function retornaUnidades() {
        var id_unidade = $("#id_unidade").val();

        $.ajax({
            "url": "/model/compras/gcon/processo/request.php",
            "dataType": "html",
            "method": "POST",
            "data": {
                "acao": "retorna_unidade",
                "id_unidade": id_unidade
            },
            "success": function (response) {
                $("#uni_cont_process").append(response);
            }
        });
    }
    retornaUnidades();

    function carregaAnexos() {
        var id_processo = $("#id_processo").val();

        $.ajax({
            "url": "/model/compras/gcon/upload/uploadAnexo.php",
            "dataType": "html",
            "method": "POST",
            "data": {
                "acao": "carrega_anexos",
                "id_processo": id_processo
            },
            "success": function (response) {
                $("#anexos").html(response);
            }
        });
    }
    carregaAnexos();

    function carregaAnotacoes() {
        var id_processo = $("#id_processo").val();
        $.ajax({
            "url": "/model/compras/gcon/processo/request.php",
            "dataType": "html",
            "method": "POST",
            "data": {
                "acao": "listar_anotacoes",
                "idProcesso": id_processo
            },
            "success": function (response) {
                $("#anotacoes_process").html(response);
            }
        });
    }
    carregaAnotacoes();

    function carregarTipoGastoProcesso() {
        var id_processo = $("#id_processo").val();
        $.ajax({
            "url": "/model/compras/gcon/processo/request.php",
            "dataType": "html",
            "method": "POST",
            "data": {
                "acao": "carrega_tipo_gasto_processo",
                "id_processo": id_processo
            },
            "success": function (response) {
                $("#tipogasto").append(response);
                $(".tipoGastoSelect").select2({
                    width: " 100%"
                });
                $('.valorTipoGasto').priceFormat({
                    prefix: '',
                    centsSeparator: ',',
                    thousandsSeparator: '.'
                });
            }
        });
    }
    carregarTipoGastoProcesso();

    function carregarCentraisProcesso() {
        var id_processo = $("#id_processo").val();

        $.ajax({
            "url": "/model/compras/gcon/processo/request.php",
            "dataType": "html",
            "method": "POST",
            "data": {
                "acao": "carrega_central_processo",
                "id_processo": id_processo
            },
            "success": function (response) {
                $("#centrais").append(response);
                $(".selectCentrais").select2({
                    width: " 100%"
                });
            }
        });
    }
    carregarCentraisProcesso();
    retornaTipoDeGasto();
    retornarCentrais();

    $('body').on('click', '.btn-ExluirAnexo', function (e) {
        var id_anexo = $(this).attr('id_anexo');
        var anexo = $(this).attr('anexo');
        var dados = {
            id_anexo: id_anexo,
            id_processo: $('#id_processo').val(),
            anexo: anexo
        };
        $.ajax({
            "url": "/model/compras/gcon/upload/uploadAnexo.php",
            "dataType": "html",
            "method": "POST",
            "data": {
                "acao": "excluir_anexos",
                "dados": dados
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
    });


    $('body').on('click', '.btn-enviarUpload', function (e) {
        var tabela = document.getElementById('form-upload');
        var anexar = new FormData(tabela);

        $.ajax({
            url: '/model/compras/gcon/upload/uploadAnexo.php',
            data: anexar,
            processData: false,
            contentType: false,
            type: 'POST',

            "success": function (response) {
                if (response.trim() == "SessaoExpirada") {
                    $("#upload").modal('hide');
                    func.modalAlert(func.msgSemPermissao);
                    return false;
                }

                try {
                    response = JSON.parse(response);
                } catch (e) {
                    $("#upload").modal('hide');
                    func.modalAlert(func.msgErroPadrao, 'danger');
                    return false;
                }

                if (response.tipoMsg === "Erro") {
                    if (response.tipoExibicao === "console") {
                        $("#upload").modal('hide');
                        func.modalAlert(func.msgErroPadrao, 'danger');
                        return false;
                    } else if (response.tipoExibicao === "alert") {
                        $("#upload").modal('hide');
                        func.modalAlert(response.msg, 'warning');
                        return false;
                    }
                } else if (response.tipoMsg === "ok") {
                    $("#upload").modal('hide');
                    func.modalAlert(response.msg, 'success');
                    $('.modal-alert').on('hidden.bs.modal', function (e) {
                        location.reload();
                    });
                    return false;
                } else {
                    $("#upload").modal('hide');
                    func.modalAlert(func.msgErroPadrao, 'danger');
                    return false;
                }
            },
            "error": function (response) {
                $("#upload").modal('hide');
                func.modalAlert(func.msgErroPadrao, 'danger');
                return false;
            }
        });
    });

    $('body').on('click', '.btn-anexar', function (e) {
        $('#upload').modal();
    });

    $('body').on('click', '.btn-addAnotacao', function (e) {
        $('#adAnotacao').modal();
    });

    $('body').on('click', '.btn-enviarAnotacao', function (e) {
        var processo = {
            id_processo: $('#id_processo_anotacao').val(),
            anotacao: $('#anotacao').val()
        };
        $.ajax({
            "url": "/model/compras/gcon/processo/request.php",
            "method": "POST",
            "dataType": "html",
            "data": {
                "acao": "adicionar_anotacao",
                "dados": processo
            },

            "success": function (response) {
                if (response.trim() === "SessaoExpirada") {
                    $("#adAnotacao").modal('hide');
                    func.modalAlert(func.msgSemPermissao);
                    return false;
                }

                try {
                    response = JSON.parse(response);
                } catch (e) {
                    $("#adAnotacao").modal('hide');
                    func.modalAlert(func.msgErroPadrao, 'danger');
                    return false;
                }

                if (response.tipoMsg === "Erro") {
                    if (response.tipoExibicao === "console") {
                        $("#adAnotacao").modal('hide');
                        func.modalAlert(func.msgErroPadrao, 'danger');
                        return false;
                    } else if (response.tipoExibicao === "alert") {
                        $("#adAnotacao").modal('hide');
                        func.modalAlert(response.msg);
                        return false;
                    }
                } else if (response.tipoMsg === "ok") {
                    $("#adAnotacao").modal('hide');
                    func.modalAlert(response.msg, 'success');
                    $('.modal-alert').on('hidden.bs.modal', function (e) {
                        location.reload();
                    });
                    return false;
                } else {
                    $("#adAnotacao").modal('hide');
                    func.modalAlert(func.msgErroPadrao, 'danger');
                    return false;
                }
            },
            "error": function (response) {
                $("#adAnotacao").modal('hide');
                func.modalAlert(func.msgErroPadrao, 'danger');
                return false;
            }
        });

    });

    $('body').on('click', '.btn-editar', function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else {
            e.preventDefault();
            var central = [];
            $('#centrais .centrais').each(function () {
                var $this = $(this);
                var centrais = $this.find('.selectCentrais').val();
                central.push(centrais);
            });
            var tipoDeGasto = [];
            $('#tipogasto .tipoGastoCampos').each(function () {
                var $this = $(this);
                var idGast = $this.closest('.tipoGastoCampos').data('id');
                idGast = (idGast == null) ? 0 : idGast;
                var tpGast = $this.find('.tipoGastoSelect').val();
                var vlGast = $this.find('.valorTipoGasto').val();
                tipoDeGasto.push({'id': idGast, 'tpg': tpGast, 'valor': vlGast});
            });
            
            var processo = {
                id_processo: $("#id_processo").val(),
                ada_temp: $("#ada_temp").val(),
                ada_process: $("#ADA_process").val(),
                valor_estim_process: $("#valor_process").val(),
                id_unidade: $("#uni_cont_process").val(),
                data_process: $("#data_process").val(),
                nume_pregao_process: $("#nume_pregao_process").val(),
                val_homo_process: $("#val_homo_process").val(),
                tipo_gasto: tipoDeGasto,
                id_objeto: $("#objeto_process").val(),
                id_area: $("#abrangencia_process").val(),
                id_situacao: $("#sit_acom_process").val(),
                id_modalidade: $("#modalidade_process").val(),
                id_tecnico: $("#tecnico_process").val(),
                centrais_atendimento: central
            };
        
            if (processo.ada_process === "" & processo.id_unidade === "" & processo.id_tecnico === "" & processo.id_area === "" & processo.id_situacao === "" & processo.data_process === "" & tipoDeGasto === null & central === null) {
                return func.modalAlert(func.msgPreencherCampos);
                return false;
            }

            $.ajax({
                "url": "/model/compras/gcon/processo/request.php",
                "method": "POST",
                "dataType": "html",
                "data": {
                    "acao": "edita_processo",
                    "atualizaProcesso": processo
                },
                "success": function (response) {
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
                            location.href = "/pages/compras/gcon/pesquisa/pesquisa.php";
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
    });
    
     $('body').on('keypress', '.formEditar', function (e) {
        var key = e.which;
        if (key == 13) {
            $(".btn-editar").trigger('click');
            return false;
        }
    });
});