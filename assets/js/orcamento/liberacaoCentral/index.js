$(document).ready(function () {

    func = new Funcoes();

    $(".select").select2({
        width: " 100%"
    });

    //carrega centrais
    $.ajax({
        "url": "/model/orcamento/liberacaoCentral/request.php",
        "dataType": 'html',
        "data": {
            "acao": "retornaCentrais"
        },
        "success": function (response) {
            $("body").find("#central").html(response);
        }
    });
    //fim

    //carrega tipo de gasto
    $.ajax({
        "url": "/model/orcamento/liberacaoCentral/request.php",
        "dataType": 'html',
        "data": {
            "acao": "retornaTipoGasto"
        },
        "success": function (response) {
            $("body").find("#tipoDeGasto").html(response);
        }
    });
    //fim

    //carrega fontes
    $.ajax({
        "url": "/model/orcamento/liberacaoCentral/request.php",
        "dataType": 'html',
        "data": {
            "acao": "retornaFonte"
        },
        "success": function (response) {
            $("body").find("#fonte").append(response);
        }
    });
    //fim

    $("body").on("change", "#ano", function () {
        $.ajax({
            "url": "/model/orcamento/liberacaoCentral/request.php",
            "dataType": 'html',
            "data": {
                "acao": "retornaProjetoAtividade",
                "ano": $("#ano").val()
            },
            "success": function (response) {
                $("body").find("#projeto").html('<option value="0">Selecione uma projeto/atividade</option> ');
                $("body").find("#projeto").append(response);
            }
        });
    });

    $("body").on("change", "#tipoDeGasto", function () {
        var dados = {
            "contrato": $("#tipoDeGasto").val()
        };
        //carrega tipo de gasto
        $.ajax({
            "url": "/model/orcamento/liberacaoCentral/request.php",
            "dataType": 'html',
            "data": {
                "acao": "retornaElemento",
                "dados": dados
            },
            "success": function (response) {
                $("body").find("#despesa").html(response);
            }
        });
        //fim
    });


    $('body').on('click', '.btn-novo-liberacao', function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else {
            window.location.href = "/pages/orcamento/liberacaoCentral/cad_liberacao.php";

        }
    });

    $('body').on('click', '.btn-novo-reducao', function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else {
            window.location.href = "/pages/orcamento/liberacaoCentral/red_liberacao_.php";

        }
    });

    $('body').on('click', '.btn-pesquisar', function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else {
            //zerando o tbody
            $("#tabela").find("tbody").html("");
            var Dados = {
                "ano": $("#ano option:selected").val(),
                "projeto": $("#projeto option:selected").val(),
                "central": $("#central option:selected").val(),
                "tipoDeGasto": $("#tipoDeGasto option:selected").val(),
                "despesa": $("#despesa option:selected").val(),
                "fonte": $("#fonte option:selected").val()
            };
            $.ajax({
                "url": "/model/orcamento/liberacaoCentral/request.php",
                "dataType": "html",
                "data": {
                    "acao": "buscaLiberacao",
                    "dados": Dados
                },
                "success": function (response) {
                    if (response.trim() === "SessaoExpirada") {
                        func.modalAlert(func.msgSemPermissao);
                        return false;
                    }

                    try {
                        response = JSON.parse(response);
                    } catch (e) {
                        func.modalAlert(func.msgErroPadrao);
                        console.log("Parse JSON");
                        console.log(response);
                        $(".btn-salvar").prop("disabled", false);
                        return false;
                    }

                    if (response.tipoMsg === "Erro") {
                        if (response.tipoExibicao === "console") {
                            console.log('Console Mensagem');
                            console.log(response);
                            func.modalAlert(func.msgErroPadrao);
                            $(".btn-salvar").prop("disabled", false);
                            return false;
                        } else if (response.tipoExibicao === "alert") {
                            func.modalAlert(response.msg);
                            $(".btn-salvar").prop("disabled", false);
                            return false;
                        }
                    } else if (response.tipoMsg === "ok") {
                        console.log(response);
                        func.carregaTabelaPadraoFoot('tabela', response.msg[0], response.msg[1], [4], true);
                        return false;
                    } else {
                        console.log('Ultimo else');
                        console.log(response.msg);
                        func.modalAlert(func.msgErroPadrao);
                        $(".btn-salvar").prop("disabled", false);
                        return false;
                    }
                },
                "error": function (response) {
                    console.log(response);
                    func.modalAlert(func.msgErroPadrao);
                    $(".btn-salvar").prop("disabled", false);
                    return false;
                }
            });
        }
    });
});