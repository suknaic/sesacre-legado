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

    //select2
    $("#ano").select2();

    //Escondendo botões
    $(".btn-cancelar").hide();
    $(".btn-editar").hide();

    //Escondendo campos
    $("#campos").hide();
    
    document.getElementById("codigo").disabled = true;
    document.getElementById("descricao").disabled = true;
    
    //metodo para carregar os anos no comboBox
    function listaAno() {
        $.ajax({
            "url": "/model/orcamento/programaTrabalho/request.php",
            "dataType": "html",
            "data": {
                "acao": "retornaAno"
            },
            "success": function (response) {
                $("#ano").append(response);
            }
        });
    }
    listaAno();
    
    //Desabilitando campos
    $("body").on("change", "#codigo", function () {
        var texto = $(this).val();
        if (texto != 0) {
            document.getElementById("descricao").disabled = true;
            document.getElementById("ano").disabled = true;
        } else {
            document.getElementById("descricao").disabled = false;
            document.getElementById("ano").disabled = false;
        }
    });
    $("body").on("change", "#descricao", function () {
        var texto = $(this).val();
        if (texto != 0) {
            document.getElementById("codigo").disabled = true;
            document.getElementById("ano").disabled = true;
        } else {
            document.getElementById("codigo").disabled = false;
            document.getElementById("ano").disabled = false;
        }
    });
    $("body").on("change", "#ano", function () {
        var texto = $(this).val();
        if (texto != 0) {
            document.getElementById("codigo").disabled = true;
            document.getElementById("descricao").disabled = true;
        } else {
            document.getElementById("codigo").disabled = false;
            document.getElementById("descricao").disabled = false;
        }
    });

    $('body').on('click', '.btn-edit', function (e) {
        var id_programa_trabalho = $(this).attr('value');
        top.location = "/pages/orcamento/programa_trabalho/cadastrar/cadProgramaTrabalho.php?idProgTrab=" + id_programa_trabalho;
    });

    $('body').on('click', '.btn-pesquisar', function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else {
            e.preventDefault();
            var $this = $(this);
            $this.prop("disabled", true);
            var progTrab = {
                cd: $("#codigo").val(),
                ds: $("#descricao").val(),
                ano: $("#ano").val()
            };

            $.ajax({
                "url": "/model/orcamento/programaTrabalho/request.php",
                "dataType": "html",
                "data": {
                    "acao": "listarProgTrab",
                    "progTrab": progTrab
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
                        var oTable = $('#tabela_prog_trab').dataTable();
                        oTable.fnDestroy();
                        //criando o datable novamente
                        $("#retorno").html(response.msg);
                        $('#tabela_prog_trab').DataTable({
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

    $('body').on('click', '.btn-remover', function (e) {

        var $this = $(this);
        var idProgramaTrabalho = $this.val();
        var cdProgramaTrabalho = $this.closest('td').find('.btn-edit').attr("programa");

        bootbox.confirm({
            title: func.msgCaixaDeConfirmacao,
            message: 'Você tem certeza que deseja continuar com a exclusão do registro <span class="text-danger">' + cdProgramaTrabalho + '</span> ?',
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
                        id: idProgramaTrabalho,
                        cd: cdProgramaTrabalho
                    };

                    if (idProgramaTrabalho == "") {
                        func.modalAlert(func.msgPreencherCampos);
                        $this.prop("disabled", false);
                        return false;
                    }
                    $.ajax({
                        "url": "/model/orcamento/programaTrabalho/request.php",
                        "dataType": "html",
                        "data": {
                            "acao": "removerProgTrab",
                            "progTrab": programa
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