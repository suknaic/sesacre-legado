
$(document).ready(function () {
    
    //select2
    $('body').find('select').select2({
        width: '100%'
    });
    
    $('body').on('click', '.ver-documento', function (e) {
        var id = $(this).val();
        window.open("/pages/financeiro/gdof/documentoFiscal/ver_documento/index.php?&id=" + id);
    });
});


