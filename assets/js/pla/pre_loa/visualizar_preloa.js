$(document).ready(function () {

    func = new Funcoes();       
    
    
    function lista(){
        
        var ano = $("#ano").val();
        
        $.ajax({
            "url": "/model/pla/pre_loa/request_visualizar_preloa.php",
            "dataType": 'html',
            "data": {
                acao: "valores",
                ano: ano
            },
            "success": function (response) {         
                $("#informacao").html(response);                    
                $("#sesacre-xlsx").show();
            }
        });        
    }
    
    lista();
    
    
    
       
});

function exportExcel(format, ano) {
    return ExcellentExport.convert({
        anchor: 'sesacre-' + format,
        filename: 'pre_loa-'+ano,
        format: format
    }, [{
        name: 'Pre-LOA',
        from: {
            table: 'tabela'
        }
    }]);
}