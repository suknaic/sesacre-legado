
function listaLotacaoCombo(id) {
    $.ajax({
        "url": "/model/rh/lotacao/request.php",
        "dataType": 'html',
        "data": {
            acao: "listaLotacaoOption",
            id: id
        },
        "success": function (response) {
            console.log(response);
            $("#id_pai_lotacao").append(response);
            $("#id_pai_lotacao").select2({
                width: " 100%"
            });
        }
    });
}

function listaCategoriaCombo(id) {
    $.ajax({
        "url": "/model/rh/lotacao/request.php",
        "dataType": 'html',
        "data": {
            acao: "listaCategoriaOption",
            id: id
        },
        "success": function (response) {
            $("#id_categoria").append(response);
            $("#id_categoria").select2({
                //width: " 100%"
            });
        }
    });
}
//listaCategoriaCombo();
//******************************************************************************************
function listaPaisCombo() {
    $.ajax({
        "url": "/model/rh/lotacao/request.php",
        "dataType": 'html',
        "data": {
            acao: "listaPaisOption"
        },
        "success": function (response) {
            $(".pais").append(response);
            $(".pais").select2({
                //width: " 100%"
            });
            returnLotacaoEditar();
        }
    });
}
listaPaisCombo();
function listaEstadoCombo(idPais, idEstado) {
    $.ajax({
        "url": "/model/rh/lotacao/request.php",
        "dataType": 'html',
        "data": {
            acao: "listaEstadoOption",
            idPais: idPais,
            idEstado: idEstado
        },
        "success": function (response) {
            $("#id_estado_endereco").empty();
            $("#id_estado_endereco").append(response);
            $("#id_estado_endereco").select2({
                //width: " 100%"
            });
            $("#id_estado_endereco").val(idEstado);
        }
    });
}
function listaCidadeCombo(idEstado, idCidade) {
    $.ajax({
        "url": "/model/rh/lotacao/request.php",
        "dataType": 'html',
        "data": {
            acao: "listaCidadeOption",
            idEstado: idEstado,
            idCidade: idCidade
        },
        "success": function (response) {
            $("#id_cidade").empty();
            $("#id_cidade").append(response);
            $("#id_cidade").select2({
                //width: " 100%"
            });

        }
    });
}

//******************************************************************************************
function returnTelefones(id_lotacao) {
    $.ajax({
        "url": "/model/rh/lotacao/request.php",
        "dataType": "html",
        "data": {
            "acao": "returnTelefones",
            "idLotacao": id_lotacao
        },
        "success":
                function (response) {
                    $("#corpoTabela").html(response);
                }
    });
}
//******************************************************************************************
function returnLotacaoEditar() {
    var id_get = $("#id_get").val();
    $.ajax({
        "url": "/model/rh/lotacao/request.php",
        "dataType": "html",
        "data": {
            "acao": "returnLotacaoEditar",
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
                    $("#id_lotacao").val(response[0]['id_lotacao']);
                    if (response[0]['id_lotacao_categoria'] == 5) {
                        $('#obgPai').hide();
                    } else {
                        $('#obgPai').show();
                    }
                    listaLotacaoCombo(response[0]['id_pai']);
                    listaCategoriaCombo(response[0]['id_lotacao_categoria']);
                    $("#nm_lotacao").val(response[0]['nm_lotacao']);
                    $("#nr_cnpj").val(response[0]['nr_cnpj']);
                    $("#ds_logradouro").val(response[0]['ds_logradouro']);
                    $("#ds_bairro").val(response[0]['ds_bairro']);
                    $("#nr_cep").val(response[0]['nr_cep']);
                    $("#nm_email").val(response[0]['nm_email']);
                    $("#mp_latitude").val(response[0]['mp_latitude']);
                    $("#mp_longitude").val(response[0]['mp_longitude']);
                    //*************************************************************
                    $("#id_pessoa").val(response[0]['id_pessoa']);
                    $("#id_pessoa_juridica").val(response[0]['id_pessoa_juridica']);
                    $("#nm_pessoa_juridica").val(response[0]['nm_pessoa_juridica']);
                    $("#nm_pessoa2").val(response[0]['nm_pessoa']);
                    //******************************************************
                    $("#id_pais_endereco").val(response[0]['id_pais']).change();
                    //********************************************************
                    // $("#id_estado_endereco").empty();
                    listaEstadoCombo(response[0]['id_pais'], response[0]['id_estado']);
                    $("#id_estado_endereco").val(response[0]['id_estado']);
                    listaCidadeCombo(response[0]['id_estado'], response[0]['id_cidade']);
                    $("#id_cidade").val(response[0]['id_cidade']).change();
                    //console.log(response);
                    returnTelefones(id_get);
                }
    });
}
//**********************uf para cep**********************************************************
function listaCidadeComboUf(idEstado, uf) {
    $.ajax({
        "url": "/model/rh/lotacao/request.php",
        "dataType": 'html',
        "method": 'POST',
        "data": {
            acao: "listaCidadeOptionUf",
            idEstado: idEstado,
            uf: uf
        },
        "success": function (response) {
            $("#id_cidade").empty();
            $("#id_cidade").append(response);
            $("#id_cidade").select2({
                width: " 100%"
            });


        }
    });
}
//**********************************************************************************************************************

$("body").on("change.select2", "#id_categoria", function (e) {
    if ($('#id_categoria').val() == 5) {
        $('#obgPai').hide();
    } else {
        $('#obgPai').show();
    }
});

$(document).ready(function () {

    func = new Funcoes();
    //******************************************************************************************
    $("body").on("change", "#id_cidade", function (e) {
        $("#ds_logradouro").val("");
        $("#ds_bairro").val("");
        $("#ds_complemento").val("");
        $("#nr_cep").val("");

    });
    //******************************************************************************************
    $("body").on("change", "#id_pais_endereco", function (e) {
        $("#id_estado_endereco").empty();
        $("#id_cidade").empty();
        $idPais = $("#id_pais_endereco").val();
        if ($idPais == 0) {
            return;
        }
        $("#id_cidade").empty();
        listaEstadoCombo($idPais, 0);
        //***********
    });
    //******************************************************************************************
    $("body").on("change", "#id_estado_endereco", function (e) {
        //$("#id_cidade").empty();
        $idEstado = $("#id_estado_endereco").val();
        if ($idEstado == 0) {
            return;
        }
        listaCidadeCombo($idEstado, $("#id_cidade").val());
    });
//******************************************************************************************
    $("#nr_cnpj").mask("99.999.999/9999-99");
    $("#nr_cep").mask("99999-999");
    $("#nr_telefone").mask("(99) 9999-9999");

//******************************************************************************************
    $("body").on("click", ".btn-add", function (e) {
        var idLotacao = $("#id_lotacao").val();
        var nro = $("#nr_telefone").val();
        var x = $(".st_principal").is(":checked");
        if (nro == 0 && nro == "") {
            func.modalAlert("Informe um Numero Telefônico");
            return;
        }
        var flag = 0;
        //********************************************************************************* 
        if ($(this).closest(".panelTelefone").find(".telefoneLinha").length > 0) {
            $("#tabela tbody tr").each(function () {
                if (nro == $(this).find(".telefone").text()) {
                    flag = 1;
                    func.modalAlert(" O Item já Existe!!!");
                }
            });
        }

        if (flag == 1) {
            return;
        }
        //********************************************************************************
        var st = "";
        var value = 0;
        if (x) {
            value = 1;
        }
        var Telefone = {
            idLotacao: idLotacao,
            telefone: nro,
            principal: value
        };
        //****************************************
        $.ajax({
            "url": "/model/rh/lotacao/request.php",
            "dataType": "html",
            "method": "POST",
            "data": {
                "acao": "inserirTelefones",
                "telefone": Telefone

            },
            "success":
                    function (response) {
                        console.log(response);
                        returnTelefones(idLotacao);
                    }
        });


        //*****************************************
        $("#nr_telefone").val("");
        $(".st_principal").prop("checked", false);
    });
//******************************************************************************************
    $("body").on("click", ".excluirLinha", function (e) {
        var idTelefone = $(this).val();
        var idLotacao = $("#id_lotacao").val();
        $.ajax({
            "url": "/model/rh/lotacao/request.php",
            "dataType": "html",
            "data": {
                "acao": "excluirTelefone",
                "idTelefone": idTelefone
            },
            "success":
                    function (response) {
                        returnTelefones(idLotacao);
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
            var cep = func.extrairCarater($("#nr_cep").val(), "-");
            var DadosLotacao = {
                //****************dados *********************
                idLotacao: $("#id_lotacao").val(),
                nomeLotacao: $("#nm_lotacao").val(),
                idCategoria: $("#id_categoria").val(),
                cnpj: $("#nr_cnpj").val(),
                email: $("#nm_email").val(),
                idPaiLotacao: $("#id_pai_lotacao").val(),
                pessoaJuridica: $("#id_pessoa_juridica").val(),
                pessoa: $("#id_pessoa").val(),
                logradouro: $("#ds_logradouro").val(),
                bairro: $("#ds_bairro").val(),
                cep: cep,
                latitude: $("#mp_latitude").val(),
                longitude: $("#mp_longitude").val(),
                cidade: $("#id_cidade").val()
            };

            var x = 0;
            if ($(this).closest(".formRhLotacao").find(".telefoneLinha").length > 0) {
                x = 1;
            }
            //*******************************************************************

            //******************************************************************
            if (DadosLotacao.idCategoria != 5){
                var DadosObrigatorio = {
                    "Categoria": DadosLotacao.idCategoria,
                    "Nome da Lotacao": DadosLotacao.nomeLotacao,
                    "Empresa Responsável": DadosLotacao.pessoaJuridica,
                    "Pessoa Responsável": DadosLotacao.pessoa,
                    "Lotação Pai": DadosLotacao.idPaiLotacao,
                    //********************************************
                    "Cidade": DadosLotacao.cidade,
                    "Logradouro": DadosLotacao.logradouro,
                    "Bairro": DadosLotacao.bairro
                };
            } else {
                var DadosObrigatorio = {
                    "Categoria": DadosLotacao.idCategoria,
                    "Nome da Lotacao": DadosLotacao.nomeLotacao,
                    "Empresa Responsável": DadosLotacao.pessoaJuridica,
                    "Pessoa Responsável": DadosLotacao.pessoa,
                    // "Lotação Pai": DadosLotacao.idPaiLotacao,
                    //********************************************
                    "Cidade": DadosLotacao.cidade,
                    "Logradouro": DadosLotacao.logradouro,
                    "Bairro": DadosLotacao.bairro
                };
            }
            
            $campo = 0;
            $i = 0;
            $.each(DadosObrigatorio, function (index, value) {
                $i++;
                $campo = "";
                if (value == 0 || value == "" || value == null) {
                    if ($i <= 5) {
                        func.modalAlert(func.msgPreencherCampos + " (<strong>" + index + "</strong>)");
                    } else if ($i >= 6 && $i <= 8) {
                        func.modalAlert(func.msgPreencherCampos + " (<strong>" + index + "</strong>)");
                    }
                    $campo = 1;
                    return false;
                }
            });
            if ($campo == 1) {
                return false;
            }

            //***********************************************

            if (x == 0) {
                func.modalAlert(" Informe pelo menos um número de Telefone da Lotação");
                return false;
            }
            //***********************************************
            $.ajax({
                "url": "/model/rh/lotacao/request.php",
                "dataType": "html",
                "data": {
                    "acao": "editarLotacao",
                    "dadosLotacao": DadosLotacao

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
                        func.fechaModalHref('/pages/rh/lotacao/index.php');
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

    $('body').on('click', '.btn-limpar', function (e) {
        location.reload();
    });

    $('body').on('keypress', '.formRhLotacao', function (e) {
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
                                //console.log(response);
                                $("#id_pais_endereco").val(response[0]["id_pais"]).change();
                                listaEstadoCombo(response[0]['id_pais'], response[0]['id_estado']);
                                listaCidadeComboUf(response[0]['id_estado'], cidade);
                            }
                        });
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
    //**************************************************************************
    $('body').on('click', '.pesquisaPessoaJuridica', function (e) {
        $('#tipo').val(2);
        $('#modalTitulo').html('Pesquisa de Empresa');
        $("#nm_pessoa").attr("placeholder", "Nome da Empresa").val("").focus().blur();
        $('#nm_pessoa').val("");
        func.carregaTabelaPadrao('tabelaPessoa', null, null, true);
        $('#nm_pessoa').focus();
    });
    $('body').on('click', '.pesquisaPessoaFisica', function (e) {
        $('#tipo').val(1);
        $('#modalTitulo').html('Pesquisa de Pessoa');
        $("#nm_pessoa").attr("placeholder", "Nome da Pessoa").val("").focus().blur();
        $('#nm_pessoa').val("");
        func.carregaTabelaPadrao('tabelaPessoa', null, null, true);
        $('#nm_pessoa').focus();
    });
    $('body').on('click', '#btn-pesquisa', function (e) {
        $nome = $.trim($("#nm_pessoa").val());
        $tipo = $.trim($("#tipo").val());
        if ($nome == '') {
            return false;
        }
        var Pessoa = {
            nome: $nome,
            tipoPessoa: $tipo
        };
        $.ajax({
            "url": "/model/rh/lotacao/request.php",
            "dataType": 'html',
            "method": "POST",
            "data": {
                acao: "listaPessoaTable",
                pessoa: Pessoa
            },
            "success": function (response) {
                //console.log(response);
                func.carregaTabelaPadrao('tabelaPessoa', response, [2], true);
            }
        });
    });
    $('body').on('click', '.pessoa', function (e) {
        var $this = $(this);
        $nome = $this.find("td:eq(0)").text();
        $idPessoa2 = $this.attr("idPessoa2");
        if ($('#tipo').val() == 2) {
            $('#nm_pessoa_juridica').val($nome);
            $('#id_pessoa_juridica').val($idPessoa2);
        } else {
            $('#nm_pessoa2').val($nome);
            $('#id_pessoa').val($idPessoa2);
        }
        $('#pesquisaPessoa').modal('hide');
        $('#tabelaPessoa').dataTable().fnDestroy();
    });
    $('body').on('keypress', '#nm_pessoa', function (e) {
        var key = e.which;
        if (key == 13) {
            $("#btn-pesquisa").trigger('click');
            return false;
        }
    });
});
