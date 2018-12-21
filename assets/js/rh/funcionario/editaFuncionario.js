$(document).ready(function () {

    func = new Funcoes();

    $(".select").select2({width: " 100%"});

    //***************************************** Retorna Dados do Contrato ***********************************************
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
                    //console.log(response);
                    try {
                        response = JSON.parse(response);
                    } catch (e) {
                        //                        console.log(response);
                        return false;
                    }
                    $cpf = response[0]['nr_cpf'].replace(/(\d{3})(\d{3})(\d{3})(\d{2})/g, "\$1.\$2.\$3\-\$4");
                    $("#nm_email").val(response[0]['nm_email']);
                    $("#nm_civil").val(response[0]['nm_civil']);
                    $("#nm_nome").val(response[0]['nm_social']);
                    $("#dt_nascimento").val(response[0]['dt_nascimento']);
                    //**************************************************************************
                    listaPaisNaturalidade(response[0]['id_pais_naturalidade']);
                    listaEstadoNaturalidade(response[0]['id_pais_naturalidade'],response[0]['id_estado_naturalidade']);
                    listaCidadeNaturalidade(response[0]['id_estado_naturalidade'], response[0]['id_naturalidade']);
                    //********************************************************************
                    $("#id_pessoa").val(response[0]['id_pessoa']);
                    $("#id_pessoa_fisica").val(response[0]['id_pessoa_fisica']);
                    $("#tp_sexo").val(response[0]['tp_sexo']).change();
                    $("#nr_cpf").val($cpf);
                    $("#nr_rg").val(response[0]['nr_rg']);
                    $("#ds_orgao_expedidor").val(response[0]['ds_orgao_expedidor']);
                    $("#nm_mae").val(response[0]['nm_mae']);
                    $("#nm_pai").val(response[0]['nm_pai']);
                    $("#nr_cns").val(response[0]['nr_cns']);
                    $("#ds_habilidade").val(response[0]['ds_habilidade']);
                    $("#ds_logradouro").val(response[0]['ds_logradouro']);
                    $("#ds_complemento").val(response[0]['ds_complemento']);
                    $("#ds_bairro").val(response[0]['ds_bairro']);
                    $("#nr_cep").val(response[0]['nr_cep']);
                    $("#nr_cep").mask("99999-999");
                    // $("#id_estado").val(response[0]['id_estado_orgao_expedidor']).change();
                    listaOrgaoExpeditor(response[0]['id_estado_orgao_expedidor']);
                    listaEstadoCivilCombo(response[0]['id_estado_civil']);
                    listaEscolaridadeCombo(response[0]['id_escolaridade']);
                    //**********************************************************************
                    //$("#id_cidade").val(response[0]['id_cidade']).change();
                    listaPaisEndereco(response[0]['id_pais_endereco']);
                    listaEstadoEndereco(response[0]['id_pais_endereco'], response[0]['id_estado_endereco']);
                    listaCidadeEndereco(response[0]['id_estado_endereco'], response[0]['id_cidade']);
                    //*************************************************************************
                    $("#nr_telefone_residencial").val(response[0]['nr_telefone_residencial']);
                    $("#nr_telefone_celular").val(response[0]['nr_telefone_celular']);
                    $("#nr_telefone_residencial").mask("(99) 9999-9999");
                    $("#nr_telefone_celular").mask("(99) 9 9999-9999");
                    $("#ds_observacao").val(response[0]['ds_observacao']);
                    $("#id_contrato").val(response[0]['id_contrato']);
                    $("#dt_admissao").val(response[0]['dt_admissao']);
                    $("#dt_demissao").val(response[0]['dt_demissao']);
                    $("#nr_carga_horaria").val(response[0]['nr_carga_horaria']);
                    $("#nr_matricula").val(response[0]['nr_matricula']);
                    listaVinculoCombo(response[0]['id_vinculo']);
                    listaPjCombo(response[0]['id_pessoa_juridica']);
                    listaCargoCombo(response[0]['id_cargo']);
                    returnCompetencia(idPessoaFisica);
                    returnLotacaoFuncao(idContrato);
                }
        });
    }
    //******************************************************************************************************************

    //******************************************** Carrega os Dados de Naturalidade ************************************
    function listaPaisNaturalidade(idPais = 0) {
        $.ajax({
            "url": "/model/rh/funcionario/request.php",
            "dataType": 'html',
            "data": {
                acao: "listaPaisOption",
                idPais: idPais
            },
            "success": function (response) {
                $("#id_pais_naturalidade").append(response);
            }
        });
    }

    function listaEstadoNaturalidade(pais = 0, estado = 0) {
        $.ajax({
            "url": "/model/rh/funcionario/request.php",
            "dataType": 'html',
            "data": {
                acao: "listaEstadoOption",
                idPais: pais,
                idEstado: estado
            },
            "success": function (response) {
                $("#id_estado_naturalidade").html(response);
            }
        });
    }

    function listaCidadeNaturalidade(estado = 0, idCidade = 0) {
        $.ajax({
            "url": "/model/rh/funcionario/request.php",
            "dataType": 'html',
            "data": {
                acao: "listaCidadeOption",
                idEstado: estado,
                idCidade: idCidade
            },
            "success": function (response) {
                $("#id_naturalidade").html(response);
            }
        });
    }
    //******************************************************************************************************************

    //******************************************* Carrega os Dados de Endereço *****************************************
    function listaPaisEndereco(idPais = 0) {
        $.ajax({
            "url": "/model/rh/funcionario/request.php",
            "dataType": 'html',
            "data": {
                acao: "listaPaisOption",
                idPais: idPais
            },
            "success": function (response) {
                $("#id_pais_endereco").append(response);
            }
        });
    }

    function listaEstadoEndereco(pais = 0, estado = 0) {
        $.ajax({
            "url": "/model/rh/funcionario/request.php",
            "dataType": 'html',
            "data": {
                acao: "listaEstadoOption",
                idPais: pais,
                idEstado: estado
            },
            "success": function (response) {
                $("#id_estado_endereco").html(response);
            }
        });
    }

    function listaCidadeEndereco(idEstado = 0, idCidade = 0, nmCidade = null) {
        $.ajax({
            "url": "/model/rh/funcionario/request.php",
            "dataType": 'html',
            "data": {
                acao: "listaCidadeOption",
                idEstado: idEstado,
                idCidade: idCidade,
                nmCidade: nmCidade,
            },
            "success": function (response) {
                $("#id_cidade").html(response);
            }
        });
    }
    //******************************************************************************************************************

    //************************************* Orgao Expeditor ************************************
    function listaOrgaoExpeditor(idOrgao = null) {
        $.ajax({
            "url": "/model/rh/funcionario/request.php",
            "dataType": 'html',
            "data": {
                acao: "listaEstadoOption"
            },
            "success": function (response) {
                if (idOrgao == null) {
                    $("#id_estado").html(response);
                } else {
                    $("#id_estado").html(response);
                    $("#id_estado").val(idOrgao).change();
                }
            }
        });
    }
    listaOrgaoExpeditor();
    //******************************************************************************************
function listaFuncaoCombo() {
    $.ajax({
        "url": "/model/rh/funcionario/request.php",
        "dataType": 'html',
        "data": {
            acao: "listaFuncaoOption"
        },
        "success": function (response) {
            $("#id_funcao").append(response);
            $("#id_funcao").select2({
                width: " 100%"
            });
        }
    });
}
listaFuncaoCombo();
//******************************************************************************************
function listaLotacaoCombo() {
    $.ajax({
        "url": "/model/rh/funcionario/request.php",
        "dataType": 'html',
        "data": {
            acao: "listaLotacaoOption"
        },
        "success": function (response) {
            $("#id_lotacao").append(response);
            $("#id_lotacao").select2({
                width: " 100%"
            });
        }
    });
}
listaLotacaoCombo();
//******************************************************************************************
function listaPjCombo(idPj) {
    $.ajax({
        "url": "/model/rh/funcionario/request.php",
        "dataType": 'html',
        "method": "POST",
        "data": {
            acao: "listaPessoaJuridicaOption",
            id: idPj
        },
        "success": function (response) {
            $("#id_pessoa_juridica").append(response);
            $("#id_pessoa_juridica").select2({
                width: " 100%"
            });
        }
    });
}
//******************************************************************************************
function listaVinculoCombo(idVinculo) {
    $.ajax({
        "url": "/model/rh/funcionario/request.php",
        "dataType": 'html',
        "method": "POST",
        "data": {
            acao: "listaVinculoOption",
            id: idVinculo

        },
        "success": function (response) {
            $("#id_vinculo").append(response);
            $("#id_vinculo").select2({
                width: " 100%"
            });
        }
    });
}

//******************************************************************************************
function listaCargoCombo(idCargo) {
    $.ajax({
        "url": "/model/rh/funcionario/request.php",
        "dataType": 'html',
        "method": 'POST',
        "data": {
            acao: "listaCargoOption",
            id: idCargo
        },
        "success": function (response) {
            $("#id_cargo").append(response);
            $("#id_cargo").select2({
                width: " 100%"
            });
        }
    });
}
//******************************************************************************************
function listaEstadoCivilCombo(id) {
    $.ajax({
        "url": "/model/rh/funcionario/request.php",
        "dataType": 'html',
        "method": 'POST',
        "data": {
            acao: "listaEstadoCivilOption",
            id: id
        },
        "success": function (response) {
            $("#id_estado_civil").append(response);
            $("#id_estado_civil").select2({
                width: " 100%"
            });
        }
    });
}
//******************************************************************************************
function listaEscolaridadeCombo(id) {
    $.ajax({
        "url": "/model/rh/funcionario/request.php",
        "dataType": 'html',
        "method": 'POST',
        "data": {
            acao: "listaEscolaridadeOption",
            id: id
        },
        "success": function (response) {
            $("#id_escolaridade").append(response);
            $("#id_escolaridade").select2({
                width: " 100%"
            });
        }
    });
}
//******************************************************************************************
function listaEscolaridadeFormacaoCombo() {
    $.ajax({
        "url": "/model/rh/funcionario/request.php",
        "dataType": 'html',
        "data": {
            acao: "listaEscolaridadeFormacaoOption"
        },
        "success": function (response) {
            $(".formacao").append(response);
            $(".formacao").select2({
                width: " 100%"
            });
        }
    });
}
listaEscolaridadeFormacaoCombo();
//******************************************************************************************
function returnCompetencia(id_pessoa_fisica) {
    var DadosPessoa = {
        id_pessoa_fisica: id_pessoa_fisica,
        contrato: 0
    };
    $.ajax({
        "url": "/model/rh/funcionario/request.php",
        "dataType": "html",
        "method": "POST",
        "data": {
            "acao": "returnCompetencia",
            "dadosPessoa": DadosPessoa
        },
        "success":
                function (response) {
                    $("#corpoCompetencia").html(response);
                }
    });
}
//******************************************************************************************
function returnLotacaoFuncao(idContrato) {
    $.ajax({
        "url": "/model/rh/funcionario/request.php",
        "dataType": "html",
        "data": {
            "acao": "returnLotacaoFuncao",
            "idContrato": idContrato

        },
        "success":
                function (response) {
                    $("#corpoTabelaLotacao").html(response);
                }
    });
}
//******************************************************************************************
    returnContratoEditar();
    //*********************************************************************
    // função do botão Próximo
    $(".pro").click(function () {
        $('.nav > .active').next('li').find('a').trigger('click');
    });
    // função do botão anterior
    $(".ant").click(function () {
// aba que esta ativa no momento
        $('.nav > .active').prev('li').find('a').trigger('click');
    });
    //************************************************************
    $("body").on("change", "#id_vinculo", function (e) {
        var id = $(this).val();
        if (id == 5) {
            $(".demissao").show();
        } else {
            $(".demissao").hide();
        }
        $("#dt_demissao").val("");
    });
    //******************************************************************************************
    $("body").on("change", "#id_cidade", function (e) {
        $("#ds_logradouro").val("");
        $("#ds_bairro").val("");
        $("#ds_complemento").val("");
        $("#nr_cep").val("");

    });
//*********************************************************************

    //************************************ Regras dos Dados da Naturalidade ****************************************
    $("body").on("change.select2", "#id_pais_naturalidade", function (e) {
        $("#id_estado_naturalidade").val(0).trigger('change.select2');
        $("#id_naturalidade").val(0).trigger('change.select2');
        idPais = $("#id_pais_naturalidade").val();
        if (idPais == 0) {
            return;
        }
        listaEstadoNaturalidade(idPais);
    });

    $("body").on("change.select2", "#id_estado_naturalidade", function (e) {
        $("#id_naturalidade").val(0).trigger('change.select2');
        idEstado = $("#id_estado_naturalidade").val();
        if (idEstado == 0) {
            return;
        }
        listaCidadeNaturalidade(idEstado);
    });
    //******************************************************************************************

    //************************************ Endereço ****************************************
    $("body").on("change.select2", "#id_pais_endereco", function (e) {
        $("#id_estado_endereco").val(0).trigger('change.select2');
        $("#id_cidade").val(0).trigger('change.select2');
        idPais = $("#id_pais_endereco").val();
        if (idPais == 0) {
            return;
        }
        listaEstadoEndereco(idPais);
    });

    $("body").on("change.select2", "#id_estado_endereco", function (e) {
        $("#id_cidade").val(0).trigger('change.select2');
        idEstado = $("#id_estado_endereco").val();
        if (idEstado == 0) {
            return;
        }
        listaCidadeEndereco(idEstado);
    });
    //******************************************************************************************

    $(".nr").mask("99");
    $("#nr_cns").mask("999 9999 9999 9999");
    $("#nr_cpf").mask("999.999.999-99");
    $("#nr_cep").mask("99999-999");
    $(".data").mask("99/99/9999");
    $("#nr_telefone_residencial").mask("(99) 9999-9999");
    $("#nr_telefone_celular").mask("(99) 9 9999-9999");
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
            //return false;
        }
    });
//******************************************************************************************
    $("body").on("click", ".editarLinhaLotacao", function (e) {
        $('#modalContratoLotacao').modal('show');
        $idContratoLotacao = $(this).val();
        lotacoes = 0;
        $("#tabelaLotacao tbody tr").each(function () {
            if ($(this).closest(".lotacaoLinha").find(".dataFim").attr("dt_fim") === '') {
                lotacoes++;
            }
        });
        if (lotacoes > 1) {
            $("#dt_inicio_editar").prop("disabled", true);
        } else {
            $("#dt_inicio_editar").prop("disabled", false);
        }
        //**********************************************************************************
        $("#nr_ch_editar").val("");
        $("#dt_inicio_editar").val("");
        $("#dt_fim_editar").val("");
        //**********************************************************************************
        $("#modal_titulo").text("Lotação: " + $(this).closest(".lotacaoLinha").find(".lotacao").text() + "  /  Função: " + $(this).closest(".lotacaoLinha").find(".funcao").text());
        $("#id_contrato_lotacao").val($idContratoLotacao);
        $("#nr_ch_editar2").val($(this).closest(".lotacaoLinha").find(".cargaLotacao").attr("ch"));
        $("#nr_ch_editar").val($(this).closest(".lotacaoLinha").find(".cargaLotacao").attr("ch"));
        $("#dt_inicio_editar").val($(this).closest(".lotacaoLinha").find(".dataIni").attr("dt_inicio"));
        $("#dt_fim_editar").val($(this).closest(".lotacaoLinha").find(".dataFim").attr("dt_fim"));
        $("#id_funcao_editar").val($(this).closest(".lotacaoLinha").find(".funcao").attr("idFuncao"));
        $("#id_lotacao_editar").val($(this).closest(".lotacaoLinha").find(".lotacao").attr("idLotacao"));
    });
//******************************************************************************************
    $('#modalContratoLotacao').on('shown.bs.modal', function () {
        $('#nr_ch_editar').focus();
    });
    //***********************************************************

//******************************************************************************************
    $("body").on("click", ".AtualizarItem", function () {

        $nr_carga_horaria = $("#nr_carga_horaria").val();
        $cH2 = $("#nr_ch_editar2").val();
        //*********************************************
        $cH = $("#nr_ch_editar").val();
        $dI = $("#dt_inicio_editar").val();
        $dF = $("#dt_fim_editar").val();
        $idContraLotacao = $("#id_contrato_lotacao").val();
        //**************************************************
        if ($cH == 0 && $cH == "") {
            func.modalAlert(func.msgPreencherCampos + " - <strong>Dados Funcionais (Informe Carga Horária da Lotação)</strong>");
            $("#nr_ch_editar").focus();
            return;
        }
        if ($("#dt_inicio_editar").val() == "") {
            func.modalAlert(func.msgPreencherCampos + " - <strong>Dados Funcionais (Informe Data de Inicio da Função na Lotação)</strong>");
            $("#dt_inicio_editar").focus();
            return;
        }
        //*******************************
        if ($nr_carga_horaria <= 0) {
            func.modalAlert(func.msgPreencherCampos + " - <strong>Dados Funcionais (Carga Horária do Funcionário)</strong>");
            return;
        }
        //********carga hoaria da lotação não deve exceder a carga horaria do funcionario**************** 
        if ((parseInt($cH)) > parseInt($nr_carga_horaria)) {
            func.modalAlert("Carga Horária da Lotação excede a Carga Horária do Funcionário");
            $("#nr_ch_editar").focus();
            return;
        }
        //*************************************************************************
        if ($(this).closest(".corpoTodo").find(".lotacaoLinha").length > 0) {
            var cargaHorariaLotacao = 0;
            $("#tabelaLotacao tbody tr").each(function () {
                cargaLotacao = $(this).find(".cargaLotacao").attr("ch");
                if (cargaLotacao == '') {
                    cargaHorariaLotacao += parseInt($(this).find(".cargaLotacao").attr("ch"));
                } else {
                    cargaHorariaLotacao += parseInt(0);
                }
            });
        }
        $totalHoras = (cargaHorariaLotacao + parseInt($cH)) - parseInt($cH2);

        if ($totalHoras > parseInt($nr_carga_horaria)) {
            func.modalAlert("Carga Horária da Lotação excede a Carga Horária do Funcionário");
            $("#nr_ch_editar").focus();
            return;
        }
        //********data inicial da função na lotação tem de ser inferior a data final**********************
        if ($("#dt_fim_editar").val().length > 3) {
            var data1 = $("#dt_inicio_editar").val();
            var data2 = $("#dt_fim_editar").val();
            var x = data1.split("/")[2].toString() + "/" + data1.split("/")[1].toString() + "/" + data1.split("/")[0].toString();
            var y = data2.split("/")[2].toString() + "/" + data2.split("/")[1].toString() + "/" + data2.split("/")[0].toString();
            var dataIni = new Date(x);
            var dataFim = new Date(y);
            if (dataIni > dataFim) {
                func.modalAlert(" A Data Início da Lotação não pode ser Maior que a Data Fim.");
                return;
            }
        }
        var contratoId = $("#id_contrato").val();
        var funcaoId = $("#id_funcao_editar").val();
        var lotacaoId = $("#id_lotacao_editar").val();
        //***********************************************
        var DadosContratoLotacao = {
            idContrato: contratoId,
            idLotacao: lotacaoId,
            idFuncao: funcaoId,
            idContratoLotacao: $idContraLotacao,
            cargaLotacao: $cH,
            dataIni: $("#dt_inicio_editar").val(),
            dataFim: $("#dt_fim_editar").val()
        };

        //************************************************
        $.ajax({
            "url": "/model/rh/funcionario/request.php",
            "dataType": "html",
            "data": {
                "acao": "atualizarContratoLotacao",
                "dadosContratoLotacao": DadosContratoLotacao

            },
            "success":
                    function (response) {
                        $('#modalContratoLotacao').modal('hide');
                        if (response.trim() == "SessaoExpirada") {
                            func.modalAlert(func.msgSemPermissao);
                            return false;
                        }

                        try {
                            response = JSON.parse(response);
                        } catch (e) {
                            func.modalAlert(func.msgErroPadrao);
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
                            returnLotacaoFuncao(contratoId);
                            return false;
                        } else {
                            console.log(response);
                            func.modalAlert(func.msgErroPadrao, 'danger');
                            return false;
                        }
                    }
        });
    });
//******************************************************************************************
    $("body").on("click", ".btn-add-lotacao", function (e) {

        var contratoId = $("#id_contrato").val();
        var lotacaoId = $("#id_lotacao").val();
        var funcaoId = $("#id_funcao").val();
        var nr_carga_horaria = $("#nr_carga_horaria").val();
        var nr_carga_horaria2 = $("#nr_carga_horaria2").val();
        //**********************************************************************************
        var idContrato = 0;
        if ($("#id_contrato").val() !== "") {
            idContrato = $("#id_contrato").val();
        }
        //**********************************************************************************
        if (nr_carga_horaria <= 0) {
            func.modalAlert(func.msgPreencherCampos + " - <strong>Dados Funcionais(Carga Horária do Funcionário)</strong>");
            $("#nr_carga_horaria").focus();
            return;
        }

        //********carga hoaria da lotação não deve exceder a carga horaria do funcionario****************
        if ((parseInt(nr_carga_horaria2)) > parseInt(nr_carga_horaria)) {
            func.modalAlert("Carga Horaria da Lotação excede a Carga Horária do Funcionário");
            return;
        }
        var flag = 0;
        if ($(this).closest(".panelForm").find(".lotacaoLinha").length > 0) {
            var cargaHorariaLotacao = 0;
            $("#tabelaLotacao tbody tr").each(function () {
                if (lotacaoId == $(this).find(".lotacao").attr("idLotacao") && funcaoId == $(this).find(".funcao").attr("idFuncao")) {
                    func.modalAlert("Os dados de Lotação e Função Informados já estão cadastrados no Sistema.");
                    flag = 1;
                }

                dataFimAntiga = $(this).closest(".lotacaoLinha").find(".dataFim").attr("dt_fim");
                dataAtual = $(this).closest(".lotacaoLinha").attr("dataAtual");
                if (dataFimAntiga !== "" && +new Date(dataFimAntiga.split("/")[2].toString() + "/" + dataFimAntiga.split("/")[1].toString() + "/" + dataFimAntiga.split("/")[0].toString()) < +new Date(dataAtual.split("/")[2].toString() + "/" + dataAtual.split("/")[1].toString() + "/" + dataAtual.split("/")[0].toString())) {
                    cargaHorariaLotacao += 0;
                } else {
                    cargaHorariaLotacao += parseInt($(this).find(".cargaLotacao").attr("ch"));
                }
            });
        }
        if (flag === 1) {
            return;
        }

        //*********** Controle de data e carga horária das lotações dos funcionários (Autor: Elivelton)*************
        seguir = 0;
        $("#tabelaLotacao tbody tr").each(function () {
            if (dataFimAntiga !== '') {
                var dataAnti = +new Date(dataFimAntiga.split("/")[2].toString() + "/" + dataFimAntiga.split("/")[1].toString() + "/" + dataFimAntiga.split("/")[0].toString());
                var dataAtua = +new Date(dataAtual.split("/")[2].toString() + "/" + dataAtual.split("/")[1].toString() + "/" + dataAtual.split("/")[0].toString());

                if (dataAnti >= dataAtua) {
                    if ((cargaHorariaLotacao + parseInt(nr_carga_horaria2)) > parseInt(nr_carga_horaria)) {
                        seguir = 3;
                        return;
                    }
                }

                dtFim = $(this).closest(".lotacaoLinha").find(".dataFim").attr("dt_fim").split("/")[2].toString() + "/" + $(this).closest(".lotacaoLinha").find(".dataFim").attr("dt_fim").split("/")[1].toString() + "/" + $(this).closest(".lotacaoLinha").find(".dataFim").attr("dt_fim").split("/")[0].toString();
                dtInicio = $("#dt_inicio").val().split("/")[2].toString() + "/" + $("#dt_inicio").val().split("/")[1].toString() + "/" + $("#dt_inicio").val().split("/")[0].toString();
                dtInicio2 = $(this).closest(".lotacaoLinha").find(".dataIni").attr("dt_inicio").split("/")[2].toString() + "/" + $(this).closest(".lotacaoLinha").find(".dataIni").attr("dt_inicio").split("/")[1].toString() + "/" + $(this).closest(".lotacaoLinha").find(".dataIni").attr("dt_inicio").split("/")[0].toString();

                if (+new Date(dtInicio) <= +new Date(dtInicio2) && +new Date(dtInicio) >= +new Date(dtFim)) {
                    seguir = 1;
                    return;
                }

                if (dtFim > dataAtua) {
                    console.log(parseInt(nr_carga_horaria));
                    console.log(cargaHorariaLotacao);
                    if ((cargaHorariaLotacao > parseInt(nr_carga_horaria))) {
                        seguir = 3;
                        return;
                    }
                }

                if ((cargaHorariaLotacao + parseInt(nr_carga_horaria2)) > parseInt(nr_carga_horaria)) {
                    seguir = 3;
                    return;
                }
            }

            if ((cargaHorariaLotacao + parseInt(nr_carga_horaria2)) > parseInt(nr_carga_horaria)) {
                seguir = 3;
                return;
            }
        });

        if (seguir === 1) {
            func.modalAlert("A (DATA INÍCIO) da Nova Lotação do Funcionário é Menor ou igual a (DATA FIM) da Lotação ainda Vigente.");
            return false;
        }

        if (seguir === 2) {
            func.modalAlert("Não é Possível Inserir uma Nova Lotação pois a uma Lotação ainda Vigente.");
            return false;
        }
        if (seguir === 3) {
            func.modalAlert("Carga Horária da Lotação excede a Carga Horária do Funcionário.");
            return false;
        }
        //*********************************************************************************************************

        //********************************************************************************
        if (lotacaoId == 0) {
            func.modalAlert(func.msgPreencherCampos + " - <strong>Dados Funcionais(Lotação)</strong>");
            $("#lotacao").focus();
            return;
        }
        if (funcaoId == 0) {
            func.modalAlert(func.msgPreencherCampos + " - <strong>Dados Funcionais(Função)</strong>");
            $("#id_funcao").focus();
            return;
        }
        if (nr_carga_horaria2 == null) {
            func.modalAlert(func.msgPreencherCampos + " - <strong>Dados Funcionais(Carga Horária da Lotação)</strong>");
            $("#nr_carga_horaria2").focus();
            return;
        }
        if ($("#dt_inicio").val() == "") {
            func.modalAlert(func.msgPreencherCampos + " - <strong>Dados Funcionais(Data de inicio da Função na Lotação)</strong>");
            return;
        }
        //********data inicial da função na lotação tem de ser inferior a data final**********************
        if ($("#dt_fim").val().length > 3) {
            var data1 = $("#dt_inicio").val();
            var data2 = $("#dt_fim").val();
            var x = data1.split("/")[2].toString() + "/" + data1.split("/")[1].toString() + "/" + data1.split("/")[0].toString();
            var y = data2.split("/")[2].toString() + "/" + data2.split("/")[1].toString() + "/" + data2.split("/")[0].toString();
            var dataIni = new Date(x);
            var dataFim = new Date(y);
            if (dataIni > dataFim) {
                func.modalAlert(" A data Inicio não pode ser maior que a data fim");
                return;
            }
        }
        //********************************************************************************
        if (idContrato == 0) {
            var lotacao = $("#lotacao option:selected").text();
            var funcao = $("#id_funcao option:selected").text();
            //********************************************************************************
            var linha = "";
            linha = "<tr class='warning lotacaoLinha'>\n\
                    <td class='text-center lotacao' idLotacao='" + lotacaoId + "'>" + lotacao + "</td>\n\
                    <td class='text-center funcao' idFuncao='" + funcaoId + "'>" + funcao + "</td>\n\
                    <td class='text-center cargaLotacao'ch='" + nr_carga_horaria2 + "'>" + nr_carga_horaria2 + "</td>\n\
                    <td class='text-center dataIni' dt_inicio='" + $("#dt_inicio").val() + "'>" + $("#dt_inicio").val() + "</td>\n\
                    <td class='text-center dataFim' dt_fim='" + $("#dt_fim").val() + "'>" + $("#dt_fim").val() + "</td>\n\
                    <td class='text-center'><button type='button' title='Remover' class='excluirLinhaLotacao' value=''><i class='fa fa-remove text-danger'></i></button></td>\n\
                 </tr>";
            $(linha).appendTo('.corpoTabelaLotacao');
            $("#nr_carga_horaria2").val("");
            $("#dt_inicio").val("");
            $("#dt_fim").val("");
            //***********************************************************************************
            $("#lotacao").val(0);
            $("#lotacao").select2({width: " 100%"});
            $("#id_funcao").val(0);
            $("#id_funcao").select2({ width: " 100%"});
        } else {
            var DadosContratoLotacao = {
                idContrato: contratoId,
                idLotacao: lotacaoId,
                idFuncao: funcaoId,
                cargaLotacao: nr_carga_horaria2,
                dataIni: $("#dt_inicio").val(),
                dataFim: $("#dt_fim").val()
            };
            $.ajax({
                "url": "/model/rh/funcionario/request.php",
                "dataType": "html",
                "data": {
                    "acao": "inserirContratoLotacao",
                    "dadosContratoLotacao": DadosContratoLotacao

                },
                "success":
                    function (response) {
                        returnLotacaoFuncao(contratoId);
                    }
            });
        }
    });
//******************************************************************************************
    $("body").on("click", ".btn-add", function (e) {
        var pessoaFisica = $("#id_pessoa_fisica").val();
        var competencia = $("#id_competencia").val();
        if (competencia == 0) {
            func.modalAlert("informe Competência");
            $("#id_competencia").focus();
            return;
        }
        //*********************************************************************************
        var flag = 0;
        if ($(this).closest(".panelCompetencia").find(".competenciaLinha").length > 0) {
            $("#tabela tbody tr").each(function () {
                if (competencia == $(this).find(".escolaridade").attr("idEscolaridadeFormacao")) {
                    flag = 1;
                    func.modalAlert("O Item já Existe!!!");
                }
            });
        }

        if (flag == 1) {
            return;
        }
        //*********************************************************************************
        $.ajax({
            "url": "/model/rh/funcionario/request.php",
            "dataType": "html",
            "data": {
                "acao": "inserirCompetencia",
                "competencia": competencia,
                "pessoaFisica": pessoaFisica
            },
            "success":
                    function (response) {
                        returnCompetencia(pessoaFisica);
                    }

        });
    });
//******************************************************************************************
    $("body").on("click", ".excluirLinha", function (e) {
        //$(this).closest(".competenciaLinha").remove();
        var idCompetencia = $(this).val();
        $idPessoaFisica = $(this).closest(".competenciaLinha").attr("idPf");
        $.ajax({
            "url": "/model/rh/funcionario/request.php",
            "dataType": "html",
            "data": {
                "acao": "excluirCompetencia",
                "idCompetencia": idCompetencia
            },
            "success":
                    function (response) {
                        returnCompetencia($idPessoaFisica);
                    }
        });
    });
//******************************************************************************************
    $("body").on("click", ".excluirLinhaLotacao", function (e) {
        var idContratoLotacao = $(this).val();
        var lotacao = $(this).closest(".lotacaoLinha").find(".lotacao").text();
        var funcao = $(this).closest(".lotacaoLinha").find(".funcao").text();
        //**********************************************************************************
        var idContrato = 0;
        if ($("#id_contrato").val() !== "") {
            idContrato = $("#id_contrato").val();
        }
        //**********************************************************************************
        bootbox.confirm({
            title: 'Caixa de Confirmação',
            message: 'Você tem Certeza que deseja Excluir:   <span class="text-danger">Lotação: ' + lotacao + " -- Função: " + funcao + '</span>?',
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

                    if (idContrato == 0) {
                        $(this).closest(".lotacaoLinha").remove();
                    } else {
                        $.ajax({
                            "url": "/model/rh/funcionario/request.php",
                            "dataType": "html",
                            "data": {
                                "acao": "excluirContratoLotacao",
                                "idContratoLotacao": idContratoLotacao
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
                                    returnLotacaoFuncao(idContrato);
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
            }
        });
    });
//******************************************************************************************
//    $("body").on("change", "#id_vinculo", function (e) {
//        var id = $(this).val();
//        if (id == 5) {
//            $(".demissao").show();
//        } else {
//            $(".demissao").hide();
//        }
//    });
//******************************************************************************************
    $('body').on('click', '.btn-salvar', function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else {
            e.preventDefault();
            var $this = $(this);
            var idPessoaFisica = ($("#id_pessoa_fisica").val());
            var idPessoa = ($("#id_pessoa").val());
            var idContrato = ($("#id_contrato").val());
            if (idContrato == "") {
                idContrato = 0;
            }
            var cep = func.extrairCarater($("#nr_cep").val(), "-");
            var DadosPessoa = {
                //****************dados pessoais*********************
                idPessoa: idPessoa,
                nomeSocial: $("#nm_nome").val(),
                naturalidade: $("#id_naturalidade").val(),
                logradouro: $("#ds_logradouro").val(),
                complemento: $("#ds_complemento").val(),
                bairro: $("#ds_bairro").val(),
                cep: cep,
                cidade: $("#id_cidade").val(),
                telefone_residencial: $("#nr_telefone_residencial").val(),
                telefone_celular: $("#nr_telefone_celular").val(),
                email: $("#nm_email").val(),
                obs: $("#ds_observacao").val()
            };
            $cpf = $("#nr_cpf").val().replace(/(\.|\/|\-)/g, "");
            var DadosPessoaFisica = {
                idPessoaFisica: idPessoaFisica,
                nomeCivil: $("#nm_civil").val(),
                tpSexo: $("#tp_sexo").val(),
                cpf: $cpf,
                rg: $("#nr_rg").val(),
                orgaoExpedidor: $("#ds_orgao_expedidor").val(),
                habilidade: $("#ds_habilidade").val(),
                orgaoExpedidorEst: $("#id_estado").val(),
                estadoCivil: $("#id_estado_civil").val(),
                pai: $("#nm_pai").val(),
                mae: $("#nm_mae").val(),
                dtNascimento: $("#dt_nascimento").val(),
                cns: $("#nr_cns").val(),
                escolaridade: $("#id_escolaridade").val()
            };
            //********data admissao tem de ser inferior a data demissao**********************
            if ($("#dt_demissao").val().length > 3) {
                var data1 = $("#dt_admissao").val();
                var data2 = $("#dt_demissao").val();
                var x = data1.split("/")[2].toString() + "/" + data1.split("/")[1].toString() + "/" + data1.split("/")[0].toString();
                var y = data2.split("/")[2].toString() + "/" + data2.split("/")[1].toString() + "/" + data2.split("/")[0].toString();
                var dataIni = new Date(x);
                var dataFim = new Date(y);
                if (dataIni > dataFim) {
                    func.modalAlert(" A data de Admissão não pode ser maior que a data de Demissão.");
                    return;
                }
            }
            cargaHorariaLotacao = 0;
            $("#tabelaLotacao tbody tr").each(function () {
                dataFimAntiga = $(this).closest(".lotacaoLinha").find(".dataFim").attr("dt_fim");
                dataAtual = $(this).closest(".lotacaoLinha").attr("dataAtual");
                if (dataFimAntiga !== "" && +new Date(dataFimAntiga.split("/")[2].toString() + "/" + dataFimAntiga.split("/")[1].toString() + "/" + dataFimAntiga.split("/")[0].toString()) < +new Date(dataAtual.split("/")[2].toString() + "/" + dataAtual.split("/")[1].toString() + "/" + dataAtual.split("/")[0].toString())) {
                    cargaHorariaLotacao += 0;
                } else {
                    cargaHorariaLotacao += parseInt($(this).find(".cargaLotacao").attr("ch"));
                }
            });
            if (parseInt($("#nr_carga_horaria").val()) !== cargaHorariaLotacao) {
                func.modalAlert('Complete ou Reajuste a Carga Horária.');
                $('.modal-alert').on('hidden.bs.modal', function (e) {
                    $("#nr_carga_horaria").focus();
                });
                return false;
            }
            var DadosContrato = {
                idContrato: idContrato,
                nrMatricula: $("#nr_matricula").val(),
                dtAdmissao: $("#dt_admissao").val(),
                dtDemissao: $("#dt_demissao").val(),
                nrCargaHoraria: $("#nr_carga_horaria").val(),
                vinculo: $("#id_vinculo").val(),
                pessoaJuridica: $("#id_pessoa_juridica").val(),
                idCargo: $("#id_cargo").val()
            };
            console.log(DadosContrato.nrCargaHoraria);
            if (DadosContrato.nrCargaHoraria == 20 || DadosContrato.nrCargaHoraria == 24 || DadosContrato.nrCargaHoraria == 30 || DadosContrato.nrCargaHoraria == 40 || DadosContrato.nrCargaHoraria == 44) {
                segue = true;
            } else {
                segue = false;
            }

            if (segue == false) {
                func.modalAlert('Carga Horária do Contrato deve Corresponder as Cargas 20,24,30,40 ou 44 Horas.');
                return;
            }

            var DadosContrato_Lotacao = [];
            if (idContrato == 0) {
                var x = 0;
                if ($(this).closest(".formRhFuncionario").find(".lotacaoLinha").length > 0) {
                    x = 1;
                    $("#tabelaLotacao tbody tr").each(function () {
                        DadosContrato_Lotacao.push({
                            chLotacao: $(this).find(".cargaLotacao").attr("ch"),
                            idLotacao: $(this).find(".lotacao").attr("idLotacao"),
                            idFuncao: $(this).find(".funcao").attr("idFuncao"),
                            dt_inicio: $(this).find(".dataIni").attr("dt_inicio"),
                            dt_fim: $(this).find(".dataFim").attr("dt_fim")
                        });
                    });
                }
            }
            //******************************************************************
            var DadosObrigatorio = {
                //**************1-12***********************
                "Email": DadosPessoa.email,
                "Nome Civil": DadosPessoaFisica.nomeCivil,
                "Sexo": DadosPessoaFisica.tpSexo,
                "Data de Nascimento": DadosPessoaFisica.dtNascimento,
                "Naturalidade": DadosPessoa.naturalidade,
                "CPF": DadosPessoaFisica.cpf,
                "Registro Geral": DadosPessoaFisica.rg,
                "Orgão Expedidor": DadosPessoaFisica.orgaoExpedidor,
                "Orgão Expedidor Estado": DadosPessoaFisica.orgaoExpedidorEst,
                "Mãe": DadosPessoaFisica.mae,
                "Estado Civil": DadosPessoaFisica.estadoCivil,
                "Escolaridade": DadosPessoaFisica.escolaridade,
                //***************13-16*****************************
                "Cidade Endereco": DadosPessoa.cidade,
                "Logradouro": DadosPessoa.logradouro,
                "Bairro": DadosPessoa.bairro,
                "Telefone Celular": DadosPessoa.telefone_celular,
                //******************17-22****************************
                "Vínculo": DadosContrato.vinculo,
                "Empresa": DadosContrato.pessoaJuridica,
                "Data de Admissao": DadosContrato.dtAdmissao,
                "Carga Horária do Contrato": DadosContrato.nrCargaHoraria,
                "Matrícula": DadosContrato.nrMatricula,
                "Cargo": DadosContrato.idCargo
            };

            $campo = 0;
            $i = 0;
            $.each(DadosObrigatorio, function (index, value) {
                $i++;
                $campo = "";
                if (value == 0 || value == "" || value == null) {
                    if ($i <= 12) {
                        func.modalAlert(func.msgPreencherCampos + " - <strong>Dados Pessoais (" + index + ")</strong>");
                    } else if ($i >= 13 && $i <= 16) {
                        func.modalAlert(func.msgPreencherCampos + " - <strong>Endereço / Contato ("+ index + ")</strong>");
                    } else if ($i >= 17 && $i <= 22) {
                        func.modalAlert(func.msgPreencherCampos + " - <strong>Dados Funcionais (" + index + ")</strong>");
                    }
                    $campo = 1;
                    return false;
                }
            });
            if ($campo == 1) {
                return false;
            }
            //*******************************************************************

            if (x == 0) {
                func.modalAlert(func.msgPreencherCampos + " - <strong>Dados Funcionais (Informar Lotação e Função)</strong>");
                return false;
            }
            //***********************************************
            $.ajax({
                "url": "/model/rh/funcionario/request.php",
                "dataType": "html",
                "method": "POST",
                "data": {
                    "acao": "editarContrato",
                    "dadosPessoa": DadosPessoa,
                    "dadosPessoaFisica": DadosPessoaFisica,
                    "dadosContrato": DadosContrato,
                    "dadosContrato_Lotacao": DadosContrato_Lotacao
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
                        func.fechaModalHref('/pages/rh/funcionario/index.php');
                        return false;
                    } else {
                        func.modalAlert(func.msgErroPadrao, 'danger');
                        return false;
                    }
                },
                "error": function (response) {
                    $this.prop("disabled", false);
                    func.modalAlert(func.msgErroPadrao, 'danger');
                    return false;
                }
            });
            $this.prop("disabled", false);
        }
    });
    //*************************************************** Busca Cep ****************************************************
    $('body').on('click', '.cep', function (e) {
        $("#id_cidade").prop('disabled', false);
        $("#id_estado_endereco").prop('disabled', false);
        //Nova variável "cep" somente com dígitos.
        var cep = $("#nr_cep").val().replace(/\D/g, '');
        //Verifica se campo cep possui valor informado.
        if (cep != "") {
            //Expressão regular para validar o CEP.
            var validacep = /^[0-9]{8}$/;
            //Valida o formato do CEP.
            if (validacep.test(cep)) {
                //Preenche os campos com "..." enquanto consulta webservice.
                $("#ds_logradouro").val("");
                $("#ds_bairro").val("");
                $("#id_pais").val(0).trigger('change.select2');
                // return false;
                //Consulta o webservice viacep.com.br/
                $.getJSON("https://viacep.com.br/ws/" + cep + "/json/?callback=?", function (dados) {
                    if (!("erro" in dados)) {
                        //Atualiza os campos com os valores da consulta.
                        $("#ds_logradouro").val(dados.logradouro);
                        $("#ds_bairro").val(dados.bairro);
                        $("#ds_logradouro").focus();
                        var uf = dados.uf;
                        var cidade = dados.localidade;
                        $.ajax({
                            "url": "/model/rh/funcionario/request.php",
                            "dataType": "html",
                            "method": "POST",
                            "data": {
                                "acao": "listaCidadeOptionUf",
                                "uf": uf
                            },
                            "success": function (response) {
                                try {
                                    response = JSON.parse(response);
                                    $('#id_pais_endereco').val(response[0].id_pais).trigger('change.select2');
                                    listaEstadoEndereco(response[0].id_pais, response[0].id_estado);
                                    listaCidadeEndereco(response[0].id_estado, 0,cidade);
                                } catch (e) {
                                    console.log(response);
                                    return false;
                                }
                            }
                        });
                    } else {
                        //CEP pesquisado não foi encontrado.
                        func.modalAlert("CEP não encontrado.");
                        return false;
                    }
                });
            } else {
                //cep é inválido.
                func.modalAlert("Formato de CEP inválido.");
                return false;
            }
        } else {
            //cep sem valor, limpa formulário.
        }
    });
    //******************************************************************************************************************
    $('body').on('click', '.btn-limpar', function (e) {
        location.reload();
    });
});
