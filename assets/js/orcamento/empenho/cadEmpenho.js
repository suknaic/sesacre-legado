$(document).ready(function () {
    //instacinado fucoes js
    func = new Funcoes();
    $("#nrEmpenho").mask("9999999999/9999");
    $("#dtEmpenho").mask("99/99/9999");
    //retornaTipo Do empenho
    $.ajax({
        "url": "/model/orcamento/empenho/request.php",
        "dataType": 'html',
        "data": {
            "acao": "tpEmpenho"
        },
        "success": function (response) {
            $("body").find("#tpEmpenho").html(response);
        }
    });
    //Masca para valor
    $("body").on("focus", "#vlEmpenho", function () {
        $(this).priceFormat({
            centsLimit: 4,
            prefix: '',
            centsSeparator: ',',
            thousandsSeparator: '.',
        });
    });

    $("body").on("click", ".btn-salvar", function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else {
            e.preventDefault();
            var $this = $(this);
            $this.prop("disabled", true);
            //validação de campos js
            if ($("#nrEmpenho").val() == "") {
                func.modalAlert(func.msgPreencherCampos);
                $this.prop("disabled", false);
                return false;
            }

            if ($("#tpEmpenho").val() == "") {
                func.modalAlert(func.msgPreencherCampos);
                $this.prop("disabled", false);
                return false;
            }

            if ($("#vlEmpenho").val() == "") {
                func.modalAlert(func.msgPreencherCampos);
                $this.prop("disabled", false);
                return false;
            }

            if ($("#dtEmpenho").val() == "") {
                func.modalAlert(func.msgPreencherCampos);
                $this.prop("disabled", false);
                return false;
            }
            var empenho = {
                "pedido": $("#pedido").val(),
                "nrEmpenho": $("#nrEmpenho").val(),
                "tpEmpenho": $("#tpEmpenho").val(),
                "vlEmpenho": $("#vlEmpenho").val(),
                "dtEmpenho": $("#dtEmpenho").val(),
                "obsEmpenho": $("#obsEmpenho").val(),
                "idLotacao": $("#remetente option:selected").data("lotacao"),
                "idDocTipoLotacao": $("#remetente option:selected").data("tipo-lotacao") 
            }
            $.ajax({
                "url": "/model/orcamento/empenho/request.php",
                "dataType": 'html',
                "method": 'post',
                "data": {
                    "acao": "salvaEmpenho",
                    "empenho": empenho
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
                            func.modalAlert(func.msgErroPadrao);
                            return false;
                        } else if (response.tipoExibicao === "alert") {
                            func.modalAlert(response.msg);
                            return false;
                        }
                    } else if (response.tipoMsg === "ok") {
                        func.modalAlert(response.msg, 'success');
                        $('.modal-alert').on('hidden.bs.modal', function (e) {
                            window.location.href = "/pages/orcamento/empenho/index.php";
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
        }
    });
    
    $('body').on('click', '.btn-addAnotacao', function (e) {
        $('#adAnotacao').modal();
    });

    $('body').on('click', '.btn-enviarAnotacao', function (e) {
        var Dados = {
            pedido: $('#pedido').val(),
            anotacao: $('#anotacao').val()
        };
        $.ajax({
            "url": "/model/orcamento/empenho/request.php",
            "method": "POST",
            "dataType": "html",
            "data": {
                "acao": "salvaAnotacao",
                "dados": Dados
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
});
      