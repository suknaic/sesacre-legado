$(document).ready(function () {

    func = new Funcoes();
    func.carregaTabelaPadrao('tabela', null, [8]);

    $('body').on('click', '.btn-pesquisar', function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else {
            e.preventDefault();
            var $this = $(this);
            $this.prop("disabled", true);
            var PessoaFisica = {
                nome: $("#nmPessoa").val(),
                cpf: $("#nrCpf").val()
            };

            if (PessoaFisica.nome == '' && PessoaFisica.cpf == '') {
                func.modalAlert(func.msgPreencherCampos);
                $this.prop("disabled", false);
                return false;
            }

            $.ajax({
                "url": "/pages/sistema/pessoa/fisica/request.php",
                "dataType": "html",
                "method": "POST",
                "data": {
                    "acao": "pesquisaPessoaFisica",
                    "dados": PessoaFisica
                },
                "success": function (response) {
                    func.carregaTabelaPadrao('tabela', response, [8], true);
                    return false;
                }
            });
            $this.prop("disabled", false);
        }
    });

    $('body').on('click', '.btn-remover', function (e) {
        var $this = $(this);
        var id = $this.val();
        var item = $this.closest('td').find('.btn-edit').attr("nome");
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
                        idPessoa: id

                    };

                    if (Pessoa.idPessoa == "") {
                        func.modalAlert(func.msgPreencherCampos);
                        $this.prop("disabled", false);
                        return false;
                    }

                    $.ajax({
                        "url": "/pages/sistema/pessoa/fisica/request.php",
                        "dataType": "html",
                        "method": "POST",
                        "data": {
                            "acao": "removerPessoaFisica",
                            "dados": Pessoa
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
                            func.modalAlert(func.msgErroPadrao, 'danger');
                            return false;
                        }
                    });
                }
            }
        });
    });

    $('body').on('click', '.btn-desativar', function (e) {
        var $this = $(this);
        var id = $this.val();
        var item = $this.closest('td').find('.btn-edit').attr("nome");
        var idPessoa = id;
        bootbox.confirm({
            title: 'Caixa de Confirmação',
            message: 'Você tem certeza que deseja ativar/desativar:   <span class="text-danger">' + item + '</span>?',
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

                    if (Pessoa.idPessoa == "") {
                        func.modalAlert(func.msgPreencherCampos);
                        $this.prop("disabled", false);
                        return false;
                    }

                    $.ajax({
                        "url": "/pages/sistema/pessoa/fisica/request.php",
                        "dataType": "html",
                        "data": {
                            "acao": "desativarPessoa",
                            "pessoa": Pessoa
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
                            func.modalAlert(func.msgErroPadrao, 'danger');
                            return false;
                        }
                    });
                }
            }
        });
    });

    $('body').on('click', '.btn-limpar', function (e) {
        $('#nmPessoa').prop("disabled", false);
        $('#nrCpf').prop("disabled", false);
        $("#nrCpf").val("");
        $('#nmPessoa').val('');
    });

    $('body').on('click', '.btn-novaPessoaFisica', function (e) {
        top.location.href = "cadPessoaFisica/cadastraPessoaFisica.php";
    });

    $('body').on('click', '.btn-edit', function (e) {
        e.preventDefault();
        //**********************
        var id = $(this).val();
        if (id.split("-")[0] == 1) {
            top.location.href = "/pages/sistema/pessoa/fisica/editPessoaFisica/editaPessoaFisica.php?id=" + id;
        }
    });

    $("#nrCpf").mask("999.999.999-99");

    $('body').on('keypress', '.formPessoaFisica', function (e) {
        var key = e.which;
        if (key == 13) {
            $(".btn-pesquisar").trigger('click');
            return false;
        }
    });
});
