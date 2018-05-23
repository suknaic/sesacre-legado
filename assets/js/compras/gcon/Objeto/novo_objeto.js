$(document).ready(function () {
    //instacinado fucoes js
    func = new Funcoes();

    $.ajax({
        "url": "/layout/menus/compras/gcon/menu_gcon.php",
        "dataType": "html",
        "success": function (response) {
            $("body").find("#butao").append(response);
            $("body").find("#menu_gcon").append('<button class="btn btn-primary btn-rounded btn-objetosDsativados" style="display: block; margin-left: 100px;margin-top: -32px" type="button">\n\
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

    $('body').on('click', '.btn-objetosDsativados', function (e) {
        top.location = "/pages/compras/gcon/objeto/objetosDesativados.php";
    });

    $('body').on('click', '.btn-salvar', function (e) {

        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else {
            e.preventDefault();
            var $this = $(this);
            $this.prop("disabled", true);

            if (
                    $("#novo_objeto").val() == "") {
                func.modalAlert(func.msgPreencherCampos);
                $this.prop("disabled", false);
                return false;
            }

            var novo_objeto = {
                objeto: $("#novo_objeto").val()
            };
            $.ajax({
                "url": "/model/compras/gcon/objeto/request.php",
                "dataType": "html",
                "data": {
                    "acao": "cadastrar_objeto",
                    "cadObjeto": novo_objeto
                },
                "success": function (response) {
                    $this.prop("disabled", false);
                    if (response.trim() === "SessaoExpirada") {
                        func.modalAlert(func.msgSemPermissao);
                        $('.modal-alert').on('hidden.bs.modal', function (e) {
                            top.location = "/pages/index.php";
                        });
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
                    $this.prop("disabled", false);
                    func.modalAlert(func.msgErroPadrao, 'danger');
                    return false;
                }
            });
            $this.prop("disabled", false);
        }
    });
});