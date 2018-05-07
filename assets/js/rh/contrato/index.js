$(document).ready(function () {
    $("#nr_cpf").mask("999.999.999-99");
    $("#dt_nascimento").mask("99/99/9999");
    //datapiker, plugins para data

    func = new Funcoes();
    $("#nr_cpf").focus();
    $('body').on('click', '.btn-pesquisar', function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else {
            e.preventDefault();
            var cpf = $("#nr_cpf").val();
            cpf = cpf.replace(/(\.|\/|\-)/g, "");
            $.ajax({
                "url": "/model/rh/funcionario/request.php",
                "dataType": 'html',
                "data": {
                    acao: "retornaPessoaFisica",
                    cpf: cpf
                },
                "success": function (response) {
                    if (response == 0) {
                        func.modalAlert(func.msgRegistroNaoEncontrado);
                        $("nr_cpf").focus();
                        return false;
                    }
                    try {
                        response = JSON.parse(response);
                    } catch (e) {
                        console.log(response);
                        return false;
                    }
                    top.location.href = "/pages/rh/contrato/cadastrarContrato.php?id=" + cpf + "="+ response[0]['nr_contratos'];
                },

            });
        }
    });

    $('.modal-alert').on('shown.bs.modal', function (e) {
        $("#nome").focus();
    });

    $('body').on('keypress', '.cpf', function (e) {
        var key = e.which;
        if (key == 13) {
            $(".btn-pesquisar").trigger('click');
            return false;
        }
    });

});
