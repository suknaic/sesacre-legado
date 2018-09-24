
$(document).ready(function () {
    
    //select2
    $('body').find('select').select2({
        width: '100%'
    });
    
    $('.docFis').hide();
    
    habilitaDocumentosFiscais();
    
    $('body').on('click', '.ver-documento', function (e) {
        var id = $(this).val();
        window.open("/pages/financeiro/gdof/documentoFiscal/ver_documento/index.php?&id=" + id);
    });
});

function habilitaDocumentosFiscais(){
    var tipo_solicitacao = $("#id_pedido").data('tipo-solicitacao');
    
    if (tipo_solicitacao != 2 ) {
        $('.docFis').hide();
        $("#vl_liquidacao").prop("disabled",false);
    } else {
        $('.docFis').show();
        $("#vl_liquidacao").prop("disabled",true);
    }
}