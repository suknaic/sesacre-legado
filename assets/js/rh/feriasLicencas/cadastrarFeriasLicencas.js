$(document).ready(function () {
    //alert($("#id_get").val())

    //********************
    func = new Funcoes();
    //   func.carregaTabelaPadrao('tabela', null, [2]);
    //**********************************
    $(".data").mask("99/99/9999");
    //datapiker, plugins para data
    $('.data').datepicker({
        format: 'dd/mm/yyyy',
        language: "pt-BR"
    });
    $(".data").datepicker().on('changeDate', function () {
        $(".data").datepicker('hide');
    });
    $('body').on('keypress', '.data', function (e) {
        var key = e.which;
        if (key == 13) {
            $(".data").datepicker('hide');
        }
    });
    //****************************************************
    function listaSituacaoCombo() {
        $.ajax({
            "url": "/model/rh/funcionario/request.php",
            "dataType": 'html',
            "data": {
                acao: "listaSituacaoOption"
            },
            "success": function (response) {
                $("#id_situacao").append(response);
                $("#id_situacao").select2({
                    width: " 100%"
                });
                returnContratoEditar();
            }
        });
    }
    listaSituacaoCombo();
    //****************************************************
    function listaSituacao2Combo(idSituacao) {
        $.ajax({
            "url": "/model/rh/funcionario/request.php",
            "dataType": 'html',
            "data": {
                acao: "listaSituacaoOption",
                id: idSituacao
            },
            "success": function (response) {
                $("#id_situacao2").html(response);
                $("#id_situacao2").select2({
                    width: " 100%"
                });
            }
        });
    }

    //*****************************************************
    $('body').on('click', '.btn-salvar', function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else {
            e.preventDefault();
            //*****************************************
            var idContrato = $("#id_contrato").val();
            var idSituacao = $("#id_situacao").val();
            var data1 = $("#dt_inicio").val();
            var data2 = $("#dt_fim").val();
            //***************validações***************************
            if (idSituacao == 0) {
                func.modalAlert(func.msgPreencherCampos+" <strong>(Situação)</strong>");
                return;
            }
            if (data1 == "") {
                func.modalAlert(func.msgPreencherCampos+" <strong>(Data de Início)</strong>");
                return;
            }
            if ($("#dt_fim").val().length > 3) {

                var x = data1.split("/")[2].toString() + "/" + data1.split("/")[1].toString() + "/" + data1.split("/")[0].toString();
                var y = data2.split("/")[2].toString() + "/" + data2.split("/")[1].toString() + "/" + data2.split("/")[0].toString();

                var dataIni = new Date(x);
                var dataFim = new Date(y);

                if (dataIni > dataFim) {
                    func.modalAlert("A data Inicio não Pode ser Maior que a Data Fim.");
                    return;
                }
            }
            //***********************************************************************
            var DadosSituacao = {
                idContrato: idContrato,
                idSituacao: idSituacao,
                dtInicio: data1,
                dtFim: data2,
                dsObs: $("#ds_observacao").val()
            };
            //*************************salvar*****************************************
            $.ajax({
                "url": "/model/rh/funcionario/request.php",
                "dataType": 'html',

                "data": {
                    acao: "cadastraSituacao",
                    dadosSituacao: DadosSituacao
                },
                "success":
                        function (response) {
                            console.log(response);
                            if (response.trim() == "SessaoExpirada") {
                                func.modalAlert(func.msgSemPermissao);
                                return false;
                            }
                            try {
                                response = JSON.parse(response);
                            } catch (e) {
                                func.modalAlert(func.msgErroPadrao, 'danger');
                                console.log(response);
                                return false;
                            }
                            if (response.tipoMsg === "Erro") {
                                if (response.tipoExibicao === "console") {
                                    console.log(response);
                                    func.modalAlert(func.msgErroPadrao, 'danger');
                                    return false;
                                } else if (response.tipoExibicao === "alert") {
                                    func.modalAlert(response.msg);
                                    return false;
                                }
                            } else if (response.tipoMsg === "ok") {
                                func.modalAlert(response.msg, 'success');
                                func.fechaModalReload();
                                return false;
                            } else {
                                console.log(response);
                                func.modalAlert(func.msgErroPadrao, 'danger');
                                return false;
                            }
                        }
            });
        }
    });
    //**************************************************************************
    $('.modal-alert').on('hide.bs.modal', function () {
        var data1 = $("#dt_inicio").val();

        if ($("#id_situacao").val() == 0) {
            $("#id_situacao").trigger('focus');
        } else if ($("#dt_inicio").val() == "") {
            $("#dt_inicio").focus();
        }
    });
    //*************************************************************************
    $('body').on('click', '.btn-registrar', function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else {
            top.location.href = "/pages/rh/contrato/index.php";
        }
    });
    //************************************************************
    function returnContratoEditar() {
        var id_get = $("#id_get").val();
        var idContrato = id_get.split("/")[0];
        var idPessoaFisica = id_get.split("/")[1];
        var cpf = $("#cpf").val();
        $.ajax({
            "url": "/model/rh/funcionario/request.php",
            "dataType": "html",
            "method": "POST",
            "data": {
                "acao": "returnContratoEditar",
                "id_get": id_get,
                "cpf": cpf
            },
            "success":
                    function (response) {
                        try {
                            response = JSON.parse(response);
                        } catch (e) {
                            console.log(response);
                            return false;
                        }
                        //console.log(response);
                        $(".titulo").text(response[0]['nm_social']);
                        $("#id_contrato").val(idContrato);
                        $("#id_pessoa_fisica").val(idPessoaFisica);
                        returnHistorico(idContrato);
                    }
        });
    }
    //***************************************************
    function returnHistorico(idContrato) {
        $.ajax({
            "url": "/model/rh/funcionario/request.php",
            "dataType": "html",
            "data": {
                "acao": "returnHistorico",
                "idContrato": idContrato
            },
            "success":
                    function (response) {
                        func.carregaTabelaPadrao('tabela', response, [5], true);
                    }

        });
    }
    //******************************************************************************************
    $("body").on("click", ".editarLinha", function (e) {
        $('#modalContratoHistorico').modal('show');
        $idContratoHistorico = $(this).val();

        //listaSituacao2Combo();
        //**********************************************************************************
        //  $("#id_situacao2").val(0).change();
        $("#dt_inicio_editar").val("");
        $("#dt_fim_editar").val("");
        //**********************************************************************************
        $("#modal_titulo").text("Alteração de Situação ");
        $("#id_contrato_historico").val($idContratoHistorico);
        $("#dt_inicio_editar").val($(this).closest(".historicoLinha").find(".dataIni").attr("dt_inicio"));
        $("#dt_fim_editar").val($(this).closest(".historicoLinha").find(".dataFim").attr("dt_fim"));
        listaSituacao2Combo($(this).closest(".historicoLinha").find(".situacao").attr("idSituacao"));
        //$("#id_situacao2").val($(this).closest(".historicoLinha").find(".situacao").attr("idSituacao")).change();
    });
    //******************************************************************************************
    $("body").on("click", ".AtualizarItem", function () {

        $id_get = $("#id_get").val();
        $idContrato = $id_get.split("/")[0];
        $idContraHistorico = $("#id_contrato_historico").val();
        $idContratoSituacao = $("#id_situacao2").val();
        //**************************************************
        if ($idContratoSituacao == 0) {
            func.modalAlert(func.msgPreencherCampos + "<strong>(Situação)</strong>");
            $("#nr_ch_editar").focus();
            return;
        }
        if ($("#dt_inicio_editar").val() == "") {
            func.modalAlert(func.msgPreencherCampos + "<strong>(Data de Inicio da Função na Lotação)</strong>");
            $("#dt_inicio_editar").focus();
            return;
        }
        //*******************************

        //********data inicial da função na lotação tem de ser inferior a data final**********************
        if ($("#dt_fim_editar").val().length > 3) {
            var data1 = $("#dt_inicio_editar").val();
            var data2 = $("#dt_fim_editar").val();
            var x = data1.split("/")[2].toString() + "/" + data1.split("/")[1].toString() + "/" + data1.split("/")[0].toString();
            var y = data2.split("/")[2].toString() + "/" + data2.split("/")[1].toString() + "/" + data2.split("/")[0].toString();

            var dataIni = new Date(x);
            var dataFim = new Date(y);

            if (dataIni > dataFim) {
                func.modalAlert("A Data Inicio Não Pode ser Maior que a Data Fim.");
                return;
            }
        }
        var contratoId = $("#id_contrato").val();
//        var funcaoId = $("#id_funcao_editar").val();
//        var lotacaoId = $("#id_lotacao_editar").val();
        //***********************************************
        var DadosContratoHistorico = {
            idContrato: contratoId,
            idContratoHistorico: $idContratoHistorico,
            idContratoSituacao: $idContratoSituacao,
            dataIni: $("#dt_inicio_editar").val(),
            dataFim: $("#dt_fim_editar").val()
        };

        //************************************************
        $.ajax({
            "url": "/model/rh/funcionario/request.php",
            "dataType": "html",
            "data": {
                "acao": "atualizarContratoHistorico",
                "dadosContratoHistorico": DadosContratoHistorico

            },
            "success":
                    function (response) {
                        $('#modalContratoHistorico').modal('hide');
                        if (response.trim() == "SessaoExpirada") {
                            func.modalAlert(func.msgSemPermissao);
                            return false;
                        }

                        try {
                            response = JSON.parse(response);
                        } catch (e) {
                            func.modalAlert(func.msgErroPadrao, 'danger');
                            console.log(response);
                            return false;
                        }
                        if (response.tipoMsg === "Erro") {
                            if (response.tipoExibicao === "console") {
                                console.log(response);
                                func.modalAlert(func.msgErroPadrao, 'danger');
                                return false;
                            } else if (response.tipoExibicao === "alert") {
                                func.modalAlert(response.msg);
                                return false;
                            }
                        } else if (response.tipoMsg === "ok") {
                            func.modalAlert(response.msg, 'success');
                            returnHistorico(contratoId);
                            return false;
                        } else {
                            console.log(response);
                            func.modalAlert(func.msgErroPadrao, 'danger');
                            return false;
                        }
                    }
        })
        //falta

    });
    //******************************************************************************************
    $("body").on("click", ".excluirLinha", function (e) {
        //$(this).closest(".lotacaoLinha").remove();

        var idContratoHistorico = $(this).val();
        //**********************************************************************************
        $idContrato = $("#id_contrato").val();
        //**********************************************************************************
        bootbox.confirm({
            title: 'Caixa de Confirmação',
            message: 'Você tem Certeza que deseja Excluir:   <span class="text-danger"> O Historico da Situação </span>?',
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
                    $.ajax({
                        "url": "/model/rh/funcionario/request.php",
                        "dataType": "html",
                        "data": {
                            "acao": "excluirContratoHistorico",
                            "idContratoHistorico": idContratoHistorico
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
                                    func.modalAlert(response.msg);
                                    return false;
                                }
                            } else if (response.tipoMsg === "ok") {
                                func.modalAlert(response.msg, 'success');
                                returnHistorico($idContrato);
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
    //***************************************************
    //***************************************************
    //***************************************************
    //***************************************************
    $('.modal-alert').on('shown.bs.modal', function (e) {
        $("#nome").focus();
    });
    //**********************************************
    $('body').on('keypress', '.cpf', function (e) {
        var key = e.which;
        if (key == 13) {
            $(".btn-pesquisar").trigger('click');
            return false;
        }
    });

});
