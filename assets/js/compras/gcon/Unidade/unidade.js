function listarTodasUnidades() {
    $.ajax({
        "url": "/model/compras/gcon/unidade/request.php",
        "dataType": "html",
        "data": {
            "acao": "listar_Todas_Unidades"
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
                    $("body").find("#unidade_pes").html("");
                    func.modalAlert(response.msg);
                    return false;
                }

            } else if (response.tipoMsg === "ok") {
                //criando o datable novamente
                $("#retorno").html(response.msg);
                $('#tabela_unidade').DataTable({
                    "lengthMenu": [[10, 25, 50, 10, -1], [10, 25, 50, 100, "Todos"]],
                    "language": {
                        "url": "/assets/lib/template/plugins/datatables/media/js/Portuguese-Brasil.json"
                    },
                    responsive: true,
                    dom: 'Bfrtip',
                    "scrollX": true,
                    buttons: [
                        {
                            extend: 'pageLength'
                        },
                        {
                            extend: 'excelHtml5',
                            text: '<i class="fa fa-file-excel-o"></i> Excel',
                            exportOptions: {
                                columns: function (idx) {
                                    if ($.inArray(idx) < 0) {
                                        return true;
                                    } else {
                                        return false;
                                    }
                                }
                            }
                        },
                        {
                            extend: 'pdfHtml5',
                            text: '<i class="fa fa-file-pdf-o"></i> PDF',
                            exportOptions: {
                                columns: function (idx) {
                                    if ($.inArray(idx) < 0) {
                                        return true;
                                    } else {
                                        return false;
                                    }
                                }
                            }
                        },
                        {
                            extend: 'print',
                            text: '<i class="fa fa-print"></i> Imprimir',
                            exportOptions: {
                                columns: function (idx) {
                                    if ($.inArray(idx) < 0) {
                                        return true;
                                    } else {
                                        return false;
                                    }
                                }
                            }
                        }
                    ]
                });

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

};
listarTodasUnidades();

$(document).ready(function () {
    //instacinado fucoes js
    func = new Funcoes();

    //pegando menu do gcon
    $.ajax({
        "url": "/layout/menus/compras/gcon/menu_gcon.php",
        "dataType": "html",
        "data" : {
        },
        "success": function (response) {
            $("body").find("#menu_gcon").append(response);
            $("body").find("#restoMenu").append('<li class="dropdown">\n\
                                                    <a href="/pages/compras/gcon/unidade/nova_unidade.php">Nova Unidade</a>\n\
                                                </li>\n\
                                                <li class="dropdown">\n\
                                                    <a href="/pages/compras/gcon/unidade/unidadeDesativadas.php">Unidades Desativadas</a>\n\
                                                </li>');
        }
    });

    $("#butao").mouseover(function () {
        $('#menu').css('display', 'block');
    }).mouseout(function () {
        $("#menu").mouseover(function () {
            $("#menu").css('display', 'block');
        }).mouseout(function () {
            $("#menu").css('display', 'none');
        });
    }).mouseout(function () {
        $("#menu").css('display', 'none');
    });
    
    //escodendo botões
    $(".btn-limpar").hide();
    $(".btn-editar").hide();


    $('body').on('click', '.btn-limpar', function (e) {
       $('.btn-salvar').prop("disabled", false);
        $("#unidade_pes").val("");
        $(".btn-limpar").hide();
        $(".btn-editar").hide();
        $(".btn-pesquisar").show();
    });


    $('body').on('click', '.btn-edit', function (e) {
        $(".btn-pesquisar").hide();
        $(".btn-limpar").show();
        $(".btn-editar").show();
        $("#unidade_pes").val($(this).attr('unidade'));
        $("#id_unidade").val($(this).val());
    });

    $('body').on('click', '.btn-pesquisar', function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else {
            e.preventDefault();
            var $this = $(this);
            $this.prop("disabled", true);
            var unidade = {
                unidade: $("#unidade_pes").val()
            };
            $.ajax({
                "url": "/model/compras/gcon/unidade/request.php",
                "dataType": "html",
                "data": {
                    "acao": "listar_Unidade",
                    "pesquisaUnidade": unidade
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
                        func.modalAlert(func.msgErroPadrao, 'danger');
                        return false;
                    }
                    if (response.tipoMsg === "Erro") {
                        if (response.tipoExibicao === "console") {
                            func.modalAlert(func.msgErroPadrao, 'danger');
                            return false;
                        } else if (response.tipoExibicao === "alert") {
                            $("body").find("#unidade_pes").html("");
                            func.modalAlert(response.msg);
                            return false;
                        }
                    } else if (response.tipoMsg === "ok") {
                        //destruindo o datatable para não da bug
                        var oTable = $('#tabela_unidade').dataTable();
                        oTable.fnDestroy();
                        //criando o datable novamente
                        $("#retorno").html(response.msg);
                        $('#tabela_unidade').DataTable({
                            "lengthMenu": [[10, 25, 50, 10, -1], [10, 25, 50, 100, "Todos"]],
                            "language": {
                                "url": "/assets/lib/template/plugins/datatables/media/js/Portuguese-Brasil.json"
                            },
                            responsive: true,
                            dom: 'Bfrtip',
                            "scrollX": true,
                            buttons: [
                                {
                                    extend: 'pageLength'
                                },
                                {
                                    extend: 'excelHtml5',
                                    text: '<i class="fa fa-file-excel-o"></i> Excel',
                                    exportOptions: {
                                        columns: function (idx) {
                                            if ($.inArray(idx) < 0) {
                                                return true;
                                            } else {
                                                return false;
                                            }
                                        }
                                    }
                                },
                                {
                                    extend: 'pdfHtml5',
                                    text: '<i class="fa fa-file-pdf-o"></i> PDF',
                                    exportOptions: {
                                        columns: function (idx) {
                                            if ($.inArray(idx) < 0) {
                                                return true;
                                            } else {
                                                return false;
                                            }
                                        }
                                    }
                                },
                                {
                                    extend: 'print',
                                    text: '<i class="fa fa-print"></i> Imprimir',
                                    exportOptions: {
                                        columns: function (idx) {
                                            if ($.inArray(idx) < 0) {
                                                return true;
                                            } else {
                                                return false;
                                            }
                                        }
                                    }
                                }
                            ]
                        });
                        return false;
                    } else {
                        func.modalAlert(func.msgErroPadrao, 'danger');
                        return false;
                    }
                },
                "error": function (response) {
                    $this.prop("disabled", false);
                    func.modalAlert(func.msgErroPadrao, 'danger');
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
            var unidade = {
                unidadeEdit: $("#unidade_pes").val(),
                idUnidade: $("#id_unidade").val()
            };
            $.ajax({
                "url": "/model/compras/gcon/unidade/request.php",
                "dataType": "html",
                "data": {
                    "acao": "editar_Unidade",
                    "editaUnidade": unidade
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
                        func.modalAlert(func.msgErroPadrao, 'danger');
                        return false;
                    }
                    if (response.tipoMsg === "Erro") {
                        if (response.tipoExibicao === "console") {
                            func.modalAlert(func.msgErroPadrao, 'danger');
                            return false;

                        } else if (response.tipoExibicao === "alert") {
                            $("body").find("#unidade_pes").html("");
                            func.modalAlert(response.msg);
                            return false;
                        }
                    } else if (response.tipoMsg === "ok") {
                        func.modalAlert(response.msg, 'success');
                        $('.modal-alert').on('hidden.bs.modal', function (e) {
                            location.reload();
                        });
                        return false;
                    } else {
                        func.modalAlert(func.msgErroPadrao, 'danger');
                        return false;
                    }
                },
                "error": function (response) {
                    $this.prop("disabled", false);
                    func.modalAlert(func.msgErroPadrao, 'danger');
                    return false;
                }
            });
            $this.prop("disabled", false);
        }
    });

    $('body').on('click', '.btn-remover', function (e) {

        var $this = $(this);
        var idUnidade = $this.val();
        var unidade = $this.closest('td').find('.btn-edit').attr("unidade");
        
        bootbox.confirm({
            title: func.msgCaixaDeConfirmacao,
            message: 'Você tem certeza que deseja continuar com a exclusão da unidade <span class="text-danger">' + unidade + '</span> ?',
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
                    var unidadeExc = {
                        idUnidade: idUnidade
                    };

                    if (idUnidade == "") {
                        func.modalAlert(func.msgPreencherCampos);
                        $this.prop("disabled", false);
                        return false;
                    }
                    $.ajax({
                        "url": "/model/compras/gcon/unidade/request.php",
                        "dataType": "html",
                        "data": {
                            "acao": "excluir_Unidade",
                            "excluirUnidade": unidadeExc
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
                                $('.modal-alert').on('hidden.bs.modal', function (e) {
                                    location.reload();
                                });
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
});
