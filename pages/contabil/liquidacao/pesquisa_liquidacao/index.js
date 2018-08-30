$(document).ready(function () {
    //instacinado fucoes js
    func = new Funcoes();

    $('body').find('select').select2({
        width: '100%'
    });

    function lista() {
        var Dados = {
            nrDocFis: $("#nr_liquidacao").val(),
            anoDocFis: $("#ano_liquidacao option:selected").val(),
            contratado: $("#id_contratado option:selected").val(),
            nrProtocolo: $("#nr_protocolo").val(),
            nrContrato: $("#nr_contrato").val(),
            nrPedido: $("#nr_pedido").val(),
            nrEmpenho: $("#nr_empenho").val(),
            nrDocumentoFiscal: $("#nr_documento_fiscal").val(),
            tpGasto: $("#tipo_gasto option:selected").val(),
            situacao: $("#situacao option:selected").val()
        }
        $.ajax({
            "url": "request.php",
            "dataType": 'html',
            "data": {
                "acao": "retornaLiquidacoes",
                "dados": Dados
            },
            "success": function (response) {
                
                func.carregaTabelaPadrao('tabela', response, [4], true);
            }
        });
    }

    $("body").on("click", ".btn-pesquisar", function () {
        lista();
    });

    $('body').on('click', '.ver_documento', function (e) {
        var id = $(this).val();
        window.open("/pages/financeiro/gdof/documentoFiscal/ver_documento/index.php?&id=" + id);
    });


});
