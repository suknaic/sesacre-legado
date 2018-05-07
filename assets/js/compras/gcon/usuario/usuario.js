$(document).ready(function () {
    //instacinado fucoes js
    func = new Funcoes();
    
    $("#usuario").select2();
    $("#permissao").select2();
    
    //pegando menu do gcon
    $.ajax({
        "url": "/layout/menus/compras/gcon/menu_gcon.php",
        "dataType": "html",
        "success": function (response) {
            $("body").find("#menu_gcon").html(response);
        }
    });
    
    function listarUsuarios() {
        $.ajax({
            "url": "/model/compras/gcon/usuario/request.php",
            "dataType": "html",
            "data": {
                "acao": "listar_Usuarios"
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
                    $('#tabela_usuario').DataTable({
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
    //chamando a função para listar usuarios
    listarUsuarios();
    
    //Função para retornar os tecnicos 
    function retornaUsuarios() {
        $.ajax({
            "url": "/model/compras/gcon/usuario/request.php",
            "dataType": "html",
            "data": {
                "acao": "listar_Tecnicos"
            },
            "success": function (response) {
                $("#usuario").append(response);                  
            }
        });
    }

    //chamando a função retornaTecnicos
    retornaUsuarios();

    //Função para retornar os perfis 
    function retornaPerfis() {
        $.ajax({
            "url": "/model/compras/gcon/usuario/request.php",
            "dataType": "html",
            "data": {
                "acao": "listar_Perfis"
            },
            "success": function (response) {
                $("#permissao").append(response);                
            }
        });
    }

    //chamando a função retornaTecnicos
    retornaPerfis();
    
    //escodendo botões e campo
    $(".btn-limpar").hide();
    $(".btn-editar").hide();                                                
    $("#campo").hide();
    
    //função para limpar todos os campos
    $('body').on('click', '.btn-limpar', function (e) {
        $("#campo").hide();
    });
        
    $('body').on('click', '.btn-edit', function (e) {
        $("#campo").show();
        $(".btn-limpar").show();
        $(".btn-editar").show();
        $('#permissao').val($(this).attr('perfil')).trigger('change');
        $('#usuario').val($(this).attr('usuario')).trigger('change');
        $("#id_perfil_pessoa").val($(this).val());
    });

    $('body').on("click", ".btn-editar", function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else {
            e.preventDefault();
            var $this = $(this);
            $this.prop("disabled", true);
            var usuario = {
                idUsuario: $("#usuario").val(),
                idPermissao: $("#permissao").val(),
                idPerfilPessoa: $("#id_perfil_pessoa").val()
            };
            $.ajax({
                "url": "/model/compras/gcon/usuario/request.php",
                "dataType": "html",
                "data": {
                    "acao": "editar_Usuario",
                    "editaUsuario": usuario
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
        var idPerfilPessoa = $this.val();
        
        bootbox.confirm({
            title: func.msgCaixaDeConfirmacao,
            message: 'Você tem certeza que deseja continuar com a exclusão deste registro?',
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
                    var idRegistro = {
                        idPerfilPessoa: idPerfilPessoa
                    };

                    if (idPerfilPessoa == "") {
                        func.modalAlert(func.msgPreencherCampos);
                        $this.prop("disabled", false);
                        return false;
                    }
                    $.ajax({
                        "url": "/model/compras/gcon/usuario/request.php",
                        "dataType": "html",
                        "data": {
                            "acao": "excluir_Usuario",
                            "excluir": idRegistro
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
