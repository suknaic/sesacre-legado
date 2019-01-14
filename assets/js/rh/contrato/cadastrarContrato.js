$(document).ready(function () {

    //************ Select2 ***********
    $(".select").select2({width: " 100%"});
    //********************************

    func = new Funcoes();

    //******************************************* Carrega dados da pessoa **********************************************
    function returnContratoEditar() {
        var cpf = $("#cpf").val();
        $.ajax({
            "url": "/model/rh/funcionario/request.php",
            "dataType": 'html',
            "data": {
                acao: "retornaPessoaFisica",
                cpf: cpf
            },
            "success": function (response) {
                try {
                    response = JSON.parse(response);
                } catch (e) {
                    console.log(response);
                    return false;
                }
                $cpf = response[0]['nr_cpf'].replace(/(\d{3})(\d{3})(\d{3})(\d{2})/g, "\$1.\$2.\$3\-\$4");
                $("#nm_email").val(response[0]['nm_email']);
                $("#nm_civil").val(response[0]['nm_civil']);
                $("#nm_nome").val(response[0]['nm_social']);
                $("#dt_nascimento").val(response[0]['dt_nascimento']);
                //**************************************************************************
                listaPaisNaturalidade(response[0]['id_pais_naturalidade']);
                listaEstadoNaturalidade(response[0]['id_pais_naturalidade'], response[0]['id_estado_naturalidade']);
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
                listaOrgaoExpeditor(response[0]['id_estado_orgao_expedidor']);
                listaEstadoCivilCombo(response[0]['id_estado_civil']);
                listaEscolaridadeCombo(response[0]['id_escolaridade']);
                $("#ds_habilidade").val(response[0]['ds_habilidade']);
                $("#ds_logradouro").val(response[0]['ds_logradouro']);
                $("#ds_complemento").val(response[0]['ds_complemento']);
                $("#nr_endereco").val(response[0]['nr_numero']);
                $("#ds_bairro").val(response[0]['ds_bairro']);
                $("#nr_cep").val(response[0]['nr_cep']);
                //**********************************************************************
                $("#nr_endereco").val(response[0]['nr_numero']);
                listaPaisEndereco(response[0]['id_pais_endereco']);
                listaEstadoEndereco(response[0]['id_pais_endereco'], response[0]['id_estado_endereco']);
                listaCidadeEndereco(response[0]['id_estado_endereco'], response[0]['id_cidade_endereco']);
                //*************************************************************************
                $("#nr_telefone_residencial").val(response[0]['nr_telefone_residencial']);
                $("#nr_telefone_celular").val(response[0]['nr_telefone_celular']);
                $("#ds_observacao").val(response[0]['ds_observacao']);
                $("#nr_matricula").val(response[0]['nr_matricula']);
                returnCompetencia(response[0]['id_pessoa_fisica']);
                listaVinculoCombo(response[0]['id_vinculo']);
                listaPjCombo(response[0]['id_pessoa_juridica']);
                listaCargoCombo(response[0]['id_cargo']);

                $(".nr").mask("99");
                $("#nr_cpf").mask("999.999.999-99");
                $("#nr_cep").mask("99999-999");
                $(".data").mask("99/99/9999");
                $("#nr_telefone_residencial").mask("(99) 9999-9999");
                $("#nr_telefone_celular").mask("(99) 9 9999-9999");
                $("#nr_cns").mask("999 9999 9999 9999");
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
                acao: "listaOrgaoExpeditor"
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

    //************************************* Carrega os cursos da pessoa na tabela **************************************
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

    $('#dt_admissao').datepicker({
        format: 'dd/mm/yyyy',
        language: "pt-BR"
    });
    $('#dt_demissao').datepicker({
        format: 'dd/mm/yyyy',
        language: "pt-BR"
    });
    $("#dt_admissao").datepicker().on('changeDate', function () {
        $("#dt_inicio").val($("#dt_admissao").val());
    });
    $("#dt_demissao").datepicker().on('changeDate', function () {
        $("#dt_fim").val($("#dt_demissao").val());
    });
    $('body').on('keypress', '#dt_admissao', function (e) {
        var key = e.which;
        if (key == 13) {
            $("#dt_inicio").val($("#dt_admissao").val());
        }
    });
    $('body').on('keypress', '#dt_demissao', function (e) {
        var key = e.which;
        if (key == 13) {
            $("#dt_fim").val($("#dt_demissao").val());
        }
    });

    $('#nr_carga_horaria').on('focus blur', function (e) {
        $('#nr_carga_horaria2').val($('#nr_carga_horaria').val())
    });
    //*********************************************************************

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

    //********************************** Carrega as mascaras e calendarios nos campos *********************************
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

    $(".bloqueia").prop('disabled', false);
    //********************************************* Adiciona Lotação ***************************************************
    $("body").on("click", ".btn-add-lotacao", function (e) {
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
            func.modalAlert(" Carga Horária da Lotação excede a Carga Horária do Funcionário");
            return;
        }

        //********************************************************************************
        if (lotacaoId == 0) {
            func.modalAlert(func.msgPreencherCampos + " - <strong>Dados Funcionais(Lotação)</strong>");
            $("#id_lotacao").focus();
            return;
        }
        if (funcaoId == 0) {
            func.modalAlert(func.msgPreencherCampos + " - <strong>Dados Funcionais(Função)</strong>");
            $("#id_funcao").focus();
            return;
        }
        if (nr_carga_horaria2 == 0) {
            func.modalAlert(func.msgPreencherCampos + " - <strong>Dados Funcionais(Carga Horária da Lotação)</strong>");
            $("#nr_carga_horaria2").focus();
            return;
        }
        if ($("#dt_inicio").val() == "") {
            func.modalAlert(func.msgPreencherCampos + " - <strong>Dados Funcionais(Data de Início da Função na Lotação)</strong>");
            return;
        }

        if (idContrato == 0) {
            var lotacao = $("#id_lotacao option:selected").text();
            var funcao = $("#id_funcao option:selected").text();
            //********************************************************************************
            var cont = null;
            if ($("#cont").val() === '') {
                cont = 0;
            } else {
                cont = $("#cont").val();
            }
            var linha = "";
            /*linha = "<tr class='warning lotacaoLinha' id='" + cont + "'>\n\
                    <td class='text-center lotacao' idLotacao='" + lotacaoId + "'>" + lotacao + "</td>\n\
                    <td class='text-center funcao' idFuncao='" + funcaoId + "'>" + funcao + "</td>\n\
                    <td class='text-center cargaLotacao'ch='" + nr_carga_horaria2 + "'>" + nr_carga_horaria2 + "</td>\n\
                    <td class='text-center dataIni' dt_inicio='" + $("#dt_inicio").val() + "'>" + $("#dt_inicio").val() + "</td>\n\
                    <td class='text-center dataFim' dt_fim='" + $("#dt_fim").val() + "'>" + $("#dt_fim").val() + "</td>\n\
                    <td class='text-center buttons'><button type='button' title='Editar' class='editarLinhaLotacao' value='" + cont + "'><i class='fa fa-edit text-primary'></i></button><button type='button' title='Remover' class='excluirLinhaLotacao' value=''><i class='fa fa-remove text-danger'></i></button></td>\n\
                 </tr>";*/
            linha = "<tr class='warning lotacaoLinha' id='" + cont + "'>\n\
                    <td class='text-center lotacao' idLotacao='" + lotacaoId + "'>" + lotacao + "</td>\n\
                    <td class='text-center funcao' idFuncao='" + funcaoId + "'>" + funcao + "</td>\n\
                    <td class='text-center cargaLotacao'ch='" + nr_carga_horaria2 + "'>" + nr_carga_horaria2 + "</td>\n\
                    <td class='text-center dataIni' dt_inicio='" + $("#dt_inicio").val() + "'>" + $("#dt_inicio").val() + "</td>\n\
                    <td class='text-center dataFim' dt_fim='" + $("#dt_fim").val() + "'>" + $("#dt_fim").val() + "</td>\n\
                    <td class='text-center buttons'><button type='button' title='Remover' class='excluirLinhaLotacao' value=''><i class='fa fa-remove text-danger'></i></button></td>\n\
                 </tr>";
            $(linha).appendTo('.corpoTabelaLotacao');
            $("#cont").val(++cont);
            $("#nr_carga_horaria2").val("");
            $("#dt_inicio").val("");
            $("#dt_fim").val("");
            //***********************************************************************************
            $("#id_lotacao").val('0').change();
            $("#id_lotacao").select2({width: "100%"});
            $("#id_funcao").val('0').change();
            $("#id_funcao").select2({width: "100%"});
            $(".bloqueia").prop('disabled', false);
        }
    });
    //******************************************************************************************************************

    //******************************* Edita a linha inserida caso os dados estejam erradoa *****************************
    $("body").on("click", ".editarLinhaLotacao", function (e) {
        var linha = $(this).closest('td').find('.editarLinhaLotacao').attr("value");
        $('#' + linha).each(function () {
            coluna = $(this).attr('id');
            $('#id_lotacao').val($(this).find('.lotacao').attr("idLotacao"));
            $('#id_lotacao').select2({width: "100%"});
            $('#id_funcao').val($(this).find('.funcao').attr("idFuncao"));
            $('#id_funcao').select2({width: "100%"});
            $('#nr_carga_horaria2').val($(this).find('.cargaLotacao').attr("ch"));
            $('#dt_inicio').val($(this).find('.dataIni').attr("dt_inicio"));
            $('#dt_fim').val($(this).find('.dataFim').attr("dt_fim"));
            $('#' + linha).remove();
            return false;
        });
        $(".bloqueia").prop('disabled', true);
    });
    //******************************************************************************************************************

    //*********************************************** Adicionar Competência ********************************************
    $("body").on("click", ".btn-add", function (e) {
        var competenciaId = $("#id_competencia").val();
        if (competenciaId == 0) {
            func.modalAlert('Informe a Competência.');
            $("#id_competencia").focus();
            return;
        }
        var flag = 0;
        //*********************************************************************************
        if ($(this).closest(".panelCompetencia").find(".competenciaLinha").length > 0) {
            $("#tabela tbody tr").each(function () {
                if (competenciaId == $(this).find(".escolaridade").attr("idEscolaridadeFormacao")) {
                    flag = 1;
                    func.modalAlert(" O Item já Existe.");
                }
            });
        }

        if (flag == 1) {
            return;
        }
        //********************************************************************************* 
        var competencia = $("#id_competencia option:selected").text().split('-');
        var linha = "";
        linha = "<tr class='warning competenciaLinha'>\n\
                    <td class='text-center escolaridade' idEscolaridadeFormacao='" + competenciaId + "'>" + competencia[0] + "</td>\n\
                    <td class='text-center'>" + competencia[1] + "</td>\n\
                    <td class='text-center'><button type='button' title='Remover' class='excluirLinha' value=''><i class='fa fa-remove text-danger'></i></button></td>\n\
                 </tr>";
        $(linha).appendTo('.corpoCompetencia');

        $("#id_competencia").val(0);
        $("#id_competencia").select2({});
    });
    //******************************************************************************************************************

    //*********************************** Destroi uma linha das competencias *******************************************
    $("body").on("click", ".excluirLinha", function (e) {
        $(this).closest(".competenciaLinha").remove();
    });
    //******************************************************************************************************************

    //*********************************** Destroi uma linha das lotacoes ***********************************************
    $("body").on("click", ".excluirLinhaLotacao", function (e) {
        $(this).closest(".lotacaoLinha").remove();
    });
    //******************************************************************************************************************

    //********************************************** Salva todos os dados **********************************************
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
                paisNaturalidade: $("#id_pais_naturalidade").val(),
                estadoNaturalidade: $("#id_estado_naturalidade").val(),
                naturalidade: $("#id_naturalidade").val(),
                logradouro: $("#ds_logradouro").val(),
                complemento: $("#ds_complemento").val(),
                numero: $('#nr_endereco').val(),
                bairro: $("#ds_bairro").val(),
                cep: cep,
                pais: $("#id_pais_endereco").val(),
                estado: $("#id_estado_endereco").val(),
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

            //*************************************** Competencias *************************************************
            if ($(this).closest(".formRhFuncionario").find(".competenciaLinha").length > 0) {
                var DadosCompetencia = [];
                $("#tabela tbody tr").each(function () {
                    DadosCompetencia.push({
                        id_escolaridade_formacao: $(this).find(".escolaridade").attr("idEscolaridadeFormacao")
                    });
                });
            }
            //******************************************************************************************************

            chHorariaTotal = 0;
            DadosContrato_Lotacao.forEach(function (chHoraria) {
                chHorariaTotal += parseInt(chHoraria.chLotacao);
            });

            if (chHorariaTotal != parseInt(DadosContrato.nrCargaHoraria)) {
                func.modalAlert('A Carga Horária Total das Lotações é Menor ou Maior a Carga Horária do Contrato.');
                return;
            }

            //******************************************************************
            var DadosObrigatorio = {
                "E-mail": DadosPessoa.email,
                "Nome Civil": DadosPessoaFisica.nomeCivil,
                "Sexo": DadosPessoaFisica.tpSexo,
                "Data de Nascimento": DadosPessoaFisica.dtNascimento,
                "Pais de Naturalidade": DadosPessoa.paisNaturalidade,
                "Estado de Naturalidade": DadosPessoa.estadoNaturalidade,
                "Cidade de Naturalidade": DadosPessoa.naturalidade,
                "CPF": DadosPessoaFisica.cpf,
                "Registro Geral": DadosPessoaFisica.rg,
                "Órgão Expedidor": DadosPessoaFisica.orgaoExpedidor,
                "Estado do Órgão Expedidor": DadosPessoaFisica.orgaoExpedidorEst,
                "Nome da Mãe": DadosPessoaFisica.mae,
                "Estado Civil": DadosPessoaFisica.estadoCivil,
                "Escolaridade": DadosPessoaFisica.escolaridade,
                //***************15-21*****************************
                "País": DadosPessoa.pais,
                "Estado": DadosPessoa.estado,
                "Cidade": DadosPessoa.cidade,
                "Logradouro": DadosPessoa.logradouro,
                "Bairro": DadosPessoa.bairro,
                "Telefone Celular": DadosPessoa.telefone_celular,
                //******************22-28****************************
                "Vínculo": DadosContrato.vinculo,
                "Empresa": DadosContrato.pessoaJuridica,
                "Data de Admissão": DadosContrato.dtAdmissao,
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
                        func.modalAlert(func.msgPreencherCampos + "<strong>(" + index + ")</strong>");
                    } else if ($i >= 13 && $i <= 16) {
                        func.modalAlert(func.msgPreencherCampos + "<strong>(" + index + ")</strong>");
                    } else if ($i >= 17 && $i <= 22) {
                        func.modalAlert(func.msgPreencherCampos + "<strong>(" + index + ")</strong>");
                    }
                    $campo = 1;
                    return false;
                }
            });
            if ($campo == 1) {
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
                    "dadosCompetencia": DadosCompetencia,
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
                        func.fechaModalHref('/pages/rh/funcionario/index.php');
                        return false;
                    } else {
                        console.log(response);
                        func.modalAlert(func.msgErroPadrao, 'danger');
                        return false;
                    }
                },
                "error": function (response) {
                    $this.prop("disabled", false);
                    console.log(response);
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
                                    listaCidadeEndereco(response[0].id_estado, 0, cidade);
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

    $('body').on('click', '.btn-limpar', function (e) {
        location.reload();
    });

    $('.modal-alert').on('shown.bs.modal', function (e) {
        $("#nome").focus();
    });

    $('body').on('keypress', '.formRhFuncionario', function (e) {
        var key = e.which;
        if (key == 13) {
            $(".btn-salvar").trigger('click');
            return false;
        }
    });
});
