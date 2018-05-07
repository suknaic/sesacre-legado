$(document).ready(function () {

    func = new Funcoes();

    $(".select").select2({
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
            "acao": "retornaTipoGasto",
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
            $("body").find("#fonte").html(response);
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
                $("body").find("#projeto").html(response);
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

    $("body").on("focus", ".valor", function () {
        $(this).priceFormat({
            prefix: '',
            centsSeparator: ',',
            thousandsSeparator: '.',
            centsLimit: 2
        });
    });

    $('body').on('click', '.btn-add', function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else {
            e.preventDefault();
            var Dados = {
                projeto: $("#projeto option:selected").val(),
                central: $("#central option:selected").val(),
                tipoDeGasto: $("#tipoDeGasto option:selected").val(),
                despesa: $("#despesa option:selected").val(),
                fonte: $("#fonte option:selected").val(),
                valor: $("#valor").val()
            }

            if (Dados.projeto == 0 || Dados.fonte == 0 || Dados.despesa == 0 || Dados.central == 0
                    || Dados.tipoDeGasto == 0 || Dados.valor == 0 || Dados.valor == '0,00') {
                func.modalAlert(func.msgPreencherCampos, "warning");
                return false;
            }

            var Texto = {
                projeto: $("#projeto option:selected").text(),
                central: $("#central option:selected").text(),
                tipoDeGasto: $("#tipoDeGasto option:selected").text(),
                despesa: $("#despesa option:selected").text(),
                fonte: $("#fonte option:selected").text(),
                valor: $("#valor").val()
            }

            var existe = false;
            $(".linhas").each(function (index) {
                if ($(this).attr('contrato') == Dados.contrato
                        && $(this).attr('central') == Dados.central
                        && $(this).attr('projeto') == Dados.projeto
                        && $(this).attr('tipoDeGasto') == Dados.tipoDeGasto
                        && $(this).attr('despesa') == Dados.despesa
                        && $(this).attr('fonte') == Dados.fonte
                        ) {
                    func.modalAlert("Já existe informações duplicadas.", "warning");
                    existe = true;
                    return false;
                }
            });
            if (existe) {
                return false;
            }

            var linha = "<tr class='linhas' \n\
                            projeto='" + Dados.projeto + "' \n\
                            central='" + Dados.central + "'\n\
                            tipoDeGasto='" + Dados.tipoDeGasto + "'\n\
                            despesa='" + Dados.despesa + "'\n\
                            fonte='" + Dados.fonte + "'\n\
                            valor='" + Dados.valor + "'>\n\
                            <td>" + Texto.central + "</td>\n\
                            <td>" + Texto.projeto + "</td>\n\
                            <td>" + Texto.tipoDeGasto + "</td>\n\
                            <td>" + Texto.despesa + "</td>\n\
                            <td>" + Texto.fonte + "</td>\n\
                            <td>" + Texto.valor + "</td>\n\
                            <td class='text-center excluirLinha' role='button'>\n\
                                <p class='fa fa fa-times inputPFa text-danger'></p>\n\
                            </td>\n\
                        </tr>";
            $("#registros").find('tbody').append(linha);
            $("#valor").val(0);
            $("#despesa").focus();
        }
    });

    $('body').on('keypress', '#valor', function (e) {
        var key = e.which;
        if (key == 13) {
            $(".btn-add").trigger('click');
            return false;
        }
    });

    $('body').on('click', '.excluirLinha', function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else {
            e.preventDefault();
            $(this).closest('.linhas').remove();
        }
    });

    function salvarReducao(d) {

        $.ajax({
            "url": "/model/orcamento/liberacaoCentral/request.php",
            "dataType": "html",
            "data": {
                "acao": "reducao",
                "dados": d,
                "ano": $("#ano option:selected").val()
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
                    func.modalAlert(response.msg, 'success');
                    func.fechaModalReload();
                    return false;
                } else {
                    console.log('Ultimo else');
                    console.log(response);
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

    $('body').on('click', '.btn-salvar', function (e) {

        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else {
            e.preventDefault();
            var $this = $(this);
            $this.prop("disabled", true);

            var Dados = [];

            $(".linhas").each(function (index) {
                Dados.push({
                    tipo: $(this).attr('tipo'),
                    contrato: $(this).attr("contrato"),
                    projeto: $(this).attr('projeto'),
                    central: $(this).attr('central'),
                    tipoDeGasto: $(this).attr("tipoDeGasto"),
                    despesa: $(this).attr('despesa'),
                    fonte: $(this).attr('fonte'),
                    valor: $(this).attr('valor')
                });
            });

            msg = 'Você tem Certeza que deseja continuar com essa Ação?';

            if (Dados.length < 1) {
                msg += ' <span class="text-danger">NÃO existe nenhum Registro a ser liberado</span>';
            }

            bootbox.confirm({
                title: 'Caixa de Confirmação',
                message: msg,
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
                        salvarReducao(Dados);
                    } else {
                        $(".btn-salvar").prop("disabled", false);
                    }
                }
            });

            $(".btn-salvar").prop("disabled", false);
        }
    });
});
