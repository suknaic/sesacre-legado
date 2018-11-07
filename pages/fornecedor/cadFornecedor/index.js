$(document).ready(function () {

    func = new Funcoes();

    function gerarCloneSelectMedicamentos() {
        $("#medicamentos").append(' <div class="medicamentos row">\n\
                                        <div class="col-sm-5">\n\
                                            <div class="panel-body">\n\
                                                <div class="medicamentosCampos input-group">\n\
                                                    <span class="input-group-addon">\n\
                                                         <p class="fa fa-list inputPFa"></p>\n\
                                                    </span>\n\
                                                    <select class="form-control selectMedicamentos" name="medicamentos[]" required id="medicamentos">\n\
                                                        <option value="0" selected="">Selecione um tipo de Medicamento</option>\n\
                                                    </select>\n\
                                                </div>\n\
                                            </div>\n\
                                        </div>\n\
                                        <div class="col-md-3">\n\
                                            <div class="panel-body">\n\
                                                <button class="fa fa-remove btn btn-danger btn-removerMedicamento remover"></button>\n\
                                            </div>\n\
                                        <div>\n\
                                    </div>');

    }

    $("body").on("click", ".addMedicamentos", function (e) {
        e.preventDefault();
        gerarCloneSelectMedicamentos();
        $(".selectMedicamentos").select2({
            width: " 100%"
        });
    });

    $("body").on('click', '.btn-removerMedicamento', function (e) {
        e.preventDefault();
        var $this = $(this);
        $this.closest(".medicamentos").remove();
    });

    function gerarCloneSelectServico() {
        $("#servico").append(' <div class="servico row">\n\
                                        <div class="col-sm-5">\n\
                                            <div class="panel-body">\n\
                                                <div class="servicoCampos input-group">\n\
                                                    <span class="input-group-addon">\n\
                                                         <p class="fa fa-list inputPFa"></p>\n\
                                                    </span>\n\
                                                    <select class="form-control selectServico" name="servicos[]" required id="servico">\n\
                                                        <option value="0" selected="">Selecione um tipo de Serviço</option>\n\
                                                    </select>\n\
                                                </div>\n\
                                            </div>\n\
                                        </div>\n\
                                        <div class="col-md-3">\n\
                                            <div class="panel-body">\n\
                                                <button class="fa fa-remove btn btn-danger btn-removerServico remover"></button>\n\
                                            </div>\n\
                                        <div>\n\
                                    </div>');

    }

    $("body").on("click", ".addServico", function (e) {
        e.preventDefault();
        gerarCloneSelectServico();
        $(".selectServico").select2({
            width: " 100%"
        });
    });

    $("body").on('click', '.btn-removerServico', function (e) {
        e.preventDefault();
        var $this = $(this);
        $this.closest(".servico").remove();
    });

    function gerarCloneSelectConsumo() {
        $("#consumo").append(' <div class="consumo row">\n\
                                        <div class="col-sm-5">\n\
                                            <div class="panel-body">\n\
                                                <div class="consumoCampos input-group">\n\
                                                    <span class="input-group-addon">\n\
                                                         <p class="fa fa-list inputPFa"></p>\n\
                                                    </span>\n\
                                                    <select class="form-control selectConsumo" name="consumo[]" required id="consumo">\n\
                                                        <option value="0" selected="">Selecione um tipo de Material de Consumo</option>\n\
                                                    </select>\n\
                                                </div>\n\
                                            </div>\n\
                                        </div>\n\
                                        <div class="col-md-3">\n\
                                            <div class="panel-body">\n\
                                                <button class="fa fa-remove btn btn-danger btn-removerConsumo remover"></button>\n\
                                            </div>\n\
                                        <div>\n\
                                    </div>');
    }

    $("body").on("click", ".addConsumo", function (e) {
        e.preventDefault();
        gerarCloneSelectConsumo();
        $(".selectConsumo").select2({
            width: " 100%"
        });
    });

    $("body").on('click', '.btn-removerConsumo', function (e) {
        e.preventDefault();
        var $this = $(this);
        $this.closest(".consumo").remove();
    });

    function gerarCloneSelectPermanente() {
        $("#permanente").append(' <div class="permanente row">\n\
                                        <div class="col-sm-5">\n\
                                            <div class="panel-body">\n\
                                                <div class="permanenteCampos input-group">\n\
                                                    <span class="input-group-addon">\n\
                                                         <p class="fa fa-list inputPFa"></p>\n\
                                                    </span>\n\
                                                    <select class="form-control selectPermanente" name="permanente[]" required id="permanente">\n\
                                                        <option value="0" selected="">Selecione um tipo de Material Permanente</option>\n\
                                                    </select>\n\
                                                </div>\n\
                                            </div>\n\
                                        </div>\n\
                                        <div class="col-md-3">\n\
                                            <div class="panel-body">\n\
                                                <button class="fa fa-remove btn btn-danger btn-removerPermanente remover"></button>\n\
                                            </div>\n\
                                        <div>\n\
                                    </div>');
    }

    $("body").on("click", ".addPermanente", function (e) {
        e.preventDefault();
        gerarCloneSelectPermanente();
        $(".selectPermanente").select2({
            width: " 100%"
        });
    });

    $("body").on('click', '.btn-removerPermanente', function (e) {
        e.preventDefault();
        var $this = $(this);
        $this.closest(".permanente").remove();
    });

//******************************************************************************************
    $('body').find("select").select2({});
    $('body').find("selectTipoPessoa").select2({});
    $(".nr").mask("99");
    $("#nr_cpf").mask("999.999.999-99");
    $("#nr_cnpj").mask("99.999.999/9999-99");
    $("#nr_cep").mask("99999-999");
    $("#nr_telefone_residencial").mask("(99) 9999-9999");
    $("#nr_telefone_empresa").mask("(99) 9 9999-9999");
    $("#nr_telefone_celular").mask("(99) 9 9999-9999");
//******************************************************************************************
    $('body').on('click', '.btn-salvar', function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else {
            e.preventDefault();
            var $this = $(this);

            if ($('#id_tipo_fornecedor').val() == 1) {
                var PessoaFisica = {
                    sexo: $('#tp_sexo').val(),
                    cpf: $('#nr_cpf').val(),
                    tl_celular: $("#nr_telefone_celular").val(),
                    nmPessoaFisica: $('#nm_pessoa').val()
                };
            }

            if ($('#id_tipo_fornecedor').val() == 2) {
                var PessoaJuridica = {
                    nmRazaoSoc: $('#rz_social').val(),
                    nmFantasia: $('#nm_fantasia').val(),
                    cnpj: $("#nr_cnpj").val().replace(/(\.|\/|\-)/g, ""),
                    nrEstudal: $('#nr_estadual').val(),
                    nrMunicipal: $('#nr_municipal').val(),
                    tl_empresa: $("#nr_telefone_empresa").val(),
                    natureza: $("#id_natureza").val()
                };
            }

            var cep = func.extrairCarater($("#nr_cep").val(), "-");
            var Pessoa = {
                cidade: $("#id_cidade").val(),
                logradouro: $("#ds_logradouro").val(),
                bairro: $("#ds_bairro").val(),
                cep: cep,
                email: $("#nm_email").val(),
                tl_residencial: $("#nr_telefone_residencial").val()
            };

            var medicamento = [];
            $("select[name=medicamento\\[\\]]").each(function () {
                if ($(this).val() != '' && $(this).val() != 0) {
                    medicamento.push($(this).val());
                }
            });

            var servico = [];
            $("select[name=servico\\[\\]]").each(function () {
                if ($(this).val() != '' && $(this).val() != 0) {
                    servico.push($(this).val());
                }
            });

            var materialConsumo = [];
            $("select[name=materialConsumo\\[\\]]").each(function () {
                if ($(this).val() != '' && $(this).val() != 0) {
                    materialConsumo.push($(this).val());
                }
            });

            var materialPermanente = [];
            $("select[name=materialPermanente\\[\\]]").each(function () {
                if ($(this).val() != '' && $(this).val() != 0) {
                    materialPermanente.push($(this).val());
                }
            });

            var MaterialServico = {
                medicamento: medicamento,
                servico: servico,
                materialConsumo: materialConsumo,
                materialPermanente: materialPermanente
            };

            if ($("#id_tipo_fornecedor").val() == 1) {
                if ((PessoaFisica.sexo == '' || PessoaFisica.sexo == 0) || PessoaFisica.cpf == '' || PessoaFisica.tl_celular == ''){
                    func.modalAlert(func.msgPreencherCampos);
                    return false;
                }
            }

            if ($("#id_tipo_fornecedor").val() == 2) {
                if ((PessoaJuridica.natureza == '0' || PessoaJuridica.natureza == '') || PessoaJuridica.nmRazaoSoc == '' || PessoaJuridica.nmFantasia == '' || PessoaJuridica.cnpj == '' || PessoaJuridica.tl_empresa == ''){
                    func.modalAlert(func.msgPreencherCampos);
                    return false;
                }
            }

            if (Pessoa.cep == '' || (Pessoa.cidade == '' || Pessoa.cidade == 0) || (Pessoa.estado == '' || Pessoa.estado == 0) || (Pessoa.pais == '' || Pessoa.pais == 0) || Pessoa.bairro == '' || Pessoa.empDist == '' || Pessoa.empExc == '' || Pessoa.logradouro == ''){
                func.modalAlert(func.msgPreencherCampos);
                return false;
            }

            var Fornecedor = {
                pessoaFisica: PessoaFisica,
                pessoaJuridica: PessoaJuridica,
                pessoa: Pessoa,
                materialServico: MaterialServico,
                empExc: $("input[name='emp_exc']:checked").val(),
                empDist: $("input[name='emp_dist']:checked").val()
            };

            $.ajax({
                "url": "request.php",
                "dataType": "html",
                "method": "POST",
                "data": {
                    "acao": "cadastrarFornecedor",
                    "dadosFornecedor": Fornecedor,
                },
                "success": function (response) {
                    console.log(response);
                    // return false;
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
                        func.fechaModalHref('/pages/sistema/login/index.php');
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

    function listaNatureza() {
        $.ajax({
            "url": "request.php",
            "dataType": 'html',
            "data": {
                acao: "retornaNatureza"
            },
            "success": function (response) {
                $("#id_natureza").append(response);
            }
        });
    }
    listaNatureza();

    function listaMedicamento() {
        $.ajax({
            "url": "request.php",
            "dataType": 'html',
            "data": {
                acao: "retornaMedicamento"
            },
            "success": function (response) {
                $("#id_medicamentos").append(response);
            }
        });
    }
    listaMedicamento();

    function listaServico() {
        $.ajax({
            "url": "request.php",
            "dataType": 'html',
            "data": {
                acao: "retornaServico"
            },
            "success": function (response) {
                $("#id_servicos").append(response);
            }
        });
    }
    listaServico();

    function listaMaterialConsumo() {
        $.ajax({
            "url": "request.php",
            "dataType": 'html',
            "data": {
                acao: "retornaMaterialConsumo"
            },
            "success": function (response) {
                $("#id_material_consumo").append(response);
            }
        });
    }
    listaMaterialConsumo();

    function listaMaterialPermanente() {
        $.ajax({
            "url": "request.php",
            "dataType": 'html',
            "data": {
                acao: "retornaMaterialPermanente"
            },
            "success": function (response) {
                $("#id_material_permanente").append(response);
            }
        });
    }
    listaMaterialPermanente();

    //************************* Enderedeço *********************
    function listaPais() {
        $.ajax({
            "url": "request.php",
            "dataType": 'html',
            "data": {
                acao: "retornaPais"
            },
            "success": function (response) {
                $("#id_pais").html(response);
            }
        });
    }
    listaPais();

    function listaEstado(pais = 0, estado = 0) {
        $.ajax({
            "url": "request.php",
            "dataType": 'html',
            "data": {
                acao: "retornaEstado",
                pais: pais,
                estado: estado
            },
            "success": function (response) {
                $("#id_estado").html(response);
            }
        });
    }
    listaEstado();

    function listaCidade(estado = 0, cidade) {
        $.ajax({
            "url": "request.php",
            "dataType": 'html',
            "data": {
                acao: "retornaCidade",
                estado: estado,
                cidade: cidade
            },
            "success": function (response) {
                $("#id_cidade").html(response);
            }
        });
    }
    listaCidade();
    //***********************************************************
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
                $("#id_pais").val(0).trigger('change.select2');
                // return false;
                //Consulta o webservice viacep.com.br/
                $.getJSON("https://viacep.com.br/ws/" + cep + "/json/?callback=?", function (dados) {
                    if (!("erro" in dados)) {
                        // console.log(dados);
                        //Atualiza os campos com os valores da consulta.
                        $("#ds_logradouro").val(dados.logradouro);
                        $("#ds_bairro").val(dados.bairro);
                        $("#ds_logradouro").focus();
                        var uf = dados.uf;
                        var cidade = dados.localidade;
                        $.ajax({
                            "url": "request.php",
                            "dataType": "html",
                            "method": "POST",
                            "data": {
                                "acao": "retornaCidadeUf",
                                "uf": uf
                            },
                            "success": function (response) {
                                try {
                                    response = JSON.parse(response);
                                    $('#id_pais').val(response[0].id_pais).trigger('change.select2');
                                    listaEstado(response[0].id_pais, response[0]['id_estado']);
                                    listaCidade(response[0]['id_estado'], cidade);
                                    // console.log(response);
                                    // $('#id_estado').val(response[0].id_estado).trigger('change.select2');
                                    // $('#id_cidade').val($('option:contains("'+cidade+'")').val()).trigger('change.select2');
                                } catch (e) {
                                    console.log(response);
                                    return false;
                                }
                            }
                        });
                    } else {
                        //CEP pesquisado não foi encontrado.
                        func.modalAlert("CEP não encontrado.");
                    }
                });
            } else {
                //cep é inválido.
                func.modalAlert("Formato de CEP inválido.");
            }
        } else {
            //cep sem valor, limpa formulário.
        }
        //*************************************************************************************************
    });

    $('.fisica').hide();
    $('.juridica').hide();
    $('.resto').hide();
    $('body').on("change", "#id_tipo_fornecedor", function(){
        if ($('#id_tipo_fornecedor').val() == 1) {
            $('.juridica').hide();
            $('.fisica').show();
            $('.resto').show();
        } else if ($('#id_tipo_fornecedor').val() == 2) {
            $('.juridica').show();
            $('.fisica').hide();
            $('.resto').show();
        } else {
            $('.juridica').hide();
            $('.fisica').hide();
            $('.resto').hide();
        }
    });


    //******************************************************************************************
    $("body").on("change.select2", "#id_pais", function (e) {
        pais = $("#id_pais").val();
        if (pais == 0) {
            return;
        }
        listaEstado(pais, 0);
    });

    $("body").on("change.select2", "#id_estado", function (e) {
        estado = $("#id_estado").val();
        if (estado == 0) {
            return;
        }
        listaCidade(estado, 0);
    });
    //******************************************************************************************

});
