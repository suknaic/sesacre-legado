//******************************************************************************************
function listaVinculoCombo() {
    $.ajax({
        "url": "/model/rh/funcionario/request.php",
        "dataType": 'html',
        "data": {
            acao: "listaVinculoOption",
            id: 0
        },
        "success": function (response) {
            //  console.log(response);
            $("#id_vinculo").append(response);
            $("#id_vinculo").select2({
            //    width: " 100%"
            });
        }
    });
}
listaVinculoCombo();
//******************************************************************************************
function listaLotacaoCombo() {
    $.ajax({
        "url": "/model/rh/funcionario/request.php",
        "dataType": 'html',
        "data": {
            acao: "listaLotacaoOption",
            id: 0
        },
        "success": function (response) {
            // console.log(response);
            $("#id_lotacao").append(response);
            $("#id_lotacao").select2({
          //      width: " 100%"
            });
        }
    });
}
listaLotacaoCombo();

//**********************************
$(document).ready(function () {
    //**********************
    func = new Funcoes();
    func.carregaTabelaPadrao('tabela', null, [7]);
    $("#nm_nome").focus();
    //************************************
    $("#nr_cpf").mask("999.999.999-99");
    $("#dt_nascimento").mask("99/99/9999");
    //datapiker, plugins para data
    $('#dt_nascimento').datepicker({
        format: 'dd/mm/yyyy',
        language: "pt-BR"
    });

//******************************************************************************************
    $('body').on('click', '.btn-novo', function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else {
            top.location.href = "/pages/rh/funcionario/cadastraFuncionario.php";

        }
    });
    //*************************************************************************
    $('body').on('click', '.btn-novoContrato', function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else {
            top.location.href = "/pages/rh/contrato/index.php";

        }
    });
    //************************************************************************
    $('body').on('click', '.btn-pesquisar', function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else {
            e.preventDefault();
            var nome = $("#nm_nome").val();
            var matricula = $("#matricula").val();
            var vinculo = $("#id_vinculo").val();
            var lotacao = $("#id_lotacao").val();
            var cpf = $("#nr_cpf").val().replace(/(\.|\/|\-)/g, "");
            $.ajax({
                "url": "/model/rh/funcionario/request.php",
                "dataType": 'html',
                "method": 'POST',
                "data": {
                    acao: "listaPessoaFisicaTable",
                    nome: nome,
                    cpf: cpf,
                    matricula: matricula,
                    vinculo: vinculo,
                    lotacao: lotacao

                },
                "success": function (response) {
                    //console.log(response);
                    func.carregaTabelaPadrao('tabela', response, [7], true);
                }
            });
        }
    });

    $('body').on('click', '.btn-remover', function (e) {
        
        var $this = $(this);
        var id = $this.val();
        var item = $this.closest('td').find('.btn-edit').attr("nome");
        var idContrato = id;
        bootbox.confirm({
            title: 'Caixa de Confirmação',
            message: 'Você tem Certeza que deseja Excluir:   <span class="text-danger">' + item + '</span>?',
            buttons: {
                'cancel': {
                    label: 'Não',
                    className: 'btn-default btn-rounded'
                },
                'confirm': {
                    label: 'Sim',
                    className: 'btn-primary btn-rounded'
                }
            },
            callback: function (result) {
                if (result) {
                    var Pessoa = {
                        idContrato: idContrato

                    }

                    if (id == "") {
                        func.modalAlert(func.msgPreencherCampos);
                        $this.prop("disabled", false);
                        return false;
                    }

                    $.ajax({
                        "url": "/model/rh/funcionario/request.php",
                        "dataType": "html",
                        "method": "POST",
                        "data": {
                            "acao": "removerContrato",
                            "pessoa": Pessoa
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
                                func.modalAlert(func.msgErroPadrao);
                                //console.log("Parse JSON");
                                //console.log(response);
                                return false;
                            }

                            if (response.tipoMsg === "Erro") {
                                if (response.tipoExibicao === "console") {
                                    //console.log('Console Mensagem');
                                    //console.log(response);
                                    func.modalAlert(func.msgErroPadrao);
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
                                //console.log('Ultimo else');
                                //console.log(response);
                                func.modalAlert(func.msgErroPadrao);
                                return false;
                            }
                        },
                        "error": function (response) {
                            //console.log(response);
                            func.modalAlert(func.msgErroPadrao);
                            return false;
                        }
                    });


                }
            }
        });

    });
    
    $('body').on('click', '.btn-redefinir', function (e) {

        var $this = $(this);
        var idPessoa = $this.val();
        var item = $this.closest('td').find('.btn-edit').attr("nome");
        
        bootbox.confirm({
            title: 'Caixa de Confirmação',
            message: 'Você tem Certeza que deseja <span class="text-danger">REDEFINIR</span> a senha padrão de:   <span class="text-danger">' + item + '</span>?',
            buttons: {
                'cancel': {
                    label: 'Não',
                    className: 'btn-default btn-rounded'
                },
                'confirm': {
                    label: 'Sim',
                    className: 'btn-primary btn-rounded'
                }
            },
            callback: function (result) {
                if (result) {
                    var Pessoa = {
                        idPessoa: idPessoa

                    }
                    $.ajax({
                        "url": "/model/rh/funcionario/request.php",
                        "dataType": "html",
                        "method": "POST",
                        "data": {
                            "acao": "redefinirSenha",
                            "pessoa": Pessoa
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
                                func.modalAlert(func.msgErroPadrao);
                                //console.log("Parse JSON");
                                //console.log(response);
                                return false;
                            }

                            if (response.tipoMsg === "Erro") {
                                if (response.tipoExibicao === "console") {
                                    //console.log('Console Mensagem');
                                    //console.log(response);
                                    func.modalAlert(func.msgErroPadrao);
                                    return false;
                                } else if (response.tipoExibicao === "alert") {
                                    func.modalAlert(response.msg);
                                    return false;
                                }
                            } else if (response.tipoMsg === "ok") {
                                func.modalAlert(response.msg, 'primary');
                                //func.fechaModalReload();
                                return false;
                            } else {
                                //console.log('Ultimo else');
                                //console.log(response);
                                func.modalAlert(func.msgErroPadrao);
                                return false;
                            }
                        },
                        "error": function (response) {
                            //console.log(response);
                            func.modalAlert(func.msgErroPadrao);
                            return false;
                        }
                    });


                }
            }
        });

    });

    $('body').on('click', '.btn-edit', function (e) {
        e.preventDefault();
        var idContrato = $(this).val();
        top.location.href = "/pages/rh/funcionario/editaFuncionario.php?id=" + idContrato;

    });

    $('body').on('click', '.btn-limpar', function (e) {
        $("#nm_nome").val("");
        $("#nr_cpf").val("");
        $("#matricula").val("");
        $("#id_lotacao").val(0).change();
        $("#id_vinculo").val(0).change();
    });

    $('.modal-alert').on('shown.bs.modal', function (e) {
        $("#nome").focus();
    });


    $('body').on('keypress', '.formPesquisaFuncionario', function (e) {
        var key = e.which;
        if (key == 13) {
            $(".btn-pesquisar").trigger('click');
            return false;
        }
    });

});
