func = new Funcoes();

function retornaUsuarios() {
    $.ajax({
        "url": "/model/compras/gcon/usuario/request.php",
        "dataType": "html",
        "method": "POST",
        "data": {
            "acao": "listar_pessoas"
        },
        "success": function (response) {
            $("#pessoa").html(response);
        }
    });
}
retornaUsuarios();

function retornaPerfis() {
    $.ajax({
        "url": "/model/compras/gcon/usuario/request.php",
        "dataType": "html",
        "method": "POST",
        "data": {
            "acao": "listar_perfis"
        },
        "success": function (response) {
            $("#perfil").html(response);
        }
    });
}
retornaPerfis();

function listarTodosUsuarios() {
    $.ajax({
        "url": "/model/compras/gcon/usuario/request.php",
        "dataType": "html",
        "method": "POST",
        "data": {
            "acao": "listar_Todos_Usuarios"
        },
        "success": function (response) {
            func.carregaTabelaPadrao('tabela_usuario', response, [1], true);
        }
    });
}
listarTodosUsuarios();

$(document).ready(function () {

    $.ajax({
        "url": "/layout/menus/compras/gcon/menu_gcon.php",
        "dataType": "html",
        "data" : {
            menu : 'menu_2'
        },
        "success": function (response) {
            $("body").find("#menu_gcon").append(response);
        }
    });
    
    $("#butao").mouseover(function () {
        $('#menu').css({'display' : 'flex', 'margin-left': '440px'});
    }).mouseout(function () {
        $("#menu").mouseover(function () {
            $("#menu").css({'display' : 'flex', 'margin-left': '440px'});
        }).mouseout(function () {
            $("#menu").css('display', 'none');
        });
    }).mouseout(function () {
        $("#menu").css('display', 'none');
    });

    $('body').on('click', '.btn-limpar', function (e) {
        $('.btn-salvar').prop("disabled", false);
        $("#pessoa").select2('val', '0');
        $("#perfil").select2('val', '0');
    });

    $("#pessoa").select2();
    $("#perfil").select2();

    $('body').on('click', '.btn-salvar', function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else {
            e.preventDefault();
            var $this = $(this);
            $this.prop("disabled", true);
            
            var usuario = {
                id_usuario: $("#pessoa").val(),
                id_permissao: $("#perfil").val()
            };
            
            $.ajax({
                "url": "/model/compras/gcon/usuario/request.php",
                "dataType": "html",
                "data": {
                    "acao": "cadastrar_Usuario",
                    "cadUsuario": usuario
                },

                "success": function (response) {
                    $this.prop("disabled", false);
                    if (response.trim() === "SessaoExpirada") {
                        func.modalAlert(func.msgSemPermissao);
                        return false;
                    }

                    try {
                        response = JSON.parse(response);
                    } catch (e) {
                        func.modalAlert(func.msgErroPadrao, 'danger');
                        console.log("Parse JSON");
                        return false;
                    }

                    if (response.tipoMsg === "Erro") {
                        if (response.tipoExibicao === "console") {
                            console.log('Console Mensagem');
                            func.modalAlert(func.msgErroPadrao, 'danger');
                            return false;
                        } else if (response.tipoExibicao === "alert") {
                            func.modalAlert(response.msg, 'danger');
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
        var idPessoa = $this.closest('td').find('.btn-remover').attr("pessoa");
        var idPerfil = $this.closest('td').find('.btn-remover').attr("perfil");

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
                    var perfilPessoa = {
                        idPerfil: idPerfil,
                        idPessoa: idPessoa
                    };

                    if (idPerfil == "" && idPessoa == "") {
                        func.modalAlert(func.msgPreencherCampos);
                        $this.prop("disabled", false);
                        return false;
                    }
                    $.ajax({
                        "url": "/model/compras/gcon/usuario/request.php",
                        "dataType": "html",
                        "data": {
                            "acao": "excluir_Usuario",
                            "excluir": perfilPessoa
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