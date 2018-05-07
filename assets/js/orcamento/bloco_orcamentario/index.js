$(document).ready(function () {
    //instacinado fucoes js
    func = new Funcoes();
    
    //menu programa trabalho
    $.ajax({
        "url": "/layout/menus/orcamento/bloco_orcamentario/menu_bloco_orcamentario.php",
        "dataType": "html",
        "success": function (response) {
            $("body").find("#menu_bloco_orcamentario").html(response);
        }
    });
    
    $(".btn-cancelar").hide();
    $(".btn-editar").hide();
    
    $('body').on('click', '.btn-cancelar', function (e) {
        $("#bloco").val("");
        $(".btn-cancelar").hide();
        $(".btn-editar").hide();
        $(".btn-pesquisar").show();
    });
    
    $('body').on('click', '.btn-edit', function (e) {
        $(".btn-pesquisar").hide();
        $(".btn-cancelar").show();
        $(".btn-editar").show();
        $("#bloco").val($(this).attr('bloco'));
        $("#id_bloco_orcamentario").val($(this).val());
    });
    
    function listaBloco(listar) {
        var bloco = {
            nm: listar
        };
        $.ajax({
            "url": "/model/orcamento/blocOrcamentario/request.php",
            "dataType": "html",
            "data": {
                "acao": "listarBloco",
                "bloco": bloco
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
                        $("body").find("#bloco").html("");
                        func.modalAlert(response.msg);
                        return false;
                    }

                } else if (response.tipoMsg === "ok") {
                    //criando o datable novamente
                    $("#retorno").html(response.msg);
                    $('#tabela_bloco').DataTable({
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
    listaBloco('todas');
    
    $('body').on('click', '.btn-pesquisar', function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else {
            e.preventDefault();
            var $this = $(this);
            $this.prop("disabled", true);
            var bloco = {
                nm: $("#bloco").val()
            };
            
            $.ajax({
                "url": "/model/orcamento/blocOrcamentario/request.php",
                "dataType": "html",
                "data": {
                    "acao": "listarBloco",
                    "bloco": bloco
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
                            $("body").find("#bloco").html("");
                            func.modalAlert(response.msg);
                            return false;
                        }
                    } else if (response.tipoMsg === "ok") {
                        //destruindo o datatable para não da bug
                        var oTable = $('#tabela_bloco').dataTable();
                        oTable.fnDestroy();
                        //criando o datable novamente
                        $("#retorno").html(response.msg);
                        $('#tabela_bloco').DataTable({
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
            var blocOrcamentario = {
                nm: $("#bloco").val(),
                id: $("#id_bloco_orcamentario").val()
            };
            $.ajax({
                "url": "/model/orcamento/blocOrcamentario/request.php",
                "dataType": "html",
                "data": {
                    "acao": "editarBloco",
                    "bloco": blocOrcamentario
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
                            $("body").find("#bloco").html("");
                            func.modalAlert(response.msg);
                            return false;
                        }
                    } else if (response.tipoMsg === "ok") {
                        func.modalAlert(response.msg, 'success');
                        $('.modal-alert').on('hidden.bs.modal', function (e) {
                            $("#bloco").val("");
                            $(".btn-cancelar").hide();
                            $(".btn-editar").hide();
                            $(".btn-pesquisar").show();
                            //destruindo o datatable para não da bug
                            var oTable = $('#tabela_bloco').dataTable();
                            oTable.fnDestroy();
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
        var idBlocOrcamentario = $this.val();
        var nmBlocOrcamentario = $this.closest('td').find('.btn-edit').attr("bloco");
        
        bootbox.confirm({
            title: func.msgCaixaDeConfirmacao,
            message: 'Você tem certeza que deseja continuar com a exclusão do registro <span class="text-danger">' + nmBlocOrcamentario + '</span> ?',
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
                    var blocOrcamentario = {
                        id: idBlocOrcamentario,
                        nm: nmBlocOrcamentario
                    };

                    if (idBlocOrcamentario == "" && nmBlocOrcamentario == "") {
                        func.modalAlert(func.msgPreencherCampos);
                        $this.prop("disabled", false);
                        return false;
                    }
                    $.ajax({
                        "url": "/model/orcamento/blocOrcamentario/request.php",
                        "dataType": "html",
                        "data": {
                            "acao": "removerBloco",
                            "bloco": blocOrcamentario
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