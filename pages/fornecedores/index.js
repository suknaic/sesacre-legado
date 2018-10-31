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
                                        </div><br>\n\
                                        <div class="col-md-3">\n\
                                            <div class="panel-body">\n\
                                                <button class="fa fa-remove btn btn-danger btn-removerMedicamento"></button>\n\
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
                                        </div><br>\n\
                                        <div class="col-md-3">\n\
                                            <div class="panel-body">\n\
                                                <button class="fa fa-remove btn btn-danger btn-removerServico"></button>\n\
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
                                        </div><br>\n\
                                        <div class="col-md-3">\n\
                                            <div class="panel-body">\n\
                                                <button class="fa fa-remove btn btn-danger btn-removerConsumo"></button>\n\
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
                                        </div><br>\n\
                                        <div class="col-md-3">\n\
                                            <div class="panel-body">\n\
                                                <button class="fa fa-remove btn btn-danger btn-removerPermanente"></button>\n\
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

    $('body').find("select").select2({});

    //******************************************************************************************
    function listaPais() {
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
    listaPais();
    function listaEstado() {
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
    listaEstado();
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
                            }
                        });
                    }
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


    });
});
