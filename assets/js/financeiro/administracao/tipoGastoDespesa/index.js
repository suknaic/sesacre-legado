$(document).ready(function () {
    //instacinado fucoes js
    func = new Funcoes();

    $(".select").select2({
        width: " 100%"
    });

    $.ajax({
        "url": "/model/financeiro/administracao/tipoGastoDespesa/request.php",
        "dataType": 'html',
        "data": {
            "acao": "retornaTipoGasto"
        },
        "success": function (response) {
            $("body").find("#tipoGasto").html(response);
        }
    });

    $.ajax({
        "url": "/model/financeiro/administracao/tipoGastoDespesa/request.php",
        "dataType": 'html',
        "data": {
            "acao": "retornaDespesa"
        },
        "success": function (response) {
            $("body").find("#despesa").html(response);
        }
    });

    $.ajax({
        "url": "/model/financeiro/administracao/tipoGastoDespesa/request.php",
        "dataType": 'html',
        "data": {
            "acao": "listaTipoDeGastoDespesa"
        },
        "success": function (response) {
            func.carregaTabelaPadrao('tabela', response, [], true);
        }
    });

    $("body").on("click", ".btn-salvar", function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else {
            e.preventDefault();
            var $this = $(this);
            $this.prop("disabled", true);
            //validação de campos js

            if ($("#tipoGasto").val() == "") {
                func.modalAlert(func.msgPreencherCampos);
                $this.prop("disabled", false);
                return false;
            }

            if ($("#despesa").val() == "") {
                func.modalAlert(func.msgPreencherCampos);
                $this.prop("disabled", false);
                return false;
            }


            var dados = {
                "tipoGasto": $("#tipoGasto").val(),
                "despesa": $("#despesa").val()

            }

            $.ajax({
                "url": "/model/financeiro/administracao/tipoGastoDespesa/request.php",
                "dataType": "html",
                "data": {
                    "acao": "cadastrarTipoDespesa",
                    "dados": dados
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
                        func.modalAlert(func.msgErroPadrao);
                        console.log("Parse JSON");
                        return false;
                    }

                    if (response.tipoMsg === "Erro") {
                        if (response.tipoExibicao === "console") {
                            console.log('Console Mensagem');
                            func.modalAlert(func.msgErroPadrao);
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
                        console.log('Ultimo else');
                        func.modalAlert(func.msgErroPadrao);
                        return false;
                    }
                },
                "error": function (response) {
                    $this.prop("disabled", false);
                    func.modalAlert(func.msgErroPadrao);
                    return false;
                }
            });
            $this.prop("disabled", false);
        }
    });
});
