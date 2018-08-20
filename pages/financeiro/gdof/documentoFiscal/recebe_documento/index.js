
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
        remetente: $("#remetente option:selected").val()

    }
    $.ajax({
        "url": "request.php",
        "dataType": 'html',
        "data": {
            "acao": "retornaDocumentosFiscais",
            "dados": Dados
        },
        "success": function (response) {
            func.carregaTabelaPadrao('tabela', response, [4], true);
        }
    });
}

$(documento).ready(function(){
    lista();
    
    $("body").on("click", ".btn-pesquisar", function () {
        lista();
    });

});
