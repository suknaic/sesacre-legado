$(document).ready(function () {

    func = new Funcoes();

    //************ Select2 **************
    $(".select").select2({width: " 100%"});
    //************************************

    //****************************************** Carregas dados da pessoa **********************************************
    function returnPessoaJuridicaEditar() {
        var id_get = $("#id_get").val();
        $.ajax({
            "url": "/model/sistema/pessoa/request.php",
            "dataType": "html",
            "method": "POST",
            "data": {
                "acao": "returnPessoaJuridicaEditar",
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
                    $("#nm_email").val(response[0]['nm_email']);
                    $("#nm_pessoa").val(response[0]['nm_pessoa']);
                    $("#nm_fantasia").val(response[0]['nm_fantasia']);
                    $("#dt_fundacao").val(response[0]['dt_fundacao']);
                    //**************************************************************************
                    $("#id_pessoa").val(response[0]['id_pessoa']);
                    $("#id_pessoa_juridica").val(response[0]['id_pessoa_juridica']);
                    $("#nr_cnpj").val(response[0]['nr_cnpj']);
                    $("#nr_cnae").val(response[0]['nr_cnae']);
                    $("#nr_safira").val(response[0]['nr_safira']);
                    $("#ds_insc_estadual").val(response[0]['ds_insc_estadual']);
                    $("#ds_insc_municipal").val(response[0]['ds_insc_municipal']);
                    listaNatureza(response[0]['id_natureza']);
                    $("#ds_logradouro").val(response[0]['ds_logradouro']);
                    $("#ds_complemento").val(response[0]['ds_complemento']);
                    $('#nr_endereco').val(response[0]['nr_numero']);
                    $("#ds_bairro").val(response[0]['ds_bairro']);
                    $("#nr_cep").val(response[0]['nr_cep']);
                    $("#nr_cep").mask("99999-999");
                    //********************************************************
                    $("#id_pais_endereco").val(response[0]['id_pais_endereco']).change();
                    listaEstadoEndereco(response[0]['id_pais_endereco'],response[0]['id_estado_endereco']);
                    listaCidadeEndereco(response[0]['id_estado_endereco'], null,response[0]['id_cidade']);
                    //*************************************************************************
                    $("#nr_telefone_residencial").val(response[0]['nr_telefone_residencial']);
                    $("#nr_telefone_celular").val(response[0]['nr_telefone_celular']);
                    $("#nr_telefone_residencial").mask("(99) 9999-9999");
                    $("#nr_telefone_celular").mask("(99) 9 9999-9999");
                    $("#ds_observacao").val(response[0]['ds_observacao']);

                }
        });
    }
    //******************************************************************************************************************

    //*********************** Natureza ********************
    function listaNatureza(id) {
        $.ajax({
            "url": "/model/sistema/pessoa/request.php",
            "dataType": 'html',
            "method": "POST",
            "data": {
                acao: "listaNaturezaOption",
                id: id
            },
            "success": function (response) {
                $("#id_natureza").append(response);
            }
        });
    }
    //******************************************************

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
    function listaCidadeEndereco(estado = 0, cidade = null, idCidade = null) {
        $.ajax({
            "url": "/model/sistema/pessoa/request.php",
            "dataType": 'html',
            "data": {
                acao: "listaCidadeOption",
                idEstado: estado,
                nmCidade: cidade,
                idCidade: idCidade
            },
            "success": function (response) {
                $("#id_cidade").html(response);
            }
        });
    }
    //******************************************************************************************

    //**************************************** Abas ********************************************
    $(".pro").click(function () {
        $('.nav > .active').next('li').find('a').trigger('click');
    });
    // função do botão anterior
    $(".ant").click(function () {
        // aba que esta ativa no momento
        $('.nav > .active').prev('li').find('a').trigger('click');
    });
    //******************************************************************************************

    //******************************** Regras dos Dados do Endereço *********************************
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
    //***********************************************************************************************

    returnPessoaJuridicaEditar();

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
            //return false;
        }
    });

//******************************************************************************************
    $('body').on('click', '.btn-salvar', function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else {
            e.preventDefault();
            var $this = $(this);
            var idPessoaJuridica = ($("#id_pessoa_juridica").val());
            var idPessoa = ($("#id_pessoa").val());
            //$this.prop("disabled", true);
            var cep = func.extrairCarater($("#nr_cep").val(), "-");
            var DadosPessoa = {
                //****************dados pessoais*********************
                idPessoa: idPessoa,
                razaoSocial: $("#nm_pessoa").val(),
                naturalidade: $("#id_naturalidade").val(),
                logradouro: $("#ds_logradouro").val(),
                complemento: $("#ds_complemento").val(),
                numero: $('#nr_endereco').val(),
                bairro: $("#ds_bairro").val(),
                cep: cep,
                cidade: $("#id_cidade").val(),
                telefone_residencial: $("#nr_telefone_residencial").val(),
                telefone_celular: $("#nr_telefone_celular").val(),
                email: $("#nm_email").val(),
                senha: "Palmeiras",
                obs: $("#ds_observacao").val()
            };
            $cnpj = $("#nr_cnpj").val().replace(/(\.|\/|\-)/g, "");
            var DadosPessoaJuridica = {
                idPessoaJuridica: idPessoaJuridica,
                nomeFantasia: $("#nm_fantasia").val(),
                idNatureza: $("#id_natureza").val(),
                cnpj: $cnpj,
                cnae: $("#nr_cnae").val(),
                safira: $("#nr_safira").val(),
                inscricaoEstadual: $("#ds_insc_estadual").val(),
                inscricaoMunicipal: $("#ds_insc_municipal").val(),
                dtFundacao: $("#dt_fundacao").val()
            };
            //******************************************************************
            var DadosObrigatorio = {
                'E-mail': DadosPessoa.email,
                //*************************************
                'Razão Social': DadosPessoa.razaoSocial,
                'Nartureza': DadosPessoaJuridica.idNatureza,
                'CNPJ': DadosPessoaJuridica.cnpj,
                //********************************************
                'Cidade': DadosPessoa.cidade,
                'Logradouro': DadosPessoa.logradouro,
                'Bairro': DadosPessoa.bairro,
                'Telefone Celular': DadosPessoa.telefone_celular

            };

            $campo = 0;
            $i = 0;
            $.each(DadosObrigatorio, function (index, value) {
                $i++;
                $campo = "";
                if (value == 0 || value == "" || value == null) {
                    if ($i <= 4) {
                        func.modalAlert(func.msgPreencherCampos + " - Dados Pessoais (" + index + ")");
                    } else if ($i >= 5 && $i <= 8) {
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
                    "acao": "editarPessoaJuridica",
                    "dadosPessoa": DadosPessoa,
                    "dadosPessoaJuridica": DadosPessoaJuridica
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
                        func.fechaModalHref("/pages/sistema/pessoa/juridica/index.php");
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
