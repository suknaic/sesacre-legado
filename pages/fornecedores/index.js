
function listaPaisCombo() {
    $.ajax({
        "url": "/model/fornecedores/request.php",
        "dataType": 'html',
        "data": {
            acao: "listaPaisOption"
        },
        "success": function (response) {
            $(".pais").append(response);
            $(".pais").select2({
                width: " 100%"
            });
        }
    });
}
listaPaisCombo();
function listaEstadoNaturalidadeCombo(sw, estado) {
    $.ajax({
        "url": "/model/fornecedores/request.php",
        "dataType": 'html',
        "data": {
            acao: "listaEstadoOption",
            idEstado: estado
        },
        "success": function (response) {
            if (sw == 1) {
                $("#id_estado_naturalidade").empty();
                $("#id_estado_naturalidade").append(response);
                $("#id_estado_naturalidade").select2({
                    width: " 100%"
                });
                $("#id_estado_naturalidade").val(estado);
            }
            if (sw == 2) {
                $("#id_estado_endereco").empty();
                $("#id_estado_endereco").append(response);
                $("#id_estado_endereco").select2({
                    width: " 100%"
                });
                $("#id_estado_endereco").val(estado);
            }

        }
    });
}

//listaEstadoCombo();
function listaCidadeCombo(idEstado, sw, cidade) {
    //alert(cidade);
    $.ajax({
        "url": "/model/fornecedores/request.php",
        "dataType": 'html',
        "data": {
            acao: "listaCidadeOption",
            idEstado: idEstado,
            idCidade: cidade
        },
        "success": function (response) {
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
        "url": "/model/fornecedores/request.php",
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
//******************************************************************************************    
function listaEstadoCombo() {
    $.ajax({
        "url": "/model/fornecedores/request.php",
        "dataType": 'html',
        "data": {
            acao: "listaEstadoOption"
        },
        "success": function (response) {
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
            "url": "/model/fornecedores/request.php",
            "dataType": 'html',
            "data": {
                acao: "listaPessoaJuridicaOption"
            },
            "success": function (response) {
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
    });
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
        listaEstadoNaturalidadeCombo($idPais, 0);
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
        listaEstadoNaturalidadeCombo($idPais, 0);
    });
    //******************************************************************************************
    $("body").on("change.select2", "#id_estado_endereco", function (e) {
        $("#id_cidade").empty();
        $idEstado = $("#id_estado_endereco").val();
        if ($idEstado == 0) {
            return;
        }
        listaCidadeCombo($idEstado, 1, null);
    });

//******************************************************************************************
    $(".nr").mask("99");
    $("#nr_cnpj").mask("99.999.999/9999-99");
    $("#nr_cep").mask("99999-999");
    $("#nr_telefone_residencial").mask("(99) 9 9999-9999 ");
    $("#nr_telefone_celular").mask("(99) 9 9999-9999 ");
//******************************************************************************************
    $('body').on('click', '.btn-salvar', function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else {
            e.preventDefault();
            var $this = $(this);

            var cep = func.extrairCarater($("#nr_cep").val(), "-");
            var DadosPessoa = {
                //****************dados pessoais*********************
                razaosoc: $("#razao_soc").val(),
                pais: $("#id_pais_naturalidade").val(),
                estado: $("#id_estado_naturalidade"),
                cidade: $("#id_naturalidade").val(),
                logradouro: $("#ds_logradouro").val(),
                bairro: $("#ds_bairro").val(),
                cep: $("#nr_cep").val(),
                telefone_residencial: $("#nr_telefone_residencial").val(),
                email: $("#nm_email").val(),
                empDist: $("#emp_dist").val(),
                empExc: $("#emp_exc").val(),

            };
            $cnpj = $("#nr_cnpj").val().replace(/(\.|\/|\-)/g, "");
            var DadosDaEmpresa = {
                cnpj: $cnpj,

            };
//*******************************************************************
            var DadosObrigatorio = {
                //**************6***********************
                "Razão Social": DadosPessoa.razaosoc,
                "CNPJ": DadosDaEmpresa.cnpj,
                "Cidade Endereço": DadosPessoa.cidade,
                "CEP": DadosPessoa.cep,
                "Telefone": DadosPessoa.telefone_residencial,
                "Email": DadosPessoa.email,
            };

            $campo = 0;
            $i = 0;
            $.each(DadosObrigatorio, function (index, value) {
                $i++;
                $campo = "";
                if (value == 0 || value == "" || value == null) {
                    if ($i <= 6) {
                        func.modalAlert(func.msgPreencherCampos + " - <strong>Dados Obrigatórios (" + index + ")</strong>");
                    }
                    $campo = 1;
                    return false;
                }
            });
            if ($campo == 1) {
                return false;
            }
//***********************************************
            $.ajax({
                "url": "/model/fornecedores/request.php",
                "dataType": "html",
                "method": "POST",
                "data": {
                    "acao": "cadastrarContrato",
                    "dadosPessoa": DadosPessoa,
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
        //*************************************************************************************************
//        $('body').on('click', '.cnpj', function (e){
//        var cnpj = $("#nr_cnpj").val().replace();
//        
//        if (cnpj != ""){
//            var validacnpj = ;
//            if (validacnpj.teste (cnpj)) {
//                $ds
//            }
//        }
//        }) 

    });
});
