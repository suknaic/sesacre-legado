function listarTodasModalidades() {
    $.ajax({
        "url": "/model/compras/gcon/modalidade/request.php",
        "dataType": "html",
        "data": {
            "acao": "listar_Todas_Modalidades"
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
                    $("body").find("#modalidade_pes").html("");
                    func.modalAlert(response.msg);
                    return false;
                }
            } else if (response.tipoMsg === "ok") {
                //criando o datable novamente
                $("#retorno").html(response.msg);
                $('#tabela_modalidade').DataTable({
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
                console.log('Ultimo else');
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
listarTodasModalidades();

$(document).ready(function () {
    //instacinado fucoes js
    func = new Funcoes();

    //pegando menu do gcon
    $.ajax({
        "url": "/layout/menus/compras/gcon/menu_gcon.php",
        "dataType": "html",
        "success": function (response) {
            $("body").find("#menu_gcon").html(response);
        }
    });
    //escodendo botões e tabela
    $(".btn-limpar").hide();
    $(".btn-editar").hide();
    $("#tabela").hide();


    $('body').on('click', '.btn-limpar', function (e) {
       $('.btn-salvar').prop("disabled", false);
        $("#modalidade_pes").val("");
        $(".btn-limpar").hide();
        $(".btn-editar").hide();
        $(".btn-pesquisar").show();
    });


    $('body').on('click', '.btn-edit', function (e) {
        $(".btn-pesquisar").hide();
        $(".btn-limpar").show();
        $(".btn-editar").show();
        $("#modalidade_pes").val($(this).attr('modalidade'));
        $("#id_modalidade").val($(this).val());
    });

    $('body').on('click', '.btn-pesquisar', function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else {
            e.preventDefault();
            var $this = $(this);
            $this.prop("disabled", true);
            var modalidade = {
                modalidade_pes: $("#modalidade_pes").val()
            };
         
            $.ajax({
                "url": "/model/compras/gcon/modalidade/request.php",
                "dataType": "html",
                "data": {
                    "acao": "listar_Modalidade",
                    "PesqModalidade": modalidade
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
                            $("body").find("#modalidade_pes").html("");
                            func.modalAlert(response.msg);
                            return false;
                        }

                    } else if (response.tipoMsg === "ok") {
                        //destruindo o datatable para não da bug
                        var oTable = $('#tabela_modalidade').dataTable();
                        oTable.fnDestroy();
                        //criando o datable novamente
                        $("#retorno").html(response.msg);
                        $('#tabela_modalidade').DataTable({
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
            var modalidade = {
                modalidade_pes: $("#modalidade_pes").val(),
                id_modalidade: $("#id_modalidade").val()
            };
            $.ajax({
                "url": "/model/compras/gcon/modalidade/request.php",
                "dataType": "html",
                "data": {
                    "acao": "editar_Modalidade",
                    "editModalidade": modalidade
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
                            $("body").find("#modalidade_pes").html("");
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
        var id = $this.val();
        var item = $this.closest('td').find('.btn-edit').attr("modalidade");

        bootbox.confirm({
            title: func.msgCaixaDeConfirmacao,
            message: 'Você tem Certeza que deseja continuar com a Exclusão da Modalidade <span class="text-danger">' + item + '</span> ?',
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
                    var modalidade = {
                        id_modalidade: id
                    };

                    if (id == "") {
                        func.modalAlert(func.msgPreencherCampos);
                        $this.prop("disabled", false);
                        return false;
                    }

                    $.ajax({
                        "url": "/model/compras/gcon/modalidade/request.php",
                        "dataType": "html",
                        "data": {
                            "acao": "excluir_Modalidade",
                            "DelModalidade": modalidade
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
                                console.log('Ultimo else');
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
