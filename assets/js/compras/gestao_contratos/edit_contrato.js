function gerarSelect2(classe) {
    $("." + classe).select2({
        width: " 100%"
    });
}


function gerarCloneSelect(campoPrincipal, campoSelect, select, classeremove) {
    var html = '';
    $("." + campoPrincipal).find('.' + select).select2('destroy');
    html = $("." + campoSelect).clone();
    html.find('.select2-selection--single').remove();
    html.find('.selectCentrais option:selected').removeAttr('selected');
    $("." + campoPrincipal).append('<div class = "form-group"><div class="col-sm-5"><div class="panel-body">' + html.html() +
            '</div></div><div class="col-sm-3"><div class="panel-body"><a href="#" class="' + classeremove + ' btn btn-danger">X</a></div></div></div>');
    gerarSelect2(select);
}

$(document).ready(function () {
    //instacinado fucoes js
    func = new Funcoes();
    //Mascara do sistema
    $('.data').mask("99/99/9999");
    //fim
    $(".select").select2({
        width: " 100%"
    });

    $(".selectCentrais").select2({
        width: " 100%"
    });

    //Efeito de adicionar mais uma Central
    var maxCentrais = 10;
    var contCentrais = $("#contCentral").val();
    $("body").on("click", ".addCentrais", function (e) {
        $("select[name=central\\[\\]]").each(function () {
            if ($(this).val() == 0 || $(this).val() == '') {
                clone = false;
            } else {
                clone = true;
            }
        });
        if (clone == true) {
            e.preventDefault();
            if (contCentrais < maxCentrais) {
                contCentrais++;
                gerarCloneSelect("campoCentrais", "centraisCampos", "selectCentrais", "removeCentrais");
            }
        } else {
            e.preventDefault();
            $('.selectCentrais').focus();
            func.modalAlert('Selecione Uma Central.');
        }
    });

    //Efeito de adicionar mais de um Gestor
    var maxGestores = 10;
    var contGestores = 1;
    $("body").on("click", ".addGestores", function (e) {
        $("select[name=gestores\\[\\]]").each(function () {
            if ($(this).val() == 0 || $(this).val() == '') {
                clone = false;
            } else {
                clone = true;
            }
        });
        if (clone == true) {
            e.preventDefault();
            if (contGestores < maxGestores) {
                contGestores++;
                gerarCloneSelect("campoGestores", "gestoresCampos", "selectGestores", "removeGestores");
            }
        } else {
            e.preventDefault();
            $('.selectGestores').focus();
            func.modalAlert('Selecione Um Gestor Titular.');
        }
    });


    //Efeito para remover um select de um Gestor
    $("body").on('click', '.removeGestores', function (e) {
        e.preventDefault();
        var $this = $(this);
        $this.closest(".form-group").remove();
        contGestores--;
    });

    //Efeito de adicionar mais de um Gestor Substituto
    var maxGestoresSub = 10;
    var contGestoresSub = 1;
    $("body").on("click", ".addGestorSubstituto", function (e) {
        $("select[name=gestoresSub\\[\\]]").each(function () {
            if ($(this).val() == 0 || $(this).val() == '') {
                clone = false;
            } else {
                clone = true;
            }
        });
        if (clone == true) {
            e.preventDefault();
            if (contGestoresSub < maxGestoresSub) {
                contGestoresSub++;
                gerarCloneSelect("campoGestoresSub", "gestoresCamposSub", "selectGestoresSub", "removeGestoresSub");
            }
        } else {
            e.preventDefault();
            $('.selectGestoresSub').focus();
            func.modalAlert('Selecione Um Gestor Substituto.');
        }
    });

    //Efeito para remover um select de um Gestores Substitutos
    $("body").on('click', '.removeGestoresSub', function (e) {
        e.preventDefault();
        var $this = $(this);
        $this.closest(".form-group").remove();
        contGestoresSub--;
    });

    //Efeito de adicionar mais de um Gestor Substituto
    var maxFiscais = 10;
    var contFiscais = 1;
    $("body").on("click", ".addFiscais", function (e) {
        $("select[name=fiscais\\[\\]]").each(function () {
            if ($(this).val() == 0 || $(this).val() == '') {
                clone = false;
            } else {
                clone = true;
            }
        });
        if (clone == true) {
            e.preventDefault();
            if (contFiscais < maxFiscais) {
                contFiscais++;
                gerarCloneSelect("campoFiscais", "fiscaisCampos", "selectFiscais", "removeFiscais");
            }
        } else {
            e.preventDefault();
            $('.selectFiscais').focus();
            func.modalAlert('Selecione Um Fiscal Titular.');
        }
    });

    //Efeito para remover um select de um Gestores Substitutos
    $("body").on('click', '.removeFiscais', function (e) {
        e.preventDefault();
        var $this = $(this);
        $this.closest(".form-group").remove();
        contFiscais--;
    });

    //Efeito de adicionar mais de um Fical Substituto
    var maxFiscaisSub = 10;
    var contFiscaisSub = 1;
    $("body").on("click", ".addFiscaisSub", function (e) {
        $("select[name=fiscaisSub\\[\\]]").each(function () {
            if ($(this).val() == 0 || $(this).val() == '') {
                clone = false;
            } else {
                clone = true;
            }
        });
        if (clone == true) {
            e.preventDefault();
            if (contFiscaisSub < maxFiscaisSub) {
                contFiscaisSub++;
                gerarCloneSelect("campoFiscaisSub", "fiscaisSubCampos", "selectFiscaisSub", "removeFiscaisSub");
            }
        } else {
            e.preventDefault();
            $('.selectFiscaisSub').focus();
            func.modalAlert('Selecione Um Fiscal Substituto.');
        }
    });

    //Efeito para remover um select de um Gestores Substitutos
    $("body").on('click', '.removeFiscaisSub', function (e) {
        e.preventDefault();
        var $this = $(this);
        $this.closest(".form-group").remove();
        contFiscaisSub--;
    });

    //Efeito de adicionar mais de um Gestor Substituto
    var maxSubFiscais = 10;
    var contSubFiscais = 1;
    $("body").on("click", ".addSubFiscais", function (e) {
        $("select[name=subFiscais\\[\\]]").each(function () {
            if ($(this).val() == 0 || $(this).val() == '') {
                clone = false;
            } else {
                clone = true;
            }
        });
        if (clone == true) {
            e.preventDefault();
            if (contSubFiscais < maxSubFiscais) {
                contSubFiscais++;
                gerarCloneSelect("campoSubFiscais", "SubFiscaisCampos", "selectSubFiscais", "removeSubFiscais");
            }
        } else {
            e.preventDefault();
            $('.selectSubFiscais').focus();
            func.modalAlert('Selecione Um Sub-Fiscal.');
        }
    });

    //Efeito para remover um select de um Gestores Substitutos
    $("body").on('click', '.removeSubFiscais', function (e) {
        e.preventDefault();
        var $this = $(this);
        $this.closest(".form-group").remove();
        contSubFiscais--;
    });

    //Efeito de adicionar mais de um Gestor Substituto
    var maxSubFiscaisSub = 10;
    var contSubFiscaisSub = 1;
    $("body").on("click", ".addSubFiscaisSub", function (e) {
        $("select[name=subFiscaisSub\\[\\]]").each(function () {
            if ($(this).val() == 0 || $(this).val() == '') {
                clone = false;
            } else {
                clone = true;
            }
        });
        if (clone == true) {
            e.preventDefault();
            if (contSubFiscaisSub < maxSubFiscaisSub) {
                contSubFiscaisSub++;
                gerarCloneSelect("campoSubFiscaisSub", "SubFiscaisCamposSub", "selectSubFiscaisSub", "removeSubFiscaisSub");
            }
        } else {
            e.preventDefault();
            $('.selectSubFiscaisSub').focus();
            func.modalAlert('Selecione Um Sub-Fiscal Substituto.');
        }
    });

    //Efeito para remover um select de um Gestores Substitutos
    $("body").on('click', '.removeSubFiscaisSub', function (e) {
        e.preventDefault();
        var $this = $(this);
        $this.closest(".form-group").remove();
        contSubFiscaisSub--;
    });

    //Efeito para remover um select de Centrais
    $("body").on('click', '.removeCentrais', function (e) {
        e.preventDefault();
        var $this = $(this);
        if (contCentrais > 1) {
            $this.closest(".form-group").remove();
            contCentrais--;
            var central = {
                "idContrato": $("#idContrato").val(),
                "idLotacao": $this.attr("idCentral")
            };
            $.ajax({
                "method": "POST",
                "url": "/model/compras/contrato/request.php",
                "dataType": 'html',
                "data": {
                    "acao": "removeCentral",
                    "dados": central
                },
                "success": function (response) {

                }
            });
        } else {
            func.modalAlert("Essa central não pode ser removida");
        }

    });
    //fim

    //No click carrega fornecedor  Pessoa Juridica
    $("body").on("click", "#cont_pj", function () {
        $.ajax({
            "url": "/model/compras/contrato/request.php",
            "dataType": 'html',
            "data": {
                "acao": "retornaPessoaJuridica"
            },
            "success": function (response) {
                $("body").find("#empresa").html(response);
            }
        });
    });
    //fim

    //Listando tipo de gasto
    $.ajax({
        "url": "/model/compras/contrato/request.php",
        "dataType": 'html',
        "data": {
            "acao": "retornarTipoDeGastoLicitacao",
            "idProcesso": $("#id_processo").val()
        },
        "success": function (response) {
            $("body").find("#tipoDeGasto").html(response);
            $(".select").select2({});
        }
    });
    //fim

    //carrega cnpj
    $("body").on("change", "#empresa", function () {
        $.ajax({
            "url": "/model/compras/ata/request.php",
            "dataType": 'html',
            "data": {
                "acao": "retornaCnpj",
                "id": $("#empresa option:selected").val()
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
                    $("#cnpj").val(response.msg);
                    return false;
                } else {
                    console.log('Ultimo else');
                    func.modalAlert(func.msgErroPadrao);
                    return false;
                }
            }
        });
    });


    //busca licitações
    $('#modalItem').on('shown.bs.modal', function () {
        $('#codItemPesquisa').focus();
    });

    $('body').on('click', '#btn-pesquisa', function (e) {
        var dados = $("#codItemPesquisa").val();
        if (dados == "" || dados.length < 2 || dados == " ") {
            alert("Pesquisa do Item precisa ter no mínimo 2 caracteres");
            return;
        }
        $.ajax({
            "url": "/model/compras/contrato/request.php",
            "dataType": 'html',
            "data": {
                acao: "retornaLicitacao"

            },
            "success": function (response) {
                func.carregaTabelaPadrao('tabelaItens', response, [], true);
            }
        });
    });

    $('body').on('click', '.selecionaItem', function (e) {
        var $this = $(this);
        $("#id_processo").val($this.attr('processo'));
        $("#ada_cpr").text($this.find("td:eq(0)").text());
        $("#licitacao").text($this.find("td:eq(1)").text());
        $("#obejto").text($this.find("td:eq(3)").text());
        $("#modalidade").text($this.find("td:eq(4)").text());
        $('#modalItem').modal('hide');
    });

    $("body").on('click', '#cofiguracaoAta', function (e) {
        if ($("body").find("input[name='cofiguracaoAta']:checked").length > 0) {

            $.ajax({
                "url": "/model/compras/ata/request.php",
                "dataType": 'html',
                "data": {
                    acao: "retornaOrgaoGerenciador"
                },
                "success": function (response) {
                    $("#orgao").html(response);
                }
            });
        } else {
            $("#orgao").html("");
        }


    });

    //carrega Fonte
    $.ajax({
        "url": "/model/compras/contrato/request.php",
        "dataType": 'html',
        "data": {
            "acao": "retornaOptionsFonte"
        },
        "success": function (response) {
            $("body").find("#fonte").html(response);
        }
    });
    //fim

    $("body").on("change", "#ano", function (e) {
        $("#fonte").change();
    });


    $("body").on("change", "#fonte", function (e) {
        var dados = {
            "fonte": $("#fonte").val(),
            "ano": $("#ano").val()

        };
        $.ajax({
            "url": "/model/compras/contrato/request.php",
            "dataType": 'html',
            "data": {
                "acao": "retornaProgramaPorFonte",
                "dados": dados
            },
            "success": function (response) {
                $("body").find("#programa").html(response);
            }
        });
    });


    $("body").on("click", ".btn-editar", function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else {
            e.preventDefault();
            var $this = $(this);
            $this.prop("disabled", true);
            //validação de campos js
            if ($("#num_ata").val() == "") {
                func.modalAlert(func.msgPreencherCampos);
                $this.prop("disabled", false);
                return false;
            }

            if ($("#empresa option:selected").val() == 0) {
                func.modalAlert(func.msgPreencherCampos);
                $this.prop("disabled", false);
                return false;
            }

            if ($("#data_assinatura").val() == "") {
                func.modalAlert(func.msgPreencherCampos);
                $this.prop("disabled", false);
                return false;
            }

            if ($("#data_publicacao").val() == "") {
                func.modalAlert(func.msgPreencherCampos);
                $this.prop("disabled", false);
                return false;
            }

            if ($("#vig_inicial").val() == "") {
                func.modalAlert(func.msgPreencherCampos);
                $this.prop("disabled", false);
                return false;
            }

            if ($("#vig_final").val() == "") {
                func.modalAlert(func.msgPreencherCampos);
                $this.prop("disabled", false);
                return false;
            }


            if ($("#desc_ata").val() == "") {
                func.modalAlert(func.msgPreencherCampos);
                $this.prop("disabled", false);
                return false;
            }

            var central = [];
            // $("select[name=central\\[\\]]").each(function () {
            //     central.push($(this).val());
            // });
            $("select[name=central\\[\\]]").each(function () {
                if ($(this).val() == 0 || $(this).val() == '') {
                    salva = false;
                } else {
                    salva = true;
                }
            });
            if (salva === false) {
                e.preventDefault();
                $('.selectCentrais').focus();
                func.modalAlert('Selecione Uma Central.');
                $this.prop("disabled", false);
                return;
            } else {
                $("select[name=central\\[\\]]").each(function () {
                    central.push($(this).val());
                });
            }

            var gestores = [];
            // $("select[name=gestores\\[\\]]").each(function () {
            //     gestores.push($(this).val());
            // });
            $("select[name=gestores\\[\\]]").each(function () {
                if ($(this).val() == 0 || $(this).val() == '') {
                    salvaGestores = false;
                } else {
                    salvaGestores = true;
                }

            });
            if (salvaGestores === false) {
                e.preventDefault();
                $('.selectGestores').focus();
                func.modalAlert('Selecione Um Gestor Títular.');
                $this.prop("disabled", false);
                return;
            } else {
                $("select[name=gestores\\[\\]]").each(function () {
                    gestores.push($(this).val());
                });
            }

            var gestoresSub = [];
            // $("select[name=gestoresSub\\[\\]]").each(function () {
            //     gestoresSub.push($(this).val());
            // });
            // $("select[name=gestoresSub\\[\\]]").each(function () {
            //     if ($(this).val() == 0 || $(this).val() == '') {
            //         salvaGestoresSub = false;
            //     } else {
            //         salvaGestoresSub = true;
            //     }
            //
            // });
            // if (salvaGestoresSub === false) {
            //     e.preventDefault();
            //     $('.selectGestoresSub').focus();
            //     func.modalAlert('Selecione Um Gestor Substituto.');
            //     $this.prop("disabled", false);
            //     return;
            // } else {
            $("select[name=gestoresSub\\[\\]]").each(function () {
                gestoresSub.push($(this).val());
            });
            // }

            var fiscais = [];
            // $("select[name=fiscais\\[\\]]").each(function () {
            //     fiscais.push($(this).val());
            // });
            $("select[name=fiscais\\[\\]]").each(function () {
                if ($(this).val() == 0 || $(this).val() == '') {
                    salvaFiscais = false;
                } else {
                    salvaFiscais = true;
                }

            });
            if (salvaFiscais === false) {
                e.preventDefault();
                $('.selectFiscais').focus();
                func.modalAlert('Selecione Um Fiscal Titular.');
                $this.prop("disabled", false);
                return;
            } else {
                $("select[name=fiscais\\[\\]]").each(function () {
                    fiscais.push($(this).val());
                });
            }

            var fiscaisSub = [];
            // $("select[name=fiscaisSub\\[\\]]").each(function () {
            //     fiscaisSub.push($(this).val());
            // });
            // $("select[name=fiscaisSub\\[\\]]").each(function () {
            //     if ($(this).val() == 0 || $(this).val() == '') {
            //         salvaFiscaisSub = false;
            //     } else {
            //         salvaFiscaisSub = true;
            //     }
            //
            // });
            // if (salvaFiscaisSub === false) {
            //     e.preventDefault();
            //     $('.selectFiscaisSub').focus();
            //     func.modalAlert('Selecione Um Fiscal Substituto.');
            //     $this.prop("disabled", false);
            //     return;
            // } else {
            $("select[name=fiscaisSub\\[\\]]").each(function () {
                fiscaisSub.push($(this).val());
            });
            // }

            var subFiscais = [];
            // $("select[name=subFiscais\\[\\]]").each(function () {
            //     subFiscais.push($(this).val());
            // });
            // $("select[name=subFiscais\\[\\]]").each(function () {
            //     if ($(this).val() == 0 || $(this).val() == '') {
            //         salvaSubFiscais = false;
            //     } else {
            //         salvaSubFiscais = true;
            //     }
            //
            // });
            // if (salvaSubFiscais === false) {
            //     e.preventDefault();
            //     $('.selectSubFiscais').focus();
            //     func.modalAlert('Selecione Um Sub-Fiscal.');
            //     $this.prop("disabled", false);
            //     return;
            // } else {
            $("select[name=subFiscais\\[\\]]").each(function () {
                subFiscais.push($(this).val());
            });
            // }

            var subFiscaisSub = [];
            // $("select[name=subFiscaisSub\\[\\]]").each(function () {
            //     subFiscaisSub.push($(this).val());
            // });
            // $("select[name=subFiscaisSub\\[\\]]").each(function () {
            //     if ($(this).val() == 0 || $(this).val() == '') {
            //         salvaSubFiscaisSub = false;
            //     } else {
            //         salvaSubFiscaisSub = true;
            //     }
            //
            // });
            // if (salvaSubFiscaisSub === false) {
            //     e.preventDefault();
            //     $('.selectSubFiscaisSub').focus();
            //     func.modalAlert('Selecione Um Sub-Fiscal Substituto.');
            //     $this.prop("disabled", false);
            //     return;
            // } else {
            $("select[name=subFiscaisSub\\[\\]]").each(function () {
                subFiscaisSub.push($(this).val());
            });
            // }

            var contrato = {
                "idFornecedor": $("#idFornecedor").val(),
                "id_contrato": $("#idContrato").val(),
                "num_cont": $("#num_cont").val(),
                "id_processo": $("#id_processo").val(),
                "tipoContratado": $("input[name='contratado']:checked").val(),
                "empresa": $("#empresa option:selected").val(),
                "desc_objeto": $("#desc_objeto").val(),
                "vig_inicial": $("#vig_inicial").val(),
                "vig_final": $("#vig_final").val(),
                "data_assinatura": $("#data_assinatura").val(),
                "data_publicacao": $("#data_publicacao").val(),
                "obs_contrato": $("#obs_contrato").val(),
                "central": central,
                "gestores": gestores,
                "gestoresSub": gestoresSub,
                "fiscais": fiscais,
                "fiscaisSub": fiscaisSub,
                "subFiscais": subFiscais,
                "subFiscaisSub": subFiscaisSub,
                "idTipoGasto": $("#tipoDeGasto").val()
            };

            $.ajax({
                "method": "POST",
                "url": "/model/compras/contrato/request.php",
                "dataType": "html",
                "data": {
                    "acao": "editarContrato",
                    "contrato": contrato
                },
                "success": function (response) {
                   console.log(response);
                   return false;
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
                        func.modalAlert("Edição do Contrato Realizado com Sucesso.", 'success');
                        $('.modal-alert').on('hidden.bs.modal', function (e) {
                            window.location.href = "/pages/compras/gestao_contratos/ver_contrato.php?&id=" + response.msg;
                        });
                        return false;
                    } else {
                        console.log(response);
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