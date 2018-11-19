$(document).ready(function () {

    func = new Funcoes();

//******************************************************************************************
    $('body').find("select").select2({});
    $('body').find("selectTipoPessoa").select2({});
    $(".nr").mask("99");
    $("#nr_cpf").mask("999.999.999-99");
    $("#nr_cnpj").mask("99.999.999/9999-99");
//******************************************************************************************
    $('body').on('click', '.btn-pesquisar', function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else {
            e.preventDefault();
            var $this = $(this);

            if ($('#id_tipo_fornecedor').val() == 1) {
                var PessoaFisica = {
                    cpf: $('#nr_cpf').val(),
                    nmPessoaFisica: $('#nm_pessoa').val()
                };
            }

            if ($('#id_tipo_fornecedor').val() == 2) {
                var PessoaJuridica = {
                    nmRazaoSoc: $('#rz_social').val(),
                    cnpj: $("#nr_cnpj").val().replace(/(\.|\/|\-)/g, "")
                };
            }

            var MaterialServico = {
                medicamento: $('#id_medicamentos').val(),
                servico: $('#id_servicos').val(),
                materialConsumo: $('#id_material_consumo').val(),
                materialPermanente: $('#id_material_permanente').val()
            };

            var Fornecedor = {
                pessoaFisica: PessoaFisica,
                pessoaJuridica: PessoaJuridica,
                materialServico: MaterialServico,
                tipoFornecedor: $("#id_tipo_fornecedor").val()
            };

            if ($('#id_tipo_fornecedor').val() == 0 && ($('#nr_cpf').val() == '' && $('#nm_pessoa').val() == '' && $('#rz_social').val() == '' &&
                $("#nr_cnpj").val().replace(/(\.|\/|\-)/g, "") == '' && MaterialServico.servico == null &&
                MaterialServico.medicamento == null && MaterialServico.materialConsumo == null && MaterialServico.materialPermanente == null)){
                func.modalAlert(func.msgPreencherCampos);
                return false;
            }

            top.location.href = '/pages/fornecedor/relatorio/relatorio.php?token='+btoa(JSON.stringify(Fornecedor));
        }
    });

    $('body').on('click', '.btn-limpar', function (e) {
        $('#form_fornecedor').reset();
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


    $('.fisica').hide();
    $('.juridica').hide();
    $('.resto').hide();
    $('body').on("change", "#id_tipo_fornecedor", function(){
        if ($('#id_tipo_fornecedor').val() == 1) {
            $('.juridica').hide();
            $('.fisica').show();
            $('.resto').show();
            $('#form_fornecedor input').val("");
            $('input[type=checkbox]').attr('checked', false);
            $('.select').val(0).trigger('change.select2');
        } else if ($('#id_tipo_fornecedor').val() == 2) {
            $('.juridica').show();
            $('.fisica').hide();
            $('.resto').show();
            $('#form_fornecedor input').val("");
            $('input[type=checkbox]').attr('checked', false);
            $('.select').val(0).trigger('change.select2');
        } else {
            $('.juridica').hide();
            $('.fisica').hide();
            $('.resto').hide();
            $('#form_fornecedor').reset();
            $('input[type=checkbox]').attr('checked', false);
            $('.select').val(0).trigger('change.select2');
        }
    });

});
