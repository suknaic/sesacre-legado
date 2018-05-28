//******************************************************************************************
function listaPessoaCombo() {
    $.ajax({
        "url": "/model/rh/lotacaoDetalhe/request.php",
        "dataType": 'html',
        "data": {
            acao: "listaPessoaOption"
        },
        "success": function (response) {
            //console.log(response);
            $("#id_pessoa3").append(response);
            $("#id_pessoa3").select2({
                //width: " 100%"
            });
        }
    });
}
//listaPessoaCombo();
//******************************************************************************************
function listaLotacaoCombo() {
    $.ajax({
        "url": "/model/rh/lotacaoDetalhe/request.php",
        "dataType": 'html',
        "data": {
            acao: "listaLotacaoOption",
            id: 0
        },
        "success": function (response) {
            // console.log(response);
            $("#id_pai_lotacao").append(response);
            $("#id_pai_lotacao").select2({
                //width: " 100%"
            });
        }
    });
}
listaLotacaoCombo();
//******************************************************************************************
function listaPjCombo() {
    $.ajax({
        "url": "/model/rh/lotacaoDetalhe/request.php",
        "dataType": 'html',
        "data": {
            acao: "listaPessoaJuridicaOption",
            id: 0
        },
        "success": function (response) {
            //  console.log(response);
            $("#id_pessoa_juridica3").append(response);
            $("#id_pessoa_juridica3").select2({
                //width: " 100%"
            });
        }
    });
}
//listaPjCombo();
//******************************************************************************************
function listaCategoriaCombo() {
    $.ajax({
        "url": "/model/rh/lotacaoDetalhe/request.php",
        "dataType": 'html',
        "data": {
            acao: "listaCategoriaOption"
        },
        "success": function (response) {
            //  console.log(response);
            $("#id_categoria").append(response);
            $("#id_categoria").select2({
                //width: " 100%"
            });
        }
    });
}
listaCategoriaCombo();
//******************************************************************************************
function listaPaisCombo() {
    $.ajax({
        "url": "/model/rh/lotacaoDetalhe/request.php",
        "dataType": 'html',
        "data": {
            acao: "listaPaisOption"
        },
        "success": function (response) {
            //console.log(response);
            $(".pais").append(response);
            $(".pais").select2({
                //width: " 100%"
            });
        }
    });
}
listaPaisCombo();
function listaEstadoCombo(idPais, idEstado) {
    $.ajax({
        "url": "/model/rh/lotacaoDetalhe/request.php",
        "dataType": 'html',
        "data": {
            acao: "listaEstadoOption",
            idPais: idPais,
            idEstado: idEstado
        },
        "success": function (response) {
            //console.log(response);
            $("#id_estado_endereco").empty();
            $("#id_estado_endereco").append(response);
            $("#id_estado_endereco").select2({
                //width: " 100%"
            });
            $("#id_estado_endereco").val(idEstado);
        }
    });
}
function listaCidadeCombo(idEstado) {
    $.ajax({
        "url": "/model/rh/lotacaoDetalhe/request.php",
        "dataType": 'html',
        "data": {
            acao: "listaCidadeOption",
            idEstado: idEstado
        },
        "success": function (response) {
            //console.log(response);
            $("#id_cidade").append(response);
            $("#id_cidade").select2({
                //width: " 100%"
            });

        }
    });
}
//**********************uf para cep**********************************************************
function listaCidadeComboUf(idEstado, uf) {
    //alert(cidade);
    $.ajax({
        "url": "/model/rh/lotacaoDetalhe/request.php",
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
//*********************************************************************************************

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
    $("body").on("change.select2", "#id_pais_endereco", function (e) {
        $("#id_estado_endereco").empty();
        $("#id_cidade").empty();
        $idPais = $("#id_pais_endereco").val();
        if ($idPais == 0) {
            return;
        }
        listaEstadoCombo($idPais, 2);
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
    $("#nr_cnpj").mask("99.999.999/9999-99");
    $("#nr_cep").mask("99999-999");
    $("#nr_telefone").mask("(99) 9999-9999");

//******************************************************************************************
    $("body").on("click", ".btn-add", function (e) {

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
                    func.modalAlert(" O Item já Existe!!!")
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
            st = "<i class='fa fa-check-circle fa-2x text-primary'></i>";
            value = 1;
        }
        var linha = "";
        linha = "<tr class='warning telefoneLinha'>\n\
                    <td class='text-center telefone'>" + nro + "</td>\n\
                    <td class='text-center principal' st_principal = '" + value + "'>" + st + "</td>\n\
                    <td class='text-center'><button type='button' title='Remover' class='excluirLinha' value=''><i class='fa fa-remove text-danger'></i></button></td>\n\
                 </tr>";
        $(linha).appendTo('.corpoTabela')

        $("#nr_telefone").val("");
        $(".st_principal").prop("checked", false);
    });
//******************************************************************************************
    $("body").on("click", ".excluirLinha", function (e) {
        $(this).closest(".telefoneLinha").remove();
    });

//******************************************************************************************
    $('body').on('click', '.btn-salvar', function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else {
            e.preventDefault();
            var $this = $(this);
            //$this.prop("disabled", true);
            var cep = func.extrairCarater($("#nr_cep").val(), "-");

            var DadosLotacao = {
                //****************dados *********************
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
            //**************************telefones************************************
            if ($(this).closest(".formRhLotacao").find(".telefoneLinha").length > 0) {

                var DadosTelefone = [];
                $("#tabela tbody tr").each(function () {
                    //var coluna =  $(this).children();
                    DadosTelefone.push({
                        telefone: $(this).find(".telefone").text(),
                        principal: $(this).find(".principal").attr("st_principal")
                    })
                });
            }
            //*******************telefones se tem algum registro********************************
            var x = 0;
            if ($(this).closest(".formRhLotacao").find(".telefoneLinha").length > 0) {
                x = 1;
            }
            //******************************************************************
            var DadosObrigatorio = {
                categoria: DadosLotacao.idCategoria,
                nomeLotacao: DadosLotacao.nomeLotacao,
                empresaResponsavel: DadosLotacao.pessoaJuridica,
                pessoaResponsavel: DadosLotacao.pessoa,
                lotacaoPai: DadosLotacao.idPaiLotacao,
                //********************************************
                cidadeEndereco: DadosLotacao.cidade,
                logradouro: DadosLotacao.logradouro,
                bairro: DadosLotacao.bairro,
            };
//            console.log(DadosObrigatorio);
            $campo = 0;
            $i = 0;
            $.each(DadosObrigatorio, function (index, value) {
                $i++;
                $campo = "";
                if (value == 0 || value == "" || value == null) {
                    //console.log($i+"-"+index+"=>"+value);
                    if ($i <= 5) {
                        func.modalAlert(func.msgPreencherCampos + " - Dados(" + index + ")");
                    } else if ($i >= 6 && $i <= 8) {
                        func.modalAlert(func.msgPreencherCampos + "  - Endereço / Contato(" + index + ")");
                    }
                    console.log($i + "-" + index + "=>" + value);
                    $campo = 1;
                    return false;
                }
            });
            if ($campo == 1) {
                return false;
            }

            //*******************************************************************
            if (x == 0) {
                func.modalAlert(" Informe pelo menos um número de Telefone da Lotação");
                return false;
            }
            //***********************************************
            $.ajax({
                "url": "/model/rh/lotacaoDetalhe/request.php",
                "dataType": "html",
                "data": {
                    "acao": "cadastrarLotacaoDetalhe",
                    "dadosLotacaoDetalhe": DadosLotacao,
                    "dadosTelefone": DadosTelefone

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
                        console.log("Parse JSON");
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
                        func.fechaModalReload();
                        return false;
                    } else {
                        console.log('Ultimo else');
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
    //**************************************************************************
    $('body').on('click', '.pesquisaPessoaJuridica', function (e) {
        $('#tipo').val(2);
        $('#nm_pessoa').val("");
        func.carregaTabelaPadrao('tabelaPessoa', null, [2], true);
        $('#nm_pessoa').focus();
    });
    $('body').on('click', '.pesquisaPessoaFisica', function (e) {
        $('#tipo').val(1);
        $('#nm_pessoa').val("");
        func.carregaTabelaPadrao('tabelaPessoa', null, [2], true);
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
        }
        $.ajax({
            "url": "/model/rh/lotacaoDetalhe/request.php",
            "dataType": 'html',
            "method": "POST",
            "data": {
                acao: "listaPessoaTable",
                pessoa: Pessoa,
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
        $idPessoa2 =  $this.attr("idPessoa2");
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
            $(".btn-pesquisa").trigger('click');
            return false;
        }
    });
    //**************************************************************************
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
