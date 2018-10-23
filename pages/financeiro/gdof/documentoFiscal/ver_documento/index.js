$(document).ready(function () {
    //instacinado fucoes js
    func = new Funcoes();
    
    $('body').on('click', '.ver-entrega', function (e) {
        $('#entrega').modal();

        $.ajax({
            "url": "request.php",
            "dataType": "html",
            "data": {
                "acao": "retornaDadosDaEntrega",
                "dados": $(this).val()
            },
            "success": function(response){
                $("#dados-entrega").html("");
                $("#dados-entrega").append(response);
            }
        });
    });

    function listaAnotacoes() {
        $.ajax({
            "url": "/pages/financeiro/gdof/documentoFiscal/anotacao_documento/request.php",
            "method": "POST",
            "dataType": "html",
            "data": {
                "acao": "listaAnotacoes",
                "documento_fiscal": $("#idDocumentoFiscal").val()
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
    //lista as anotacoes 
    listaAnotacoes();
    
    if($("#tipo_solicitacao").val() == 1){
        $("#panel-ordem").hide();
        $("#panel-entrega").hide();        
    }

});
