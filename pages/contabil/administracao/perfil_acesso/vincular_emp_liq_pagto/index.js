
func = new Funcoes();


function lista(){
    $.ajax({
        "url": "request.php",
        "dataType": 'html',
        "data": {
            "acao": "retornaTramitacaoUsuarios"
        },
        "success": function (response) {  
            func.carregaTabelaPadrao('tabela', response, [4]);
        }
    });
}

$(document).ready(function () {  
    $('body').find('select').select2({
        width: '100%'
    });
    
    lista();
});


