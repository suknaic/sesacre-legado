$(document).ready(function () {

    func = new Funcoes();

    function listaPasValidacao() {               
        
        $.ajax({
            "url": "/model/pla/pas_validacao/request.php",
            "dataType": 'html',
            "data": {
                acao: "listaPasParaValidacao"                
            },
            "success": function (response) {             
                func.carregaTabelaPadrao('tabela', response, [2], false);
            }
        });
    }
    listaPasValidacao();          
       
       
});
