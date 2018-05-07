$(document).ready(function () {
    //instacinado fucoes js
    func = new Funcoes();
    func.carregaTabelaPadrao('tabela', null, [2], false);

    $('body').on('click', '.btn-novo', function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else {
            window.location.href = "/pages/financeiro/ordem/cadOrdem.php";

        }
    });

    $('body').on('click', '.pdf', function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else {
            var $this = $(this);
             if ($this.attr("tp") == 1) {
                window.open("/pages/financeiro/ordem/pdfBemProduto.php?id=" + $this.val());
            } else if ($this.attr("tp") == 2) {
                window.open("/pages/financeiro/ordem/pdfExecucaoServico.php?id=" + $this.val());
            }

        }
    });

    $(".select").select2({
        width: " 100%"
    });

    $.ajax({
        "url": "/model/financeiro/ordem/requestIndex.php",
        "dataType": 'html',
        "data": {
            "acao": "retornaCentrais"
        },
        "success": function (response) {
            $("body").find("#central").html(response);
        }
    });

    $('body').on('click', '.btn-pesquisar', function (e) {
        var dados = {
            "numero": $("#numero").val(),
            "central": $("#central").val(),
            "ano": $("#ano").val()
        }

        $.ajax({
            "url": "/model/financeiro/ordem/requestIndex.php",
            "dataType": 'html',
            "data": {
                acao: "pesquisaOrdem",
                dados: dados
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
