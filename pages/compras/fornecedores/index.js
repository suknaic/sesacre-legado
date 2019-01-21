//******************************************************************************************
$(document).ready(function () {
    //************ Select2 ***********
    $(".select").select2({width: " 100%"});
    //********************************
//******************************************************************************************
    func = new Funcoes();
    func.carregaTabelaPadrao('tabela', null, [8]);
    $("#nr_cpf").mask("999.999.999-99");
    $("#nr_cnpj").mask("99.999.999/9999-99");
    $('body').on('change', '#tipoPessoa', function (e) {
        $("#nm_pessoa").val("");
        $("#nr_cnpj").val("");
        $("#nr_cpf").val("");
        switch ($('#tipoPessoa').val()) {
            case '0' :
                $('#tipoPessoa').closest(".formPesquisaPessoa").find('.cpf').hide();
                $('#tipoPessoa').closest(".formPesquisaPessoa").find('.cnpj').hide();
                $('#tipoPessoa').closest(".formPesquisaPessoa").find('.nome').hide();
                break;
            case '1':
                $('#tipoPessoa').closest(".formPesquisaPessoa").find('.cpf').show();
                $('#tipoPessoa').closest(".formPesquisaPessoa").find('.cnpj').hide();
                $('#tipoPessoa').closest(".formPesquisaPessoa").find('.nome').show();
                $("#nr_cpf").focus();
                break;
            case '2':
                $('#tipoPessoa').closest(".formPesquisaPessoa").find('.cpf').hide();
                $('#tipoPessoa').closest(".formPesquisaPessoa").find('.cnpj').show();
                $('#tipoPessoa').closest(".formPesquisaPessoa").find('.nome').show();
                $("#nr_cnpj").focus();
                break;
        }
    });
    //**************************************************************************
    $('body').on('click', '.btn-novoPf', function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else {
            top.location.href = "/pages/sistema/pessoa/fisica/cadPessoaFisica/cadastraPessoaFisica.php";
        }
    });
    //*************************************************************************
    $('body').on('click', '.btn-novoPj', function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else {
            top.location.href = "/pages/sistema/pessoa/juridica/cadPessoaJuridica/cadastraPessoaJuridica.php";
        }
    });
    //************************************************************************
    $('body').on('click', '.btn-pesquisar', function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else {
            e.preventDefault();
            $nome = $.trim($("#nm_pessoa").val());
            $cpf = $.trim($("#nr_cpf").val());
            $cnpj = $.trim($("#nr_cnpj").val());

            if (($("#tipoPessoa").val() == 0 || ($cnpj == '' && $nome == '')) && ($("#tipoPessoa").val() == 0 || ($cpf == '' && $nome == ''))) {
                func.modalAlert(func.msgPreencherCampos);
                return;
            }
            $cpf = $("#nr_cpf").val().replace(/(\.|\/|\-)/g, "");
            $cnpj = $("#nr_cnpj").val().replace(/(\.|\/|\-)/g, "");
            var Pessoa = {
                nome: $("#nm_pessoa").val(),
                cpf: $cpf,
                cnpj: $cnpj,
                tipoPessoa: $("#tipoPessoa").val()
            };
            $.ajax({
                "url": "/model/compras/fornecedores/request.php",
                "dataType": 'html',
                "method": "POST",
                "data": {
                    acao: "listaPessoaTable",
                    pessoa: Pessoa,
                },
                "success": function (response) {
                    //console.log(response);
                    func.carregaTabelaPadrao('tabela', response, [8], true);

                }
            });
        }
    });
    //*************************************************************************
    $('body').on('click', '.btn-desativar', function (e) {

        var $this = $(this);
        var id = $this.val();
        var item = $this.closest('td').find('.btn-edit').attr("nome");
        var idPessoa = id;
        bootbox.confirm({
            title: 'Caixa de Confirmação',
            message: 'Você tem Certeza que deseja ativar/Inativar:   <span class="text-danger">' + item + '</span>?',
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

                    };

                    if (id == "") {
                        func.modalAlert(func.msgPreencherCampos);
                        $this.prop("disabled", false);
                        return false;
                    }

                    $.ajax({
                        "url": "/model/compras/fornecedores/request.php",
                        "dataType": "html",
                        "data": {
                            "acao": "inativarPessoa",
                            "pessoa": Pessoa
                        },
                        "success": function (response) {
                            //console.log(response);
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
    //*********************************************************************************
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
                        "url": "/model/compras/fornecedores/request.php",
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
    //*************************************************************************
    $('body').on('click', '.btn-remover', function (e) {
        var $this = $(this);
        var id = $this.val();
        var item = $this.closest('td').find('.btn-edit').attr("nome");
        var idPessoa = id;
        bootbox.confirm({
            title: 'Caixa de Confirmação',
            message: 'Você tem Certeza que deseja remover:   <span class="text-danger">' + item + '</span>?',
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

                    };

                    if (id == "") {
                        func.modalAlert(func.msgPreencherCampos);
                        $this.prop("disabled", false);
                        return false;
                    }

                    $.ajax({
                        "url": "/model/compras/fornecedores/request.php",
                        "dataType": "html",
                        "data": {
                            "acao": "removerPessoa",
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
    //**************************************************************************************
    $('body').on('click', '.btn-edit', function (e) {
        e.preventDefault();
        //**********************
        var id = $(this).val();
        if (id.split("-")[0] == 1) {
            top.location.href = "/pages/sistema/pessoa/fisica/editPessoaFisica/editaPessoaFisica.php?id=" + id;
        }
        if (id.split("-")[0] == 2) {
            top.location.href = "/pages/sistema/pessoa/juridica/editPessoaJuridica/editaPessoaJuridica.php?id=" + id;
        }
    });
    $('body').on('click', '.btn-limpar', function (e) {

        $("#tipoPessoa").val(0);
        $("#tipoPessoa").trigger("change");
    });
    $('.modal-alert').on('shown.bs.modal', function (e) {
        $("#nm_pessoa").focus();
    });
    $('body').on('keypress', '.formPesquisaPessoa', function (e) {
        var key = e.which;
        if (key == 13) {
            $(".btn-pesquisar").trigger('click');
            return false;
        }
    });
});
