$(document).ready(function () {
    //instacinado fucoes js
    func = new Funcoes();
    func.carregaTabelaPadrao('tabela', null, [2], false);

    $('body').on('click', '.btn-novo', function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else {
            window.location.href = "/pages/financeiro/necessidade_central/pedido.php";

        }
    });

    $(".select").select2({
        width: " 100%"
    });

    $.ajax({
        "url": "/model/financeiro/necessidade_central/requestPedido.php",
        "dataType": 'html',
        "data": {
            "acao": "carregaLotacao"
        },
        "success": function (response) {
            $("body").find("#central").html(response);
            $(".select").select2({
            });
        }
    });

    //Listando cadfornecedores
    $.ajax({
        "url": "/model/compras/gestaoContratos/request.php",
        "dataType": 'html',
        "data": {
            "acao": "retornaFornecedor"
        },
        "success": function (response) {
            $("body").find("#contratado").html(response);
            $(".select").select2({
            });
        }
    });
    //fim

    //Listando tipo de gasto
    $.ajax({
        "url": "/model/compras/gestaoContratos/request.php",
        "dataType": 'html',
        "data": {
            "acao": "retornaTipoGasto"
        },
        "success": function (response) {
            $("body").find("#tipoGasto").html(response);
            $(".select").select2({
            });
        }
    });
    //fim

    $('body').on('click', '.btn-pesquisar', function (e) {
        var dados = {
            "numero": $("#numero").val(),
            "central": $("#central option:selected").val(),
            "ano": $("#ano option:selected").val(),
            "contratado": $("#contratado option:selected").val(),
            "tipoGasto": $("#tipoGasto option:selected").val()
        }

        $.ajax({
            "url": "/model/financeiro/necessidade_central/request.php",
            "method": "POST",
            "dataType": 'html',
            "data": {
                acao: "pesquisaPedido",
                dados: dados
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
                    return false;
                }

                if (response.tipoMsg === "Erro") {
                    if (response.tipoExibicao === "console") {
                        func.modalAlert(func.msgErroPadrao);
                        return false;
                    } else if (response.tipoExibicao === "alert") {
                        func.modalAlert(response.msg);
                        return false;
                    }
                } else if (response.tipoMsg === "ok") {
                    func.carregaTabelaPadrao('tabela', response.msg, [], true);
                } else {
                    console.log('Ultimo else');
                    func.modalAlert(func.msgErroPadrao);
                    return false;
                }
            }
        });
    });
});
