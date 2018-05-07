$(document).ready(function () {
    //instacinado fucoes js
    func = new Funcoes();
    
    //menu programa trabalho
    $.ajax({
        "url": "/layout/menus/orcamento/bloco_orcamentario/menu_bloco_orcamentario.php",
        "dataType": "html",
        "success": function (response) {
            $("body").find("#menu_bloco_orcamentario").html(response);
        }
    });
    
    $('body').on('click', '.btn-limpar', function (e) {
        $("#bloco").val("");
    });
    
    $('body').on('click', '.btn-salvar', function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else {
            e.preventDefault();
            var $this = $(this);
            $this.prop("disabled", true);
            var blocOrca = {
                    bloco: $("#bloco").val()
            };
            
            $.ajax({
                "url": "/model/orcamento/blocOrcamentario/request.php",
                "dataType": "html",
                "data": {
                    "acao": "cadastrarBloco",
                    "bloco": blocOrca
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
                            $("body").find("#codigo").html("");
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