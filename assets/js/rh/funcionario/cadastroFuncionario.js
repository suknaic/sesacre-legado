$(document).ready(function () {

    func = new Funcoes();

    $(".select").select2({width: " 100%"});

    //***************************************** Cargo *****************************************
    function listaCargo() {
        $.ajax({
            "url": "/model/rh/funcionario/request.php",
            "dataType": 'html',
            "method": 'POST',
            "data": {
                acao: "listaCargoOption",
                id: 0
            },
            "success": function (response) {
                //console.log(response);
                $("#id_cargo").append(response);
            }
        });
    }

    listaCargo();
    //******************************************************************************************

    //**************************************** Funçao ******************************************
    function listaFuncao() {
        $.ajax({
            "url": "/model/rh/funcionario/request.php",
            "dataType": 'html',
            "data": {
                acao: "listaFuncaoOption"
            },
            "success": function (response) {
                // console.log(response);
                $("#id_funcao").append(response);
            }
        });
    }

    listaFuncao();
    //******************************************************************************************

    //************************************* Lotacao ********************************************
    function listaLotacao() {
        $.ajax({
            "url": "/model/rh/funcionario/request.php",
            "dataType": "html",
            "data": {
                "acao": "listaLotacaoOption"
            },
            "success": function (response) {
                $("#id_lotacao").append(response);
            }
        });
    }

    listaLotacao();
    //******************************************************************************************

    //*************************************** Vinculo ******************************************
    function listaVinculo() {
        $.ajax({
            "url": "/model/rh/funcionario/request.php",
            "dataType": 'html',
            "data": {
                acao: "listaVinculoOption"
            },
            "success": function (response) {
                $("#id_vinculo").append(response);
            }
        });
    }

    listaVinculo();
    //******************************************************************************************

    //********************************** Pais Naturalidade *************************************
    function listaPaisNaturalidade() {
        $.ajax({
            "url": "/model/rh/funcionario/request.php",
            "dataType": 'html',
            "data": {
                acao: "listaPaisOption"
            },
            "success": function (response) {
                $("#id_pais_naturalidade").append(response);
            }
        });
    }

    listaPaisNaturalidade();
    //******************************************************************************************

    //********************************** Estado Naturalidade ***********************************
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

    //******************************************************************************************

    //********************************** Cidade Naturalidade ***********************************
    function listaCidadeNaturalidade(estado = 0) {
        $.ajax({
            "url": "/model/rh/funcionario/request.php",
            "dataType": 'html',
            "data": {
                acao: "listaCidadeOption",
                idEstado: estado
            },
            "success": function (response) {
                $("#id_naturalidade").html(response);
            }
        });
    }

    //******************************************************************************************

    //************************************* Pais Endereço **************************************
    function listaPaisEndereco() {
        $.ajax({
            "url": "/model/rh/funcionario/request.php",
            "dataType": 'html',
            "data": {
                acao: "listaPaisOption"
            },
            "success": function (response) {
                $("#id_pais_endereco").append(response);
            }
        });
    }

    listaPaisEndereco();
    //******************************************************************************************

    //************************************* Estado Endereço ************************************
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

    //******************************************************************************************

    //************************************* Cidade Endereço ************************************
    function listaCidadeEndereco(estado = 0, cidade = null) {
        $.ajax({
            "url": "/model/rh/funcionario/request.php",
            "dataType": 'html',
            "data": {
                acao: "listaCidadeOption",
                idEstado: estado,
                nmCidade: cidade,
            },
            "success": function (response) {
                $("#id_cidade").html(response);
            }
        });
    }

    //******************************************************************************************

    //************************************ Estado Civil ***************************************
    function listaEstadoCivil() {
        $.ajax({
            "url": "/model/rh/funcionario/request.php",
            "dataType": 'html',
            "data": {
                acao: "listaEstadoCivilOption"
            },
            "success": function (response) {
                $("#id_estado_civil").append(response);
            }
        });
    }

    listaEstadoCivil();
    //******************************************************************************************

    //*************************************** Curso ********************************************
    function listaEscolaridadeFormacao() {
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

    listaEscolaridadeFormacao();
    //******************************************************************************************

    //*************************************** Escolaridade *************************************
    function listaEscolaridade() {
        $.ajax({
            "url": "/model/rh/funcionario/request.php",
            "dataType": 'html',
            "data": {
                acao: "listaEscolaridadeOption"
            },
            "success": function (response) {
                $("#id_escolaridade").append(response);
            }
        });
    }

    listaEscolaridade();
    //******************************************************************************************

    //************************************* Orgao Expeditor ************************************
    function listaOrgaoExpeditor() {
        $.ajax({
            "url": "/model/rh/funcionario/request.php",
            "dataType": 'html',
            "data": {
                acao: "listaOrgaoExpeditor",
                idPais: 1,
                orgaoExpedidor: '1'
            },
            "success": function (response) {
                $("#id_estado").html(response);
            }
        });
    }

    listaOrgaoExpeditor();
    //******************************************************************************************

    //************************************** Pessoa Jurídica ***********************************
    function listaPjCombo() {
        $.ajax({
            "url": "/model/rh/funcionario/request.php",
            "dataType": 'html',
            "data": {
                acao: "listaPessoaJuridicaOption"
            },
            "success": function (response) {
                $("#id_pessoa_juridica").append(response);
            }
        });
    }

    listaPjCombo();
    //******************************************************************************************

    // função do botão Próximo
    $(".pro").click(function () {
        $('.nav > .active').next('li').find('a').trigger('click');
    });
    // função do botão anterior
    $(".ant").click(function () {
        // aba que esta ativa no momento
        $('.nav > .active').prev('li').find('a').trigger('click');
    });
    //******************************************************************************************
    $("body").on("change", "#id_cidade", function (e) {
        $("#ds_logradouro").val("");
        $("#ds_bairro").val("");
        $("#ds_complemento").val("");
        $("#nr_cep").val("");
    });

    //************************************ Naturalidade ****************************************
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

    //******************************************************************************************
    $(".nr").mask("99");
    $("#nr_cns").mask("999 9999 9999 9999");
    $("#nr_cpf").mask("999.999.999-99");
    $("#nr_cep").mask("99999-999");
    $("#nr_telefone_residencial").mask("(99) 9999-9999");
    $("#nr_telefone_celular").mask("(99) 9 9999-9999");
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
    //*********************************************************************

    //*********************************************************************
    $("#dt_demissao").datepicker().on('changeDate', function () {
        $("#dt_fim").val($("#dt_demissao").val());
    });
    $('body').on('keypress', '#dt_demissao', function (e) {
        var key = e.which;
        if (key == 13) {
            $("#dt_fim").val($("#dt_demissao").val());
        }
    });
    $("#dt_admissao").datepicker().on('changeDate', function () {
        $("#dt_inicio").val($("#dt_admissao").val());
    });
    $('body').on('keypress', '#dt_admissao', function (e) {
        var key = e.which;
        if (key == 13) {
            $("#dt_inicio").val($("#dt_admissao").val());
        }
    });
    $('#nr_carga_horaria').on('focus blur', function (e) {
        $('#nr_carga_horaria2').val($('#nr_carga_horaria').val());
    });

//******************************************************************************************
    $("body").on("click", ".btn-add-lotacao", function (e) {

        var lotacaoId = $("#id_lotacao").val();
        var funcaoId = $("#id_funcao").val();
        var nr_carga_horaria = $("#nr_carga_horaria").val();
        var nr_carga_horaria2 = $("#nr_carga_horaria2").val();


        if (nr_carga_horaria <= 0) {
            func.modalAlert(func.msgPreencherCampos + " - <strong>Dados Funcionais (Data de admissão do Contrato)</strong>");
            return;
        }

        //******************************* Verifica se a data de admissão está vazia ****************************
        if ($("#dt_admissao").val() == "") {
            func.modalAlert(func.msgPreencherCampos + " - <strong>Dados Funcionais (Data de admissão do Contrato)</strong>");
            return;
        }
        //******************************************************************************************************

        //********************************** Verifica se a lotacao esta vazia **********************************
        if (lotacaoId == 0) {
            func.modalAlert(func.msgPreencherCampos + " - <strong>Dados Funcionais (Lotação)</strong>");
            return;
        }
        //******************************************************************************************************

        //************************************** Verifica se a funcao esta vazia *******************************
        if (funcaoId == 0) {
            func.modalAlert(func.msgPreencherCampos + " - <strong>Dados Funcionais (Função)</strong>");
            return;
        }
        //******************************************************************************************************

        //************************ Verifica se a carga horaria da lotacao esta vazia ***************************
        if (nr_carga_horaria2 == 0) {
            func.modalAlert(func.msgPreencherCampos + " - <strong>Dados Funcionais (Carga Horária da Lotação)</strong>");
            return;
        }

        var lotacao = $("#id_lotacao option:selected").text();
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
        $("#id_lotacao").val(0);
        $("#id_lotacao").select2({});
        $("#id_funcao").val(0);
        $("#id_funcao").select2({});
    });
    //******************************************************************************************
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
        //********************************************************************************
        var competencia = $("#id_competencia option:selected").text().split('-');
        var linha = "";
        linha = "<tr class='warning competenciaLinha'>\n\
                    <td class='text-center escolaridade' idEscolaridadeFormacao='" + competenciaId + "'>" + competencia[0] + "</td>\n\
                    <td class='text-center'>" + competencia[1] + "</td>\n\
                    <td class='text-center'><button type='button' title='Remover' class='excluirLinha' value=''><i class='fa fa-remove text-danger'></i></button></td>\n\
                 </tr>";
        $(linha).appendTo('.corpoTabela');

        $("#id_competencia").val(0);
        $("#id_competencia").select2({});
    });

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

            var cep = func.extrairCarater($("#nr_cep").val(), "-");
            var DadosPessoa = {
                //****************dados pessoais*********************
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
                senha: "$2y$14$rnt28R3reooTFh1exTRw9.aF08zbyP2Kio73YxgVeqh/3qZmCPbQ2",
                obs: $("#ds_observacao").val()
            };
            $cpf = $("#nr_cpf").val().replace(/(\.|\/|\-)/g, "");
            var DadosPessoaFisica = {
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

            //****************************************** DADOS FUNCIONAIS **********************************************
            //***************************** Data admissao tem de ser inferior a data demissao **************************
            if ($("#dt_demissao").val().length > 3) {
                var data1 = $("#dt_admissao").val();
                var data2 = $("#dt_demissao").val();
                var x = data1.split("/")[2].toString() + "/" + data1.split("/")[1].toString() + "/" + data1.split("/")[0].toString();
                var y = data2.split("/")[2].toString() + "/" + data2.split("/")[1].toString() + "/" + data2.split("/")[0].toString();
                var dataIni = new Date(x);
                var dataFim = new Date(y);

                if (dataIni > dataFim) {
                    func.modalAlert("A data de Admissão não pode ser maior que a data de Demissão");
                    return;
                }
            }
            //**********************************************************************************************************

            //************************* Carga Horaria dos Contratos permitidas são:20,24,30 e 44 *******************
            var DadosContrato = {
                nrMatricula: $("#nr_matricula").val(),
                dtAdmissao: $("#dt_admissao").val(),
                dtDemissao: $("#dt_demissao").val(),
                nrCargaHoraria: $("#nr_carga_horaria").val(),
                vinculo: $("#id_vinculo").val(),
                pessoaJuridica: $("#id_pessoa_juridica").val(),
                idCargo: $("#id_cargo").val()
            };
            //******************************************************************************************************

            var x = 0;
            if ($(this).closest(".formRhFuncionario").find(".lotacaoLinha").length > 0) {
                x = 1;
                var chTotal = 0;
                var DadosContrato_Lotacao = [];
                $("#tabelaLotacao tbody tr").each(function () {
                    DadosContrato_Lotacao.push({
                        chLotacao: $(this).find(".cargaLotacao").attr("ch"),
                        idLotacao: $(this).find(".lotacao").attr("idLotacao"),
                        idFuncao: $(this).find(".funcao").attr("idFuncao"),
                        dt_inicio: $(this).find(".dataIni").attr("dt_inicio"),
                        dt_fim: $(this).find(".dataFim").attr("dt_fim")
                    });
                    chTotal = chTotal + parseInt($(this).find(".cargaLotacao").attr("ch"));
                });
            }

            if (chTotal != DadosContrato.nrCargaHoraria) {
                func.modalAlert('Carga horária total das lotações deve ser igual a carga horária do contrato.');
            }
            //*******************************************************************
            var DadosObrigatorio = {
                //**************1-14***********************
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
                //***************15-20*****************************
                "País": DadosPessoa.pais,
                "Estado": DadosPessoa.estado,
                "Cidade": DadosPessoa.cidade,
                "Logradouro": DadosPessoa.logradouro,
                "Bairro": DadosPessoa.bairro,
                "Telefone Celular": DadosPessoa.telefone_celular,
                //******************21-27****************************
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
                    if ($i <= 14) {
                        func.modalAlert(func.msgPreencherCampos + " - <strong>Dados Pessoais (" + index + ")</strong>");
                    } else if ($i >= 15 && $i <= 20) {
                        func.modalAlert(func.msgPreencherCampos + " - <strong>Endereço / Contato (" + index + ")</strong>");
                    } else if ($i >= 21 && $i <= 27) {
                        func.modalAlert(func.msgPreencherCampos + " - <strong>Dados Funcionais (" + index + ")</strong>");
                    }
                    $campo = 1;
                    return false;
                }
            });
            if ($campo == 1) {
                return false;
            }

            //**********************************************************************************************************
            if (DadosContrato.nrMatricula == "" && DadosContrato.dtAdmissao == "" && DadosContrato.nrCargaHoraria == "" && DadosContrato.vinculo == 0
                && DadosContrato.nrCargaHoraria == 0 && DadosContrato.pessoaJuridica == 0 && DadosContrato.id_cargo == 0) {
                func.modalAlert(func.msgPreencherCampos + " (Dados Funcionais)");
                return false;
            }
            if (x == 0) {
                func.modalAlert(func.msgPreencherCampos + "<strong>(Lotação e Função)</strong>");
                return false;
            }
            //**********************************************************************************************************
            
            
            bootbox.confirm({
                title: `${func.msgRecadastramentoTitulo}`,                    
                message: `<span class="text-danger">${func.msgRecadastramentoOpcao}</span>                        
                    <br><br>  
                    <div class="form-group">

                        <div class="input-group">
                            <div class="radio-inline">
                                <label role="button">
                                    <input type="radio" name="opt_recadastramento" value="s">Sim
                                </label>
                            </div>
                            <div class="radio-inline">
                                <label role="button">
                                    <input type="radio" name="opt_recadastramento" value="n">Não
                                </label>
                            </div>
                        </div>
                    </div>`,  
                buttons: {
                    'cancel': {
                        label: 'Fechar',
                        className: 'btn-default btn-rounded'
                    },
                    'confirm': {
                        label: 'Salvar',
                        className: 'btn-primary btn-rounded'
                    }
                },
                callback: function (result) {
                    if (result) {                            
                        if($('input[name=opt_recadastramento]:checked', '.bootbox-body').length < 1 ){
                            func.modalAlert(`${func.msgRecadastramentoObrigatorio}`);                             
                        }else{                                                                
                            salvarContrato(DadosPessoa
                            , DadosPessoaFisica
                            , DadosCompetencia
                            , DadosContrato
                            , DadosContrato_Lotacao
                            , $('input[name=opt_recadastramento]:checked', '.bootbox-body').val())
                        }                            

                    }
                }
            });
                                    
            $this.prop("disabled", false);
        }
    });
    
    
    
    function salvarContrato(DadosPessoa, DadosPessoaFisica, DadosCompetencia, DadosContrato, DadosContrato_Lotacao, recadastramento){
        $.ajax({
            "url": "/model/rh/funcionario/request.php",
            "dataType": "html",
            "method": "POST",
            "data": {
                "acao": "cadastrarContrato",
                "dadosPessoa": DadosPessoa,
                "dadosPessoaFisica": DadosPessoaFisica,
                "dadosCompetencia": DadosCompetencia,
                "dadosContrato": DadosContrato,
                "dadosContrato_Lotacao": DadosContrato_Lotacao,
                "recadastramento" : recadastramento
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
                func.modalAlert(func.msgErroPadrao, 'danger');
                return false;
            }
        });
    }
    
    
    
    
    
    
    
    
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

    //************************** Naturalidade *************************
    $("#id_estado_naturalidade").attr('disabled', true);
    $("#id_naturalidade").attr('disabled', true);

    $("body").on("change", "#id_pais_naturalidade", function () {
        var texto = $(this).val();
        if (texto == 0) {
            $('#id_estado_naturalidade').val(0).trigger('change.select2');
            $("#id_naturalidade").val(0).trigger('change.select2');
            $('#id_estado_naturalidade').prop('disabled', true);
            $("#id_naturalidade").prop('disabled', true);
        }
    });

    $("body").on("change", "#id_pais_naturalidade", function () {
        var texto = $(this).val();
        if (texto != 0) {
            $('#id_estado_naturalidade').prop('disabled', false);
        } else {
            $('#id_estado_naturalidade').prop('disabled', true);
        }
    });

    $("body").on("change", "#id_estado_naturalidade", function () {
        var texto = $(this).val();
        if (texto != 0) {
            $("#id_naturalidade").prop('disabled', false);
        } else {
            $("#id_naturalidade").val(0).trigger('change.select2');
            $("#id_naturalidade").prop('disabled', true);
        }
    });
    //********************************************************************

    //**************************** Endereco ******************************
    $("#id_estado_endereco").attr('disabled', true);
    $("#id_cidade").attr('disabled', true);

    $("body").on("change", "#id_pais_endereco", function () {
        var texto = $(this).val();
        if (texto == 0) {
            $('#id_estado_endereco').val(0).trigger('change.select2');
            $("#id_cidade").val(0).trigger('change.select2');
            $('#id_estado_endereco').prop('disabled', true);
            $("#id_cidade").prop('disabled', true);
        }
    });

    $("body").on("change", "#id_pais_endereco", function () {
        var texto = $(this).val();
        if (texto != 0) {
            $('#id_estado_endereco').prop('disabled', false);
        } else {
            $('#id_estado_endereco').prop('disabled', true);
        }
    });

    $("body").on("change", "#id_estado_endereco", function () {
        var texto = $(this).val();
        if (texto != 0) {
            $("#id_cidade").prop('disabled', false);
        } else {
            $("#id_cidade").val(0).trigger('change.select2');
            $("#id_cidade").prop('disabled', true);
        }
    });
    //********************************************************************

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
                                    listaCidadeEndereco(response[0].id_estado, cidade);
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
        //**************************************************************************************************************
    });
    
    
    $('body').on('focusout', '#nm_email', function (e) {
        var $this = $(this)        
        if($this.val().length < 5){
            return false
        }
        $.ajax({
            "url": "/model/rh/funcionario/request.php",
            "dataType": "json",
            "method": "GET",
            "data": {
                "acao": "validaEmailExiste",
                "email": $this.val()                
            },
            "success": function (response) {
                console.log(response)
                if(response.tipoMsg == "Erro"){
                    func.modalAlert(response.msg);
                }else{
                    $(".pro").trigger('click');
                }               
            },
            "error": function (response) {
                console.log(response)                
            }
        });
    });
//   URL: viacep.com.br/ws/01001000/json/ 
//    {
//      "cep": "01001-000",
//      "logradouro": "Praça da Sé",
//      "complemento": "lado ímpar",
//      "bairro": "Sé",
//      "localidade": "São Paulo",
//      "uf": "SP",
//      "unidade": "",
//      "ibge": "3550308",
//      "gia": "1004"
//    }
});
