$(document).ready(function () {

    //************ Select2 *********
    $(".select").select2({});
    //******************************

    func = new Funcoes();

    //******************************************************************************************
    function listaLotacaoCombo() {
        $.ajax({
            "url": "/model/rh/lotacao/request.php",
            "dataType": 'html',
            "data": {
                acao: "listaLotacaoOption",
                id: 0
            },
            "success": function (response) {
                $("#id_pai_lotacao").append(response);
            }
        });
    }
    listaLotacaoCombo();

    //******************************************************************************************
    function listaPjCombo() {
        $.ajax({
            "url": "/model/rh/lotacao/request.php",
            "dataType": 'html',
            "data": {
                acao: "listaPessoaJuridicaOption",
                id: 0
            },
            "success": function (response) {
                $("#id_pessoa_juridica3").append(response);
            }
        });
    }

    //******************************************************************************************
    function listaCategoriaCombo() {
        $.ajax({
            "url": "/model/rh/lotacao/request.php",
            "dataType": 'html',
            "data": {
                acao: "listaCategoriaOption"
            },
            "success": function (response) {
                $("#id_categoria").append(response);
            }
        });
    }

    listaCategoriaCombo();

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

    //*********************************************************************************************
    $("body").on("change.select2", "#id_categoria", function (e) {
        if ($('#id_categoria').val() == 5) {
            $('#obgPai').hide();
        } else {
            $('#obgPai').show();
        }
    });

    //******************************************************************************************
    $("body").on("change.select2", "#id_pais_endereco", function (e) {
        $("#id_estado_endereco").empty();
        $idPais = $("#id_pais_endereco").val();
        if ($idPais == 0) {
            return;
        }
        $("#id_cidade").val('0');
        listaEstadoEndereco($idPais);
    });
    //******************************************************************************************
    $("body").on("change.select2", "#id_estado_endereco", function (e) {
        $("#id_cidade").empty();
        $idEstado = $("#id_estado_endereco").val();
        if ($idEstado == 0) {
            return;
        }
        $("#id_cidade").val('0');
        listaCidadeEndereco($idEstado);
    });
    //******************************************************************************************

    //*************** Mascaras *************
    $("#nr_cnpj").mask("99.999.999/9999-99");
    $("#nr_cep").mask("99999-999");
    $("#nr_telefone").mask("(99) 9999-9999");
    //***************************************

    //******************************************* Add *************************************************
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
            st = "<i class='fa fa-check-circle fa-2x text-primary'></i>";
            value = 1;
        }
        var linha = "";
        linha = "<tr class='warning telefoneLinha'>\n\
                    <td class='text-center telefone'>" + nro + "</td>\n\
                    <td class='text-center principal' st_principal = '" + value + "'>" + st + "</td>\n\
                    <td class='text-center'><button type='button' title='Remover' class='excluirLinha' value=''><i class='fa fa-remove text-danger'></i></button></td>\n\
                 </tr>";
        $(linha).appendTo('.corpoTabela');

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
                    DadosTelefone.push({
                        telefone: $(this).find(".telefone").text(),
                        principal: $(this).find(".principal").attr("st_principal")
                    });
                });
            }
            //*******************telefones se tem algum registro********************************
            var x = 0;
            if ($(this).closest(".formRhLotacao").find(".telefoneLinha").length > 0) {
                x = 1;
            }
            //******************************************************************
            if (DadosLotacao.idCategoria != 5) {
                var DadosObrigatorio = {
                    "Categoria": DadosLotacao.idCategoria,
                    "Nome da Lotação": DadosLotacao.nomeLotacao,
                    // "Pessoa Responsável": DadosLotacao.pessoa,
                    "Lotação Pai": DadosLotacao.idPaiLotacao,
                    //********************************************
                    "Logradouro": DadosLotacao.logradouro,
                    "Bairro": DadosLotacao.bairro,
                    "País": $('#id_pais_endereco').val(),
                    "Estado": $("#id_estado_endereco").val(),
                    "Cidade": DadosLotacao.cidade
                };
            } else {
                var DadosObrigatorio = {
                    "Categoria": DadosLotacao.idCategoria,
                    "Nome da Lotação": DadosLotacao.nomeLotacao,
                    // "Pessoa Responsável": DadosLotacao.pessoa,
                    //********************************************
                    "Logradouro": DadosLotacao.logradouro,
                    "Bairro": DadosLotacao.bairro,
                    "País": $('#id_pais_endereco').val(),
                    "Estado": $("#id_estado_endereco").val(),
                    "Cidade": DadosLotacao.cidade
                };
            }

            $campo = 0;
            $i = 0;
            $.each(DadosObrigatorio, function (index, value) {
                $i++;
                $campo = "";
                if (value == 0 || value == "" || value == null) {
                    func.modalAlert(func.msgPreencherCampos + " (<strong>" + index + "</strong>)");
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
                "url": "/model/rh/lotacao/request.php",
                "dataType": "html",
                "data": {
                    "acao": "cadastrarLotacao",
                    "dadosLotacao": DadosLotacao,
                    "dadosTelefone": DadosTelefone

                },

                "success": function (response) {
                    if (response.trim() == "SessaoExpirada") {
                        func.modalAlert(func.msgSemPermissao);
                        return false;
                    }
                    try {
                        response = JSON.parse(response);
                    } catch (e) {
                        console.log(response);
                        func.modalAlert(func.msgErroPadrao, 'danger');
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
                        func.fechaModalHref('/pages/rh/lotacao/');
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
    //**************************************************************************
    $('body').on('click', '.pesquisaPessoaJuridica', function (e) {
        $('#tipo').val(2);
        $('#modalTitulo').html('Pesquisa de Empresa');
        $("#nm_pessoa").attr("placeholder", "Nome da Empresa").val("").focus().blur();
        $('#nm_pessoa').val("");
        func.carregaTabelaPadrao('tabelaPessoa', null, [2], true);
        $('#nm_pessoa').focus();
    });
    $('body').on('click', '.pesquisaPessoaFisica', function (e) {
        $('#tipo').val(1);
        $('#modalTitulo').html('Pesquisa de Pessoa');
        $("#nm_pessoa").attr("placeholder", "Nome da Pessoa").val("").focus().blur();
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
