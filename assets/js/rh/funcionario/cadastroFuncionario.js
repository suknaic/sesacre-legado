//*********************************************************************
function listaCargoCombo() {
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
            "acao": "listaLotacaoOption"
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
function listaPaisCombo() {
    $.ajax({
        "url": "/model/rh/funcionario/request.php",
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
//**********************uf para cep**********************************************************
function listaCidadeComboUf(idEstado, uf) {
    //alert(cidade);
    $.ajax({
        "url": "/model/rh/funcionario/request.php",
        "dataType": 'html',
        "method": 'POST',
        "data": {
            acao: "listaCidadeOptionUf",
            idEstado: idEstado,
            uf: uf
        },
        "success": function (response) {
            //       console.log(response);
            //console.log(cidade);

            $("#id_cidade").empty();
            $("#id_cidade").append(response);
            $("#id_cidade").select2({
                width: " 100%"
            });


        }
    });
}
//*****************************************************************************************
//listaCidadeCombo();
function listaEstadoCombo() {
    $.ajax({
        "url": "/model/rh/funcionario/request.php",
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
        "url": "/model/rh/funcionario/request.php",
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
        "url": "/model/rh/funcionario/request.php",
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
        "url": "/model/rh/funcionario/request.php",
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
        "url": "/model/rh/funcionario/request.php",
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
$(document).ready(function () {

    func = new Funcoes();
//******************************************************************************************
    function listaPjCombo() {
        $.ajax({
            "url": "/model/rh/funcionario/request.php",
            "dataType": 'html',
            "data": {
                acao: "listaPessoaJuridicaOption"
            },
            "success": function (response) {
                //  console.log(response);
                $("#id_pessoa_juridica").append(response);
                $("#id_pessoa_juridica").select2({
                    width: " 100%"
                });
            }
        });
    }
    listaPjCombo();
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
    $("body").on("change", "#id_cidade", function (e) {
        $("#ds_logradouro").val("");
        $("#ds_bairro").val("");
        $("#ds_complemento").val("");
        $("#nr_cep").val("");

    });
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
        listaCidadeCombo($idEstado, 1, null);
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
        listaCidadeCombo($idEstado, 2, null);
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
    //*********************************************************************
  
    //*********************************************************************
    $("#dt_demissao").datepicker().on('changeDate', function () {
        $("#dt_fim").val($("#dt_demissao").val());
    });
    $('body').on('keypress', '#dt_demissao', function (e) {
        var key = e.which;
        if (key == 13) {
            $("#dt_fim").val($("#dt_demissao").val());
            //return false;
        }
    });
    $("#dt_admissao").datepicker().on('changeDate', function () {
        $("#dt_inicio").val($("#dt_admissao").val());
    });
    $('body').on('keypress', '#dt_admissao', function (e) {
        var key = e.which;
        if (key == 13) {
            $("#dt_inicio").val($("#dt_admissao").val());
            //return false;
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
            func.modalAlert(" Informe Carga Horária do Funcionário");
            $("#nr_carga_horaria").focus();
            return;
        }
        //********carga hoaria da lotação não deve exceder a carga horaria do funcionario**************** 
        if ((parseInt(nr_carga_horaria2)) > parseInt(nr_carga_horaria)) {
            func.modalAlert(" Carga Horária da Lotação excede a Carga Horária do Funcionário");
            return;
        }
        //********data inicial da função na lotação tem de ser inferior a data final**********************
        if ((parseInt(nr_carga_horaria2)) > parseInt(nr_carga_horaria)) {
            func.modalAlert(" Carga Horária da Lotação excede a Carga Horária do Funcionário");
            return;
        }
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
            func.modalAlert(" Carga Horária da Lotação excede a Carga Horária do Funcionário");
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
        });
        $("#id_funcao").val(0);
        $("#id_funcao").select2({
        });
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
                    func.modalAlert(" O Item já Existe!!!");
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
    $("body").on("click", ".excluirLinhaLotacao", function (e) {
        $(this).closest(".lotacaoLinha").remove();
    });
//******************************************************************************************
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
//******************************************************************************************
    $('body').on('click', '.btn-salvar', function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else {
            e.preventDefault();
            var $this = $(this);
            //$this.prop("disabled", true);
//*******************************************************
//            $email = $("#nm_email").val();
//            $x = $email.split("@");
//            $y = $x[1].substring(0, 3);
//*******************************************************
          
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
//*******************dados funcionais********************************
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
            //*******************************
            var DadosContrato = {
                nrMatricula: $("#nr_matricula").val(),
                dtAdmissao: $("#dt_admissao").val(),
                dtDemissao: $("#dt_demissao").val(),
                nrCargaHoraria: $("#nr_carga_horaria").val(),
                vinculo: $("#id_vinculo").val(),
                pessoaJuridica: $("#id_pessoa_juridica").val(),
                idCargo: $("#id_cargo").val()
            };
            var x = 0;
            if ($(this).closest(".formRhFuncionario").find(".lotacaoLinha").length > 0) {
                x = 1;
                var DadosContrato_Lotacao = [];
                $("#tabelaLotacao tbody tr").each(function () {
//alert($(this).find(".escolaridade").attr("idEscolaridadeFormacao"));
//var coluna =  $(this).children();
                    DadosContrato_Lotacao.push({
                        chLotacao: $(this).find(".cargaLotacao").attr("ch"),
                        idLotacao: $(this).find(".lotacao").attr("idLotacao"),
                        idFuncao: $(this).find(".funcao").attr("idFuncao"),
                        dt_inicio: $(this).find(".dataIni").attr("dt_inicio"),
                        dt_fim: $(this).find(".dataFim").attr("dt_fim")
                    });
                });
            }
//*******************************************************************
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
            //***********************************************
            if (DadosContrato.nrMatricula == "" || DadosContrato.dtAdmissao == "" || DadosContrato.nrCargaHoraria == "" || DadosContrato.vinculo == 0
                    || DadosContrato.nrCargaHoraria == 0 || DadosContrato.pessoaJuridica == 0 || DadosContrato.id_cargo == 0) {
                func.modalAlert(func.msgPreencherCampos + " (Dados Funcionais)");
                //$this.prop("disabled", false);
                return false;
            }
            if (x == 0) {
                func.modalAlert(" Informar Lotação e Função");
                return false;
            }
//***********************************************
//console.log(DadosPessoa);
//console.log(DadosPessoaFisica);
//console.log(DadosCompetencia);
//console.log(DadosContrato);
//console.log(DadosContrato_Lotacao);
//return false;
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
                    "dadosContrato_Lotacao": DadosContrato_Lotacao
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
    //*************************************************************************************************
    $('body').on('click', '.cep', function (e) {
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
