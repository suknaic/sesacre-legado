$(document).ready(function () {
    //instacinado fucoes js
    func = new Funcoes();

    //pegando menu do gcon
    $.ajax({
        "url": "/layout/menus/compras/gcon/menu_gcon.php",
        "dataType": "html",
        "data" : {
            "menu" : 'menu_1'
        },
        "success": function (response) {
            $("body").find("#menu_gcon").append(response);
            $("body").find("#restoMenu").append('<li class="dropdown">\n\
                                                    <a href="/pages/compras/gcon/modalidade/nova_modalidade.php">Nova Modalidade</a>\n\
                                                </li>\n\
                                                <li class="dropdown">\n\
                                                    <a href="/pages/compras/gcon/modalidade/modalidadeDesativada.php">Modalidades Desativadas</a>\n\
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

    function listarModalidades(a) {    
        $.ajax({
            "url": "/model/compras/gcon/modalidade/request.php",
            "dataType": "html",
            "data": {
                "acao": "listar_modalidades_desativadas"
            },

            "success": function (response) {
                if (a == 0) {
                    func.carregaTabelaPadrao('tabela_modalidade', response, [10]); 
                }else{
                    func.carregaTabelaPadrao('tabela_modalidade', response, [10], true);
                }
            }
        });
    };
    //chamando função para listar objetos
    listarModalidades(0);
    
    $('body').on('click', '.btn-ativar', function (e) {
        $("#id_modalidade").val($(this).val());
    });
    
    $('body').on("click", ".btn-ativar", function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else {
            e.preventDefault();
            var $this = $(this);
            $this.prop("disabled", true);
            var modalidade = {
                mod: $("#id_modalidade").val()
            };
            $.ajax({
                "url": "/model/compras/gcon/modalidade/request.php",
                "dataType": "html",
                "data": {
                    "acao": "ativar_modalidade",
                    "ativa_modalidade": modalidade
                },
                "success": function (response) {
                    console.log(response);
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
                            $("body").find("#campoEmpenho").html("");
                            func.modalAlert(response.msg);
                            return false;
                        }
                    } else if (response.tipoMsg === "ok") {
                        func.modalAlert(response.msg, 'success');
                        $('.modal-alert').on('hidden.bs.modal', function (e) {
                            //reload na página para não da bug na tabela
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
});