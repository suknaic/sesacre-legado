function listaPaisCombo() {
    $.ajax({
        "url": "/model/sistema/pessoa/request.php",
        "dataType": 'html',
        "data": {
            acao: "listaPaisOption"
        },
        "success": function (response) {
            //console.log(response);
            $(".pais").append(response);
            $(".pais").select2({
                width: " 100%"
            });
        }
    });
}
listaPaisCombo();
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
//listaEstadoCombo();
function listaCidadeCombo(idEstado, sw) {
    $.ajax({
        "url": "/model/sistema/pessoa/request.php",
        "dataType": 'html',
        "data": {
            acao: "listaCidadeOption",
            idEstado: idEstado
        },
        "success": function (response) {
            //console.log(response);
            if (sw == 1) {
                $("#id_naturalidade").append(response);
                $("#id_naturalidade").select2({
                    width: " 100%"
                });
            }
            if (sw == 2) {
                $("#id_cidade").append(response);
                $("#id_cidade").select2({
                    width: " 100%"
                });
            }

        }
    });
}
//listaCidadeCombo();
function listaEstadoCombo() {
    $.ajax({
        "url": "/model/sistema/pessoa/request.php",
        "dataType": 'html',
        "data": {
            acao: "listaEstadoOption",
            idPais: null
        },
        "success": function (response) {
            //    console.log(response);
            $("#id_estado_expedidor").append(response);
            $("#id_estado_expedidor").select2({
                width: " 100%"
            });
            returContratoEditar();
        }
    });
}
listaEstadoCombo();
//******************************************************************************************    
function listaEstadoCivilCombo() {
    $.ajax({
        "url": "/model/sistema/pessoa/request.php",
        "dataType": 'html',
        "data": {
            acao: "listaEstadoCivilOption"
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
listaEstadoCivilCombo();
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
        }
    });
}
listaEscolaridadeFormacaoCombo();
//******************************************************************************************    
function listaEscolaridadeCombo() {
    $.ajax({
        "url": "/model/sistema/pessoa/request.php",
        "dataType": 'html',
        "data": {
            acao: "listaEscolaridadeOption"
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
listaEscolaridadeCombo();
//******************************************************************************************    
function listaEstadoCombo() {
    $.ajax({
        "url": "/model/sistema/pessoa/request.php",
        "dataType": 'html',
        "data": {
            acao: "listaEstadoOption"
        },
        "success": function (response) {
            //  console.log(response);
            $("#id_estado").append(response);
            $("#id_estado").select2({
                width: " 100%"
            });
        }
    });
}
listaEstadoCombo();
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
    //******************************************************************************************
    $("body").on("change.select2", "#id_pais_naturalidade", function (e) {
        $("#id_estado_naturalidade").empty();
        $("#id_naturalidade").empty();
        $idPais = $("#id_pais_naturalidade").val();
        if ($idPais == 0) {
            return;
        }
        listaEstadoNaturalidadeCombo($idPais, 1);

    });
    //******************************************************************************************
    $("body").on("change.select2", "#id_estado_naturalidade", function (e) {
        $("#id_naturalidade").empty();
        $idEstado = $("#id_estado_naturalidade").val();
        if ($idEstado == 0) {
            return;
        }
        listaCidadeCombo($idEstado, 1);

    });
    //******************************************************************************************
    $("body").on("change.select2", "#id_pais_endereco", function (e) {
        $("#id_estado_endereco").empty();
        $("#id_cidade").empty();
        $idPais = $("#id_pais_endereco").val();
        if ($idPais == 0) {
            return;
        }
        listaEstadoNaturalidadeCombo($idPais, 2);

    });
    //******************************************************************************************
    $("body").on("change.select2", "#id_estado_endereco", function (e) {
        $("#id_cidade").empty();
        $idEstado = $("#id_estado_endereco").val();
        if ($idEstado == 0) {
            return;
        }
        listaCidadeCombo($idEstado, 2);

    });
//******************************************************************************************
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
        $(linha).appendTo('.corpoTabela')

        $("#id_competencia").val(0);
        $("#id_competencia").select2({
        });
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
                cep: cep,
                cidade: $("#id_cidade").val(),
                telefone_residencial: $("#nr_telefone_residencial").val(),
                telefone_celular: $("#nr_telefone_celular").val(),
                email: $("#nm_email").val(),
                senha: "dd25mm05aaaa2005",
                obs: $("#ds_observacao").val()
            }
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
            }
            //***************competencias************************************
            if ($(this).closest(".formRhFuncionario").find(".competenciaLinha").length > 0) {
                var DadosCompetencia = [];
                $("#tabela tbody tr").each(function () {
                    //var coluna =  $(this).children();
                    DadosCompetencia.push({
                        id_escolaridade_formacao: $(this).find(".escolaridade").attr("idEscolaridadeFormacao")
                    })
                });
            }
            //******************************************************************
            var DadosObrigatorio = {
                email: DadosPessoa.email,
                //*************************************
                nomeCivil: DadosPessoaFisica.nomeCivil,
                tpSexo: DadosPessoaFisica.tpSexo,
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
                    "acao": "cadastrarPessoaFisica",
                    "dadosPessoa": DadosPessoa,
                    "dadosPessoaFisica": DadosPessoaFisica,
                    "dadosCompetencia": DadosCompetencia
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
    //******************************************************************************************
    $("body").on("change", "#id_cidade", function (e) {
        $("#ds_logradouro").val("");
        $("#ds_bairro").val("");
        $("#ds_complemento").val("");
        $("#nr_cep").val("");

    });

    $(".pais").select2({
        width: " 100%"
    });
    $(".estado").select2({
        width: " 100%"
    });
    $(".idCidade").select2({
        width: " 100%"
    });
    $(".sexo").select2({
        width: " 100%"
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
