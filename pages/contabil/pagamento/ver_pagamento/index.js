
$(document).ready(function () {
     
    $('body').on('click', '.ver-documento', function (e) {
        var id = $(this).val();
        window.open("/pages/financeiro/gdof/documentoFiscal/ver_documento/index.php?&id=" + id);
    });
    
    //lista as anotacoes 
    listaAnotacoes();
});


function listaAnotacoes() {
        $.ajax({
            "url": "/pages/contabil/liquidacao/anotacao_liquidacao/request.php",
            "method": "POST",
            "dataType": "html",
            "data": {
                "acao": "listaAnotacoes",
                "liquidacao": $("#id_liquidacao").val()
            },

            "success": function (response) {
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

                    $(".anotacoes").html("");
                    $(".anotacoes").html(response.msg);
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