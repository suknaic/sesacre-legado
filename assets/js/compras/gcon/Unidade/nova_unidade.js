$(document).ready(function () {
    //instacinado fucoes js
    func = new Funcoes();

    $.ajax({
        "url": "/layout/menus/compras/gcon/menu_gcon.php",
        "dataType": "html",
        "data" : {
            "menu" : 'menu_1'
        },
        "success": function (response) {
            $("body").find("#menu_gcon").append(response);
            $("body").find("#restoMenu").append('<li class="dropdown">\n\
                                                    <a href="/pages/compras/gcon/unidade/nova_unidade.php">Nova Unidade</a>\n\
                                                </li>\n\
                                                <li class="dropdown">\n\
                                                    <a href="/pages/compras/gcon/unidade/unidadeDesativadas.php">Unidades Desativadas</a>\n\
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

    $('body').on('click', '.btn-salvar', function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else {
            e.preventDefault();
            var $this = $(this);
            $this.prop("disabled", true);

            if ($("#nova_unidade").val() == "") {
                func.modalAlert(func.msgPreencherCampos);
                $this.prop("disabled", false);
                return false;
            }

            var nova_unidade = {
                novaUnidade: $("#nova_unidade").val()
            };

            $.ajax({
                "url": "/model/compras/gcon/unidade/request.php",
                "dataType": "html",
                "data": {
                    "acao": "cadastrar_Unidade",
                    "unidade": nova_unidade
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