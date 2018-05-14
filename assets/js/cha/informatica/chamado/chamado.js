$(document).ready(function () {
//instacinado fucoes js
    func = new Funcoes();
//*********************************************************************************************************************
    $("body").on("change", "#id_lotacao1", function (e) {
        $.ajax({
            "url": "/model/cha/informatica/chamado/request.php",
            "dataType": 'html',
            'method': 'POST',
            "data": {
                acao: "returnTelefones",
                idLotacao: $("body").find("#id_lotacao1").val()
            },
            "success": function (response) {
//                console.log(response);
                if (response == false) {
                    $("#nr_telefone").val("");
                    $("#nr_telefone").mask("(99) 9999-9999");
                } else {
                    $("#nr_telefone").val(response);
                }
            }
        });
    });
//*********************************************************************************************************************
    function listaPaisCombo() {
        $.ajax({
            "url": "/model/cha/informatica/chamado/request.php",
            "dataType": 'html',
            "data": {
                acao: "listaPaisOption"
            },
            "success": function (response) {
//                console.log(response);
                $(".pais").append(response);
                $(".pais").select2({
                    width: " 100%"
                });
            }
        });
    }
//*********************************************************************************************************************
    function listarCategoriaTipo() {
        $.ajax({
            "url": "/model/cha/informatica/chamado/request.php",
            "dataType": "html",
            "data": {
                "acao": "listaTipoOption",
                idCategoriaPrincipal: $("#idCategoriaPrincipal").val()
            },
            "success": function (response) {
                try {
                    response = JSON.parse(response);
                } catch (e) {
                    $("#idCategoriaTipo").html(response);
                    $("#idCategoriaTipo").select2({
                        width: " 100%"
                    });
                }
                if (response.tipoMsg === "Erro") {
                    if (response.tipoExibicao === "alert") {
                        func.modalAlert(response.msg);
                        return false;
                    }
                }
            }
        });
    }
    listarCategoriaTipo();
//*********************************************************************************************************************
    $("body").on("change", "#idCategoriaTipo", function (e) {
        $.ajax({
            "url": "/model/cha/informatica/chamado/request.php",
            "dataType": 'html',
            "data": {
                acao: "listaPrimariaOption",
                idCategoriaTipo: $("#idCategoriaTipo option:selected").val()
            },
            "success": function (response) {
                try {
                    response = JSON.parse(response);
                } catch (e) {
                    $("#idCategoriaPrimaria").html(response);
                    $("#idCategoriaPrimaria").select2({
                        width: " 100%"
                    });
                }
                if (response.tipoMsg === "Erro") {
                    if (response.tipoExibicao === "alert") {
                        func.modalAlert(response.msg);
                        return false;
                    }
                }
            }
        });
    });
//*********************************************************************************************************************
    $("body").on("change", "#idCategoriaPrimaria", function (e) {
        $.ajax({
            "url": "/model/cha/informatica/chamado/request.php",
            "dataType": 'html',
            "data": {
                acao: "listaSecundariaOption",
                idCategoriaPrimaria: $("#idCategoriaPrimaria option:selected").val()
            },
            "success": function (response) {
                try {
                    response = JSON.parse(response);
                } catch (e) {
                    $("#idCategoriaSecundaria").html(response);
                    $("#idCategoriaSecundaria").select2({
                        width: " 100%"
                    });
                }
                if (response.tipoMsg === "Erro") {
                    if (response.tipoExibicao === "alert") {
                        func.modalAlert(response.msg);
                        return false;
                    }
                }
            }
        });
    });
//*********************************************************************************************************************
    $("body").on("change", "#idCategoriaSecundaria", function (e) {
        $.ajax({
            "url": "/model/cha/informatica/chamado/request.php",
            "dataType": 'html',
            'method': 'POST',
            "data": {
                acao: "retornaFormulario",
                idCategoriaSecundaria: $("#idCategoriaSecundaria option:selected").val()
            },
            "success": function (response) {
                $(".camposformulario").html(response);
                listaPessoaCombo();
                listaPaisCombo();
                listaEstadoCivilCombo();
            }
        });
    });
//*********************************************************************************************************************
    function listaLotacao1Combo(change = false) {
        $.ajax({
            "url": "/model/cha/informatica/chamado/request.php",
            "dataType": 'html',
            'method': 'POST',
            "data": {
                acao: "listaLotacaoOptionPessoa1",
                idPessoa: $("#id_pessoa option:selected").val()
            },
            "success": function (response) {
//                console.log(response);
                $("#id_lotacao1").empty();
                $("body").find("#id_lotacao1").append("<option value='0'>Selecione a Lotação</option>");
                $("#id_lotacao1").append(response);
                $("#id_lotacao1").select2({
                    width: " 100%"
                });
                if (change == true) {
                    $("#id_lotacao1").change();
                }
            }
        });
    }
//*********************************************************************************************************************
    function listaLotacaoCombo() {
        $.ajax({
            "url": "/model/cha/informatica/chamado/request.php",
            "dataType": 'html',
            "data": {
                acao: "listaLotacaoOptionPessoa",
            },
            "success": function (response) {
//                console.log(response);
                $(".Lotacao").append(response);
                $(".Lotacao").select2({
                    width: " 100%"
                });
            }
        });
    }
//*********************************************************************************************************************
    function listaCargo1Combo() {
        $.ajax({
            "url": "/model/cha/informatica/chamado/request.php",
            "dataType": 'html',
            'method': 'POST',
            "data": {
                acao: "listaCargoOptionPessoa1",
                idPessoa: $("#id_pessoa option:selected").val()
            },
            "success": function (response) {
//                console.log(response);
                $("#id_cargo1").empty();
                $("body").find("#id_cargo1").append("<option value='0'>Selecione o Cargo</option>");
                $("#id_cargo1").append(response);
                $("#id_cargo1").select2({
                    width: " 100%"
                });
            }
        });
    }
//*********************************************************************************************************************
    function listaCargoCombo() {
        $.ajax({
            "url": "/model/cha/informatica/chamado/request.php",
            "dataType": 'html',
            "data": {
                acao: "listaCargoOptionPessoa",
            },
            "success": function (response) {
//              console.log(response);
                $("#id_cargo1").empty();
                $("#id_cargo1").append(response);
                $("#id_cargo1").select2({
                    width: " 100%"
                });
            }
        });
    }
//*********************************************************************************************************************
    function listaFuncao1Combo() {
        $.ajax({
            "url": "/model/cha/informatica/chamado/request.php",
            "dataType": 'html',
            'method': 'POST',
            "data": {
                acao: "listaFuncaoOptionPessoa1",
                idPessoa: $("#id_pessoa option:selected").val()
            },
            "success": function (response) {
//                console.log(response);
                $("#id_funcao1").empty();
                $("body").find("#id_funcao1").append("<option value='0'>Selecione a Função</option>");
                $("#id_funcao1").append(response);
                $("#id_funcao1").select2({
                    width: " 100%"
                });
            }
        });
    }
//*********************************************************************************************************************
    function listaFuncaoCombo() {
        $.ajax({
            "url": "/model/cha/informatica/chamado/request.php",
            "dataType": 'html',
            "data": {
                acao: "listaFuncaoOptionPessoa",
            },
            "success": function (response) {
//              console.log(response);
                $("#id_funcao1").empty();
                $("#id_funcao1").append(response);
                $("#id_funcao1").select2({
                    width: " 100%"
                });
            }
        });
    }
//*********************************************************************************************************************
    function listaVinculo1Combo() {
        $.ajax({
            "url": "/model/cha/informatica/chamado/request.php",
            "dataType": 'html',
            'method': 'POST',
            "data": {
                acao: "listaVinculoOptionPessoa1",
                idPessoa: $("#id_pessoa option:selected").val()
            },
            "success": function (response) {
//                console.log(response);
                $("#id_vinculo1").empty();
                $("body").find("#id_vinculo1").append("<option value='0'>Selecione o Vínculo</option>");
                $("#id_vinculo1").append(response);
                $("#id_vinculo1").select2({
                    width: " 100%"
                });
            }
        });
    }
//*********************************************************************************************************************
    function listaVinculoCombo() {
        $.ajax({
            "url": "/model/cha/informatica/chamado/request.php",
            "dataType": 'html',
            "data": {
                acao: "listaVinculoOptionPessoa",
            },
            "success": function (response) {
//              console.log(response);
                $(".Vinculo").append(response);
                $(".Vinculo").select2({
                    width: " 100%"
                });
            }
        });
    }
//*********************************************************************************************************************
    function listaEscolaridade1Combo() {
        $.ajax({
            "url": "/model/cha/informatica/chamado/request.php",
            "dataType": 'html',
            'method': 'POST',
            "data": {
                acao: "listaEscolaridadeOptionPessoa1",
                idPessoa: $("#id_pessoa option:selected").val()
            },
            "success": function (response) {
//                  console.log(response);
                $("#id_escolaridade1").empty();
                $("body").find("#id_escolaridade1").append("<option value='0'>Selecione a Escolaridade</option>");
                $("#id_escolaridade1").append(response);
                $("#id_escolaridade1").select2({
                    width: " 100%"
                });
            }
        });
    }
//*********************************************************************************************************************
    function listaEscolaridadeCombo() {
        $.ajax({
            "url": "/model/cha/informatica/chamado/request.php",
            "dataType": 'html',
            "data": {
                acao: "listaEscolaridadeOptionPessoa"
            },
            "success": function (response) {
                //  console.log(response);
                $(".Escolaridade").append(response);
                $(".Escolaridade").select2({
                    width: " 100%"
                });
            }
        });
    }
//*********************************************************************************************************************
    function listaEstadoCivil1Combo() {
        $.ajax({
            "url": "/model/cha/informatica/chamado/request.php",
            "dataType": 'html',
            'method': 'POST',
            "data": {
                acao: "listaEstadoCivilOptionPessoa1",
                idPessoa: $("#id_pessoa option:selected").val()
            },
            "success": function (response) {
//                  console.log(response);
                $("#id_estado_civil1").empty();
                $("body").find("#id_estado_civil1").append("<option value='0'>Selecione o Estado Civíl</option>");
                $("#id_estado_civil1").append(response);
                $("#id_estado_civil1").select2({
                    width: " 100%"
                });
            }
        });
    }
//*********************************************************************************************************************
    function listaEstadoCivilCombo() {
        $.ajax({
            "url": "/model/cha/informatica/chamado/request.php",
            "dataType": 'html',
            "data": {
                acao: "listaEstadoCivilOptionPessoa"
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
//*********************************************************************************************************************
    function listaPessoaCombo() {
        $.ajax({
            "url": "/model/cha/informatica/chamado/request.php",
            "dataType": 'html',
            "data": {
                acao: "listaPessoaOption"
            },
            "success": function (response) {
                $("body").find("#id_pessoa").empty("<option value='0'>Pessoa não cadastrada no sistema</option>");
                $("body").find("#id_pessoa").append("<option value='0'>Pessoa não cadastrada no sistema</option>");
                $("body").find("#id_pessoa").append(response);
                $("#id_pessoa").select2({
                    width: " 100%"
                });
                $.ajax({
                    "url": "/model/cha/informatica/chamado/request.php",
                    "dataType": 'html',
                    'method': 'POST',
                    "data": {
                        acao: "returnPessoa",
                        idPessoa: $("#id_pessoa option:selected").val()
                    },
                    "success": function (response) {
//                     console.log(response);
                        try {
                            response = JSON.parse(response);
                        } catch (e) {
                        }
                        $(".nmPessoa").val(response[0]['nm_pessoa']);
                        $(".nrTelefone").val(response[0]['nr_telefone_celular']);
                        $(".dsEmail").val(response[0]['nm_email']);
                        $(".nrCartaoSus").val(response[0]['nr_cns']);
                        $(".nrCartaoSus").mask("999 9999 9999 9999");
                        $(".nrCpf").val(response[0]['nr_cpf']);
                        $(".nrCpf").mask("999.999.999-99");
                        $(".nrRg").val(response[0]['nr_rg']);
                        $(".telefoneLotacao").val(response[0]['nr_telefone']);
                        $("#nr_telefone").mask("(99) 9999-9999");
                        $("#nrTelefoneSetor").mask("(99) 9999-9999");
                        $("#id_pais_naturalidade").val(response[0]['id_pais_naturalidade']).change();
                        $("#tp_sexo").val(response[0]['tp_sexo']);
                        $(".nrMatricula").val(response[0]['nr_matricula']);
                        $(".estadoCivil").val(response[0]['id_estado_civil']).change();
                        $("#nrTelefone").mask("(99) 9 9999-9999");
                        $("#dt_inicial").mask("99/99/9999");
                        $("#dt_fim").mask("99/99/9999");
                        $(".Vlan").mask("9999");
                        $("#dt_nascimento").mask("99/99/9999");
                        $(".dtNascimento").val(response[0]['dt_nascimento']);
                        $(".Cargo").val(response[0]['id_cargo']);
                        $(".idFuncao").val(response[0]['id_funcao']);
                        $(".Vinculo").val(response[0]['id_vinculo']);
                        $(".Escolaridade").val(response[0]['id_escolaridade']);
                        $(".Lotacao").val(response[0]['id_lotacao']);
                        listaLotacao1Combo(true);
                        listaCargo1Combo();
                        listaVinculo1Combo();
                        listaFuncao1Combo();
                        listaEscolaridade1Combo();
                        listaEstadoCivil1Combo();
                        return;
                        if (response.tipoMsg === "Erro") {
                            if (response.tipoExibicao === "alert") {
                                func.modalAlert(response.msg);
                                return false;
                            }
                        }
                    }
                })
            }
        });
    }
//*********************************************************************************************************************
    function returnChamados() {
        $.ajax({
            "url": "/model/cha/informatica/chamado/request.php",
            "dataType": "html",
            "method": "POST",
            "data": {
                "acao": "returnChamados"
            },
            "success":
                    function (response) {
                        try {
                            response = JSON.parse(response);
                        } catch (e) {
//                            console.log(response);
//                            return false;
                        }
//                        console.log(response);
                        $(".nmPessoa").val(response[0]['nm_pessoa']);
                        $(".nrTelefone").val(response[0]['nr_telefone_celular']);
                        $(".dsEmail").val(response[0]['nm_email']);
                        $(".nrCartaoSus").val(response[0]['nr_cns']);
                        $(".nrCartaoSus").mask("999 9999 9999 9999");
                        $(".nrCpf").val(response[0]['nr_cpf']);
                        $(".nrCpf").mask("999.999.999-99");
                        $(".nrRg").val(response[0]['nr_rg']);
                        $(".telefoneLotacao").val(response[0]['nr_telefone']);
                        $("#nr_telefone").mask("(99) 9999-9999");
                        $("#nrTelefoneSetor").mask("(99) 9999-9999");
                        $(".nrMatricula").val(response[0]['nr_matricula']);
                        $(".estadoCivil").val(response[0]['id_estado_civil']);
                        $("#nrTelefone").mask("(99) 9 9999-9999");
                        $("#dt_inicial").mask("99/99/9999");
                        $("#dt_fim").mask("99/99/9999");
                        $("#dt_nascimento").mask("99/99/9999");
                        $(".Vlan").mask("9999");
//             $(".nmResponsavel").val(response[0]['id_pessoa']);
                        $(".dtNascimento").val(response[0]['dt_nascimento']);
                        $(".Cargo").val(response[0]['id_cargo']);
                        $(".idFuncao").val(response[0]['id_funcao']);
                        $(".Vinculo").val(response[0]['id_vinculo']);
                        $(".Escolaridade").val(response[0]['id_escolaridade']);
                        $(".Lotacao").val(response[0]['id_lotacao']);
                        listaLotacaoCombo();
                        listaCargoCombo();
                        listaVinculoCombo();
                        listaFuncaoCombo()
                        listaEscolaridadeCombo();
                        listaEstadoCivilCombo();
                        return;
                    }
        });
    }
    returnChamados();
    //*********************************************************************************************************************
    $("body").on("change", "#id_pessoa", function (e) {
        if ($("#id_pessoa").val() == 0) {
            $("#nm_pessoa").val("");
            $("#id_cargo1").val("");
            $("#nm_email").val("");
            $("#nr_cns").val("");
            $("#id_lotacao1").val("");
            $("#nr_rg").val("");
            $("#dt_nascimento").val("");
            $("#id_estado_civil").val("");
            $("#nr_matricula").val("");
            $("#nr_cpf").val("");
            $("#nr_telefone").val("");
            $("#cdCnes").val("");
            $("#tp_sexo").val(0);
            $("#id_pais_naturalidade").val("");
            $("#id_funcao1").val("");
            $("#id_vinculo1").val("");
            $("#id_escolaridade1").val("");
            $("#id_estado_civil1").val("");
            $("#dsAndar").val(0);
            $("#nrVlan").val("");
            $("#qtPontosRede").val("");
            $("#nmAplicativo").val("");
            $("#qtCabos").val("");
            $("#qtLineCords").val("");
            $("#qtPatchCord").val("");
            $("#ipGateway").val("");
            $("#dsJustificativa").val("");
            $("#dsProblema").val("");
            $("#qtKeystones").val("");
            $("#qtRj45").val("");
            $("#qtRacks").val("");
            $("#nmPasta").val("");
            listaLotacao1Combo(true);
            listaCargo1Combo();
            listaFuncao1Combo();
            listaVinculo1Combo();
            listaEscolaridade1Combo();
            listaEstadoCivil1Combo();
            return false;
        }
        $.ajax({
            "url": "/model/cha/informatica/chamado/request.php",
            "dataType": 'html',
            'method': 'POST',
            "data": {
                acao: "returnPessoa",
                idPessoa: $("#id_pessoa option:selected").val()
            },
            "success": function (response) {
//                console.log(response);
                try {
                    response = JSON.parse(response);
                } catch (e) {
//                    $("#id_pessoa").html(response);
//                    $("#id_pessoa").select2({
//                        width: " 100%"
//                    });
                }
                $("#nm_pessoa").val(response[0]['nm_pessoa']);
                $("#tp_sexo").val(response[0]['tp_sexo']);
                $(".nrTelefone").val(response[0]['nr_telefone_celular']);
                $(".dsEmail").val(response[0]['nm_email']);
                $(".nrCartaoSus").val(response[0]['nr_cns']);
                $(".nrCartaoSus").mask("999 9999 9999 9999");
                $(".nrCpf").val(response[0]['nr_cpf']);
                $(".nrCpf").mask("999.999.999-99");
                $(".nrRg").val(response[0]['nr_rg']);
                $(".telefoneLotacao").val(response[0]['nr_telefone']);
                $("#nr_telefone").mask("(99) 9999-9999");
                $("#nrTelefoneSetor").mask("(99) 9999-9999");
                $(".nrMatricula").val(response[0]['nr_matricula']);
                $(".estadoCivil").val(response[0]['id_estado_civil']);
                $("#nrTelefone").mask("(99) 9 9999-9999");
                $("#dt_inicial").mask("99/99/9999");
                $("#dt_fim").mask("99/99/9999");
                $("#dt_nascimento").mask("99/99/9999");
                $(".dtNascimento").val(response[0]['dt_nascimento']);
                $(".Vlan").mask("9999");
                $(".Cargo").val(response[0]['id_cargo']);
                $(".Funcao").val(response[0]['id_funcao']);
                $(".Vinculo").val(response[0]['id_vinculo']);
                $(".Escolaridade").val(response[0]['id_escolaridade']);
                $(".Lotacao").val(response[0]['id_lotacao']);
                listaLotacao1Combo(true);
                listaCargo1Combo();
                listaVinculo1Combo();
                listaFuncao1Combo()
                listaEscolaridade1Combo();
                listaEstadoCivil1Combo();
                return;
                if (response.tipoMsg === "Erro") {
                    if (response.tipoExibicao === "alert") {
                        func.modalAlert(response.msg);
                        return false;
                    }
                }
            }
        });
    });
//******************************************************************************************
    $(".nrCpf").mask("999.999.999-99");
    $("#nr_cep").mask("99999-999");
    $(".nrCartaoSus").mask("999 9999 9999 9999");
    $("#nrTelefoneSolicitante").mask("(99) 9 9999-9999");
    $("#nrTelefone").mask("(99) 9 9999-9999");
    $("#nrTelefoneSetor").mask("(99) 9999-9999");
    $("#nr_telefone").mask("(99) 9999-9999");
    $(".nr_ramal").mask("(99) 9999-9999");
    $(".data").mask("99/99/9999");
    $("#dt_inicial").mask("99/99/9999");
    $("#dt_fim").mask("99/99/9999");
    $("#dt_nascimento").mask("99/99/9999");
    $(".Vlan").mask("9999");
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

    $('body').on('click', '.btn-salvar', function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else {
            e.preventDefault();
            var $this = $(this);
            //$this.prop("disabled", true);

            var dsChamado = ($("#dsProblema").val() ? $("#dsProblema").val() : "");

            //Percorre os anexos
            var anexos = [];
            $('#arquivos .form-group').each(function (e) {
                var anexo = $(this).data('anexo');
                anexos.push(anexo);
            });

            var DadosChamado = {
                idCategoriaSecundaria: $("#idCategoriaSecundaria").val(),
                idPessoaSolicitante: $("#nm_usuario").val(),
                idPessoaServico: $("#id_pessoa").val(),
                dhAbertura: $("#data").val(),
                dsChamado: dsChamado,
                nrTelefoneSolicitante: $("#nrTelefoneSolicitante").val(),
                dsFinalizado: null,
                dhFinalizado: null,
                nrAvaliacao: null,
                dhAvaliacao: null,
                dsAvaliacao: null,
                vlChamado: null,
                idStatus: 1,
                dhAgendamento: null,
                idPrioridade: null,
                dhCancelamento: null,
                dsCancelamento: null,
                dtPrazo: null,
                anexos: anexos
            };
//            console.log(DadosChamado);
//            return;
            var nmPessoa = ($("#nm_pessoa").val() ? $("#nm_pessoa").val() : "");
            var dsEmail = ($("#nm_email").val() ? $("#nm_email").val() : "");
            var nrTelefone = ($("#nrTelefone").val() ? $("#nrTelefone").val() : "");
            var nrCartaoSus = ($("#nr_cns").val() ? $("#nr_cns").val() : "");
            var nrCpf = ($("#nr_cpf").val() ? $("#nr_cpf").val() : "");
            var nrRg = ($("#nrRg").val() ? $("#nrRg").val() : "");
            var nrTelefoneSetor = ($("#nr_telefone").val() ? $("#nr_telefone").val() : "");
            var nrMatricula = ($("#nrMatricula").val() ? $("#nrMatricula").val() : "");
            var nmModulo = ($("#nmModulo").val() ? $("#nmModulo").val() : "");
            var nrPortaria = ($("#nrPortaria").val() ? $("#nrPortaria").val() : "");
            var nmSetor = ($("#nmSetor").val() ? $("#nmSetor").val() : "");
            var cdSetor = ($("#cdSetor").val() ? $("#cdSetor").val() : "");
            var nmResponsavel = ($("#nm_pessoa").val() ? $("#nm_pessoa").val() : "");
            var nrParticipantes = ($("#nrParticipantes").val() ? $("#nrParticipantes").val() : "");
            var dsSenhaDesejada = ($("#dsSenhaDesejada").val() ? $("#dsSenhaDesejada").val() : "");
            var nmExame = ($("#nmExame").val() ? $("#nmExame").val() : "");
            var dsExameParametro = ($("#dsExameParametro").val() ? $("#dsExameParametro").val() : "");
            var nmPermissao = ($("#nmPermissao").val() ? $("#nmPermissao").val() : "");
            var nmConselho = ($("#nmConselho").val() ? $("#nmConselho").val() : "");
            var nrConselho = ($("#nrConselho").val() ? $("#nrConselho").val() : "");
            var dtInicial = ($("#dtInicial").val() ? $("#dtInicial").val() : "");
            var dtFim = ($("#dtFim").val() ? $("#dtFim").val() : "");
            var dtNascimento = ($("#dtNascimento").val() ? $("#dtNascimento").val() : "");
            var idCargo = ($("#idCargo").val() ? $("#idCargo").val() : "");
            var idFuncao = ($("#idFuncao").val() ? $("#idFuncao").val() : "");
            var idLotacao = ($("#id_lotacao1").val() ? $("#id_lotacao1").val() : "");
            var idVinculo = ($("#idVinculo").val() ? $("#idVinculo").val() : "");

            var DadosFormSistema = {
                nmPessoa: nmPessoa,
                dsEmail: dsEmail,
                nrTelefone: nrTelefone,
                nrCartaoSus: nrCartaoSus,
                nrCpf: nrCpf,
                nrRg: nrRg,
                nrTelefoneSetor: nrTelefoneSetor,
                nrMatricula: nrMatricula,
                nmModulo: nmModulo,
                nrPortaria: nrPortaria,
                nmSetor: nmSetor,
                cdSetor: cdSetor,
                nmResponsavel: nmResponsavel,
                nrParticipantes: nrParticipantes,
                dsSenhaDesejada: dsSenhaDesejada,
                nmExame: nmExame,
                dsExameParametro: dsExameParametro,
                nmPermissao: nmPermissao,
                nmConselho: nmConselho,
                nrConselho: nrConselho,
                dtInicial: dtInicial,
                dtFim: dtFim,
                dtNascimento: dtNascimento,
                idCargo: idCargo,
                idFuncao: idFuncao,
                idLotacao: idLotacao,
                idVinculo: idVinculo
            };

            var tpLiberacao = ($("#tpLiberacao").val() ? $("#tpLiberacao").val() : "");
            var nmPessoa = ($("#nm_pessoa").val() ? $("#nm_pessoa").val() : "");
            var idCargo = ($("#idCargo").val() ? $("#idCargo").val() : "");
            var idFuncao = ($("#idFuncao").val() ? $("#idFuncao").val() : "");
            var idLotacao = ($("#id_lotacao1").val() ? $("#id_lotacao1").val() : "");
            var nmEmail = ($("#nm_email").val() ? $("#nm_email").val() : "");
            var dsAndar = ($("#dsAndar").val() ? $("#dsAndar").val() : "");
            var qtPontos = ($("#qtPontos").val() ? $("#qtPontos").val() : "");
            var qtCabos = ($("#qtCabos").val() ? $("#qtCabos").val() : "");
            var nmApp = ($("#nmApp").val() ? $("#nmApp").val() : "");
            var qtPatchCord = ($("#qtPatchCord").val() ? $("#qtPatchCord").val() : "");
            var dsJustificativa = ($("#dsJustificativa").val() ? $("#dsJustificativa").val() : "");
            var nrVlan = ($("#nrVlan").val() ? $("#nrVlan").val() : "");
            var qtKeystone = ($("#qtKeystone").val() ? $("#qtKeystone").val() : "");
            var qtRj45 = ($("#qtRj45").val() ? $("#qtRj45").val() : "");
            var qtRack = ($("#qtRack").val() ? $("#qtRack").val() : "");
            var nmPasta = ($("#nmPasta").val() ? $("#nmPasta").val() : "");
            var dsDestino = ($("#dsDestino").val() ? $("#dsDestino").val() : "");
            var qtComputador = ($("#qtComputador").val() ? $("#qtComputador").val() : "");
            var qtImpressora = ($("#qtImpressora").val() ? $("#qtImpressora").val() : "");
            var qtTelefone = ($("#qtTelefone").val() ? $("#qtTelefone").val() : "");
            var dsIpGateway = ($("#dsIpGateway").val() ? $("#dsIpGateway").val() : "");
            var nrTelefone = ($("#nrTelefone").val() ? $("#nrTelefone").val() : "");

            var DadosFormInfraestrutura = {
                tpLiberacao: tpLiberacao,
                nmPessoa: nmPessoa,
                idCargo: idCargo,
                idFuncao: idFuncao,
                idLotacao: idLotacao,
                nmEmail: nmEmail,
                dsAndar: dsAndar,
                qtPontos: qtPontos,
                qtCabos: qtCabos,
                nmApp: nmApp,
                qtPatchCord: qtPatchCord,
                dsJustificativa: dsJustificativa,
                nrVlan: nrVlan,
                qtKeystone: qtKeystone,
                qtRj45: qtRj45,
                qtRack: qtRack,
                nmPasta: nmPasta,
                dsDestino: dsDestino,
                qtComputador: qtComputador,
                qtImpressora: qtImpressora,
                qtTelefone: qtTelefone,
                dsIpGateway: dsIpGateway,
                nrTelefone: nrTelefone
            };
//            console.log(DadosFormSistema);

//            console.log(DadosFormSistema);
//            return;


//            if (DadosChamado.idCategoriaSecundaria == 0 || DadosChamado.idPessoaSolicitante == "" || DadosChamado.idPessoaServico == "" || DadosChamado.dhAbertura == "" ||
//                    DadosChamado.dsChamado == "" || DadosChamado.nrTelefoneSolicitante == "" || DadosChamado.dsFinalizado == "" || DadosChamado.dhFinalizado == "" ||
//                    DadosChamado.nrAvaliacao == "" || DadosChamado.dhAvaliacao == "" || DadosChamado.dsAvaliacao == "" || DadosChamado.vlChamado == "" ||
//                    DadosChamado.idStatus == 0 || DadosChamado.dhAgendamento == "" || DadosChamado.idPrioridade == 0 || DadosChamado.dhCancelamento == "" ||
//                    DadosChamado.dsCancelamento == "" || DadosChamado.dtPrazo == "") {
//                func.modalAlert(func.msgPreencherCampos + " (Chamado)");
//                //$this.prop("disabled", false);
//                return false;
//            }
//            
//            if (DadosFormSistema.nmPessoa == "" || DadosFormSistema.dsEmail == "" || DadosFormSistema.nrTelefone == "" || DadosFormSistema.nrCartaoSus == "" || 
//                    DadosFormSistema.nrCpf == "" || DadosFormSistema.nrRg == "" || DadosFormSistema.nrTelefoneSetor == "" || DadosFormSistema.nrMatricula == "" || 
//                    DadosFormSistema.nmModulo == "" || DadosFormSistema.nrPortaria == "" || DadosFormSistema.nmSetor == "" || DadosFormSistema.cdSetor == "" || 
//                    DadosFormSistema.nmResponsavel == "" || DadosFormSistema.nrParticipantes == "" || DadosFormSistema.dsSenhaDesejada == "" || DadosFormSistema.nmExame == "" || 
//                    DadosFormSistema.dsExameParametro == "" || DadosFormSistema.nmPermissao == "" || DadosFormSistema.nmConselho == "" || DadosFormSistema.nrConselho == "" || 
//                    DadosFormSistema.dtInicial == "" || DadosFormSistema.dtFim == "" || DadosFormSistema.dtNascimento == "" || DadosFormSistema.idCargo == "" || 
//                    DadosFormSistema.idFuncao == "" || DadosFormSistema.idLotacao == "" || DadosFormSistema.idVinculo == "") {
//                func.modalAlert(func.msgPreencherCampos + " (sISTEMA)");
//                //$this.prop("disabled", false);
//                return false;
//            }
//            
//            if (DadosFormInfraestrutura.tpLiberacao == 0 || DadosFormInfraestrutura.nmPessoa == "" || DadosFormInfraestrutura.idCargo == 0 || DadosFormInfraestrutura.idFuncao == 0 || 
//                    DadosFormInfraestrutura.idLotacao == 0 || DadosFormInfraestrutura.nmEmail == "" || DadosFormInfraestrutura.dsAndar == 0 || DadosFormInfraestrutura.qtPontos == "" || 
//                    DadosFormInfraestrutura.qtCabos == "" || DadosFormInfraestrutura.nmApp == "" || DadosFormInfraestrutura.qtPatchCord == "" || DadosFormInfraestrutura.dsJustificativa == "" || 
//                    DadosFormInfraestrutura.nrVlan == "" || DadosFormInfraestrutura.qtKeystone == "" || DadosFormInfraestrutura.qtRj45 == "" || DadosFormInfraestrutura.qtRack == "" || 
//                    DadosFormInfraestrutura.nmPasta == "" || DadosFormInfraestrutura.dsDestino == "" || DadosFormInfraestrutura.qtComputador == "" || DadosFormInfraestrutura.qtImpressora == ""
//                    || DadosFormInfraestrutura.qtTelefone == "" || DadosFormInfraestrutura.dsIpGateway == "" || DadosFormInfraestrutura.nrTelefone == "" ) {
//                func.modalAlert(func.msgPreencherCampos + " (INFRA)");
//                //$this.prop("disabled", false);
//                return false;
//            }
            //***********************************************
//
//console.log(DadosChamado);
//console.log(DadosFormSistema);

            $.ajax({
                "url": "/model/cha/informatica/chamado/request.php",
                "dataType": 'html',
                'method': 'POST',
                "data": {
                    "acao": "cadastrarChamado",
                    "dadosChamado": DadosChamado,
                    "dadosFormSistema": DadosFormSistema,
                    "dadosFormInfraestrutura": DadosFormInfraestrutura,
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
                        $('.modal-alert').on('hidden.bs.modal', function (e) {
                            top.location.href = "/pages/cha/informatica/index.php?id=3";
                        });
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
//*********************************************************************************************************************

    $('body').on('click', '.btn-remover', function (e) {

        var $this = $(this);
        var id = $this.val();
        var chamado = $this.closest('td').find('.btn-edit').attr("nome");
        bootbox.confirm({
            title: 'Caixa de Confirmação',
            message: 'Você tem Certeza que deseja continuar com a Exclusão deste Chamado?<span class="text-danger">' + id + '</span>?',
            buttons: {
                'cancel': {
                    label: 'Não',
                    className: 'btn-default btn-rounded'
                },
                'confirm': {
                    label: 'Sim',
                    className: 'btn-primary btn-rounded'
                }
            },
            callback: function (result) {
                if (result) {
                    var Dados = {
                        id: id
                    }

                    if (id == "") {
                        func.modalAlert(func.msgPreencherCampos);
                        $this.prop("disabled", false);
                        return false;
                    }

                    $.ajax({
                        "url": "/model/cha/informatica/chamado/request.php",
                        "dataType": "html",
                        "data": {
                            "acao": "remChamado",
                            "dados": Dados
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
                                //console.log("Parse JSON");
                                //console.log(response);
                                return false;
                            }

                            if (response.tipoMsg === "Erro") {
                                if (response.tipoExibicao === "console") {
                                    //console.log('Console Mensagem');
                                    //console.log(response);
                                    func.modalAlert(func.msgErroPadrao);
                                    return false;
                                } else if (response.tipoExibicao === "alert") {
                                    func.modalAlert(response.msg);
                                    return false;
                                }
                            } else if (response.tipoMsg === "ok") {
                                func.modalAlert(response.msg, 'primary');
//                                $('.modal-alert').on('hidden.bs.modal', function (e) {
//                                    top.location.href = "/pages/rh/funcionario/index.php";
//                                });
                                return false;
                            } else {
                                //console.log('Ultimo else');
                                //console.log(response);
                                func.modalAlert(func.msgErroPadrao);
                                return false;
                            }
                        },
                        "error": function (response) {
                            //console.log(response);
                            func.modalAlert(func.msgErroPadrao);
                            return false;
                        }
                    });
                }
            }
        });
    });
//******************************************************************************************


    $('body').on('click', '.btn-edit', function (e) {
        e.preventDefault();
        var id = $(this).val();
        $('.btn-editar').val(id);
        $("#nome").val($(this).attr('nome'));
        $('.btn-salvar').hide();
        $('.btn-editar').show();
        $("#codigo").val($(this).attr('codigo'));
        $("#dt_inicio").val($(this).attr('aa_inicio'));
        $("#dt_fim").val($(this).attr('aa_fim'));
        $("#nome").focus();
    });
    $('body').on('click', '.btn-limpar', function (e) {
        $('.btn-salvar').prop("disabled", false);
        $('.btn-editar').prop("disabled", false);
        $('.btn-salvar').show();
        $('.btn-editar').val(0);
        $('.btn-editar').hide();
        $("#nome").val("");
        $("#dt_inicio").val("");
        $("#dt_fim").val("");
    });
    $('.modal-alert').on('shown.bs.modal', function (e) {
        $("#nome").focus();
    });
    $('body').on('keypress', '.formVinculo', function (e) {
        var key = e.which;
        if (key == 13) {
            $(".btn-salvar").trigger('click');
            return false;
        }
    });
//************************************************************************************

    $('body').on('click', '.btn-enviarUpload', function (e) {
        var formulario = document.getElementById('form-upload');
        var anexar = new FormData(formulario);

        $.ajax({

            url: '/model/cha/informatica/chamado/upload/anexaArquivo.php',
            data: anexar,
            processData: false,
            contentType: false,
            method: "post",

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
                        func.modalAlert(response.msg, 'danger');
                        return false;
                    }
                } else if (response.tipoMsg === "ok") {
                    $("#arquivos").append(response.msg);
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
    });
});
