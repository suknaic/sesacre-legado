$(document).ready(function () {

    func = new Funcoes();       
    
    
    function lista(){
        
               
        $.ajax({
            "url": "/model/orcamento/qdd/request_quadro.php",
            "dataType": 'html',
            "data": {
                acao: "valores",
                ano: $("#ano").val()
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
        filename: 'qdd-'+ano,
        format: format
    }, [{
        name: 'Pre-LOA',
        from: {
            table: 'tabela'
        }
    }]);
}