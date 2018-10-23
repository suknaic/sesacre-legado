function listaNatureza() {
    $.ajax({
        "url": "/model/sistema/pessoa/request.php",
        "dataType": 'html',
        "data": {
            acao: "listaNaturezaOption"
        },
        "success": function (response) {
            //console.log(response);
            $("#id_natureza").append(response);
            $("#id_natureza").select2({
                width: " 100%"
            });
        }
    });
}
listaNatureza();
//*************************************************
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
//********************************************
$(document).ready(function () {
    func = new Funcoes();
    //******************************************************************************************
    $(".pro").click(function () {
        $('.nav > .active').next('li').find('a').trigger('click');

    });
    // função do botão anterior
    $(".ant").click(function () {
        // aba que esta ativa no momento
        $('.nav > .active').prev('li').find('a').trigger('click');
    })

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
    $("body").on("change", "#id_cidade", function (e) {
        $("#ds_logradouro").val("");
        $("#ds_bairro").val("");
        $("#ds_complemento").val("");
        $("#nr_cep").val("");

    });
//******************************************************************************************
    $("#nr_cnpj").mask("99.999.999/9999-99");
    $("#nr_cnae").mask("9999-9/99");
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
            //$this.prop("disabled", true);

            var cep = func.extrairCarater($("#nr_cep").val(), "-");
            var DadosPessoa = {
                //****************dados pessoais*********************
                razaoSocial: $("#nm_pessoa").val(),
                naturalidade: $("id_cidade").val(),
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
            $cnpj = $("#nr_cnpj").val().replace(/(\.|\/|\-)/g, "");
            var DadosPessoaJuridica = {
                nomeFantasia: $("#nm_fantasia").val(),
                idNatureza: $("#id_natureza").val(),
                cnpj: $cnpj,
                cnae: $("#nr_cnae").val(),
                safira: $("#nr_safira").val(),
                inscricaoEstadual: $("#ds_insc_estadual").val(),
                inscricaoMunicipal: $("#ds_insc_municipal").val(),
                dtFundacao: $("#dt_fundacao").val(),

            }
            //******************************************************************
            var DadosObrigatorio = {
                email: DadosPessoa.email,
                //*************************************
                razaoSocial: DadosPessoa.razaoSocial,
                natureza: DadosPessoaJuridica.idNatureza,
                cnpj: DadosPessoaJuridica.cnpj,
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
                    "acao": "cadastrarPessoaJuridica",
                    "dadosPessoa": DadosPessoa,
                    "dadosPessoaJuridica": DadosPessoaJuridica
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
                        func.modalAlert(func.msgErroPadrao, 'danger');
                        return false;
                    }
                    if (response.tipoMsg === "Erro") {
                        if (response.tipoExibicao === "console") {
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
                        func.modalAlert(func.msgErroPadrao, 'danger');
                        return false;
                    }
                },
                "error": function (response) {
                    $this.prop("disabled", false);
                    func.modalAlert(func.msgErroPadrao, 'danger');
                    return false;
                }
            });
            $this.prop("disabled", false);
        }
    });

    $('body').on('click', '.btn-limpar', function (e) {
        $("#nome").val("");
        $("#dt_inicio").val("");
        $("#dt_fim").val("");
    });
    $('.modal-alert').on('shown.bs.modal', function (e) {
        $("#nome").focus();
    });
    $('body').on('keypress', '.formPessoaJuridica', function (e) {
        var key = e.which;
        if (key == 13) {
            $(".btn-salvar").trigger('click');
            return false;
        }
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
