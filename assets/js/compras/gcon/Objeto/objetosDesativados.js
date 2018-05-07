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

    function listarObjetos(a) {    
        $.ajax({
            "url": "/model/compras/gcon/objeto/request.php",
            "dataType": "html",
            "data": {
                "acao": "listar_objetos_desativados"
            },

            "success": function (response) {
                if (a == 0) {
                    func.carregaTabelaPadrao('tabela_objeto', response, [10]); 
                }else{
                    func.carregaTabelaPadrao('tabela_objeto', response, [10], true);
                }
            }
        });
    };
    //chamando função para listar objetos
    listarObjetos(0);
    
    $('body').on("click", ".btn-ativar", function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else {
            e.preventDefault();
            var $this = $(this);
            $this.prop("disabled", true);
            $("#id_objeto").val($(this).val());
            var objeto = {
                obj: $("#id_objeto").val()
            };
            $.ajax({
                "url": "/model/compras/gcon/objeto/request.php",
                "dataType": "html",
                "data": {
                    "acao": "ativar_objeto",
                    "ativa_objeto": objeto
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