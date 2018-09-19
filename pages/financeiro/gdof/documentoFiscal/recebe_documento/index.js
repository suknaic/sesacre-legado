func = new Funcoes();

function lista() {
    var Dados = {
        nrDocFis: $("#id_doc_fis").val(),
        anoDocFis: $("#ano_doc_fis option:selected").val(),
        contratado: $("#id_contratado option:selected").val(),
        nrProtocolo: $("#nr_protocolo").val(),
        nrContrato: $("#nr_contrato").val(),
        nrPedido: $("#nr_pedido").val(),
        nrEmpenho: $("#nr_empenho").val(),
        tpGasto: $("#tipo_gasto option:selected").val(),
        sitDoc: $("#situacao option:selected").val(),
        destinatario: $("#destinatario option:selected").val()

    }
    $.ajax({
        "url": "request.php",
        "dataType": 'html',
        "data": {
            "acao": "retornaDocumentosFiscais",
            "dados": Dados
        },
        "success": function (response) {
            console.log(response);
            func.carregaTabelaPadrao('tabela', response, [4], true);
        }
    });
}

$(document).ready(function(){
//    lista();
    
     $('body').find('select').select2({
        width: '100%'
    });
    
    $("body").on("click", ".btn-pesquisar", function () {
        lista();
    });
    
    $('body').on('click', '.ver_documento', function (e) {
        var id = $(this).val();
        window.open("/pages/financeiro/gdof/documentoFiscal/ver_documento/index.php?&id=" + id);
    });
    
    
    $("body").on("click", ".receberDocumento", function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else {
            var dados = $(this).closest('tr').data('objeto');
            $.ajax({
                "url": "request.php",
                "dataType": 'html',
                "method": 'post',
                "data": {
                    "acao": "cadastrarRecebimento",
                    "dados": dados.id_documento_fiscal
                },
                "success": function (response) {
                    console.log(response);
                    
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
                            console.log('Console Mensagem');
                            func.modalAlert(func.msgErroPadrao);
                            return false;
                        } else if (response.tipoExibicao === "alert") {
                            func.modalAlert(response.msg);
                            return false;
                        }
                    } else if (response.tipoMsg === "ok") {
                        func.modalAlert(response.msg, 'success');
                        func.fechaModalReload();
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
            })
        }
        
    });

});
