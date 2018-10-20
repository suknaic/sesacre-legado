$(document).ready(function () {
    //instacinado fucoes js
    func = new Funcoes();

    $("body").on("click", ".btn-deferir", function (e) {
        var $this = $(this);
        var dados = {
            "deferir": $this.val(),
            "pagamento": $("#pagamento").val()
        }
        
        $.ajax({
            "type": "POST",
            "url": "/pages/contabil/empenho/anulacao/ver_autorizacao/request.php",
            "dataType": "html",
            "data": {
                "acao": "cadastrarAnulacao",
                "dados": dados
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
                    func.modalAlert(func.msgErroPadrao);
                    console.log("Parse JSON");
                    return false;
                }

                if (response.tipoMsg === "Erro") {
                    if (response.tipoExibicao === "console") {
                        console.log(response);
                        console.log('Console Mensagem');
                        func.modalAlert(func.msgErroPadrao);
                        return false;
                    } else if (response.tipoExibicao === "alert") {
                        func.modalAlert(response.msg);
                        return false;
                    }
                } else if (response.tipoMsg === "ok") {
                    func.modalAlert('Itens cadastros com Sucesso', 'success');
                    $('.modal-alert').on('hidden.bs.modal', function (e) {
                        window.location.href = "/pages/contabil/empenho/anulacao/ver_autorizacao/index.php";
                    });
                    return false;
                } else {
                    console.log('Ultimo else');
                    func.modalAlert(func.msgErroPadrao);
                    return false;
                }
            },
            "error": function (response) {
                $this.prop("disabled", false);
                func.modalAlert(func.msgErroPadrao);
                return false;
            }
        });

    });

});




