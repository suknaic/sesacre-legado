$(document).ready(function () {

    func = new Funcoes();

    //**************** Select2 ************
    $(".select").select2({width: "100%"});
    //*************************************

    //********************************** Pais Naturalidade *************************************
    function listaPaisNaturalidade() {
        $.ajax({
            "url": "/model/sistema/pessoa/request.php",
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
            "url": "/model/sistema/pessoa/request.php",
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
            "url": "/model/sistema/pessoa/request.php",
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

    //************************************* Pais Endereço **************************************
    function listaPaisEndereco() {
        $.ajax({
            "url": "/model/sistema/pessoa/request.php",
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
            "url": "/model/sistema/pessoa/request.php",
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
            "url": "/model/sistema/pessoa/request.php",
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

    //********************************************* Função do botão Próximo ********************************************
    $(".pro").click(function () {
        $('.nav > .active').next('li').find('a').trigger('click');
    });

    $(".ant").click(function () {
        $('.nav > .active').prev('li').find('a').trigger('click');
    });
    //******************************************************************************************************************

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

    //*************************************** Escolaridade *************************************
    function listaEscolaridade() {
        $.ajax({
            "url": "/model/sistema/pessoa/request.php",
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
            "url": "/model/sistema/pessoa/request.php",
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

    //************************************ Estado Civil ***************************************
    function listaEstadoCivil() {
        $.ajax({
            "url": "/model/sistema/pessoa/request.php",
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

    //****************** Letras Maiúsculas *************
    $("#ds_orgao_expedidor").keyup(function(){
        $(this).val($(this).val().toUpperCase());
    });
    //**************************************************

//******************************************************************************************
    $("body").on("click", ".btn-add", function (e) {

        var competenciaId = $("#id_competencia").val();
        if (competenciaId == 0) {
            alert("informe Competência");
            $("#id_competencia").focus();
            return;
        }
        var flag = 0;
        //********************************************************************************* 
        if ($(this).closest(".panelCompetencia").find(".competenciaLinha").length > 0) {
            $("#tabela tbody tr").each(function () {
                if (competenciaId == $(this).find(".escolaridade").attr("idEscolaridadeFormacao")) {
                    flag = 1;
                    func.modalAlert(" O Item já Existe!!!")
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
//******************************************************************************************
    $("body").on("click", ".excluirLinha", function (e) {
        $(this).closest(".competenciaLinha").remove();
    });
//******************************************************************************************

//******************************************************************************************
    $('body').on('click', '.btn-salvar', function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else {
            e.preventDefault();
            var $this = $(this);
            //$this.prop("disabled", true);

            var cep = func.extrairCarater($("#nr_cep").val(), "-");
            var DadosPessoa = {
                //****************dados pessoais*********************
                nomeSocial: $("#nm_nome").val(),
                naturalidade: $("#id_naturalidade").val(),
                logradouro: $("#ds_logradouro").val(),
                complemento: $("#ds_complemento").val(),
                bairro: $("#ds_bairro").val(),
                numero: $('#nr_endereco').val(),
                cep: cep,
                cidade: $("#id_cidade").val(),
                telefone_residencial: $("#nr_telefone_residencial").val(),
                telefone_celular: $("#nr_telefone_celular").val(),
                email: $("#nm_email").val(),
                senha: "dd25mm05aaaa2005",
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
            //***************competencias************************************
            if ($(this).closest(".formRhFuncionario").find(".competenciaLinha").length > 0) {
                var DadosCompetencia = [];
                $("#tabela tbody tr").each(function () {
                    DadosCompetencia.push({
                        id_escolaridade_formacao: $(this).find(".escolaridade").attr("idEscolaridadeFormacao")
                    })
                });
            }
            //******************************************************************
            var DadosObrigatorio = {
                "E-mail": DadosPessoa.email,
                //*************************************
                "Nome Civil": DadosPessoaFisica.nomeCivil,
                "Sexo": DadosPessoaFisica.tpSexo,
                "Data de Nascimento": DadosPessoaFisica.dtNascimento,
                "País Naturalidade": $("#id_pais_naturalidade").val(),
                "Estado Naturalidade": $("#id_estado_naturalidade").val(),
                "Cidade Naturalidade": DadosPessoa.naturalidade,
                "CPF": DadosPessoaFisica.cpf,
                "Registro Geral": DadosPessoaFisica.rg,
                "Estado Civil": DadosPessoaFisica.estadoCivil,
                "Órgão Expedidor": DadosPessoaFisica.orgaoExpedidor,
                "Estado do Órgão Expedidor": DadosPessoaFisica.orgaoExpedidorEst,
                "Mãe": DadosPessoaFisica.mae,
                //********************************************
                "País": $("#id_pais_endereço").val(),
                "Estado": $("#id_estado_endereço").val(),
                "Cidade": DadosPessoa.cidade,
                "Logradouro": DadosPessoa.logradouro,
                "Bairro": DadosPessoa.bairro,
                "Telefone Celular": DadosPessoa.telefone_celular
            };

            $campo = 0;
            $i = 0;
            $.each(DadosObrigatorio, function (index, value) {
                $i++;
                $campo = "";
                if (value == 0 || value == "" || value == null) {
                    if ($i <= 13) {
                        func.modalAlert(func.msgPreencherCampos + " - Dados Pessoais (" + index + ")");
                    } else if ($i >= 14 && $i <= 19) {
                        func.modalAlert(func.msgPreencherCampos + "  - Endereço / Contato (" + index + ")");
                    }
                    console.log($i + "-" + index + "=>" + value);
                    $campo = 1;
                    return false;
                }
            });
            if ($campo == 1) {
                return false;
            }


            //***********************************************
            $.ajax({
                "url": "/model/sistema/pessoa/request.php",
                "dataType": "html",
                "method": "POST",
                "data": {
                    "acao": "cadastrarPessoaFisica",
                    "dadosPessoa": DadosPessoa,
                    "dadosPessoaFisica": DadosPessoaFisica,
                    "dadosCompetencia": DadosCompetencia
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
                        func.fechaModalReload();
                        return false;
                    } else {
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
    //******************************************************************************************
    $("body").on("change", "#id_cidade", function (e) {
        $("#ds_logradouro").val("");
        $("#ds_bairro").val("");
        $("#ds_complemento").val("");
        $("#nr_cep").val("");

    });

    $('body').on('click', '.btn-limpar', function (e) {
        $("#nome").val("");
        $("#dt_inicio").val("");
        $("#dt_fim").val("");
    });
    $('.modal-alert').on('shown.bs.modal', function (e) {
        $("#nome").focus();
    });
    $('body').on('keypress', '.formPessoFisica', function (e) {
        var key = e.which;
        if (key == 13) {
            $(".btn-salvar").trigger('click');
            return false;
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
                            "url": "/model/sistema/pessoa/request.php",
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
});
