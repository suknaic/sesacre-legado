$(document).ready(function () {

    func = new Funcoes();

    //********************* Select2 *******************
    $(".select").select2({width: " 100%"});
    //*************************************************

    function returnPessoaFisicaEditar() {
        var id_get = $("#id_get").val();
        var idPessoaFisica = id_get.split("-")[1];
        $.ajax({
            "url": "/model/sistema/pessoa/request.php",
            "dataType": "html",
            "method": "POST",
            "data": {
                "acao": "returnPessoaFisicaEditar",
                "id_get": id_get
            },
            "success":
                function (response) {
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
                    $("#ds_habilidade").val(response[0]['ds_habilidade']);
                    $("#ds_logradouro").val(response[0]['ds_logradouro']);
                    $("#ds_complemento").val(response[0]['ds_complemento']);
                    $("#ds_bairro").val(response[0]['ds_bairro']);
                    $("#nr_cep").val(response[0]['nr_cep']);
                    $("#nr_cep").mask("99999-999");
                    listaOrgaoExpeditor(response[0]['id_estado_orgao_expedidor']);
                    listaEstadoCivilCombo(response[0]['id_estado_civil']);
                    listaEscolaridadeCombo(response[0]['id_escolaridade']);
                    //**********************************************************************
                    $("#nr_endereco").val(response[0]['nr_numero']);
                    listaPaisEndereco(response[0]['id_pais_endereco']);
                    listaEstadoEndereco(response[0]['id_pais_endereco'], response[0]['id_estado_endereco']);
                    listaCidadeEndereco(response[0]['id_estado_endereco'], response[0]['id_cidade']);
                    //*************************************************************************
                    $("#nr_telefone_residencial").val(response[0]['nr_telefone_residencial']);
                    $("#nr_telefone_celular").val(response[0]['nr_telefone_celular']);
                    $("#nr_telefone_residencial").mask("(99) 9999-9999");
                    $("#nr_telefone_celular").mask("(99) 9 9999-9999");
                    $("#ds_observacao").val(response[0]['ds_observacao']);
                    returnCompetencia(idPessoaFisica);
                }
        });
    }

    //************************************* Carrega os cursos da pessoa na tabela **************************************
    function returnCompetencia(id_pessoa_fisica) {
        var DadosPessoa = {
            id_pessoa_fisica: id_pessoa_fisica,
            contrato: 0
        };
        $.ajax({
            "url": "/model/sistema/pessoa/request.php",
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

    //********************************** Pais Naturalidade *************************************
    function listaPaisNaturalidade(idPais) {
        $.ajax({
            "url": "/model/sistema/pessoa/request.php",
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
    //******************************************************************************************

    //************************** Naturalidade *************************
    // $("#id_estado_naturalidade").attr('disabled', true);
    // $("#id_naturalidade").attr('disabled', true);
    //
    // $("body").on("change", "#id_pais_naturalidade", function () {
    //     var texto = $(this).val();
    //     if (texto == 0) {
    //         $('#id_estado_naturalidade').val(0).trigger('change.select2');
    //         $("#id_naturalidade").val(0).trigger('change.select2');
    //         $('#id_estado_naturalidade').prop('disabled', true);
    //         $("#id_naturalidade").prop('disabled', true);
    //     }
    // });
    //
    // $("body").on("change", "#id_pais_naturalidade", function () {
    //     var texto = $(this).val();
    //     if (texto != 0) {
    //         $('#id_estado_naturalidade').prop('disabled', false);
    //     } else {
    //         $('#id_estado_naturalidade').prop('disabled', true);
    //     }
    // });
    //
    // $("body").on("change", "#id_estado_naturalidade", function () {
    //     var texto = $(this).val();
    //     if (texto != 0) {
    //         $("#id_naturalidade").prop('disabled', false);
    //     } else {
    //         $("#id_naturalidade").val(0).trigger('change.select2');
    //         $("#id_naturalidade").prop('disabled', true);
    //     }
    // });
    //********************************************************************

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

    //******************************************* Carrega os Dados de Endereço *****************************************
    function listaPaisEndereco(idPais = 0) {
        $.ajax({
            "url": "/model/sistema/pessoa/request.php",
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

    function listaCidadeEndereco(idEstado = 0, idCidade = 0, nmCidade = null) {
        $.ajax({
            "url": "/model/sistema/pessoa/request.php",
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

    //**************************** Endereco ******************************
    // $("#id_estado_endereco").attr('disabled', true);
    // $("#id_cidade").attr('disabled', true);
    //
    // $("body").on("change", "#id_pais_endereco", function () {
    //     var texto = $(this).val();
    //     if (texto == 0) {
    //         $('#id_estado_endereco').val(0).trigger('change.select2');
    //         $("#id_cidade").val(0).trigger('change.select2');
    //         $('#id_estado_endereco').prop('disabled', true);
    //         $("#id_cidade").prop('disabled', true);
    //     }
    // });
    //
    // $("body").on("change", "#id_pais_endereco", function () {
    //     var texto = $(this).val();
    //     if (texto != 0) {
    //         $('#id_estado_endereco').prop('disabled', false);
    //     } else {
    //         $('#id_estado_endereco').prop('disabled', true);
    //     }
    // });
    //
    // $("body").on("change", "#id_estado_endereco", function () {
    //     var texto = $(this).val();
    //     if (texto != 0) {
    //         $("#id_cidade").prop('disabled', false);
    //     } else {
    //         $("#id_cidade").val(0).trigger('change.select2');
    //         $("#id_cidade").prop('disabled', true);
    //     }
    // });
    //********************************************************************

    //************************************************* Regras dos Dados do Endereço *******************************************************
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

    //******************************************************************************************
    function listaEstadoCivilCombo(id) {
        $.ajax({
            "url": "/model/sistema/pessoa/request.php",
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

    //******************************************************************************************
    function listaEscolaridadeFormacaoCombo() {
        $.ajax({
            "url": "/model/sistema/pessoa/request.php",
            "dataType": 'html',
            "data": {
                acao: "listaEscolaridadeFormacaoOption"
            },
            "success": function (response) {
                //  console.log(response);
                $(".formacao").append(response);
            }
        });
    }

    listaEscolaridadeFormacaoCombo();
    //******************************************************************************************

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

    function listaEscolaridadeCombo(id) {
        $.ajax({
            "url": "/model/sistema/pessoa/request.php",
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
    //******************************************************************************************

    //**********************************função do botão Próximo ********************************
    $(".pro").click(function () {
        $('.nav > .active').next('li').find('a').trigger('click');

    });
    // função do botão anterior
    $(".ant").click(function () {
        // aba que esta ativa no momento
        $('.nav > .active').prev('li').find('a').trigger('click');
    });

    $("body").on("change", "#id_cidade", function (e) {
        $("#ds_logradouro").val("");
        $("#ds_bairro").val("");
        $("#ds_complemento").val("");
        $("#nr_cep").val("");

    });
    //*******************************************************************************************

    //****************************** Chama funcao para carrregar dados **************************
    returnPessoaFisicaEditar();
    //*******************************************************************************************

    $(".nr").mask("99");
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

    //*********************************************** Adicionar Competência ********************************************
    $("body").on("click", ".btn-add", function (e) {
        var competenciaId = $("#id_competencia").val();
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
        var competencia = $("#id_competencia option:selected").text().split('-');
        var linha = "";
        linha = "<tr class='warning competenciaLinha'>\n\
                    <td class='text-center escolaridade' idEscolaridadeFormacao='" + competenciaId + "'>" + competencia[0] + "</td>\n\
                    <td class='text-center'>" + competencia[1] + "</td>\n\
                    <td class='text-center'><button type='button' title='Remover' class='excluirLinha' value=''><i class='fa fa-remove text-danger'></i></button></td>\n\
                 </tr>";
        $(linha).appendTo('.corpoCompetencia');

        $("#id_competencia").val('0').change();
        $("#id_competencia").select2({});
    });
    //******************************************************************************************************************

    //************************************************* Exclui Competência *********************************************
    $("body").on("click", ".excluirLinha", function (e) {
        $(this).closest(".competenciaLinha").remove();
    });
    //******************************************************************************************************************

    $('body').on('click', '.btn-salvar', function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else {
            e.preventDefault();
            var $this = $(this);
            var idPessoaFisica = ($("#id_pessoa_fisica").val());
            var idPessoa = ($("#id_pessoa").val());
            //$this.prop("disabled", true);

            var cep = func.extrairCarater($("#nr_cep").val(), "-");
            var DadosPessoa = {
                //****************dados pessoais*********************
                idPessoa: idPessoa,
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
                senha: "Palmeiras",
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
            //******************************************************************
            var DadosObrigatorio = {
                email: DadosPessoa.email,
                //*************************************
                nomeCivil: DadosPessoaFisica.nomeCivil,
                Sexo: DadosPessoaFisica.tpSexo,
                dataNascimento: DadosPessoaFisica.dtNascimento,
                naturalidade: DadosPessoa.naturalidade,
                cpf: DadosPessoaFisica.cpf,
                rg: DadosPessoaFisica.rg,
                orgaoExpedidor: DadosPessoaFisica.orgaoExpedidor,
                orgaoExpedidorEstado: DadosPessoaFisica.orgaoExpedidorEst,
                mae: DadosPessoaFisica.mae,
                //********************************************
                cidadeEndereco: DadosPessoa.cidade,
                logradouro: DadosPessoa.logradouro,
                bairro: DadosPessoa.bairro,
                telefoneCelular: DadosPessoa.telefone_celular

            };

            $campo = 0;
            $i = 0;
            $.each(DadosObrigatorio, function (index, value) {
                $i++;
                $campo = "";
                if (value == 0 || value == "" || value == null) {
                    //console.log($i+"-"+index+"=>"+value);
                    if ($i <= 10) {
                        func.modalAlert(func.msgPreencherCampos + " - Dados Pessoais (" + index + ")");
                    } else if ($i >= 11 && $i <= 14) {
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

            //*************************** Competencias ********************************
            if ($(this).closest(".formRhFuncionario").find(".competenciaLinha").length > 0) {
                var DadosCompetencia = [];
                $("#tabela tbody tr").each(function () {
                    DadosCompetencia.push({
                        id_escolaridade_formacao: $(this).find(".escolaridade").attr("idEscolaridadeFormacao")
                    });
                });
            }
            //**************************************************************************

            //***********************************************
            $.ajax({
                "url": "/model/sistema/pessoa/request.php",
                "dataType": "html",
                "method": "POST",
                "data": {
                    "acao": "editarPessoaFisica",
                    "dadosPessoa": DadosPessoa,
                    "dadosCompetencia": DadosCompetencia,
                    "dadosPessoaFisica": DadosPessoaFisica
                },

                "success": function (response) {
                    //$this.prop("disabled", false);
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
                            console.log(response);
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
                        //top.location = "/pages/rh/pessoaFisica/index.php";
                    } else {
                        console.log('Ultimo else');
                        console.log(response);
                        func.modalAlert(func.msgErroPadrao);
                        return false;
                    }
                },
                "error": function (response) {
                    $this.prop("disabled", false);
                    console.log(response);
                    func.modalAlert(func.msgErroPadrao);
                    return false;
                }
            });
            $this.prop("disabled", false);
        }
    });


    $('body').on('click', '.btn-limpar', function (e) {

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
    //*************************************************************************************************

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
});
