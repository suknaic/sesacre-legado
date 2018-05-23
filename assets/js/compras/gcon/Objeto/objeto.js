$(document).ready(function () {
    //instacinado fucoes js
    func = new Funcoes();

    //pegando menu do gcon
    $.ajax({
        "url": "/layout/menus/compras/gcon/menu_gcon.php",
        "dataType": "html",
        "success": function (response) {
            $("body").find("#butao").append(response);
            $("body").find("#menu_gcon").append('<button class="btn btn-primary btn-rounded btn-novoObjeto" style="display: block; margin-left: 100px;margin-top: -32px" type="button">\n\
                            <i class="ion ion-plus-round" aria-hidden="true"></i> Novo Objeto\n\
                        </button>');
            $("body").find("#menu_gcon").append('<button class="btn btn-primary btn-rounded btn-objetosDsativados" style="display: block; margin-left: 230px;margin-top: -32px" type="button">\n\
                            <i class="ion-power" aria-hidden="true"></i> Objetos Desativados\n\
                        </button>');
        }
    });
    
    $("#butao").mouseover(function () {
        $(".menuButton").show();
    })
    .mouseout(function () {
        $(".menuButton").hide();
    });
    
    $('body').on('click', '.btn-novoObjeto', function (e) {
        top.location = "/pages/compras/gcon/objeto/novo_objeto.php";
    });
    
    $('body').on('click', '.btn-objetosDsativados', function (e) {
        top.location = "/pages/compras/gcon/objeto/objetosDesativados.php";
    });

    function listarObjeto(a) {
        $.ajax({
            "url": "/model/compras/gcon/objeto/request.php",
            "dataType": "html",
            "data": {
                "acao": "listar_Todos_Objetos"
            },

            "success": function (response) {
                if (response.trim() == "SessaoExpirada") {
                    func.modalAlert(func.msgSemPermissao);
                    return false;
                }

                try {
                    response = JSON.parse(response);
                } catch (e) {
                    func.carregaTabelaPadrao('objetos', response, [2], true);
                    return false;
                }

                if (response.tipoMsg === "Erro") {
                    if (response.tipoExibicao === "console") {
                        func.modalAlert(func.msgErroPadrao, 'danger');
                        return false;

                    } else if (response.tipoExibicao === "alert") {
                        $("body").find("#objeto_pes").html("");
                        func.modalAlert(response.msg);
                        return false;
                    }

                }
            },
            "error": function (response) {
                func.modalAlert(func.msgErroPadrao, 'danger');
                return false;
            }
        });
    };
    listarObjeto();
    //escodendo botões
    $(".btn-limpar").hide();
    $(".btn-editar").hide();


    $('body').on('click', '.btn-limpar', function (e) {
        $('.btn-salvar').prop("disabled", false);
        $("#objeto_pes").val("");
        $(".btn-limpar").hide();
        $(".btn-editar").hide();
        $(".btn-pesquisar").show();
    });


    $('body').on('click', '.btn-edit', function (e) {
        $(".btn-pesquisar").hide();
        $(".btn-limpar").show();
        $(".btn-editar").show();
        $("#objeto_pes").val($(this).attr('objeto'));
        $("#id_objeto").val($(this).val());
    });

    $('body').on('click', '.btn-pesquisar', function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else {
            e.preventDefault();
            var $this = $(this);
            $this.prop("disabled", true);
            var objeto = {
                objeto_pes: $("#objeto_pes").val()
            };

            $.ajax({
                "url": "/model/compras/gcon/objeto/request.php",
                "dataType": "html",
                "data": {
                    "acao": "listar_Objeto",
                    "objeto": objeto
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
                        func.carregaTabelaPadrao('objetos', response, [2], true);
                        return false;
                    }

                    if (response.tipoMsg === "Erro") {
                        if (response.tipoExibicao === "console") {
                            func.modalAlert(func.msgErroPadrao, 'danger');
                            return false;

                        } else if (response.tipoExibicao === "alert") {
                            $("body").find("#objeto_pes").html("");
                            func.modalAlert(response.msg);
                            return false;
                        }
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
            var objeto = {
                objeto_pes: $("#objeto_pes").val(),
                id_objeto: $("#id_objeto").val()
            };
            $.ajax({
                "url": "/model/compras/gcon/objeto/request.php",
                "dataType": "html",
                "data": {
                    "acao": "editar_Objeto",
                    "objeto": objeto
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
                            $("body").find("#objeto_pes").html("");
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
        var item = $this.closest('td').find('.btn-edit').attr("objeto");

        bootbox.confirm({
            title: func.msgCaixaDeConfirmacao,
            message: 'Você tem Certeza que deseja continuar com a Exclusão do Objeto <span class="text-danger">' + item + '</span> ?',
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
                    var objetoExc = {
                        id_objeto: id,
                        objeto: item
                    };

                    if (id == "") {
                        func.modalAlert(func.msgPreencherCampos);
                        $this.prop("disabled", false);
                        return false;
                    }
                    $.ajax({
                        "url": "/model/compras/gcon/objeto/request.php",
                        "dataType": "html",
                        "data": {
                            "acao": "excluir_Objeto",
                            "objeto": objetoExc
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
