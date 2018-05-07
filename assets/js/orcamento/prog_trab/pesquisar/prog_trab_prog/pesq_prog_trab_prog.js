$(document).ready(function () {
    //instacinado fucoes js
    func = new Funcoes();
    
    //menu programa trabalho
    $.ajax({
        "url": "/layout/menus/orcamento/programa_trabalho/menu_programa_trabalho.php",
        "dataType": "html",
        "success": function (response) {
            $("body").find("#menu_prog_trab").html(response);
        }
    });
    
    $(".btn-limpar").hide();
    $(".btn-editar").hide();
    $("#informacao").hide();
    
    function listaPrograma(programa) {
        var cdTrabProg = {
            cd: programa
        };
        $.ajax({
            "url": "/model/orcamento/programaTrabalho/progTrabPrograma/request.php",
            "dataType": "html",
            "data": {
                "acao": "listarPrograma",
                "programa": cdTrabProg
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
                        $("body").find("#pesq_prog_trab_prog").html("");
                        func.modalAlert(response.msg);
                        return false;
                    }

                } else if (response.tipoMsg === "ok") {
                    //criando o datable novamente
                    $("#retorno").html(response.msg);
                    $('#tabela_prog_trab_programa').DataTable({
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
    listaPrograma('todas');
    
    $('body').on('click', '.btn-limpar', function (e) {
       $('.btn-salvar').prop("disabled", false);
        $("#pesq_prog_trab_prog").val("");
        $(".btn-limpar").hide();
        $(".btn-editar").hide();
        $(".btn-pesquisar").show();
        $("#obrigatorio").show();
        $("#informacao").hide();
    });

    $('body').on('click', '.btn-edit', function (e) {
        $(".btn-pesquisar").hide();
        $(".btn-limpar").show();
        $(".btn-editar").show();
        $("#pesq_prog_trab_prog").val($(this).attr('programa'));
        $("#id_prog_trab_prog").val($(this).val());
        $("#obrigatorio").hide();
        $("#informacao").show();
    });

    $('body').on('click', '.btn-pesquisar', function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else {
            e.preventDefault();
            var $this = $(this);
            $this.prop("disabled", true);
            var cdTrabProg = {
                cd: $("#pesq_prog_trab_prog").val()
            };
            
            $.ajax({
                "url": "/model/orcamento/programaTrabalho/progTrabPrograma/request.php",
                "dataType": "html",
                "data": {
                    "acao": "listarPrograma",
                    "programa": cdTrabProg
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
                            $("body").find("#pesq_prog_trab_prog").html("");
                            func.modalAlert(response.msg);
                            return false;
                        }
                    } else if (response.tipoMsg === "ok") {
                        //destruindo o datatable para não da bug
                        var oTable = $('#tabela_prog_trab_programa').dataTable();
                        oTable.fnDestroy();
                        //criando o datable novamente
                        $("#retorno").html(response.msg);
                        $('#tabela_prog_trab_programa').DataTable({
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
            var cdTrabProg = {
                cd: $("#pesq_prog_trab_prog").val(),
                id: $("#id_prog_trab_prog").val()
            };
            $.ajax({
                "url": "/model/orcamento/programaTrabalho/progTrabPrograma/request.php",
                "dataType": "html",
                "data": {
                    "acao": "editarPrograma",
                    "programa": cdTrabProg
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
                            $('.btn-salvar').prop("disabled", false);
                            $("#pesq_prog_trab_prog").val("");
                            $(".btn-limpar").hide();
                            $(".btn-editar").hide();
                            $(".btn-pesquisar").show();
                            //destruindo o datatable para não da bug
                            var oTable = $('#tabela_prog_trab_programa').dataTable();
                            oTable.fnDestroy();
                            listaPrograma('todas');
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
        var idCdTrabProg = $this.val();
        var cdTrabProg = $this.closest('td').find('.btn-edit').attr("programa");
        
        bootbox.confirm({
            title: func.msgCaixaDeConfirmacao,
            message: 'Você tem certeza que deseja continuar com a exclusão do registro <span class="text-danger">' + cdTrabProg + '</span> ?',
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
                    var programa = {
                        id: idCdTrabProg,
                        cd: cdTrabProg
                    };

                    if (idCdTrabProg == "" && cdTrabProg == "") {
                        func.modalAlert(func.msgPreencherCampos);
                        $this.prop("disabled", false);
                        return false;
                    }
                    $.ajax({
                        "url": "/model/orcamento/programaTrabalho/progTrabPrograma/request.php",
                        "dataType": "html",
                        "data": {
                            "acao": "removerPrograma",
                            "programa": programa
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
