$(document).ready(function () {

    //instacinado fucoes js
    func = new Funcoes();

    //buscando o select option
    $("#id_usuario").select2();
    $("#id_permissao").select2();

    //Função para retornar os tecnicos 
    function retornaUsuarios() {
        $.ajax({
            "url": "/model/compras/gestaoContratos/perfil/request.php",
            "dataType": "html",
            "data": {
                "acao": "listar_Tecnicos"
            },
            "success": function (response) {
                $("#id_usuario").append(response);
            }
        });
    }

    //chamando a função retornaTecnicos
    retornaUsuarios();

    //Função para retornar os perfis 
    function retornaPerfis() {
        $.ajax({
            "url": "/model/compras/gestaoContratos/perfil/request.php",
            "dataType": "html",
            "data": {
                "acao": "listar_Perfis"
            },
            "success": function (response) {
                $("#id_permissao").append(response);
            }
        });
    }

    //chamando a função retornaTecnicos
    retornaPerfis();


    //Função para retornar os usuarios com permisao 
    function retornaUsuariosComPermisao() {
        $.ajax({
            "url": "/model/compras/gestaoContratos/perfil/request.php",
            "dataType": "html",
            "data": {
                "acao": "listar_Usuarios"
            },
            "success": function (response) {
                $("#tabela").find("tbody").html(response);
            }
        });
    }

    //chamando a função retorna Usuarios Com Permisao
    retornaUsuariosComPermisao();

    //Executa quando clica o butão Salvar
    $('body').on('click', '.btn-salvar', function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else {
            e.preventDefault();
            var $this = $(this);
            $this.prop("disabled", true);
            //Array que vai para o request
            var usuario = {
                id_usuario: $("#id_usuario").val(),
                id_permissao: $("#id_permissao").val()

            };
            //Enviando via Ajax para o request
            $.ajax({
                "url": "/model/compras/gestaoContratos/perfil/request.php",
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


    //busca os dados para ediçao
    $('body').on('click', '.btn-edit', function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else {
            e.preventDefault();
            var $this = $(this);
            $(".btn-salvar").addClass("hidden");
            $(".btn-editar").removeClass("hidden");
            $("#id_perfil_pessoa").val($this.val());
            $.ajax({
                "url": "/model/compras/gestaoContratos/perfil/request.php",
                "dataType": "html",
                "data": {
                    "acao": "listar_Tecnicos",
                    "id": $this.attr('usuario')
                },
                "success": function (response) {
                    $("#id_usuario").html(response);
                }
            });

            $.ajax({
                "url": "/model/compras/gestaoContratos/perfil/request.php",
                "dataType": "html",
                "data": {
                    "acao": "listar_Perfis",
                    "id": $this.attr('perfil')
                },
                "success": function (response) {
                    $("#id_permissao").html(response);
                }
            });
        }
    });

    //Executa quando clica o butão Salvar
    $('body').on('click', '.btn-editar', function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else {
            e.preventDefault();
            var $this = $(this);
            $this.prop("disabled", true);
            //Array que vai para o request
            var usuario = {
                idUsuario: $("#id_usuario").val(),
                idPermissao: $("#id_permissao").val(),
                idPerfilPessoa: $("#id_perfil_pessoa").val()
            };

            //Enviando via Ajax para o request
            $.ajax({
                "method": "POST",
                "url": "/model/compras/gestaoContratos/perfil/request.php",
                "dataType": "html",
                "data": {
                    "acao": "editar_Usuario",
                    "editaUsuario": usuario
                },

                "success": function (response) {
                    console.log(response);
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
                        "url": "/model/compras/gestaoContratos/perfil/request.php",
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