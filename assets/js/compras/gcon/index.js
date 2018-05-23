

$(document).ready(function () {
    //instacinado fucoes js
    func = new Funcoes();

    //pegando menu do gcon
    $.ajax({
        "url": "/layout/menus/compras/gcon/menu_gcon.php",
        "dataType": "html",
        "success": function (response) {
            $("body").find("#butao").append(response);
            $("body").find("#menu_gcon").append('<button class="btn btn-primary btn-rounded btn-novoProcesso" style="display: block; margin-left: 100px;margin-top: -32px" type="button">\n\
                            <i class="ion ion-plus-round" aria-hidden="true"></i> Novo Processo\n\
                        </button>');
            $("body").find("#menu_gcon").append('<button class="btn btn-primary btn-rounded btn-processosDsativados" style="display: block; margin-left: 245px;margin-top: -32px" type="button">\n\
                            <i class="ion-power" aria-hidden="true"></i> Processos Desativados\n\
                        </button>');
        }
    });
    
    $("#butao").mouseover(function () {
        $(".menuButton").show();
    })
    .mouseout(function () {
        $(".menuButton").hide();
    });
    
    $('body').on('click', '.btn-novoProcesso', function (e) {
        top.location = "/pages/compras/gcon/processo/processo.php";
    });
    
    $('body').on('click', '.btn-processosDsativados', function (e) {
        top.location = "/pages/compras/gcon/processo/processosDesativados.php";
    });
    //escodendo botões
    $(".btn-limpar").hide();
    $(".btn-editar").hide();

    //buscando o select option
    $('body').find("select").select2({});

    //função para retonar os anos no select option
    function retornarAno() {
        $.ajax({
            "url": "/model/compras/gcon/processo/request.php",
            "dataType": "html",
            "data": {
                "acao": "retorna_ano"
            },
            "success": function (response) {
                $("#ano_pesquisa").append(response);
            }
        });
    }
    retornarAno();

    //função para retonar as situações no select option
    function retornarSituacao() {
        $.ajax({
            "url": "/model/compras/gcon/processo/request.php",
            "dataType": "html",
            "data": {
                "acao": "retorna_situacao"
            },
            "success": function (response) {
                $("#sit_acom_pesquisa").append(response);
            }
        });
    }
    retornarSituacao();

    //função para retonar as modalidades no select option
    function retornarModalidade() {
        $.ajax({
            "url": "/model/compras/gcon/processo/request.php",
            "dataType": "html",
            "data": {
                "acao": "retorna_modalidade"
            },
            "success": function (response) {
                $("#modalidade_pesquisa").append(response);
            }
        });
    }
    retornarModalidade();

    //Função para retornar os técnicos no selec option
    function retornarTecnico() {
        $.ajax({
            "url": "/model/compras/gcon/processo/request.php",
            "dataType": "html",
            "data": {
                "acao": "retorna_tecnicos_processo"
            },
            "success": function (response) {
                $("#tec_pesquisa").append(response);
            }
        });
    }
    retornarTecnico();

    //função para retonar as categorias no select option
    function retornarTipoDeGasto() {
        $.ajax({
            "url": "/model/compras/gcon/processo/request.php",
            "dataType": "html",
            "data": {
                "acao": "retorna_tipo_de_gasto"
            },
            "success": function (response) {
                $("#tiposDeGasto").append(response);
            }
        });
    }
    retornarTipoDeGasto();

    function retornarCentrais() {
        $.ajax({
            "url": "/model/compras/gcon/processo/request.php",
            "dataType": "html",
            "method": "POST",
            "data": {
                "acao": "listar_centrais"
            },
            "success": function (response) {
                $("#centrais").append(response);
            }
        });
    }
    retornarCentrais();


    //função para retonar as areas no select option
    function retornarAreas() {
        $.ajax({
            "url": "/model/compras/gcon/processo/request.php",
            "dataType": "html",
            "data": {
                "acao": "retorna_area"
            },
            "success": function (response) {
                $("#abrang_pesquisa").append(response);
            }
        });
    }
    retornarAreas();

    //escondendo botão imprimir
    $("#tabela").hide();

    $('body').on('click', '.btn-edit', function (e) {
        var id_processo = $(this).val();
        top.location = "/pages/compras/gcon/processo/editarProcesso.php?idProcesso=" + id_processo;
    });

    $('body').on('click', '.btn-pesquisar', function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else {
            e.preventDefault();
            var ada = $("#ADA_pesquisa").val();
            var pregao = $("#num_pregao_pesquisa").val();
            var ano = $("#ano_pesquisa").val();
            var situacao = $("#sit_acom_pesquisa").val();
            var modalidade = $("#modalidade_pesquisa").val();
            var tecnico = $("#tec_pesquisa").val();
            var tipoDeGasto = $("#tiposDeGasto").val();
            var centrais = $("#centrais").val();
            var area = $("#abrang_pesquisa").val();

            $.ajax({
                "url": "/model/compras/gcon/processo/request.php",
                "dataType": "html",
                "method": 'POST',
                "data": {
                    "acao": "pesquisa_processo",
                    "ada": ada,
                    "pregao": pregao,
                    "ano": ano,
                    "situacao": situacao,
                    "modalidade": modalidade,
                    "tecnico": tecnico,
                    "tipoDeGasto": tipoDeGasto,
                    "area": area,
                    "centrais": centrais
                },
                "success": function (response) {
                    if (response.trim() == "SessaoExpirada") {
                        func.modalAlert(func.msgSemPermissao);
                        return false;
                    }

                    try {
                        response = JSON.parse(response);
                    } catch (e) {
                        $("#tabela").show();
                        func.carregaTabelaPadrao('tabela_pesquisa', response, [12], true);
                        return false;
                    }

                    if (response.tipoMsg === "Erro") {
                        if (response.tipoExibicao === "console") {
                            func.modalAlert(func.msgErroPadrao, 'danger');
                            return false;

                        } else if (response.tipoExibicao === "alert") {
                            $("body").find("#retorno_pesq").html("");
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
    });

    //Modal    
    $('body').on('click', '.btn-anexar', function (e) {
        $('#upload').modal();
        var id_processo = $(this).val();
        $("#id_processo").val(id_processo);
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
                        func.modalAlert(response.msg, 'danger');
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
    //Fim modal

    $('body').on('click', '.btn-remover', function (e) {

        var $this = $(this);
        var id = $this.val();
        var item = $this.closest('td').find('.btn-edit').attr("ada");

        bootbox.confirm({
            title: func.msgCaixaDeConfirmacao,
            message: 'Você tem Certeza que deseja continuar com a exclusão do proceso com o ADA/CPR: <span class="text-danger">' + item + '</span> ?',
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
                    var processo = {
                        id: id,
                        ada: item
                    };

                    if (id == "") {
                        func.modalAlert(func.msgPreencherCampos);
                        $this.prop("disabled", false);
                        return false;
                    }
                    $.ajax({
                        "url": "/model/compras/gcon/processo/request.php",
                        "method": "POST",
                        "dataType": "html",
                        "data": {
                            "acao": "exclui_processo",
                            "excluiProcesso": processo
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
                                    func.modalAlert(response.msg, 'danger');
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

    $("body").on("click", ".btn-imprimir", function () {
        var $this = $(this);
        var idProcesso = $this.val();
        window.open('/pages/compras/gcon/imprimir/imprimir.php?idProcesso=' + idProcesso, '_blank');
    });

    $("body").on("click", ".btn-imprimirTodos", function () {
        var ada = $("#ADA_pesquisa").val();
        var pregao = $("#num_pregao_pesquisa").val();
        var ano = $("#ano_pesquisa").val();
        var situacao = $("#sit_acom_pesquisa").val();
        var modalidade = $("#modalidade_pesquisa").val();
        var tecnico = $("#tec_pesquisa").val();
        var tipoGasto = $("#tiposDeGasto").val();
        var area = $("#abrang_pesquisa").val();
        var centrais = $("#centrais").val();
        window.open('/pages/compras/gcon/imprimir/imprimirTodos.php?ada=' + ada + "&centrais=" + centrais + "&pregao=" + pregao + "&ano=" + ano + "&situacao=" + situacao + "&modalidade=" + modalidade + "&tecnico=" + tecnico + "&tipoGasto=" + tipoGasto + "&area=" + area, '_blank');
    });

    $("#ADA_pesquisa").prop('disabled', true);
    $("#num_pregao_pesquisa").prop('disabled', true);
    $("#centrais").prop('disabled', true);
    $("#tiposDeGasto").prop('disabled', true);

    $("body").on("change", "#centrais", function () {
        var texto = $(this).val();
        if (texto != null || texto == 0) {
            $("#ano_pesquisa").select2('val', '0');
            $("#tec_pesquisa").select2('val', '0');
            $("#modalidade_pesquisa").select2('val', '0');
            $("#tiposDeGasto").select2('val', '0');
            $("#abrang_pesquisa").select2('val', '0');
            $("#sit_acom_pesquisa").select2('val', '0');

            $("#ADA_pesquisa").prop('disabled', true);
            $("#num_pregao_pesquisa").prop('disabled', true);
            $("#ano_pesquisa").prop('disabled', true);
            $("#sit_acom_pesquisa").prop('disabled', true);
            $("#modalidade_pesquisa").prop('disabled', true);
            $("#tec_pesquisa").prop('disabled', true);
            $("#tiposDeGasto").prop('disabled', true);
            $("#abrang_pesquisa").prop('disabled', true);
            $("#centrais").prop('disabled', false);
        } else {
            $("#ADA_pesquisa").prop('disabled', false);
            $("#num_pregao_pesquisa").prop('disabled', false);
            $("#ano_pesquisa").prop('disabled', false);
            $("#sit_acom_pesquisa").prop('disabled', false);
            $("#modalidade_pesquisa").prop('disabled', false);
            $("#tec_pesquisa").prop('disabled', false);
            $("#tiposDeGasto").prop('disabled', false);
            $("#abrang_pesquisa").prop('disabled', false);
            $("#centrais").prop('disabled', false);
        }
    });

    $("body").on("change", "#ADA_pesquisa", function () {
        var texto = $(this).val();
        if (texto.length > 0) {
            $("#num_pregao_pesquisa").prop('disabled', true);
            $("#ano_pesquisa").prop('disabled', true);
            $("#sit_acom_pesquisa").prop('disabled', true);
            $("#modalidade_pesquisa").prop('disabled', true);
            $("#tec_pesquisa").prop('disabled', true);
            $("#tiposDeGasto").prop('disabled', true);
            $("#abrang_pesquisa").prop('disabled', true);
            $("#centrais").prop('disabled', true);
        } else {
            $("#num_pregao_pesquisa").prop('disabled', false);
            $("#ano_pesquisa").prop('disabled', false);
            $("#sit_acom_pesquisa").prop('disabled', false);
            $("#modalidade_pesquisa").prop('disabled', false);
            $("#tec_pesquisa").prop('disabled', false);
            $("#tiposDeGasto").prop('disabled', false);
            $("#abrang_pesquisa").prop('disabled', false);
            $("#centrais").prop('disabled', false);
        }
    });

    $("body").on("change", "#num_pregao_pesquisa", function () {
        var texto = $(this).val();
        if (texto.length > 0) {
            $("#ADA_pesquisa").prop('disabled', true);
            $("#ano_pesquisa").prop('disabled', true);
            $("#sit_acom_pesquisa").prop('disabled', true);
            $("#modalidade_pesquisa").prop('disabled', true);
            $("#tec_pesquisa").prop('disabled', true);
            $("#tiposDeGasto").prop('disabled', true);
            $("#abrang_pesquisa").prop('disabled', true);
            $("#centrais").prop('disabled', true);
        } else {
            $("#ADA_pesquisa").prop('disabled', false);
            $("#ano_pesquisa").prop('disabled', false);
            $("#sit_acom_pesquisa").prop('disabled', false);
            $("#modalidade_pesquisa").prop('disabled', false);
            $("#tec_pesquisa").prop('disabled', false);
            $("#tiposDeGasto").prop('disabled', false);
            $("#abrang_pesquisa").prop('disabled', false);
            $("#centrais").prop('disabled', false);
        }
    });

    $("body").on("change", "#ano_pesquisa", function () {
        var texto = $(this).val();
        if (texto === 'Todos') {
            $("#tec_pesquisa").select2('val', '0');
            $("#modalidade_pesquisa").select2('val', '0');
            $("#tiposDeGasto").select2('val', '0');
            $("#abrang_pesquisa").select2('val', '0');
            $("#sit_acom_pesquisa").select2('val', '0');

            $("#ADA_pesquisa").prop('disabled', true);
            $("#num_pregao_pesquisa").prop('disabled', true);
            $("#sit_acom_pesquisa").prop('disabled', true);
            $("#modalidade_pesquisa").prop('disabled', true);
            $("#tec_pesquisa").prop('disabled', true);
            $("#tiposDeGasto").prop('disabled', true);
            $("#abrang_pesquisa").prop('disabled', true);
            $("#centrais").prop('disabled', true);
        } else {
            if (texto == 0 || texto == null) {
                $("#ADA_pesquisa").prop('disabled', false);
                $("#num_pregao_pesquisa").prop('disabled', false);
                $("#sit_acom_pesquisa").prop('disabled', false);
                $("#modalidade_pesquisa").prop('disabled', false);
                $("#tec_pesquisa").prop('disabled', false);
                $("#tiposDeGasto").prop('disabled', false);
                $("#abrang_pesquisa").prop('disabled', false);
                $("#centrais").prop('disabled', false);
            } else {
                $("#tec_pesquisa").select2('val', '0');
                $("#modalidade_pesquisa").select2('val', '0');
                $("#tiposDeGasto").select2('val', '0');
                $("#abrang_pesquisa").select2('val', '0');
                $("#sit_acom_pesquisa").select2('val', '0');

                $("#ADA_pesquisa").prop('disabled', true);
                $("#num_pregao_pesquisa").prop('disabled', true);
                $("#sit_acom_pesquisa").prop('disabled', false);
                $("#modalidade_pesquisa").prop('disabled', false);
                $("#tec_pesquisa").prop('disabled', false);
                $("#tiposDeGasto").prop('disabled', true);
                $("#abrang_pesquisa").prop('disabled', false);
                $("#centrais").prop('disabled', true);
            }
        }
    });

    $("body").on("change", "#sit_acom_pesquisa", function () {
        var texto = $(this).val();
        if (texto == null) {
            $("#ADA_pesquisa").prop('disabled', true);
            $("#num_pregao_pesquisa").prop('disabled', true);
            $("#ano_pesquisa").prop('disabled', false);
            $("#modalidade_pesquisa").prop('disabled', false);
            $("#tec_pesquisa").prop('disabled', false);
            $("#abrang_pesquisa").prop('disabled', false);
            $("#centrais").prop('disabled', true);
        } else {
            $("#ADA_pesquisa").prop('disabled', true);
            $("#num_pregao_pesquisa").prop('disabled', true);
            $("#ano_pesquisa").prop('disabled', false);
            $("#modalidade_pesquisa").prop('disabled', true);
            $("#tec_pesquisa").prop('disabled', true);
            $("#abrang_pesquisa").prop('disabled', false);
            $("#tiposDeGasto").prop('disabled', true);
            $("#centrais").prop('disabled', true);
        }
    });

    $("body").on("change", "#modalidade_pesquisa", function () {
        var texto = $(this).val();
        if (texto == 0 || texto == null) {
            $("#ADA_pesquisa").prop('disabled', true);
            $("#num_pregao_pesquisa").prop('disabled', true);
            $("#ano_pesquisa").prop('disabled', false);
            $("#sit_acom_pesquisa").prop('disabled', false);
            $("#tec_pesquisa").prop('disabled', false);
            $("#abrang_pesquisa").prop('disabled', false);
            $("#tiposDeGasto").prop('disabled', true);
            $("#centrais").prop('disabled', true);
        } else {
            $("#ADA_pesquisa").prop('disabled', true);
            $("#num_pregao_pesquisa").prop('disabled', true);
            $("#ano_pesquisa").prop('disabled', false);
            $("#sit_acom_pesquisa").prop('disabled', true);
            $("#tec_pesquisa").prop('disabled', true);
            $("#abrang_pesquisa").prop('disabled', true);
            $("#tiposDeGasto").prop('disabled', true);
            $("#centrais").prop('disabled', true);
        }
    });
    $("body").on("change", "#tec_pesquisa", function () {
        var texto = $(this).val();
        if (texto == 0 || texto == null) {
            $("#ADA_pesquisa").prop('disabled', true);
            $("#num_pregao_pesquisa").prop('disabled', true);
            $("#ano_pesquisa").prop('disabled', false);
            $("#sit_acom_pesquisa").prop('disabled', false);
            $("#modalidade_pesquisa").prop('disabled', false);
            $("#abrang_pesquisa").prop('disabled', false);
            $("#tiposDeGasto").prop('disabled', true);
            $("#centrais").prop('disabled', true);
        } else {
            $("#ADA_pesquisa").prop('disabled', true);
            $("#num_pregao_pesquisa").prop('disabled', true);
            $("#ano_pesquisa").prop('disabled', false);
            $("#sit_acom_pesquisa").prop('disabled', true);
            $("#modalidade_pesquisa").prop('disabled', true);
            $("#abrang_pesquisa").prop('disabled', true);
            $("#tiposDeGasto").prop('disabled', true);
            $("#centrais").prop('disabled', true);
        }
    });

    $("body").on("change", "#tiposDeGasto", function () {
        var texto = $(this).val();
        if (texto == 0 || texto == null) {
            $("#ADA_pesquisa").prop('disabled', false);
            $("#num_pregao_pesquisa").prop('disabled', false);
            $("#ano_pesquisa").prop('disabled', false);
            $("#sit_acom_pesquisa").prop('disabled', false);
            $("#modalidade_pesquisa").prop('disabled', false);
            $("#tec_pesquisa").prop('disabled', false);
            $("#abrang_pesquisa").prop('disabled', false);
            $("#centrais").prop('disabled', false);
        } else {
            $("#ADA_pesquisa").prop('disabled', true);
            $("#num_pregao_pesquisa").prop('disabled', true);
            $("#ano_pesquisa").prop('disabled', true);
            $("#sit_acom_pesquisa").prop('disabled', true);
            $("#modalidade_pesquisa").prop('disabled', true);
            $("#tec_pesquisa").prop('disabled', true);
            $("#abrang_pesquisa").prop('disabled', true);
            $("#centrais").prop('disabled', true);
        }
    });

    $("body").on("change", "#abrang_pesquisa", function () {
        var texto = $(this).val();
        if (texto == 0 || texto == null) {
            $("#ADA_pesquisa").prop('disabled', true);
            $("#num_pregao_pesquisa").prop('disabled', true);
            $("#ano_pesquisa").prop('disabled', false);
            $("#sit_acom_pesquisa").prop('disabled', false);
            $("#modalidade_pesquisa").prop('disabled', false);
            $("#tec_pesquisa").prop('disabled', false);
            $("#tiposDeGasto").prop('disabled', true);
            $("#centrais").prop('disabled', true);
        } else {
            $("#ADA_pesquisa").prop('disabled', true);
            $("#num_pregao_pesquisa").prop('disabled', true);
            $("#ano_pesquisa").prop('disabled', false);
            $("#sit_acom_pesquisa").prop('disabled', false);
            $("#modalidade_pesquisa").prop('disabled', true);
            $("#tec_pesquisa").prop('disabled', true);
            $("#tiposDeGasto").prop('disabled', true);
            $("#centrais").prop('disabled', true);
        }
    });

    $('body').on('keypress', '.formPesquisa', function (e) {
        var key = e.which;
        if (key == 13) {
            $(".btn-pesquisar").trigger('click');
            return false;
        }
    });

});
