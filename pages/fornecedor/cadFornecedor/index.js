$(document).ready(function () {

    func = new Funcoes();

//******************************************************************************************
    $("body").find("select").select2({width: " 100%"});
    $('body').find("id_tipo_fornecedor").select2({});
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
                    cnpj: $("#nr_cnpj").val(),
                    nrEstudal: $('#nr_estadual').val(),
                    nrMunicipal: $('#nr_municipal').val(),
                    tl_empresa: $("#nr_telefone_empresa").val(),
                    natureza: $("#id_natureza").val()
                };
            }

            if ($('#id_tipo_fornecedor').val() == 0 || $('#id_tipo_fornecedor').val() == '') {
                func.modalAlert(func.msgPreencherCampos + " <strong>Tipo de Pessoa - Tipo de Pessoa</strong>");
                return false;
            }

            var cep = func.extrairCarater($("#nr_cep").val(), "-");
            var Pessoa = {
                cidade: $("#id_cidade").val(),
                logradouro: $("#ds_logradouro").val(),
                bairro: $("#ds_bairro").val(),
                numero: $("#nr_numero").val(),
                complemento: $("#ds_complemento").val(),
                cep: cep,
                email: $("#nm_email").val(),
                tl_residencial: $("#nr_telefone_residencial").val()
            };

            var medicamento = $('#id_medicamentos').val();
            var servico = $('#id_servicos').val();
            var materialConsumo = $('#id_material_consumo').val();
            var materialPermanente = $('#id_material_permanente').val();

            var MaterialServico = {
                medicamento: medicamento,
                servico: servico,
                materialConsumo: materialConsumo,
                materialPermanente: materialPermanente
            };

            var empDist = null;
            if ($('#empDistS').is(":checked")) {
                empDist = '1';
            } else {
                empDist = "0";
            }

            var empExc = null;
            if ($('#empExcS').is(":checked")) {
                empExc = '1';
            } else {
                empExc = "0";
            }

            //*********************************************** Pessoa Física ********************************************
            if ($("#id_tipo_fornecedor").val() == 1) {
                if (PessoaFisica.nmPessoaFisica == ''){
                    func.modalAlert(func.msgPreencherCampos + "<strong> Dados Cadastrais - Nome da Pessoa</strong>");
                    return false;
                }

                if (PessoaFisica.cpf == ''){
                    func.modalAlert(func.msgPreencherCampos + "<strong> Dados Cadastrais - CPF</strong>");
                    return false;
                }

                if ((PessoaFisica.sexo == '' || PessoaFisica.sexo == 0)) {
                    func.modalAlert(func.msgPreencherCampos + "<strong> Dados Cadastrais - Sexo</strong>");
                    return false;
                }
            }
            //**********************************************************************************************************

            //************************************************ Pessoa Jurídica *****************************************
            if ($("#id_tipo_fornecedor").val() == 2) {
                if (PessoaJuridica.nmRazaoSoc == '') {
                    func.modalAlert(func.msgPreencherCampos + "<strong> Dados Cadastrais - Razão Social</strong>");
                    return false;
                }
                if (PessoaJuridica.nmFantasia == '') {
                    func.modalAlert(func.msgPreencherCampos + "<strong> Dados Cadastrais - Nome Fantasia</strong>");
                    return false;
                }
                if (PessoaJuridica.cnpj == '') {
                    func.modalAlert(func.msgPreencherCampos + "<strong> Dados Cadastrais - CNPJ</strong>");
                    return false;
                }
            }
            //**********************************************************************************************************

            //********************************************** Endereço **************************************************
            if (($('#id_pais').val() == '' || $('#id_pais').val() == 0)) {
                func.modalAlert(func.msgPreencherCampos + "<strong> Endereço - País</strong>");
                return false;
            }

            if (($('#id_estado').val() == '' || $('#id_estado').val() == 0)) {
                func.modalAlert(func.msgPreencherCampos + " - <strong> Endereço - Estado</strong>");
                return false;
            }

            if ((Pessoa.cidade == '' || Pessoa.cidade == 0)) {
                func.modalAlert(func.msgPreencherCampos + "<strong> Endereço - Cidade</strong>");
                return false;
            }

            if (Pessoa.logradouro == '') {
                func.modalAlert(func.msgPreencherCampos + "<strong> Endereço - Logradouro</strong>");
                return false;
            }

            if (Pessoa.bairro == '') {
                func.modalAlert(func.msgPreencherCampos + "<strong> Endereço - Bairro</strong>");
                return false;
            }

            if (Pessoa.numero == '') {
                func.modalAlert(func.msgPreencherCampos + "<strong> Endereço - Número</strong>");
                return false;
            }
            //**********************************************************************************************************

            //********************************************** Contatos **************************************************
            if ($("#id_tipo_fornecedor").val() == 1) {
                if (PessoaFisica.tl_celular == ''){
                    func.modalAlert(func.msgPreencherCampos + "<strong> Contato - Telefone Celular</strong>");
                    return false;
                }
            }

            if ($("#id_tipo_fornecedor").val() == 2) {
                if (PessoaJuridica.tl_empresa == ''){
                    func.modalAlert(func.msgPreencherCampos + "<strong> Contato - Telefone da Empresa</strong>");
                    return false;
                }
            }

            if (Pessoa.email == '') {
                func.modalAlert(func.msgPreencherCampos + "<strong> Contato - E-mail</strong>");
                return false;
            }
            //**********************************************************************************************************

            //***************************************** Informações da Empresa *****************************************
            if ($('#empDistS').is(":checked") == false && $('#empDistN').is(":checked") == false){
                func.modalAlert(func.msgPreencherCampos + "<strong> Informações da Empresa - A Empresa é Distribuidora?</strong>");
                return false;
            }

            if ($('#empExcS').is(":checked") == false && $('#empExcN').is(":checked") == false){
                func.modalAlert(func.msgPreencherCampos + "<strong> Informações da Empresa - A Empresa possui Exclusividade?</strong>");
                return false;
            }

            if (empDist == '1') {
                var nmEmpresa = $('#ds_emp_dist').val();
                if (nmEmpresa == '') {
                    func.modalAlert(func.msgPreencherCampos + "<strong> Informações da Empresa - Nome da Empresa Distribuidora</strong>");
                    return false;
                } else {
                    var empresas = [];
                    $("input[name=ds_emp_dist\\[\\]]").each(function () {
                        if ($(this).val() != '' && $(this).val() != 0) {
                            empresas.push($(this).val());
                        }
                    });
                }
            }

            if ($("#id_tipo_fornecedor").val() == 2) {
                if ((PessoaJuridica.natureza == '0' || PessoaJuridica.natureza == '')){
                    func.modalAlert(func.msgPreencherCampos + "<strong> Informações da Empresa - Natureza</strong>");
                    return false;
                }
            }
            // **********************************************************************************************************

            // *********************************************** Objeto Social ********************************************
            if (MaterialServico.medicamento == null && MaterialServico.servico == null && MaterialServico.materialConsumo == null && MaterialServico.materialPermanente == null) {
                func.modalAlert(func.msgPreencherCampos + "<strong> Objeto Social </strong>");
                return false;
            }
            // **********************************************************************************************************

            var Fornecedor = {
                pessoaFisica: PessoaFisica,
                pessoaJuridica: PessoaJuridica,
                pessoa: Pessoa,
                materialServico: MaterialServico,
                empExc: empExc,
                empDist: empDist,
                nmEmpresa: empresas
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
                    if (response.trim() == "SessaoExpirada") {
                        func.modalAlert(func.msgSemPermissao);
                        return false;
                    }
                    try {
                        response = JSON.parse(response);
                    } catch (e) {
                        func.modalAlert(func.msgErroPadrao, 'danger');
                        // console.log(response);
                        return false;
                    }
                    if (response.tipoMsg === "Erro") {
                        if (response.tipoExibicao === "console") {
                            // console.log(response);
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
                        // console.log(response);
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

    $('.modal-alert').on('shown.bs.modal', function (e) {
        $("#nome").focus();
    });

    $('body').on('keypress', '.formFornecedores', function (e) {
        var key = e.which;
        if (key == 13) {
            $(".btn-salvar").trigger('click');
            return false;
        }
    });

    $('body').on('click', '.remove', function (e) {
        e.preventDefault();
        var $this = $(this);
        $this.closest(".form-group").remove();
    });

    $('body').on('click', '#remover', function (e) {
        e.preventDefault();
        $('#ds_emp_dist').val('');
        $('#remover').hide();
        $('#adicionar').show();
    });

    $('body').on('click', '#adicionar', function (e) {
        e.preventDefault();
        $('#adicionar').hide();
        $('#remover').show();
        adicionarEmpresa();
        if ($("[name=campo]").is( ":visible" ) == true) {
            $('.adicionar').hide();
        }
    });

    function adicionarEmpresa() {
        var html = "<input type=\"text\" class=\"form-control\" name=\"ds_emp_dist[]\" id=\"ds_emp_dist\" campo=\"novo\" required=\"true\" placeholder=\"Nome da Empresa\">";
        $(".empresas").append('<div class = "form-group">' +
            '                       <div class="col-sm-2" ></div>' +
            '                       <div class="col-sm-4">' +
            '                           <div class="panel-body" style=\"margin-left: -10px;\">Nome da empresa que presta serviço: <span class="text-danger">*</span>' +
            '                               <div class="input-group">' +
            '                                   <span class="input-group-addon">' +
            '                                       <p class="fa fa-file-text-o inputPFa"></p>' +
            '                                   </span>' + html + '' +
            '                               </div>' +
            '                           </div>'+
            '                       </div>'+
            '                       <div class="col-sm-2">' +
            '                           <div class="panel-body" >' +
            '                               <button class="adicionar btn btn-primary" style=\"margin: 17px; margin-left: -20px;\"><i class="fa fa-plus"></i></button>' +
            '                               <button class="remove btn btn-danger" style=\"margin: 17px; margin-left: -18px\"><i class="fa fa-remove"></i></button>' +
            '                           </div>' +
            '                       </div>' +
            '                   </div>');
    }

    $('body').on('click', '.adicionar', function (e) {
        e.preventDefault();
        $(this).hide();
        adicionarEmpresa();
        if ($("[name=campo]").is( ":visible" ) == true) {
            $('.adicionar').hide();
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
                                    listaEstado(response[0].id_pais, response[0].id_estado);
                                    listaCidade(response[0].id_estado, cidade);
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
            $('.formFornecedores input').val("");
            $('input[type=checkbox]').attr('checked', false);
            $('.select').val(0).trigger('change.select2');
        } else if ($('#id_tipo_fornecedor').val() == 2) {
            $('.juridica').show();
            $('.fisica').hide();
            $('.resto').show();
            $('.formFornecedores input').val("");
            $('input[type=checkbox]').attr('checked', false);
            $('.select').val(0).trigger('change.select2');
        } else {
            $('.juridica').hide();
            $('.fisica').hide();
            $('.resto').hide();
            $('.formFornecedores input').val("");
            $('input[type=checkbox]').attr('checked', false);
            $('.select').val(0).trigger('change.select2');
        }
    });

    $('.empDist').hide();
    $('body').on("change", "#empDistS", function(){
        if ($('#empDistS').is(":checked")) {
            $('#empDistN').prop('disabled', true);
            $('.empDist').show();
        } else {
            $('#empDistN').prop('disabled', false);
            $('.empDist').hide();
        }
    });

    $('body').on("change", "#empDistN", function(){
        if ($('#empDistN').is(":checked")) {
            $('#empDistS').prop('disabled', true);
        } else {
            $('#empDistS').prop('disabled', false);
        }
    });

    $('body').on("change", "#empExcS", function(){
        if ($('#empExcS').is(":checked")) {
            $('#empExcN').prop('disabled', true);
        } else {
            $('#empExcN').prop('disabled', false);
        }
    });

    $('body').on("change", "#empExcN", function(){
        if ($('#empExcN').is(":checked")) {
            $('#empExcS').prop('disabled', true);
        } else {
            $('#empExcS').prop('disabled', false);
        }
    });

    $("#id_estado").attr('disabled', true);
    $("#id_cidade").attr('disabled', true);

    $("body").on("change", "#id_pais", function () {
        var texto = $(this).val();
        if (texto == 0) {
            $('#id_estado').val(0).trigger('change.select2');
            $("#id_cidade").val(0).trigger('change.select2');
            $('#id_estado').prop('disabled', true);
            $("#id_cidade").prop('disabled', true);
        }
    });

    $("body").on("change", "#id_pais", function () {
        var texto = $(this).val();
        if (texto != 0) {
            $('#id_estado').prop('disabled', false);
        } else {
            $('#id_estado').prop('disabled', true);
        }
    });

    $("body").on("change", "#id_estado", function () {
        var texto = $(this).val();
        if (texto != 0) {
            $("#id_cidade").prop('disabled', false);
        } else {
            $("#id_cidade").val(0).trigger('change.select2');
            $("#id_cidade").prop('disabled', true);
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
    $('body').on('click', '.btn-limpar', function (e) {
        location.reload();
    });

    // função do botão Próximo
    $(".proximo").click(function () {
        $('.nav > .active').next('li').find('a').trigger('click');
    });
    // função do botão anterior
    $(".anterior").click(function () {
        $('.nav > .active').prev('li').find('a').trigger('click');
    });

    $('#remover').hide();
});
