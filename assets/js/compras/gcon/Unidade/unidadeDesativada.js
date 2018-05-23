$(document).ready(function () {
    //instacinado fucoes js
    func = new Funcoes();

    //pegando menu do gcon
    $.ajax({
        "url": "/layout/menus/compras/gcon/menu_gcon.php",
        "dataType": "html",
        "success": function (response) {
            $("body").find("#butao").append(response);
            $("body").find("#menu_gcon").append('<button class="btn btn-primary btn-rounded btn-novaUnidade" style="display: block; margin-left: 100px;margin-top: -32px" type="button">\n\
                            <i class="ion ion-plus-round" aria-hidden="true"></i> Nova Unidade\n\
                        </button>');
        }
    });
    
    $("#butao").mouseover(function () {
        $(".menuButton").show();
    })
    .mouseout(function () {
        $(".menuButton").hide();
    });
    
    $('body').on('click', '.btn-novaUnidade', function (e) {
        top.location = "/pages/compras/gcon/unidade/nova_unidade.php";
    });

    function listarUnidade(a) {    
        $.ajax({
            "url": "/model/compras/gcon/unidade/request.php",
            "dataType": "html",
            "data": {
                "acao": "listar_unidades_desativadas"
            },

            "success": function (response) {
                if (a == 0) {
                    func.carregaTabelaPadrao('tabela_unidade', response, [10]); 
                }else{
                    func.carregaTabelaPadrao('tabela_unidade', response, [10], true);
                }
            }
        });
    };
    //chamando função para listar objetos
    listarUnidade(0);
    
    $('body').on('click', '.btn-ativar', function (e) {
        $("#id_unidade").val($(this).val());
    });
    
    $('body').on("click", ".btn-ativar", function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else {
            e.preventDefault();
            var $this = $(this);
            $this.prop("disabled", true);
            var unidade = {
                uni: $("#id_unidade").val()
            };
            $.ajax({
                "url": "/model/compras/gcon/unidade/request.php",
                "dataType": "html",
                "data": {
                    "acao": "ativar_unidade",
                    "ativa_unidade": unidade
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