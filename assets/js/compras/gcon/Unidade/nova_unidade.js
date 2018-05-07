$(document).ready(function () {
    //instacinado fucoes js
    func = new Funcoes();
    
        $.ajax({
            "url": "/layout/menus/compras/gcon/menu_gcon.php",
            "dataType": "html",
            "success": function (response) {
                $("body").find("#menu_gcon").html(response);
            }
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