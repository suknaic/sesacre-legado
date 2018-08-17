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
            //console.log(response);
            try {
                response = JSON.parse(response);
                //console.log(response);
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
            $("#tp_sexo").val(response[0]['tp_sexo']);
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
            //********************************************************
            //$("#id_cidade").val(response[0]['id_cidade']).change();
            $("#id_pais_endereco").val(response[0]['id_pais_endereco']);
            listaEstadoNaturalidadeCombo(response[0]['id_pais_endereco'], 2, response[0]['id_estado_endereco'])
            listaCidadeCombo(response[0]['id_estado_endereco'], 2, response[0]['id_cidade_endereco'])
            //*************************************************************************
            $("#nr_telefone_residencial").val(response[0]['nr_telefone_residencial']);
            $("#nr_telefone_celular").val(response[0]['nr_telefone_celular']);
            $("#ds_observacao").val(response[0]['ds_observacao']);
            $("#nr_matricula").val(response[0]['nr_matricula']);
            returnCompetencia(response[0]['id_pessoa_fisica']);

        }
    });
}
//******************************************************************************************
function returnCompetencia(id_pessoa_fisica) {
    var DadosPessoa = {
        id_pessoa_fisica: id_pessoa_fisica,
        contrato: 1
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
                    //console.log(response);
                    $("#corpoTabelaLotacao").html(response);
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
            //console.log(response);
            $("#id_cargo").append(response);
            $("#id_cargo").select2({
                width: " 100%"
            });
        }
    });
}
listaCargoCombo();
//******************************************************************************************
function listaFuncaoCombo() {
    $.ajax({
        "url": "/model/rh/funcionario/request.php",
        "dataType": 'html',
        "data": {
            acao: "listaFuncaoOption"
        },
        "success": function (response) {
            // console.log(response);
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
        "dataType": "html",
        "data": {
            "acao": "listaLotacaoOption",
            
        },
        "success": function (response) {
            // console.log(response);
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
            //console.log(response);
            $("#id_pessoa_juridica").append(response);
            $("#id_pessoa_juridica").select2({
                width: " 100%"
            });

        }
    });
}
listaPjCombo(0);
//******************************************************************************************
function listaVinculoCombo() {
    $.ajax({
        "url": "/model/rh/funcionario/request.php",
        "dataType": 'html',
        "data": {
            acao: "listaVinculoOption"
        },
        "success": function (response) {
            //  console.log(response);
            $("#id_vinculo").append(response);
            $("#id_vinculo").select2({
                width: " 100%"
            });
        }
    });
}
listaVinculoCombo();
//******************************************************************************************

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
            //  console.log(response);
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
            //  console.log(response);
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
            //  console.log(response);
            $("#id_competencia").append(response);
            $("#id_competencia").select2({
                width: " 100%"
            });
        }
    });
}
listaEscolaridadeFormacaoCombo();
//******************************************************************************************    

//**********************************Lista Cidades********************************************************    
function listaPaisCombo() {
    $.ajax({
        "url": "/model/rh/funcionario/request.php",
        "dataType": 'html',
        "data": {
            acao: "listaPaisOption"
        },
        "success": function (response) {
            //  console.log(response);
            $(".pais").html(response);
            $(".pais").select2({
                width: " 100%"
            });
            returnContratoEditar();
        }
    });
}
listaPaisCombo();

function listaEstadoNaturalidadeCombo(idPais, sw, estado) {
    $.ajax({
        "url": "/model/rh/funcionario/request.php",
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
function listaCidadeCombo(idEstado, sw, cidade) {
    //alert(cidade);
    $.ajax({
        "url": "/model/rh/funcionario/request.php",
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
//listaCidadeCombo();
function listaEstadoCombo(id) {
    $.ajax({
        "url": "/model/rh/funcionario/request.php",
        "dataType": 'html',
        "method": "post",
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
            //returContratoEditar();
        }
    });
}
//******************************************************************************************
$(document).ready(function () {

    func = new Funcoes();
    //*********************************************************************
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
    $("body").on("change", "#id_vinculo", function (e) {
        var id = $(this).val();
        if (id == 5) {
            $(".demissao").show();
        } else {
            $(".demissao").hide();
        }
        $("#dt_demissao").val("");
        $("#dt_fim").val("");
    });
    //*********************************************************************
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
            //return false;
        }
    });
    $('body').on('keypress', '#dt_demissao', function (e) {
        var key = e.which;
        if (key == 13) {
            $("#dt_fim").val($("#dt_demissao").val());
            //return false;
        }
    });

    $('#nr_carga_horaria').on('focus blur', function (e) {
        $('#nr_carga_horaria2').val($('#nr_carga_horaria').val())
    });
//    //*********************************************************************

    $("body").on("change", "#id_pais_naturalidade", function (e) {

        $idPais = $("#id_pais_naturalidade").val();
        if ($idPais == 0) {
            return;
        }
        $("#id_naturalidade").empty();
        listaEstadoNaturalidadeCombo($idPais, 1, 0);


    });
    //******************************************************************************************
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
    //******************************************************************************************
    $("body").on("change", "#id_estado_endereco", function (e) {

        $idEstado = $("#id_estado_endereco").val();
        if ($idEstado == 0) {
            return;
        }
        listaCidadeCombo($idEstado, 2, $("#id_cidade").val());

    });
    //******************************************************************************************
    $(".nr").mask("99");
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
            func.modalAlert(" Informe Carga Horária do Funcionário");
            $("#nr_carga_horaria").focus();
            return;
        }

        //********carga hoaria da lotação não deve exceder a carga horaria do funcionario**************** 
        if ((parseInt(nr_carga_horaria2)) > parseInt(nr_carga_horaria)) {
            func.modalAlert(" Carga Horária da Lotação excede a Carga Horária do Funcionário")
            return;
        }
        //********data inicial da função na lotação tem de ser inferior a data final**********************

        var flag = 0;
        if ($(this).closest(".panelForm").find(".lotacaoLinha").length > 0) {
            var cargaHorariaLotacao = 0;
            $("#tabelaLotacao tbody tr").each(function () {
                if (lotacaoId == $(this).find(".lotacao").attr("idLotacao") && funcaoId == $(this).find(".funcao").attr("idFuncao")) {
                    func.modalAlert(" Lotação e Função já existem!!!")
                    flag = 1;
                }
                cargaHorariaLotacao += parseInt($(this).find(".cargaLotacao").attr("ch"));
            });
        }
        if (flag == 1) {
            return;
        }
        if ((cargaHorariaLotacao + parseInt(nr_carga_horaria2)) > parseInt(nr_carga_horaria)) {
            func.modalAlert(" Carga Horária da Lotação excede a Carga Horária do Funcionario")
            return;
        }

        //********************************************************************************
        if (lotacaoId == 0) {
            func.modalAlert(" Informe Lotação");
            $("#id_lotacao").focus();
            return;
        }
        if (funcaoId == 0) {
            func.modalAlert(" Informe Função");
            $("#id_funcao").focus();
            return;
        }
        if (nr_carga_horaria2 == 0) {
            func.modalAlert(" Informe Carga Horária da Lotação");
            $("#nr_carga_horaria2").focus();
            return;
        }
        if ($("#dt_inicio").val() == "") {
            func.modalAlert(" Informe Data de inicio da Função na Lotação");
            //$("#dt_inicio").focus();
            return;
        }
        if ($("#dt_fim").val().length > 3) {
            var data1 = $("#dt_inicio").val()
            var data2 = $("#dt_fim").val()
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

        //********************************************************************************
        if (idContrato == 0) {
            var lotacao = $("#id_lotacao option:selected").text()
            var funcao = $("#id_funcao option:selected").text()
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
            $(linha).appendTo('.corpoTabelaLotacao')
            $("#nr_carga_horaria2").val("");
            $("#dt_inicio").val("");
            $("#dt_fim").val("");
            //***********************************************************************************
            $("#id_lotacao").val(0);
            $("#id_lotacao").select2({
                width: " 100%",
            });
            $("#id_funcao").val(0);
            $("#id_funcao").select2({
                width: " 100%",
            });

        }

    });
//******************************************************************************************
    $("body").on("click", ".btn-add", function (e) {
        var pessoaFisica = $("#id_pessoa_fisica").val();
        var competencia = $("#id_competencia").val();
        if (competencia == 0) {
            alert("informe Competência");
            $("#id_competencia").focus();
            return;
        }
        //********************************************************************************* 
        var flag = 0;
        if ($(this).closest(".panelCompetencia").find(".competenciaLinha").length > 0) {
            $("#tabela tbody tr").each(function () {
                if (competencia == $(this).find(".escolaridade").attr("idEscolaridadeFormacao")) {
                    flag = 1;
                    func.modalAlert(" O Item já Existe!!!")
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
                        //console.log(response);
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
                        //console.log(response);
                        returnCompetencia($idPessoaFisica);
                    }
        });

    });
//******************************************************************************************
    $("body").on("click", ".excluirLinhaLotacao", function (e) {
        //$(this).closest(".lotacaoLinha").remove();
        var idContratoLotacao = $(this).val();
        //**********************************************************************************
        var idContrato = 0;
        if ($("#id_contrato").val() !== "") {
            idContrato = $("#id_contrato").val();
        }
        //**********************************************************************************
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
                "success":
                        function (response) {
                            //console.log(response);
                            location.reload();
                        }
            });
        }


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

            //$this.prop("disabled", true);
            var idPessoaFisica = ($("#id_pessoa_fisica").val());
            var idPessoa = ($("#id_pessoa").val());
            var idContrato = ($("#id_contrato").val());
            //alert(idPessoa);
            //alert(idPessoaFisica);
            //alert(idContrato);
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
            //********data admissao tem de ser inferior a data demissao**********************
            if ($("#dt_demissao").val().length > 3) {
                var data1 = $("#dt_admissao").val();
                var data2 = $("#dt_demissao").val();
                var x = data1.split("/")[2].toString() + "/" + data1.split("/")[1].toString() + "/" + data1.split("/")[0].toString();
                var y = data2.split("/")[2].toString() + "/" + data2.split("/")[1].toString() + "/" + data2.split("/")[0].toString();
                var dataIni = new Date(x);
                var dataFim = new Date(y);
                if (dataIni > dataFim) {
                    alert(" A data de Admissão não pode ser maior que a data de Demissão");
                    return;
                }
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
            }
            var DadosContrato_Lotacao = [];
            if (idContrato == 0) {
                var x = 0;
                if ($(this).closest(".formRhFuncionario").find(".lotacaoLinha").length > 0) {
                    x = 1;
                    $("#tabelaLotacao tbody tr").each(function () {
                        //alert($(this).find(".escolaridade").attr("idEscolaridadeFormacao"));
                        //var coluna =  $(this).children();
                        DadosContrato_Lotacao.push({
                            chLotacao: $(this).find(".cargaLotacao").attr("ch"),
                            idLotacao: $(this).find(".lotacao").attr("idLotacao"),
                            idFuncao: $(this).find(".funcao").attr("idFuncao"),
                            dt_inicio: $(this).find(".dataIni").attr("dt_inicio"),
                            dt_fim: $(this).find(".dataFim").attr("dt_fim")
                        })
                    });
                }
            }
            //******************************************************************
            var DadosObrigatorio = {
                //**************1-12***********************
                email: DadosPessoa.email,
                nomeCivil: DadosPessoaFisica.nomeCivil,
                tpSexo: DadosPessoaFisica.tpSexo,
                dataNascimento: DadosPessoaFisica.dtNascimento,
                naturalidade: DadosPessoa.naturalidade,
                cpf: DadosPessoaFisica.cpf,
                rg: DadosPessoaFisica.rg,
                orgaoExpedidor: DadosPessoaFisica.orgaoExpedidor,
                orgaoExpedidorEstado: DadosPessoaFisica.orgaoExpedidorEst,
                mae: DadosPessoaFisica.mae,
                estadoCivil: DadosPessoaFisica.estadoCivil,
                escolaridade: DadosPessoaFisica.escolaridade,
                //***************13-16*****************************
                cidadeEndereco: DadosPessoa.cidade,
                logradouro: DadosPessoa.logradouro,
                bairro: DadosPessoa.bairro,
                telefoneCelular: DadosPessoa.telefone_celular,
                //******************17-22****************************
                vinculo: DadosContrato.vinculo,
                empresa: DadosContrato.pessoaJuridica,
                datatAdmissao: DadosContrato.dtAdmissao,
                cargaHorariaContrato: DadosContrato.nrCargaHoraria,
                matricula: DadosContrato.nrMatricula,
                cargo: DadosContrato.idCargo
            };
//            console.log(DadosObrigatorio);
            $campo = 0;
            $i = 0;
            $.each(DadosObrigatorio, function (index, value) {
                $i++;
                $campo = "";
                if (value == 0 || value == "" || value == null) {
                    //console.log($i+"-"+index+"=>"+value);
                    if ($i <= 12) {
                        func.modalAlert(func.msgPreencherCampos + " - Dados Pessoais (" + index + ")");
                    } else if ($i >= 13 && $i <= 16) {
                        func.modalAlert(func.msgPreencherCampos + "  - Endereço / Contato (" + index + ")");
                    } else if ($i >= 17 && $i <= 22) {
                        func.modalAlert(func.msgPreencherCampos + "  - Dados Funcionais (" + index + ")");
                    }
                    console.log($i + "-" + index + "=>" + value);
                    $campo = 1;
                    return false;
                }
            });
            if ($campo == 1) {
                return false;
            }
            //*************************************************************************************************
            if (x == 0) {
                func.modalAlert(" Informar Lotação e Função");
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
                    //$this.prop("disabled", false);
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
                            console.log('Console Mensagem');
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


    $('body').on('click', '.btn-edit', function (e) {

    });
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
