$(document).ready(function () {
    //instacinado fucoes js
    func = new Funcoes();

    //pegando menu do financeiro
    $.ajax({
        "url": "/layout/menus/financeiro/documento_fiscal/financeiro/menuFinanceiro.php",
        "dataType": "html",
        "success": function (response) {
            $("body").find("#menu_financeiro").html(response);
        }
    });

    //Mascara do sistema
    $("#comp_numero").mask("9999999999/9999");
    $("#comp_data").mask("99/99/9999");
    //Masca para valor
    $("body").on("focus", "#comp_valor", function () {
        $(this).priceFormat({
            prefix: '',
            centsSeparator: ',',
            thousandsSeparator: '.'
        });
    });
    //datapiker, plugins para data
    $('#comp_data').datepicker({
        format: 'dd/mm/yyyy',
        language: "pt-BR"
    });

    $("#empenhos_salvo").select2();

    $('body').on('click', '.btn-limpar', function (e) {
        $('.btn-salvar').prop("disabled", false);
        $("#empenhos_salvo").select2('val', '0');
        $("#comp_numero").val("");
        $("#comp_valor").val("");
        $("#comp_data").val("");
    });


    $('body').on('click', '.btn-salvar', function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else {
            e.preventDefault();
            var $this = $(this);
            $this.prop("disabled", true);


            if ($("#comp_numero").val() == "" || $("#comp_valor").val() == "") {

                func.modalAlert(func.msgPreencherCampos);
                $this.prop("disabled", false);
                return false;
            }

            if ($("#emp_valor").val() == "") {
                if ($("#comp_valor").val() == "") {
                    func.modalAlert(func.msgPreencherCampos);
                    $this.prop("disabled", false);
                    return false;
                }

                if ($("#emp_data").val() == "") {
                }

            }
            if ($("#comp_data").val() == "") {
                func.modalAlert(func.msgPreencherCampos);
                $this.prop("disabled", false);
                return false;
            }

            var empenho = {
                emp_numero: $("#emp_numero").val(),
                emp_valor: $("#emp_valor").val(),
                emp_data: $("#emp_data").val(),
                comp_numero: $("#comp_numero").val(),
                comp_valor: $("#comp_valor").val(),
                comp_data: $("#comp_data").val(),
                emp_id: $("#empenhos_salvo").val()
            }

            $.ajax({
                "url": "/model/financeiro/document_fiscais/financeiro/empenho/request.php",
                "dataType": "html",
                "data": {
                    "acao": "cadEmpenho",
                    "acao": "cadastrarComplemento",
                    "empenho": empenho
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
                        func.modalAlert(func.msgErroPadrao);
                        console.log("Parse JSON");
                        console.log(response);
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
                        func.modalAlert(response.msg);
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