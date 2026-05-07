function selectEmpenho() {
    $(".empenho").select2({
        width: " 100%"

    });
}

$(document).ready(function () {
    //instacinado fucoes js
    func = new Funcoes();

    //Esconde a div de empenhos
    $("#form_empenho").hide();
    //Mostrar a div de empenhos quando clicador
    $("body").on("click", "#emp_sim", function () {
        $("#form_empenho").show();
    });
    //Esconde a div de empenhos quando clicador
    $("body").on("click", "#emp_nao", function () {
        $("#form_empenho").hide();
    });
    //Mascara do sistema
    $("#num_pro").mask("99-99-9999999");
    $("#licitacao").mask("9999/9999");
    $("#arp").mask("9999/9999");
    $("#cont_num").mask("9999/9999");
    $("#cnpj").mask("99.999.999/9999-99");
    $("#doc_pro").mask("99-99-9999999");
    $(".ordem_num").mask("99999/9999");
    $("#competencia").mask("99/9999");
    //Masca para valor
    $("body").on("focus", "#documento_valor", function () {
        $(this).priceFormat({
            prefix: '',
            centsSeparator: ',',
            thousandsSeparator: '.'
        });
    });
    //datapiker, plugins para data
    $('#data_emissao').datepicker({
        format: 'dd/mm/yyyy',
        language: "pt-BR"
    });

    $('#data_atesto').datepicker({
        format: 'dd/mm/yyyy',
        language: "pt-BR"
    });


    $(".select").select2({
        width: " 100%"
    });

    /**
     * Adicionar empenho
     * **/
    var maxEmpenho = 5; //Maximo numero de empenho
    var campos = $(".input_empenho"); //campos inputs
    var add_button = $(".add_empenho"); //adicionar botão id
    var em = 1; //variavel contadora

    $("body").on("click", ".add_empenho", function (e) {
        e.preventDefault();
        if (em < maxEmpenho) { //condição dos inputs
            em++
            var htmlEmpenho = $(".clonempenho").clone();//clonando campos
            var htmlSaldo = $(".clonesaldo").clone();
            htmlEmpenho.find('.select2-selection--single').remove();
            htmlSaldo.find('.campoexcluir').append('<div class="input-group-btn"><button class="btn btn-default remove_field_empenho" type="button"><i class="fa fa-trash text-danger" aria-hidden="true"></i></button></div>');
            htmlEmpenho.find('.input-group').find('.select2').remove();
            $(".input_empenho").append('<div class = "form-group"><div class="clonempenho">' + htmlEmpenho.html() + '</div>' + htmlSaldo.html() + '</div>');
            selectEmpenho();
            $(".divRetira").removeClass('hidden');

        }
    });

    $(campos).on("click", ".remove_field_empenho", function (e) { //user click on remove text
        e.preventDefault();
        em--;
        $this = $(this);
        $this.closest('.form-group').remove()
    });

    $("body").on("change", ".empenho", function () {
        var empenho = {
            idEmpenho: $(this).val()
        }

        var $this = $(this);

        $.ajax({
            "url": "/model/financeiro/document_fiscais/unidades/request.php",
            "dataType": 'html',
            "data": {
                "acao": "retornaSaldo",
                "empenho": empenho
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
                        console.log('Console Mensagem');
                        func.modalAlert(func.msgErroPadrao);
                        return false;
                    } else if (response.tipoExibicao === "alert") {
                        func.modalAlert(response.msg);
                        return false;
                    }
                } else if (response.tipoMsg === "ok") {
                    $this.closest('.form-group').find('.emp_valor').val(response.msg);
                    return false;
                } else {
                    console.log('Ultimo else');
                    func.modalAlert(func.msgErroPadrao);
                    return false;
                }
            },
            "error": function (response) {
                func.modalAlert(func.msgErroPadrao);
                return false;
            }
        });
    });

    $("body").on("change", "#empresa", function () {
        var empresa = {
            empresa: $("#empresa").val()
        };
        $.ajax({
            "url": "/model/financeiro/document_fiscais/unidades/request.php",
            "dataType": 'html',
            "data": {
                "acao": "retornaCnpj",
                "empresa": empresa
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
                        console.log('Console Mensagem');
                        func.modalAlert(func.msgErroPadrao);
                        return false;
                    } else if (response.tipoExibicao === "alert") {
                        func.modalAlert(response.msg);
                        return false;
                    }
                } else if (response.tipoMsg === "ok") {
                    $("#cnpj").val(response.msg);
                    return false;
                } else {
                    console.log('Ultimo else');
                    func.modalAlert(func.msgErroPadrao);
                    return false;
                }
            },
            "error": function (response) {
                func.modalAlert(func.msgErroPadrao);
                return false;
            }
        });
    });

    $('body').on('click', '.btn-salvar', function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else {
            e.preventDefault();
            var $this = $(this);
            $this.prop("disabled", true);

            if ($("#modalidade option:selected").val() == "") {
                func.modalAlert(func.msgPreencherCampos);
                $this.prop("disabled", false);
                return false;
            }

            if ($("#empresa option:selected").val() == "") {
                func.modalAlert(func.msgPreencherCampos);
                $this.prop("disabled", false);
                return false;
            }

            if ($("#cnpj").val() == "") {
                func.modalAlert(func.msgPreencherCampos);
                $this.prop("disabled", false);
                return false;
            }

            if ($("#doc_pro").val() == "") {
                func.modalAlert(func.msgPreencherCampos);
                $this.prop("disabled", false);
                return false;
            }

            if ($("#documento_numero").val() == "") {
                func.modalAlert(func.msgPreencherCampos);
                $this.prop("disabled", false);
                return false;
            }

            if ($("#tipo_documento option:selected").val() == "") {
                func.modalAlert(func.msgPreencherCampos);
                $this.prop("disabled", false);
                return false;
            }

            if ($("#competencia").val() == "") {
                func.modalAlert(func.msgPreencherCampos);
                $this.prop("disabled", false);
                return false;
            }

            if ($("#data_emissao").val() == "") {
                func.modalAlert(func.msgPreencherCampos);
                $this.prop("disabled", false);
                return false;
            }

            if ($("#data_atesto").val() == "") {
                func.modalAlert(func.msgPreencherCampos);
                $this.prop("disabled", false);
                return false;
            }

            if ($("#documento_valor").val() == "") {
                func.modalAlert(func.msgPreencherCampos);
                $this.prop("disabled", false);
                return false;
            }

            //informações do empenho
            var empenhos_salvo = [];
            $(".empenho").each(function () {
                empenhos_salvo.push($(this).val());
            });
            var emp_valor = [];
            $("input[name=emp_valor\\[\\]]").each(function () {
                emp_valor.push($(this).val());
            });

            //pega valor da ordem
            var ordem = [];
            $("input[name=ordem\\[\\]]").each(function () {
                ordem.push($(this).val());
            });

            var documento = {
                num_pro: $("#num_pro").val(),
                licitacao: $("#licitacao").val(),
                modalidade: $("#modalidade").val(),
                arp: $("#arp").val(),
                cont_num: $("#cont_num").val(),
                empresa: $("#empresa").val(),
                doc_pro: $("#doc_pro").val(),
                documento_numero: $("#documento_numero").val(),
                tipo_documento: $("#tipo_documento").val(),
                competencia: $("#competencia").val(),
                data_emissao: $("#data_emissao").val(),
                data_atesto: $("#data_atesto").val(),
                documento_valor: $("#documento_valor").val(),
                requisicoes: $("#requisicoes").val(),
                observacao: $("#observacao").val()
            };

            $.ajax({
                "url": "/model/financeiro/document_fiscais/unidades/request.php",
                "dataType": "html",
                "data": {
                    "acao": "cadastrarDocumento",
                    "documento": documento,
                    "empenho": empenhos_salvo,
                    "ordem": ordem
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
