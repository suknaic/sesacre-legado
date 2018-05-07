function listaEmpenho(data) {
    var empenho = {
        emp_data: data,
        emp_numero: "",
        emp_valor: "",

    };
    $.ajax({
        "url": "/model/financeiro/document_fiscais/financeiro/empenho/request.php",
        "dataType": "html",
        "data": {
            "acao": "listaEmpenho",
            "empenho": empenho
        },
        "success": function (response) {

            if (response.trim() == "SessaoExpirada") {
                func.modalAlert(func.msgSemPermissao);
                return false;
            }

            try {
                response = JSON.parse(response);
            } catch (e) {
                func.modalAlert(func.msgErroPadrao);
                console.log("Parse JSON");
                return false;
            }

            if (response.tipoMsg === "Erro") {
                if (response.tipoExibicao === "console") {
                    console.log('Console Mensagem');
                    func.modalAlert(func.msgErroPadrao);

                    return false;

                } else if (response.tipoExibicao === "alert") {
                    $("body").find("#campoEmpenho").html("");
                    func.modalAlert(response.msg);

                    return false;
                }

            } else if (response.tipoMsg === "ok") {
                //criando o datable novamente
                $("#resultmpenho").html(response.msg);
                $('#tabela').DataTable({
                    "lengthMenu": [[10, 25, 50, 10, -1], [10, 25, 50, 100, "Todos"]],
                    "language": {
                        "url": "/assets/lib/template/plugins/datatables/media/js/Portuguese-Brasil.json"
                    },
                    responsive: true
                });

                return false;
            } else {
                console.log('Ultimo else');
                func.modalAlert(func.msgErroPadrao);

                return false;
            }
        },
        "error": function (response) {
            func.modalAlert(func.msgErroPadrao);
            return false;
        }
    });

}
;

$(document).ready(function () {
    //instacinado fucoes js
    func = new Funcoes();

    //pegando menu do financeiro
    $.ajax({
        "url": "/layout/menus/financeiro/documento_fiscal/financeiro/menuFinanceiro.php",
        "dataType": "html",
        "success": function (response) {
            $("body").find("#menu_financeiro").html(response);
        }
    });
    //escodendo botões
    $(".btn-limpar").hide();
    $(".btn-editar").hide();

    //Mascara do sistema
    $("#emp_data").mask("99/99/9999");
    $("#emp_numero").mask("9999999999/9999");
    //Masca para valor
    $("body").on("focus", "#emp_valor", function () {
        $(this).priceFormat({
            prefix: '',
            centsSeparator: ',',
            thousandsSeparator: '.'
        });
    });
    //datapiker, plugins para data
    $('#emp_data').datepicker({
        format: 'dd/mm/yyyy',
        language: "pt-BR"
    });

    $('body').on('click', '.btn-limpar', function (e) {
        $('.btn-salvar').prop("disabled", false);
        $("#emp_numero").val("");
        $("#emp_valor").val("");
        $("#emp_data").val("");
        $(".btn-limpar").hide();
        $(".btn-editar").hide();
        $(".btn-pesquisar").show();
    });


    $('body').on('click', '.btn-edit', function (e) {
        $(".btn-pesquisar").hide();
        $(".btn-limpar").show();
        $(".btn-editar").show();
        $("#emp_id").val($(this).val());
        $("#emp_numero").val($(this).attr('numero'));
        $("#emp_valor").val($(this).attr('valor'));
        $("#emp_data").val($(this).attr('data'));
    });

    $('body').on('click', '.btn-pesquisar', function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else {
            e.preventDefault();
            var $this = $(this);
            $this.prop("disabled", true);
            var empenho = {
                emp_numero: $("#emp_numero").val(),
                emp_valor: $("#emp_valor").val(),
                emp_data: $("#emp_data").val()
            }

            $.ajax({
                "url": "/model/financeiro/document_fiscais/financeiro/empenho/request.php",
                "dataType": "html",
                "data": {
                    "acao": "listaEmpenho",
                    "empenho": empenho
                },
                "success": function (response) {
                    $this.prop("disabled", false);
                    if (response.trim() == "SessaoExpirada") {
                        func.modalAlert(func.msgSemPermissao);
                        return false;
                    }

                    try {
                        response = JSON.parse(response);
                    } catch (e) {
                        func.modalAlert(func.msgErroPadrao);
                        console.log("Parse JSON");
                        return false;
                    }

                    if (response.tipoMsg === "Erro") {
                        if (response.tipoExibicao === "console") {
                            console.log('Console Mensagem');
                            func.modalAlert(func.msgErroPadrao);

                            return false;

                        } else if (response.tipoExibicao === "alert") {
                            $("body").find("#campoEmpenho").html("");
                            func.modalAlert(response.msg);

                            return false;
                        }

                    } else if (response.tipoMsg === "ok") {
                        //destruindo o datatable para não da bug
                        var oTable = $('#tabela').dataTable();
                        oTable.fnDestroy();
                        //criando o datable novamente
                        $("#resultmpenho").html(response.msg);
                        $('#tabela').DataTable({
                            "lengthMenu": [[10, 25, 50, 10, -1], [10, 25, 50, 100, "Todos"]],
                            "language": {
                                "url": "/assets/lib/template/plugins/datatables/media/js/Portuguese-Brasil.json"
                            },
                            responsive: true
                        });

                        return false;
                    } else {
                        console.log('Ultimo else');
                        func.modalAlert(func.msgErroPadrao);
                        return false;
                    }
                },
                "error": function (response) {
                    $this.prop("disabled", false);
                    func.modalAlert(func.msgErroPadrao);
                    return false;
                }
            });

            $this.prop("disabled", false);
        }
    });

    $('body').on("click", ".btn-editar", function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else {
            e.preventDefault();
            var $this = $(this);
            $this.prop("disabled", true);
            var empenho = {
                emp_id: $("#emp_id").val(),
                emp_numero: $("#emp_numero").val(),
                emp_valor: $("#emp_valor").val(),
                emp_data: $("#emp_data").val()

            };
            $.ajax({
                "url": "/model/financeiro/document_fiscais/financeiro/empenho/request.php",
                "dataType": "html",
                "data": {
                    "acao": "editarEmpenho",
                    "empenho": empenho
                },
                "success": function (response) {
                    $this.prop("disabled", false);
                    if (response.trim() == "SessaoExpirada") {
                        func.modalAlert(func.msgSemPermissao);
                        return false;
                    }

                    try {
                        response = JSON.parse(response);
                    } catch (e) {
                        console.log(response);
                        func.modalAlert(func.msgErroPadrao);
                        console.log("Parse JSON");
                        return false;
                    }

                    if (response.tipoMsg === "Erro") {
                        if (response.tipoExibicao === "console") {
                            console.log('Console Mensagem');
                            func.modalAlert(func.msgErroPadrao);

                            return false;

                        } else if (response.tipoExibicao === "alert") {
                            $("body").find("#campoEmpenho").html("");
                            func.modalAlert(response.msg);

                            return false;
                        }

                    } else if (response.tipoMsg === "ok") {
                        func.modalAlert(response.msg);
                        $('.modal-alert').on('hidden.bs.modal', function (e) {
                            $('.btn-salvar').prop("disabled", false);
                            $("#emp_numero").val("");
                            $("#emp_valor").val("");
                            $("#emp_data").val("");
                            $(".btn-limpar").hide();
                            $(".btn-editar").hide();
                            $(".btn-pesquisar").show();
                            //destruindo o datatable para não da bug
                            var oTable = $('#tabela').dataTable();
                            oTable.fnDestroy();
                            listaEmpenho(empenho['emp_data']);
                        });
                        return false;

                    } else {
                        console.log('Ultimo else');
                        func.modalAlert(func.msgErroPadrao);

                        return false;
                    }
                },
                "error": function (response) {
                    $this.prop("disabled", false);
                    func.modalAlert(func.msgErroPadrao);
                    return false;
                }
            });

            $this.prop("disabled", false);
        }
    });

    $('body').on('click', '.btn-remover', function (e) {

        var $this = $(this);
        var id = $this.val();
        var item = $this.closest('td').find('.btn-edit').attr("numero");

        bootbox.confirm({
            title: func.msgCaixaDeConfirmacao,
            message: 'Você tem Certeza que deseja continuar com a Exclusão do Empenho <span class="text-danger">' + item + '</span> ?',
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
                    var empenho = {
                        emp_id: id
                    }

                    if (id == "") {
                        func.modalAlert(func.msgPreencherCampos);
                        $this.prop("disabled", false);
                        return false;
                    }

                    $.ajax({
                        "url": "/model/financeiro/document_fiscais/financeiro/empenho/request.php",
                        "dataType": "html",
                        "data": {
                            "acao": "excluirEmpenho",
                            "empenho": empenho
                        },
                        "success": function (response) {
                            if (response.trim() == "SessaoExpirada") {
                                func.modalAlert(func.msgSemPermissao);
                                return false;
                            }

                            try {
                                response = JSON.parse(response);
                            } catch (e) {
                                func.modalAlert(func.msgErroPadrao);
                                console.log("Parse JSON");
                                return false;
                            }

                            if (response.tipoMsg === "Erro") {
                                if (response.tipoExibicao === "console") {
                                    console.log('Console Mensagem');
                                    func.modalAlert(func.msgErroPadrao);
                                    return false;
                                } else if (response.tipoExibicao === "alert") {
                                    func.modalAlert(response.msg);
                                    return false;
                                }
                            } else if (response.tipoMsg === "ok") {
                                func.modalAlert(response.msg);
                                $('.modal-alert').on('hidden.bs.modal', function (e) {
                                    location.reload();
                                });
                                return false;
                            } else {
                                console.log('Ultimo else');
                                func.modalAlert(func.msgErroPadrao);
                                return false;
                            }
                        },
                        "error": function (response) {
                            func.modalAlert(func.msgErroPadrao);
                            return false;
                        }
                    });


                }
            }
        });

    });

});
