$(document).ready(function () {
    //********************
    func = new Funcoes();
    func.carregaTabelaPadrao('tabela', null, [6]);
    //**********************************
    $("#nm_pessoa").focus();
    //datapiker, plugins para data
    //*****************************************************
    $('body').on('click', '.btn-pesquisar', function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else {
            e.preventDefault();
            var nome = $("#nm_pessoa").val();
            $.ajax({
                "url": "/model/rh/funcionario/request.php",
                "dataType": 'html',
                "data": {
                    acao: "retornaFuncionarioNome",
                    nome: nome
                },
                "success": function (response) {
                    if (response == 0){
                        alert('Dados não encontrado');
                        $("nm_pessoa").focus();
                        return;
                    }
                    func.carregaTabelaPadrao('tabela', response, [6], true);
                    //top.location.href = "/pages/rh/contrato/cadastrarFerias.php?id=" + cpf;
                },

            });
        }
    });
     //*************************************************************************
    $('body').on('click', '.btn-registrar', function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else {
            $id= $(this).val();
            top.location.href = "/pages/rh/feriasLicencas/cadastrarFeriasLicencas.php?id="+$id;

        }
    });
    //***************************************************
    $('.modal-alert').on('shown.bs.modal', function (e) {
        $("#nome").focus();
    });
    //**********************************************
    $('body').on('keypress', '.nome', function (e) {
        var key = e.which;
        if (key == 13) {
            $(".btn-pesquisar").trigger('click');
            return false;
        }
    });
    
});
