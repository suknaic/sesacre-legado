$(document).ready(function () {

    func = new Funcoes();

    $(".select").select2({width: " 100%"});

    //***************************************** Carrega Dados do Contrato **********************************************
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

    //************************************************* Orgao Expeditor ************************************************
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
    //******************************************************************************************************************

    //**************************************************** Lista a função **********************************************
    function listaFuncaoCombo() {
        $.ajax({
            "url": "/model/rh/funcionario/request.php",
            "dataType": 'html',
            "data": {
                acao: "listaFuncaoOption"
            },
            "success": function (response) {
                $("#id_funcao").append(response);
            }
        });
    }
    listaFuncaoCombo();
    //******************************************************************************************************************

    //*********************************************** Lista as lostaçõers **********************************************
    function listaLotacaoCombo() {
        $.ajax({
            "url": "/model/rh/funcionario/request.php",
            "dataType": 'html',
            "data": {
                acao: "listaLotacaoOption"
            },
            "success": function (response) {
                $("#id_lotacao").append(response);
            }
        });
    }
    listaLotacaoCombo();
    //******************************************************************************************************************

    //********************************************** Lista Pessoa Juridica *********************************************
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
            }
        });
    }
    //******************************************************************************************************************

    //************************************************ Lista o vinvulo *************************************************
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
            }
        });
    }
    //******************************************************************************************************************

    //************************************************ Lista Cargos ****************************************************
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
            }
        });
    }
    //********************************************** Lista Estado Civil ************************************************
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
            }
        });
    }
    //******************************************************************************************************************

    //*********************************************** Lista Escolaridade ***********************************************
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
            }
        });
    }
    //******************************************************************************************************************

    //*************************************************** Lista Curso **************************************************
    function listaEscolaridadeFormacaoCombo() {
        $.ajax({
            "url": "/model/rh/funcionario/request.php",
            "dataType": 'html',
            "data": {
                acao: "listaEscolaridadeFormacaoOption"
            },
            "success": function (response) {
                $(".formacao").append(response);
            }
        });
    }
    listaEscolaridadeFormacaoCombo();
    //******************************************************************************************************************

    //************************************* Carrega os cursos do contrato na tabela ************************************
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
    //******************************************************************************************************************

    //************************************ Carrega os dados das lotações do contrato ***********************************
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
    //******************************************************************************************************************

    //********************************* Chama a função que carrega os dados do contrato ********************************
    returnContratoEditar();
    //******************************************************************************************************************

    //****************************************** Função do botão Próximo ***********************************************
    $(".pro").click(function () {
        $('.nav > .active').next('li').find('a').trigger('click');
    });
    //******************************************************************************************************************

    //********************************************* Função do botão anterior *******************************************
    $(".ant").click(function () {
        // aba que esta ativa no momento
        $('.nav > .active').prev('li').find('a').trigger('click');
    });
    //******************************************************************************************************************

    //********************* Deixa o campo de data de demissão visível de acordo com o vinculo **************************
    $("body").on("change", "#id_vinculo", function (e) {
        var id = $(this).val();
        if (id == 5) {
            $(".demissao").show();
        } else {
            $(".demissao").hide();
        }
        $("#dt_demissao").val("");
    });
    //******************************************************************************************************************

    //******************************************************************************************************************
    $("body").on("change", "#id_cidade", function (e) {
        $("#ds_logradouro").val("");
        $("#ds_bairro").val("");
        $("#ds_complemento").val("");
        $("#nr_cep").val("");
    });
    //******************************************************************************************************************

    //*************************************** Regras dos Dados da Naturalidade *****************************************
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
    //******************************************************************************************************************

    //************************************************* Endereço *******************************************************
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
    //******************************************************************************************************************

    //********************************** Carregas as mascaras e calendarios nos campos *********************************
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
    //******************************************************************************************************************

    //********************************* Edita os dados da lotação que estão na tabela **********************************
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
    //******************************************************************************************************************

    //********************************************* Adiciona Lotação ***************************************************
    $("body").on("click", ".btn-add-lotacao", function (e) {
        var contratoId = $("#id_contrato").val();
        var lotacaoId = $("#id_lotacao").val();
        var funcaoId = $("#id_funcao").val();
        var nr_carga_horaria = $("#nr_carga_horaria").val();
        var nr_carga_horaria2 = $("#nr_carga_horaria2").val();

        //***********************************************
        var idContrato = 0;
        if ($("#id_contrato").val() !== "") {
            idContrato = $("#id_contrato").val();
        }
        //***********************************************
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

        //******** Controle de data e carga horária das lotações dos funcionários (Autor: Elivelton) *********
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
        //**********************************************************************************************************

        //*********************************** Verifica se os campos estão vazios ***********************************
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
        //********** Data inicial da função na lotação tem de ser inferior a data final ************
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

        var lotacao = $("#id_lotacao option:selected").text();
        var funcao = $("#id_funcao option:selected").text();

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

        $("#lotacao").val(0);
        $("#lotacao").select2({width:"100%"});
        $("#id_funcao").val(0);
        $("#id_funcao").select2({width:"100%"});
    });
    //******************************************************************************************************************

    //*********************************************** Adicionar Competência ********************************************
    $("body").on("click", ".btn-add", function (e) {
        var competenciaId = $("#id_competencia").val();
        if (competenciaId == 0) {
            func.modalAlert(func.msgPreencherCampos+" - <strong> Dados Pessoais(Competência)</strong>");
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

        var competencia = $("#id_competencia option:selected").text().split('-');
        var linha = "";
        linha = "<tr class='warning competenciaLinha'>\n\
                    <td class='text-center escolaridade' idEscolaridadeFormacao='" + competenciaId + "'>" + competencia[0] + "</td>\n\
                    <td class='text-center'>" + competencia[1] + "</td>\n\
                    <td class='text-center'><button type='button' title='Remover' class='excluirLinha' value=''><i class='fa fa-remove text-danger'></i></button></td>\n\
                 </tr>";
        $(linha).appendTo('.corpoCompetencia');

        $("#id_competencia").val(0);
        $("#id_competencia").select2({
        });
    });
    //******************************************************************************************************************

    //************************************************* Exlui Competência **********************************************
    $("body").on("click", ".excluirLinha", function (e) {
        $(this).closest(".competenciaLinha").remove();
    });
    //******************************************************************************************************************

    //*********************************************** Exclui Lotação **************************************************
    $("body").on("click", ".excluirLinhaLotacao", function (e) {
        $(this).closest(".lotacaoLinha").remove();
    });
    //******************************************************************************************************************

    // ***************************** Mostra o campos de datav de demissão de acordo com o vinculo **********************
       $("body").on("change", "#id_vinculo", function (e) {
           var id = $(this).val();
           if (id == 5) {
               $(".demissao").show();
           } else {
               $(".demissao").hide();
           }
       });
    // *****************************************************************************************************************

    //************************************************ Salva o contrato ************************************************
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

            //****************** Dados pessoais *********************
            var DadosPessoa = {
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
            //********************************************************

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
            //******* Data admissao tem de ser inferior a data demissao ********
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
            //******************************** Dados que são obrigatorios ************************************
            var DadosObrigatorio = {
                //********* 1-12 **********
                "Email": DadosPessoa.email,
                "Nome Civil": DadosPessoaFisica.nomeCivil,
                "Sexo": DadosPessoaFisica.tpSexo,
                "Data de Nascimento": DadosPessoaFisica.dtNascimento,
                "Naturalidade": DadosPessoa.naturalidade,
                "CPF": DadosPessoaFisica.cpf,
                "Registro Geral": DadosPessoaFisica.rg,
                "Orgão Expedidor": DadosPessoaFisica.orgaoExpedidor,
                "Orgão Expedidor Estado": DadosPessoaFisica.orgaoExpedidorEst,
                "Nome da Mãe": DadosPessoaFisica.mae,
                "Estado Civil": DadosPessoaFisica.estadoCivil,
                "Escolaridade": DadosPessoaFisica.escolaridade,
                //*************************

                //********* 13-16 *********
                "Cidade Endereco": DadosPessoa.cidade,
                "Logradouro": DadosPessoa.logradouro,
                "Bairro": DadosPessoa.bairro,
                "Telefone Celular": DadosPessoa.telefone_celular,
                //*************************

                //********* 17-22 *********
                "Vínculo": DadosContrato.vinculo,
                "Empresa": DadosContrato.pessoaJuridica,
                "Data de Admissao": DadosContrato.dtAdmissao,
                "Carga Horária do Contrato": DadosContrato.nrCargaHoraria,
                "Matrícula": DadosContrato.nrMatricula,
                "Cargo": DadosContrato.idCargo
                //*************************
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

            if (x == 0) {
                func.modalAlert(func.msgPreencherCampos + " - <strong>Dados Funcionais (Informar Lotação e Função)</strong>");
                return false;
            }
            //********************************************************************************************
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
    //******************************************************************************************************************

    //*************************************************** Busca Cep ****************************************************
    $('body').on('click', '.cep', function (e) {
        $("#id_cidade").prop('disabled', false);
        $("#id_estado_endereco").prop('disabled', false);
        //*** Nova variável "cep" somente com dígitos. ***
        var cep = $("#nr_cep").val().replace(/\D/g, '');
        //************************************************

        //******* Verifica se campo cep possui valor informado.********
        if (cep != "") {
            //****** Expressão regular para validar o CEP. ******
            var validacep = /^[0-9]{8}$/;
            //***************************************************
            //****** Valida o formato do CEP. *******
            if (validacep.test(cep)) {
                //******* Preenche os campos com "..." enquanto consulta webservice. ******
                $("#ds_logradouro").val("");
                $("#ds_bairro").val("");
                $("#id_pais").val(0).trigger('change.select2');
                //*************************************************************************
                //***************** Consulta o webservice viacep.com.br/ ******************
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
                //**************************************************************************
            } else {
                //cep é inválido.
                func.modalAlert("Formato de CEP inválido.");
                return false;
            }
            //*********************************
        } else {
            func.modalAlert(func.msgPreencherCampos + " - <strong>Dados Endereço / Contato(CEP)</strong>");
            return false;
        }
        //*************************************************************
    });
    //******************************************************************************************************************

    //*********************** Recarrega a Página para os dados retornarema situação inicial ****************************
    $('body').on('click', '.btn-limpar', function (e) {
        location.reload();
    });
    //******************************************************************************************************************
});
