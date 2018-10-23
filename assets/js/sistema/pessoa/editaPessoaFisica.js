//******************************************************************************************
function returnPessoaFisicaEditar() {
    var id_get = $("#id_get").val();
    var idPessoaFisica = id_get.split("-")[1];
    //var cpf = $("#cpf").val();
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
                    //console.log(response);
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
                    $("#id_pais_naturalidade").val(response[0]['id_pais_naturalidade']);
                    $("#id_estado_naturalidade").empty();
                    listaEstadoNaturalidadeCombo(response[0]['id_pais_naturalidade'], 1, response[0]['id_estado_naturalidade']);
                    listaCidadeCombo(response[0]['id_estado_naturalidade'], 1, response[0]['id_naturalidade']);
                    //********************************************************************
                    $("#id_pessoa").val(response[0]['id_pessoa']);
                    $("#id_pessoa_fisica").val(response[0]['id_pessoa_fisica']);
                    $("#tp_sexo").val(response[0]['tp_sexo'] === null ? 0 : response[0]['tp_sexo']);
                    $("#nr_cpf").val($cpf);
                    $("#nr_rg").val(response[0]['nr_rg']);
                    $("#ds_orgao_expedidor").val(response[0]['ds_orgao_expedidor']);
                    
                    $("#nm_mae").val(response[0]['nm_mae']);
                    $("#nm_pai").val(response[0]['nm_pai']);
                    $("#nr_cns").val(response[0]['nr_cns']);
                    listaEstadoCombo(response[0]['id_estado_orgao_expedidor']);
                    listaEstadoCivilCombo(response[0]['id_estado_civil']);
                    listaEscolaridadeCombo(response[0]['id_escolaridade'])
                    $("#ds_habilidade").val(response[0]['ds_habilidade']);
                    $("#ds_logradouro").val(response[0]['ds_logradouro']);
                    $("#ds_complemento").val(response[0]['ds_complemento']);
                    $("#ds_bairro").val(response[0]['ds_bairro']);
                    $("#nr_cep").val(response[0]['nr_cep']);
                    $("#nr_cep").mask("99999-999");
                    //********************************************************
                    //$("#id_cidade").val(response[0]['id_cidade']).change();
                    $("#id_pais_endereco").val(response[0]['id_pais_endereco']);
                    listaEstadoNaturalidadeCombo(response[0]['id_pais_endereco'], 2, response[0]['id_estado_endereco']);
                    listaCidadeCombo(response[0]['id_estado_endereco'], 2, response[0]['id_cidade']);
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
                    //console.log(response);
                    $("#corpoCompetencia").html(response);
                }
    });
}
//******************************************************************************************
function listaEstadoNaturalidadeCombo(idPais, sw, estado) {
    $.ajax({
        "url": "/model/sistema/pessoa/request.php",
        "dataType": 'html',
        "data": {
            acao: "listaEstadoOption",
            idPais: idPais,
            idEstado: estado
        },
        "success": function (response) {
            //console.log(response);

            if (sw == 1) {
                $("#id_estado_naturalidade").empty();
                $("#id_estado_naturalidade").append(response);
                $("#id_estado_naturalidade").select2({
                    width: " 100%"
                });
                $("#id_estado_naturalidade").val(estado);
//                $("#id_estado_naturalidade").trigger('change');
            }
            if (sw == 2) {
                $("#id_estado_endereco").empty();
                $("#id_estado_endereco").append(response);
                $("#id_estado_endereco").select2({
                    width: " 100%"
                });
                $("#id_estado_endereco").val(estado);
//                $("#id_estado_endereco").trigger('change');
            }

        }
    });
}


//*******************************************************
function listaPaisCombo() {
    $.ajax({
        "url": "/model/sistema/pessoa/request.php",
        "dataType": 'html',
        "data": {
            acao: "listaPaisOption"
        },
        "success": function (response) {
            //console.log(response);
            $(".pais").html(response);
            $(".pais").select2({
                width: " 100%"
            });

        }
    });
}
listaPaisCombo();

//listaEstadoCombo();
function listaCidadeCombo(idEstado, sw, cidade) {
    //alert(cidade);
    $.ajax({
        "url": "/model/sistema/pessoa/request.php",
        "dataType": 'html',
        "data": {
            acao: "listaCidadeOption",
            idEstado: idEstado,
            idCidade: cidade
        },
        "success": function (response) {
            //console.log(response);
            //console.log(cidade);
            if (sw == 1) {
                $("#id_naturalidade").empty();
                $("#id_naturalidade").append(response);
                $("#id_naturalidade").select2({
                    width: " 100%"
                });

                $("#id_naturalidade").val(cidade);
            }
            if (sw == 2) {
                $("#id_cidade").empty();
                $("#id_cidade").append(response);
                $("#id_cidade").select2({
                    width: " 100%"
                });
                $("#id_cidade").val(cidade);
            }


        }
    });
}

function listaEstadoCombo(id) {
    $.ajax({
        "url": "/model/sistema/pessoa/request.php",
        "dataType": 'html',
        "method": 'POST',
        "data": {
            acao: "listaEstadoOption",
            idPais: null,
            idEstado: id
        },
        "success": function (response) {
            //    console.log(response);
            $("#id_estado").append(response);
            $("#id_estado").select2({
                width: " 100%"
            });
            //returnContratoEditar();
        }
    });
}


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
            //  console.log(response);
            $("#id_estado_civil").append(response);
            $("#id_estado_civil").select2({
                width: " 100%"
            });
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
            $(".formacao").select2({
                width: " 100%"
            });
            returnPessoaFisicaEditar()
        }
    });
}
listaEscolaridadeFormacaoCombo();
//******************************************************************************************    
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
            //  console.log(response);
            $("#id_escolaridade").append(response);
            $("#id_escolaridade").select2({
                width: " 100%"
            });
        }
    });
}
//**********************uf para cep**********************************************************
function listaCidadeComboUf(idEstado, uf) {
    //alert(cidade);
    $.ajax({
        "url": "/model/sistema/pessoa/request.php",
        "dataType": 'html',
        "method": 'POST',
        "data": {
            acao: "listaCidadeOptionUf",
            idEstado: idEstado,
            uf: uf
        },
        "success": function (response) {
            //console.log(response);
            //console.log(cidade);

            $("#id_cidade").empty();
            $("#id_cidade").append(response);
            $("#id_cidade").select2({
                width: " 100%"
            });


        }
    });
}
//******************************
$(document).ready(function () {

    func = new Funcoes();

//******************************************************************************************
    // função do botão Próximo
    $(".pro").click(function () {
        $('.nav > .active').next('li').find('a').trigger('click');

    });
    // função do botão anterior
    $(".ant").click(function () {
        // aba que esta ativa no momento
        $('.nav > .active').prev('li').find('a').trigger('click');
    })
    //*********************************************************************
    $("body").on("change", "#id_pais_naturalidade", function (e) {
        $idPais = $("#id_pais_naturalidade").val();
        if ($idPais == 0) {
            return;
        }
        $("#id_naturalidade").empty();
        listaEstadoNaturalidadeCombo($idPais, 1, 0);
    });
    $("body").on("change", "#id_estado_naturalidade", function (e) {
        //$("#id_naturalidade").empty();
        $idEstado = $("#id_estado_naturalidade").val();
        if ($idEstado == 0) {
            return;
        }
        listaCidadeCombo($idEstado, 1, $("#id_naturalidade").val());
    });
    //******************************************************************************************
    $("body").on("change", "#id_pais_endereco", function (e) {
        $idPais = $("#id_pais_endereco").val();
        if ($idPais == 0) {
            return;
        }
        $("#id_cidade").empty();
        listaEstadoNaturalidadeCombo($idPais, 2, 0);
    });
    $("body").on("change", "#id_estado_endereco", function (e) {
        $idEstado = $("#id_estado_endereco").val();
        if ($idEstado == 0) {
            return;
        }
        listaCidadeCombo($idEstado, 2, $("#id_cidade").val());
    });
//******************************************************************************************
    $("body").on("change", "#id_cidade", function (e) {
        $("#ds_logradouro").val("");
        $("#ds_bairro").val("");
        $("#ds_complemento").val("");
        $("#nr_cep").val("");
     
    });
    //****************************************************************
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
            "url": "/model/sistema/pessoa/request.php",
            "dataType": "html",
            "data": {
                "acao": "inserirCompetencia",
                "competencia": competencia,
                "pessoaFisica": pessoaFisica
            },
            "success":
                    function (response) {
                        // console.log(response);
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
            "url": "/model/sistema/pessoa/request.php",
            "dataType": "html",
            "data": {
                "acao": "excluirCompetencia",
                "idCompetencia": idCompetencia
            },
            "success":
                    function (response) {
                        console.log(response);
                        returnCompetencia($idPessoaFisica);
                    }
        });
    });

//******************************************************************************************
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
                cep: cep,
                cidade: $("#id_cidade").val(),
                telefone_residencial: $("#nr_telefone_residencial").val(),
                telefone_celular: $("#nr_telefone_celular").val(),
                email: $("#nm_email").val(),
                senha: "Palmeiras",
                obs: $("#ds_observacao").val()
            }
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
            }
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
//            console.log(DadosObrigatorio);
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

            //***********************************************
            $.ajax({
                "url": "/model/sistema/pessoa/request.php",
                "dataType": "html",
                "method": "POST",
                "data": {
                    "acao": "editarPessoaFisica",
                    "dadosPessoa": DadosPessoa,
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
    $(".sexo").select2({
        width: " 100%"
    });
    //*************************************************************************************************
    $('body').on('click', '.cep', function (e) {
        //Nova variável "cep" somente com dígitos.
        var cep = $("#nr_cep").val().replace(/\D/g, '');
        $("#ds_complemento").val("");
        //Verifica se campo cep possui valor informado.
        if (cep != "") {
            //Expressão regular para validar o CEP.
            var validacep = /^[0-9]{8}$/;
            //Valida o formato do CEP.
            if (validacep.test(cep)) {
                //Preenche os campos com "..." enquanto consulta webservice.
                $("#ds_logradouro").val("");
                $("#ds_bairro").val("");
                $("#id_pais_endereco").val(0).change();
                //Consulta o webservice viacep.com.br/
                $.getJSON("https://viacep.com.br/ws/" + cep + "/json/?callback=?", function (dados) {
                    if (!("erro" in dados)) {
                        //Atualiza os campos com os valores da consulta.
                        $("#ds_logradouro").val(dados.logradouro);
                        $("#ds_bairro").val(dados.bairro);
                        $("#ds_logradouro").focus();
                        //$("#cidade").val(dados.localidade);
                        var uf = dados.uf;
                        var cidade = dados.localidade;
                        $.ajax({
                            "url": "/model/rh/funcionario/request.php",
                            "dataType": "html",
                            "method": "POST",
                            "data": {
                                "acao": "buscaCidadeUf",
                                "uf": uf
                            },
                            "success": function (response) {
                                try {
                                    response = JSON.parse(response);
                                } catch (e) {
                                    console.log(response);
                                    return false;
                                }
//                              console.log(response);
                                $("#id_pais_endereco").val(response[0]["id_pais"]).change();
                                listaEstadoNaturalidadeCombo(response[0]['id_pais'], 2, response[0]['id_estado']);
                                listaCidadeComboUf(response[0]['id_estado'], cidade);
                            }
                        });
                        //$("#ibge").val(dados.ibge);
                        //console.log(dados);
                    } //end if.
                    else {
                        //CEP pesquisado não foi encontrado.
                        alert("CEP não encontrado.");
                    }
                });
            } //end if.
            else {
                //cep é inválido.
                alert("Formato de CEP inválido.");
            }
        } //end if.
        else {
            //cep sem valor, limpa formulário.
        }

    });
});
