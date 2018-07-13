$(document).ready(function () {
    func = new Funcoes();
    
    
    function lista() {
        $.ajax({
            "url": "/model/administracao/tipo_administracao/request.php",
            "dataType": 'html',
            "data": {
                acao: "listaTiposAdministracao"
            },
            "success": function (response) {            
                func.carregaTabelaPadrao('tabela', response, [1]);
            }
        });
    }
    lista();
});

